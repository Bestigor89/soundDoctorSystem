<?php

namespace App\Http\Livewire\Mod;

use App\Models\Mod;
use App\Models\Section;
use Livewire\Component;

class Create extends Component
{
    public Mod $mod;

    public array $listsForFields = [];

    public function mount(Mod $mod)
    {
        $this->mod = $mod;
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.mod.create');
    }

    public function submit()
    {
        $this->validate();

        $this->mod->save();

        return redirect()->route('admin.mods.index');
    }

    protected function rules(): array
    {
        return [
            'mod.name' => [
                'string',
                'required',
            ],
            'mod.section_id' => [
                'integer',
                'exists:sections,id',
                'required',
            ],
        ];
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['section'] = Section::pluck('name', 'id')->toArray();
    }
}
