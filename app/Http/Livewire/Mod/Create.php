<?php

namespace App\Http\Livewire\Mod;

use App\Models\FileLibrary;
use App\Models\Mod;
use App\Models\Section;
use Livewire\Component;

class Create extends Component
{
    public Mod $mod;

    public array $sound_file = [];

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
        $this->mod->soundFile()->sync($this->sound_file);

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
            'sound_file' => [
                'required',
                'array',
            ],
            'sound_file.*.id' => [
                'integer',
                'exists:file_libraries,id',
            ],
        ];
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['section']    = Section::pluck('name', 'id')->toArray();
        $this->listsForFields['sound_file'] = FileLibrary::pluck('name', 'id')->toArray();
    }
}
