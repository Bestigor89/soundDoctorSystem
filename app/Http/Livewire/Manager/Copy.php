<?php

namespace App\Http\Livewire\Manager;

use App\Http\Livewire\WithSorting;
use App\Models\Cost;
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

    /**
     * @var array
     */
    public array $listsForFields = [];

    /**
     * @var TaskForPatient
     */
    public $taskForPatient;

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
        $this->initListsForFields();
        $this->mod = new Mod;
        $this->date_start = system_datetime_to_display($taskForPatient->date_start);
        $this->files = $taskForPatient->mode->files;
        $this->taskForPatient = $taskForPatient;
        $this->searchModule = $this->prepareModName();
        $this->updateFileDurations();
    }

    /**
     * @return void
     */
    public function booted()
    {
        $this->initListsForFields();
        $this->files = $this->taskForPatient->mode->files;
        $this->section = $this->section ?? $this->listsForFields['sections']->first();
        $this->sectionFiles = $this->section->fileLibrary;
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
        $this->taskForPatient = new TaskForPatient;
        $this->taskForPatient->cost_id = $cost->id;
        $this->taskForPatient->pacient_id = $this->patient->id;
        $this->taskForPatient->mode_id = $this->mod->id;
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
        $this->fileDurations = $this->files->sum(function (FileLibrary $fileLibrary) {
            return $fileLibrary->pivot->durations ?? $fileLibrary->durations;
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
}
