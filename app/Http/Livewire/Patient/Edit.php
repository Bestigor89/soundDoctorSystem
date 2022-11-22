<?php

namespace App\Http\Livewire\Patient;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public Patient $patient;

    public User $user;

    public array $listsForFields = [];

    /**
     * @var null
     */
    public $doctor_id = null;

    /**
     * @var null
     */
    public $phone = null;

    public function mount(Patient $patient)
    {
        $this->patient = $patient;
        $this->user = $patient->user;
        $this->doctor_id = $patient->doctor_id;
        $this->phone = $patient->phone;
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.patient.edit');
    }

    public function submit()
    {
        $this->validate();

        $this->user->save();

        $this->patient->user_id = $this->user->id;
        $this->patient->name = $this->user->name;
        $this->patient->phone = $this->phone;
        $this->patient->doctor_id = $this->doctor_id;
        $this->patient->status = $this->user->status;
        $this->patient->save();

        return redirect()->route('admin.patients.index');
    }

    protected function rules(): array
    {
        return [
            'user.name' => [
                'required',
            ],
            'user.email' => [
                'email:rfc',
                'required',
                Rule::unique('users', 'email')->ignore($this->user->id),
            ],
            'user.status' => [
                'boolean',
            ],
            'doctor_id' => [
                'integer',
                'exists:doctors,id',
                'required',
            ],
            'phone' => [
                'nullable',
            ],
        ];
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['doctor'] = Doctor::pluck('name', 'id')->toArray();
        $this->listsForFields['user']   = User::pluck('name', 'id')->toArray();
    }
}
