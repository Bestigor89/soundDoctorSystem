<?php

namespace App\Http\Livewire\Cost;

use App\Models\Cost;
use Livewire\Component;

class Create extends Component
{
    public Cost $cost;

    public function mount(Cost $cost)
    {
        $this->cost         = $cost;
        $this->cost->status = false;
    }

    public function render()
    {
        return view('livewire.cost.create');
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
