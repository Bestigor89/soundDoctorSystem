<?php

namespace App\Console\Commands;

use App\Models\DocPart;
use App\Models\Doctor;
use App\Models\DocUser;
use App\Models\Patient;
use App\Models\Role;
use App\Models\Section;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class moveRazdel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:razdel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command move user to Razdel  ';

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
     * @throws \Throwable
     */
    public function handle()
    {
        echo "starts\n";
        DocPart::all();
        foreach (DocPart::all() as $part) {
            $section = Section::where('name', $part->part_name)->first();
            if(!$section) {
                $section = new Section();
                $section->name = $part->part_name;
                $section->save();
            }
        }

        return 0;
    }
}
