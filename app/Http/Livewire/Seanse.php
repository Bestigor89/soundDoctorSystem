<?php

namespace App\Http\Livewire;

use App\Models\Mod;
use App\Models\User;
use Livewire\Component;

class Seanse extends Component
{

    public array $listsForFields = [];

    public $userId;

    public User $user;

    public Mod $mod;

    public function mount(User $user)
    {
        $this->initListsForFields();
        $this->user = $user;
    }

    public function render()
    {
        $this->user = User::find($this->userId);

        return view('livewire.seanse');
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['user'] = User::pluck('name', 'id')->toArray();
    }

    protected function rules(): array
    {
        return [
            'userId' => [
                'integer',
                'exists:user,id',
                'required',
            ],
        ];
    }
}
