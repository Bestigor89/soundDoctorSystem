<?php

namespace App\Console\Commands;

use App\Models\Doctor;
use App\Models\DocUser;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class moveUserToPacient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:userToPacient';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command move user to Pacient  ';

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
//DOCTOR
        $users = User::whereHas('roles', function ($q) {
            $q->where('title', 'Doctor');
        })->get();
        /** @var User $user */

        foreach ($users as $user) {
            $doctor = new Doctor();
            $doctor->user_id = $user->getId();
            $doctor->name = $user->getName();
            $doctor->status = true;
            $doctor->save();
        }

//USERs
        $users = User::whereHas('roles', function ($q) {
            $q->where('title', 'User');
        })->get();
//        dd($users[0]);
        /** @var User $user */
        foreach ($users as $user) {
            $temp = $user->getAdditionalData()->where('owner','=',$user->getDocId());
//            dd($temp );
              $patiens = new Patient();
              $patiens->user_id = $user->getId();
              $patiens->doctor_id = $user->getDocId();
              $patiens->name = $user->getName();
              $patiens->phone = $user->getAdditionalData()->first()->getPhone();
              $patiens->saveOrFail();

        }

        return 0;
    }
}
