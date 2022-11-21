<?php

namespace App\Http\Livewire\Doctor;

use App\Models\Doctor;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public Doctor $doctor;

    public User $user;

    public array $listsForFields = [];

    /**
     * @var null
     */
    public $password = null;

    public function mount(Doctor $doctor, User $user)
    {
        $this->doctor = $doctor;
        $this->doctor->status = true;
        $this->user = $user;
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.doctor.create');
    }

    public function submit()
    {
        $this->validate();

        $role = Role::byTitle(Role::TITLE_DOCTOR);

        $this->user->password = bcrypt($this->password);
        $this->user->save();
        $this->user->roles()->attach($role);

        $this->doctor->name = $this->user->name;
        $this->doctor->status = $this->user->status;
        $this->doctor->user_id = $this->user->id;
        $this->doctor->save();

        return redirect()->route('admin.doctors.index');
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
        ];
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['user'] = User::pluck('name', 'id')->toArray();
    }
}
