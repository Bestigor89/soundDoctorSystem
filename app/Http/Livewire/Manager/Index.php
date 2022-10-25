<?php

namespace App\Http\Livewire\Manager;

use App\Http\Livewire\WithSorting;
use App\Models\Cost;
use App\Models\FileForeMod;
use App\Models\FileLibrary;
use App\Models\Mod;
use App\Models\Patient;
use App\Models\Section;
use App\Models\TaskForPatient;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    use WithSorting;

    const MODULE_COUNT = 10;

    public Mod $mod;

    public TaskForPatient $taskForPatient;

    /**
     * @var array
     */
    public array $listsForFields = [];

    /**
     * @var int|null
     */
    public $presetPatientId = null;

    /**
     * @var Patient|null
     */
    public $patient = null;

    /**
     * @var string|null
     */
    public $searchPatient = null;

    /**
     * @var string|null
     */
    public $searchModule = null;

    /**
     * @var array
     */
    public $patientList = [];

    /**
     * @var array
     */
    public $moduleList = [];

    /**
     * @var Cost|null
     */
    public $cost = null;

    /**
     * @var string|null
     */
    public $searchFile = null;

    /**
     * @var Section|null
     */
    public $section = null;

    /**
     * @var array
     */
    public $sectionFiles = [];

    /**
     * @var Carbon|null
     */
    public $date_start;

    /**
     * @var int
     */
    public $fileDurations = 0;

    /**
     * @var Collection
     */
    public $files;

    /**
     * @var array
     */
    protected $queryString = [
        'presetPatientId',
    ];

    /**
     * @var array
     */
    protected $listeners = [
        'orderChanged',
        'updatedFileDuration',
    ];

    /**
     * @var array
     */
    protected $rules = [
        'mod.id' => ['required', 'exists:mods,id'],
        'patient.id' => ['required', 'exists:patients,id'],
        'mod.name' => ['required'],
        'date_start' => ['required', 'date', 'after:now'],
    ];

    /**
     * @return void
     */
    public function mount(Mod $mod, TaskForPatient $taskForPatient)
    {
        $this->initListsForFields();
        if ($this->presetPatientId) {
            $patient = Patient::query()->find($this->presetPatientId);
            $this->patient = $patient;
        }

        $this->mod = $mod;
        if (! $this->mod->exists) {
            $this->moduleList = Mod::query()->latest()->take(self::MODULE_COUNT)->get();
            $this->files = $this->mod->files;
        } else {
            $this->files = collect();
        }
        $this->taskForPatient = $taskForPatient;
        $this->date_start = now_in_base_time_zone();
        $this->cost = Cost::getActive();
        $this->updateFileDurations();
    }

    /**
     * @return void
     */
    public function booted()
    {
        $this->initListsForFields();
        if (! $this->mod->exists) {
            $this->moduleList = Mod::query()->latest()->take(self::MODULE_COUNT)->get();
        }
        $this->section = $this->section ?? $this->listsForFields['sections']->first();
        $this->sectionFiles = $this->section ? $this->section->fileLibrary : null;
        $this->updateFileDurations();
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.manager.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit()
    {
        $this->validate();

        $cost = Cost::getActive();
        $this->taskForPatient->cost_id = $cost->id;
        $this->taskForPatient->pacient_id = $this->patient->id;
        $this->taskForPatient->mode_id = $this->mod->id;
        $this->taskForPatient->date_start = display_date_to_system($this->date_start);

        $this->taskForPatient->save();

        return redirect()->route('admin.task-for-patients.index', ['presetPatientId' => $this->presetPatientId]);
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function updatingSearchPatient(string $value = null)
    {
        if (blank($value)) {
            $this->patientList = [];

            return;
        }

        $user = Auth::user();
        $this->patientList = Patient::query()
            ->when(! $user->is_admin, function (Builder $builder) use ($user) {
                return $builder->whereHas('doctor', function (Builder $builder) use ($user) {
                    return $builder->where('user_id', $user->id);
                });
            })
            ->advancedFilter([
                's' => $value,
                'order_column' => $this->sortBy,
                'order_direction' => $this->sortDirection,
            ])
            ->get();
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function updatingSearchModule(string $value = null)
    {
        if (blank($value)) {
            $this->moduleList = [];

            return;
        }

        $this->moduleList = Mod::query()
            ->advancedFilter([
                's' => $value,
                'order_column' => $this->sortBy,
                'order_direction' => $this->sortDirection,
            ])
            ->get();
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function updatingSearchFile(string $value = null)
    {
        if (blank($value)) {
            $this->sectionFiles = $this->section->fileLibrary;

            return;
        }

        $this->sectionFiles = FileLibrary::query()
            ->advancedFilter([
                's' => $value,
                'order_column' => $this->sortBy,
                'order_direction' => $this->sortDirection,
            ])
            ->when($this->section->exists, function (Builder $builder) {
                $builder->whereHas('section', function (Builder $builder) {
                    return $builder->where('id', $this->section->id);
                });
            })
            ->get();
    }

    /**
     * @param Patient $patient
     * @return void
     */
    public function setPatient(Patient $patient)
    {
        $patient->load('tasks');
        $this->patient = $patient;
        $this->patientList = [];
        $this->searchPatient = null;
    }

    /**
     * @param Mod $mod
     * @return void
     */
    public function setModule(Mod $mod)
    {
        $this->mod = $mod;
        $this->moduleList = [];
        $this->searchModule = null;
        $this->updateFileDurations();
    }

    /**
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function saveModule()
    {
        $this->validateOnly('mod.name');

        $this->mod->save();
        $this->mod->load('files');

        $this->moduleList = [];
        $this->searchModule = null;
    }

    /**
     * @param Section|null $section
     * @return void
     */
    public function setSection(Section $section = null)
    {
        $section->load('fileLibrary');

        $this->section = $section;
        $this->sectionFiles = $section->exists ? $section->fileLibrary : FileLibrary::query()->get();
        $this->searchFile = null;
    }

    /**
     * @param FileLibrary $fileLibrary
     * @return void
     */
    public function attachFileToMod(FileLibrary $fileLibrary)
    {
        if ($this->mod->exists) {
            $this->mod->files()->attach($fileLibrary, [
                'sort_order' => 0,
            ]);
            $this->mod->load('files');
        } else {
            $this->files->push($fileLibrary);
        }

        $this->updateFileDurations();
    }

    /**
     * @param FileLibrary $fileLibrary
     * @return void
     */
    public function detachFileFromMod(FileLibrary $fileLibrary)
    {
        $this->mod->files()->detach($fileLibrary);

        $this->mod->load('files');
        $this->updateFileDurations();
    }

    /**
     * @param array $items
     * @return void
     */
    public function orderChanged(array $items= [])
    {
        foreach ($items as $item) {
            $file = $this->mod->files->find(data_get($item, 'id'));
            $this->mod->files()->updateExistingPivot($file->id, [
                'sort_order' => data_get($item, 'order'),
            ]);
        }

        $this->mod->load('files');
    }

    /**
     * @param FileForeMod $fileForeMod
     * @param $duration
     */
    public function updatedFileDuration(FileForeMod $fileForeMod, $duration)
    {
        $fileForeMod->fill([
            'durations' => $duration,
        ])->save();

        $this->mod->load('files');
        $this->updateFileDurations();
    }

    /**
     * @return void
     */
    protected function initListsForFields(): void
    {
        $user = Auth::user();
        $this->listsForFields['sections'] = Section::query()
            ->with('fileLibrary')
            ->whereHas('fileLibrary')
            ->when(! $user->is_admin, function (Builder $builder) use ($user) {
                $builder->where('owner_id', $user->id);
            })
            ->get();
    }

    /**
     * @return void
     */
    protected function updateFileDurations()
    {
        $this->fileDurations = $this->mod->files->sum(function (FileLibrary $fileLibrary) {
            return $fileLibrary->pivot->durations ?? $fileLibrary->durations;
        });
    }
}
