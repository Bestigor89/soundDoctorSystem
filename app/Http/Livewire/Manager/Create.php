<?php

namespace App\Http\Livewire\Manager;

use App\Models\Cost;
use Livewire\Component;

class Create extends Component
{

    public function mount( )
    {
    }

    public function render()
    {
        return view('livewire.manager.create');
    }

    public function submit()
    {
        $this->validate();

        return redirect()->route('admin.manager.index');
    }

    protected function rules(): array
    {
        return [

        ];
    }
}
