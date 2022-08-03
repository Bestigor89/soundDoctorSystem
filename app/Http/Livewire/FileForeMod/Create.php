<?php

namespace App\Http\Livewire\FileForeMod;

use App\Models\FileForeMod;
use App\Models\FileLibrary;
use App\Models\Mod;
use Livewire\Component;

class Create extends Component
{
    public FileForeMod $fileForeMod;

    public array $listsForFields = [];

    public function mount(FileForeMod $fileForeMod)
    {
        $this->fileForeMod             = $fileForeMod;
        $this->fileForeMod->sort_order = '0';
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.file-fore-mod.create');
    }

    public function submit()
    {
        $this->validate();

        $this->fileForeMod->save();

        return redirect()->route('admin.file-fore-mods.index');
    }

    protected function rules(): array
    {
        return [
            'fileForeMod.file_id' => [
                'integer',
                'exists:file_libraries,id',
                'required',
            ],
            'fileForeMod.sort_order' => [
                'integer',
                'min:-2147483648',
                'max:2147483647',
                'required',
            ],
            'fileForeMod.mod_id' => [
                'integer',
                'exists:mods,id',
                'required',
            ],
        ];
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['file'] = FileLibrary::pluck('name', 'id')->toArray();
        $this->listsForFields['mod']  = Mod::pluck('name', 'id')->toArray();
    }
}
