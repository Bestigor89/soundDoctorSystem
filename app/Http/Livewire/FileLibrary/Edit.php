<?php

namespace App\Http\Livewire\FileLibrary;

use App\Models\FileLibrary;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Edit extends Component
{
    public FileLibrary $fileLibrary;

    public array $mediaToRemove = [];

    public array $mediaCollections = [];

    public function addMedia($media): void
    {
        $this->mediaCollections[$media['collection_name']][] = $media;
    }

    public function removeMedia($media): void
    {
        $collection = collect($this->mediaCollections[$media['collection_name']]);

        $this->mediaCollections[$media['collection_name']] = $collection->reject(fn ($item) => $item['uuid'] === $media['uuid'])->toArray();

        $this->mediaToRemove[] = $media['uuid'];
    }

    public function getMediaCollection($name)
    {
        return $this->mediaCollections[$name];
    }

    public function mount(FileLibrary $fileLibrary)
    {
        $this->fileLibrary      = $fileLibrary;
        $this->mediaCollections = [
            'file_library_sound_file' => $fileLibrary->sound_file,
        ];
    }

    public function render()
    {
        return view('livewire.file-library.edit');
    }

    public function submit()
    {
        $this->validate();

        $this->fileLibrary->save();
        $this->syncMedia();

        return redirect()->route('admin.file-libraries.index');
    }

    protected function syncMedia(): void
    {
        collect($this->mediaCollections)->flatten(1)
            ->each(fn ($item) => Media::where('uuid', $item['uuid'])
            ->update(['model_id' => $this->fileLibrary->id]));

        Media::whereIn('uuid', $this->mediaToRemove)->delete();
    }

    protected function rules(): array
    {
        return [
            'fileLibrary.name' => [
                'string',
                'required',
            ],
            'mediaCollections.file_library_sound_file' => [
                'array',
                'required',
            ],
            'mediaCollections.file_library_sound_file.*.id' => [
                'integer',
                'exists:media,id',
            ],
            'fileLibrary.durations' => [
                'integer',
                'min:-2147483648',
                'max:2147483647',
                'required',
            ],
        ];
    }
}
