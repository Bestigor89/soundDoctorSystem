<?php

namespace App\Http\Livewire\Manager;

use App\Enums\TaskForPatientStatusEnum;
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
        if ($this->mod->exists) {
            $this->moduleList = Mod::query()->latest()->take(self::MODULE_COUNT)->get();
            $this->files = $this->mod->files;
        } else {
            $this->files = collect();
        }
        $this->searchModule = $this->prepareModName();
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
        } else {
            $this->mod->load('files');
            $this->files = $this->mod->files;
        }
        $this->section = $this->section ?? $this->listsForFields['sections']->first();
        $this->sectionFiles = $this->section->exists ? $this->section->fileLibrary : $this->loadAllFiles();
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
        $this->taskForPatient->status = TaskForPatientStatusEnum::IN_PROGRESS;
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
        $this->mod->load('files');
        $this->files = $this->mod->files;
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

        $this->moduleList = [];
        $this->searchModule = null;

        if ($this->files->isNotEmpty()) {
            foreach ($this->files as $file) {
                $this->mod->files()->attach(data_get($file, 'id'), [
                    'sort_order' => data_get($file, 'sort_order', 0),
                ]);
            }
        }

        $this->files = $this->mod->load('files');
    }

    /**
     * @param Section|null $section
     * @return void
     */
    public function setSection(Section $section = null)
    {
        $section->load('fileLibrary');

        $this->section = $section;
        $this->sectionFiles = $section->exists ? $section->fileLibrary : $this->loadAllFiles();
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

            $this->files = $this->mod->files;
        } else {
            $fileLibrary->sort_order = $this->files->count() + 1;
            $this->files = $this->files->push($fileLibrary);
        }

        $this->updateFileDurations();
    }

    /**
     * @param FileLibrary $fileLibrary
     * @return void
     */
    public function detachFileFromMod($fileLibrary)
    {
        if ($this->mod->exists) {
            $this->mod->files()->detach($fileLibrary);

            $this->mod->load('files');

            $this->files = $this->mod->files;
        } else {
            $this->files = $this->files->reject(function ($item) use ($fileLibrary) {
                return data_get($item, 'id') === data_get($fileLibrary, 'id');
            });
        }

        $this->updateFileDurations();
    }

    /**
     * @param array $items
     * @return void
     */
    public function orderChanged(array $items = [])
    {
        foreach ($items as $item) {
            if ($this->mod->exists) {
                $file = $this->mod->files->find(data_get($item, 'id'));
                $this->mod->files()->updateExistingPivot($file->id, [
                    'sort_order' => data_get($item, 'order'),
                ]);
            } else {
                $this->files = $this->files->transform(function ($file) use ($item) {
                    if (data_get($file, 'id') === data_get($item, 'id')) {
                        $file['sort_order'] = data_get($item, 'order');
                    }

                    return $file;
                });
            }
        }

        if ($this->mod->exists) {
            $this->mod->load('files');
            $this->files = $this->mod->files;
        } else {
            $this->files = $this->files->sortBy('sort_order')->values();
        }
    }

    /**
     * @param FileForeMod $fileForeMod
     * @param $duration
     */
    public function updatedFileDuration($fileForeMod, $duration)
    {
        if ($this->mod->exists) {
            $fileForeMod = FileForeMod::find($fileForeMod);

            $fileForeMod->fill([
                'durations' => $duration,
            ])->save();
            $this->mod->load('files');

            $this->files = $this->mod->files;
        } else {
            $this->files = $this->files->transform(function ($file) use ($fileForeMod, $duration) {
                if ($fileForeMod === data_get($file, 'id')) {
                    $file = data_set($file, 'durations', $duration);
                }

                return $file;
            });
        }

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
        $this->fileDurations = $this->files->sum(function ($fileLibrary) {
            return !blank(data_get($fileLibrary, 'pivot.durations')) ?
                $fileLibrary->pivot->durations :
                data_get($fileLibrary, 'durations');
        });
    }

    /**
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function loadAllFiles()
    {
        return FileLibrary::query()->get();
    }

    /**
     * @return void
     */
    protected function prepareModName()
    {
        $lastId = Mod::query()->latest()->first();

        return $lastId->id + 1;
    }
}
