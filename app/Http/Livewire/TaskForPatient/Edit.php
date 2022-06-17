<?php

namespace App\Http\Livewire\TaskForPatient;

use App\Models\Cost;
use App\Models\Mod;
use App\Models\Patient;
use App\Models\TaskForPatient;
use Livewire\Component;

class Edit extends Component
{
    public array $listsForFields = [];

    public TaskForPatient $taskForPatient;

    public function mount(TaskForPatient $taskForPatient)
    {
        $this->taskForPatient = $taskForPatient;
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.task-for-patient.edit');
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
        ];
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['pacient'] = Patient::pluck('name', 'id')->toArray();
        $this->listsForFields['cost']    = Cost::pluck('price', 'id')->toArray();
        $this->listsForFields['mode']    = Mod::pluck('name', 'id')->toArray();
    }
}
