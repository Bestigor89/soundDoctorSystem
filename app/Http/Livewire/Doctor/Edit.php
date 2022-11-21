<?php

namespace App\Http\Livewire\Doctor;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public Doctor $doctor;

    public User $user;

    public array $listsForFields = [];

    public function mount(Doctor $doctor)
    {
        $this->doctor = $doctor;
        $this->user = $doctor->user;
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.doctor.edit');
    }

    public function submit()
    {
        $this->validate();

        $this->user->save();

        $this->doctor->name = $this->user->name;
        $this->doctor->status = $this->user->status;
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
                Rule::unique('users', 'email')->ignore($this->user->id),
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
