<?php

namespace App\Http\Livewire\Patient;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public Patient $patient;

    public array $listsForFields = [];

    public function mount(Patient $patient)
    {
        $this->patient = $patient;
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.patient.edit');
    }

    public function submit()
    {
        $this->validate();

        $this->patient->save();

        return redirect()->route('admin.patients.index');
    }

    protected function rules(): array
    {
        return [
            'patient.name' => [
                'string',
                'required',
            ],
            'patient.doctor_id' => [
                'integer',
                'exists:doctors,id',
                'required',
            ],
            'patient.phone' => [
                'string',
                'nullable',
            ],
            'patient.status' => [
                'boolean',
            ],
            'patient.user_id' => [
                'integer',
                'exists:users,id',
                'required',
            ],
        ];
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['doctor'] = Doctor::pluck('name', 'id')->toArray();
        $this->listsForFields['user']   = User::pluck('name', 'id')->toArray();
    }
}
