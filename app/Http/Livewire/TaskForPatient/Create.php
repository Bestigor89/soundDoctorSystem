<?php

namespace App\Http\Livewire\TaskForPatient;

use App\Models\Cost;
use App\Models\Mod;
use App\Models\Patient;
use App\Models\TaskForPatient;
use Livewire\Component;

class Create extends Component
{
    public array $listsForFields = [];

    public TaskForPatient $taskForPatient;

    public function mount(TaskForPatient $taskForPatient)
    {
        $this->taskForPatient         = $taskForPatient;
        $this->taskForPatient->status = false;
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.task-for-patient.create');
    }

    public function submit()
    {
        $this->validate();

        $this->taskForPatient->save();

        return redirect()->route('admin.task-for-patients.index');
    }

    protected function rules(): array
    {
        return [
            'taskForPatient.pacient_id' => [
                'integer',
                'exists:patients,id',
                'required',
            ],
            'taskForPatient.cost_id' => [
                'integer',
                'exists:costs,id',
                'required',
            ],
            'taskForPatient.mode_id' => [
                'integer',
                'exists:mods,id',
                'required',
            ],
            'taskForPatient.status' => [
                'boolean',
            ],
        ];
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['pacient'] = Patient::pluck('name', 'id')->toArray();
        $this->listsForFields['cost']    = Cost::pluck('price', 'id')->toArray();
        $this->listsForFields['mode']    = Mod::pluck('name', 'id')->toArray();
    }
}
