<?php

namespace App\Console\Commands;

use App\Models\FileLibrary;
use App\Models\Section;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Flysystem\FilesystemException;

class ImportFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var \Illuminate\Database\Connection|\Illuminate\Database\ConnectionInterface
     */
    protected $dataBase;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->dataBase = DB::connection('import');
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws FilesystemException
     */
    public function handle()
    {
        $files = $this->dataBase->table('doc_track')->get();

        foreach ($files as $file) {
            $this->handleItem($file);
        }
    }

    /**
     * @param $item
     * @return void
     */
    protected function handleItem($item)
    {
        $section = $this->handleSection($item);
        $fileLibrary = $this->handleFileLibrary($item);

        $fileLibrary->section()->sync($section);

        try {
            $fileLibrary->addMediaFromDisk(data_get($item, 'track_url'), 'import')->toMediaCollection('file_library_sound_file');
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * @param $item
     * @return Section|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function handleSection($item)
    {
        $part = $this->getPart(data_get($item, 'part_id'));

        $section = $this->getSection(trim(data_get($part, 'part_name'))) ?? new Section;

        if ($section->exists) {
            return $section;
        }

        $section->forceFill([
            'name' => trim(data_get($part, 'part_name')),
        ])->save();

        return $section;
    }

    /**
     * @param $item
     * @return FileLibrary|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function handleFileLibrary($item)
    {
        $fileLibrary = new FileLibrary;

        $fileLibrary->forceFill([
            'name' => trim(data_get($item, 'track_name')),
            'durations' => data_get($item, 'duration'),
        ])->save();

        return $fileLibrary;
    }

    /**
     * @param $item
     * @param Section $section
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null
     */
    protected function getFileLibrary($item, Section $section)
    {
        return FileLibrary::query()->where('name', data_get($item, 'track_name'))
            ->where('durations', (int)data_get($item, 'duration'))
            ->first();
    }

    /**
     * @param $name
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null
     */
    protected function getSection($name)
    {
        return Section::query()->firstWhere('name', $name);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    protected function getPart($id)
    {
        return $this->dataBase->table('doc_part')->where('part_id', $id)->first();
    }
}
