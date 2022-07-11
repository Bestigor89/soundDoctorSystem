<?php

namespace App\Console\Commands;

use App\Models\DocTrack;
use App\Models\FileLibrary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FilesystemException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\Console\Output\ConsoleOutput;

class moveFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws FilesystemException
     */
    public function handle()
    {
        $this->line("Start move files");
        $files = DocTrack::all();
        foreach ($files as $file) {
            /** @var DocTrack $file */
//            dd($file);
          try {
              $path = '/app/Old/'.$file->getTrackUrl();
              $this->line("mv ".$path);
              $fileLibrary = new FileLibrary();
              $fileLibrary->addMedia($path)->toMediaCollection('file_library_sound_file');
              $fileLibrary->durations = $file->getDuration();
              $fileLibrary->name = $file->getTrackName();
              $fileLibrary->save();
          }catch (\Exception $exception)
          {

          }
//                Storage::disk('public')->write('audio', $fileStream);

        }
        return 0;
    }
}
//todo необходимо привязать файлы к разделам согласно новым ИД
