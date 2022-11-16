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

class Copy extends Component
{
    use WithSorting;

    public Mod $mod;

    public TaskForPatient $taskForPatient;

    /**
     * @var array
     */
    public array $listsForFields = [];

    /**
     * @var string|null
     */
    public $searchModule = null;

    /**
     * @var Carbon|null
     */
    public $date_start;

    /**
     * @var Patient|null
     */
    public $patient = null;

    /**
     * @var string|null
     */
    public $searchPatient = null;

    /**
     * @var array
     */
    public $patientList = [];

    /**
     * @var Collection
     */
    public $files;

    /**
     * @var Cost
     */
    public $cost;

    /**
     * @var int
     */
    public $fileDurations = 0;

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
     * @param TaskForPatient $taskForPatient
     */
    public function mount(TaskForPatient $taskForPatient)
    {
        [$taskForPatient, $mod] = $this->prepareModels($taskForPatient);

        $this->taskForPatient = $taskForPatient;
        $this->mod = $mod;

        $this->initListsForFields();

        if ($this->mod->exists) {
            $this->files = $this->mod->files;
        }

        $this->date_start = system_datetime_to_display($this->taskForPatient->date_start);
        $this->patient = $this->taskForPatient->pacient;
        $this->cost = Cost::getActive();
        $this->updateFileDurations();
    }

    /**
     * @return void
     */
    public function booted()
    {
        $this->initListsForFields();
        $this->mod->load('files');
        $this->files = $this->mod->files;
        $this->section = $this->section ?? $this->listsForFields['sections']->first();
        $this->sectionFiles = $this->section->exists ? $this->section->fileLibrary : $this->loadAllFiles();
        $this->updateFileDurations();
    }

    public function render()
    {
        return view('livewire.manager.copy');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit()
    {
        $this->validate();

        $cost = Cost::getActive();
        $this->taskForPatient->cost_id = $cost->id;
        $this->taskForPatient->status = TaskForPatientStatusEnum::IN_PROGRESS;
        $this->taskForPatient->pacient_id = $this->patient->id;
        $this->taskForPatient->mode_id = $this->mode->id;
        $this->taskForPatient->date_start = display_date_to_system($this->date_start);

        $this->taskForPatient->save();

        return redirect()->route('admin.task-for-patients.index');
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
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function saveModule()
    {
        $this->validateOnly('mod.name');

        if (Mod::query()->find($this->mod->name)) {
            $this->addError('mod.name', __('custom.mod.name', [
                'id' => $this->mod->name,
            ]));

            return;
        }

        $this->mod->save();

        foreach ($this->files as $file) {
            $this->mod->files()->attach($file->id, [
                'durations' => $file->pivot->durations ?? $file->durations,
                'sort_order' => $file->pivot->sort_order,
            ]);
        }

        $this->mod->load('files');
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
        $this->sectionFiles = $section->exists ? $section->fileLibrary : $this->loadAllFiles();
        $this->searchFile = null;
    }

    /**
     * @param FileLibrary $fileLibrary
     * @return void
     */
    public function attachFileToMod(FileLibrary $fileLibrary)
    {
        $this->mod->files()->attach($fileLibrary, [
            'sort_order' => 0,
        ]);
        $this->mod->load('files');

        $this->files = $this->mod->files;

        $this->updateFileDurations();
    }

    /**
     * @param FileLibrary $fileLibrary
     * @return void
     */
    public function detachFileFromMod($fileLibrary)
    {
        $this->mod->files()->detach($fileLibrary);

        $this->mod->load('files');

        $this->files = $this->mod->files;

        $this->updateFileDurations();
    }

    /**
     * @param array $items
     * @return void
     */
    public function orderChanged(array $items = [])
    {
        foreach ($items as $item) {
            $file = $this->mod->files->find(data_get($item, 'id'));
            $this->mod->files()->updateExistingPivot($file->id, [
                'sort_order' => data_get($item, 'order'),
            ]);
        }

        $this->mod->load('files');
        $this->files = $this->mod->files;
    }

    /**
     * @param FileForeMod $fileForeMod
     * @param $duration
     */
    public function updatedFileDuration($fileForeMod, $duration)
    {
        $fileForeMod = FileForeMod::find($fileForeMod);

        $fileForeMod->fill([
            'durations' => $duration,
        ])->save();

        $this->mod->load('files');

        $this->files = $this->mod->files;

        $this->updateFileDurations();
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
     * @return void
     */
    protected function prepareModName()
    {
        $lastId = Mod::query()->latest()->first();

        return $lastId->id + 1;
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
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function loadAllFiles()
    {
        return FileLibrary::query()->get();
    }

    /**
     * @param TaskForPatient $taskForPatient
     * @return array
     */
    protected function prepareModels(TaskForPatient $taskForPatient)
    {
        $task = $taskForPatient->replicate(['cost_id', 'mode_id', 'pacient_id']);

        $taskForPatient->load('mode', 'mode.files');
        $task->status = TaskForPatientStatusEnum::HIDDEN;

        $mod = new Mod;
        $mod->fill([
            'name' => $this->prepareModName(),
        ])->save();

        $task->mode_id = $mod->id;

        foreach ($taskForPatient->mode->files as $file) {
            $mod->files()->attach($file, [
                'sort_order' => $file->pivot->sort_order,
                'durations' => $file->pivot->durations,
            ]);
        }

        return [$task, $mod];
    }
}
