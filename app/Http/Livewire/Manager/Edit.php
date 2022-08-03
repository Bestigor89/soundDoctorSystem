<?php

namespace App\Http\Livewire\Manager;

use App\Models\Cost;
use Livewire\Component;

class Edit extends Component
{

    public function mount(Cost $cost)
    {
    }

    public function render()
    {
        return view('livewire.manager.edit');
    }

    public function submit()
    {
        $this->validate();

        $this->cost->save();

        return redirect()->route('admin.manager.index');
    }

    protected function rules(): array
    {
        return [
        ];
    }
}
