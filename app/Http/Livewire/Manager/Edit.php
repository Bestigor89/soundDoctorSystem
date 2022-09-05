<?php

namespace App\Http\Livewire\Manager;

use App\Models\Cost;
use App\Models\FileLibrary;
use App\Models\Mod;
use App\Models\Patient;
use App\Models\Section;
use App\Models\TaskForPatient;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Edit extends Component
{
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
     * @var Mod|null
     */
    public $module = null;

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
    ];

    /**
     * @var array
     */
    protected $rules = [
        'mod.id' => ['required', 'exists:mods,id'],
        'patient.id' => ['required', 'exists:patients,id'],
    ];

    /**
     * @param TaskForPatient $taskForPatient
     */
    public function mount(TaskForPatient $taskForPatient)
    {
        $this->initListsForFields();

        $taskForPatient->load(['mode']);
        $taskForPatient->load(['cost', 'mode', 'mode.files', 'pacient']);
        $this->taskForPatient = $taskForPatient;
        $this->mod = $taskForPatient->mode;
        $this->patient = $taskForPatient->pacient;
    }

    /**
     * @return void
     */
    public function booted()
    {
        $this->initListsForFields();
        $this->section = $this->section ?? $this->listsForFields['sections']->first();
        $this->sectionFiles = $this->section->fileLibrary;
    }

    public function render()
    {
        return view('livewire.manager.edit');
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
            ->whereHas('section', function (Builder $builder) {
                return $builder->where('id', $this->section->id);
            })
            ->get();
    }

    /**
     * @param Patient $patient
     * @return void
     */
    public function setPatient(Patient $patient)
    {
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
    }

    /**
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function saveModule()
    {
        $this->validateOnly([
            'mod.name' => 'required',
        ]);

        $this->mod->save();
        $this->mod->load('files');

        $this->moduleList = [];
        $this->searchModule = null;
    }

    /**
     * @param Section $section
     * @return void
     */
    public function setSection(Section $section)
    {
        $section->load('fileLibrary');

        $this->section = $section;
        $this->sectionFiles = $section->fileLibrary;
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
    }

    /**
     * @param FileLibrary $fileLibrary
     * @return void
     */
    public function detachFileFromMod(FileLibrary $fileLibrary)
    {
        $this->mod->files()->detach($fileLibrary);

        $this->mod->load('files');
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
