<?php

namespace App\Http\Livewire\Cost;

use App\Models\Cost;
use Livewire\Component;

class Edit extends Component
{
    public Cost $cost;

    public function mount(Cost $cost)
    {
        $this->cost = $cost;
    }

    public function render()
    {
        return view('livewire.cost.edit');
    }

    public function submit()
    {
        $this->validate();

        $this->cost->save();

        return redirect()->route('admin.costs.index');
    }

    protected function rules(): array
    {
        return [
            'cost.price' => [
                'numeric',
                'required',
            ],
            'cost.status' => [
                'boolean',
            ],
        ];
    }
}
