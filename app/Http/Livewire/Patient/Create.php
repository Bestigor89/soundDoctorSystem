<?php

namespace App\Http\Livewire\Patient;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class Create extends Component
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

    public $password = null;

    /**
     * @param Patient $patient
     * @param User $user
     */
    public function mount(Patient $patient, User $user)
    {
        $this->patient         = $patient;
        $this->user = $user;
        $this->patient->status = true;
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.patient.create');
    }

    public function submit()
    {
        $this->validate();

        $role = Role::byTitle(Role::TITLE_PATIENT);

        $this->user->password = bcrypt($this->password);
        $this->user->save();

        $this->user->roles()->attach($role);

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
                'unique:users,email',
            ],
            'password' => [
                'string',
                'required',
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
