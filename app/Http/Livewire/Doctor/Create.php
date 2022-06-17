<?php

namespace App\Http\Livewire\Doctor;

use App\Models\Doctor;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public Doctor $doctor;

    public array $listsForFields = [];

    public function mount(Doctor $doctor)
    {
        $this->doctor         = $doctor;
        $this->doctor->status = true;
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.doctor.create');
    }

    public function submit()
    {
        $this->validate();

        $this->doctor->save();

        return redirect()->route('admin.doctors.index');
    }

    protected function rules(): array
    {
        return [
            'doctor.name' => [
                'string',
                'required',
            ],
            'doctor.status' => [
                'boolean',
            ],
            'doctor.user_id' => [
                'integer',
                'exists:users,id',
                'required',
            ],
        ];
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['user'] = User::pluck('name', 'id')->toArray();
    }
}
