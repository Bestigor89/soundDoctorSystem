<?php

namespace App\Http\Livewire\Section;

use App\Models\Section;
use Livewire\Component;

class Create extends Component
{
    public Section $section;

    public function mount(Section $section)
    {
        $this->section = $section;
    }

    public function render()
    {
        return view('livewire.section.create');
    }

    public function submit()
    {
        $this->validate();

        $this->section->save();

        return redirect()->route('admin.sections.index');
    }

    protected function rules(): array
    {
        return [
            'section.name' => [
                'string',
                'required',
            ],
        ];
    }
}
