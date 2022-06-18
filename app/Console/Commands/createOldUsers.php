<?php

namespace App\Console\Commands;

use App\Models\DocUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class createOldUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:oldUser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This comand add relation from old user ';

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
     */
    public function handle()
    {
        echo "starts\n";
        $docUsers = DocUser::all();
        foreach ($docUsers as $docUser)
        {
            /** @var DocUser $docUser */
//            dd($docUser->);
            $user = User::where('email', $docUser->email)->first();
//            dd($role->getRoleId("Doctor"));
            if(empty($user))
            {
                /** @var User $newUser */
                $newUser = new User();
                $newUser->doc_user_id = $docUser->user_id;
                $newUser->name = $docUser->fio;
                $newUser->email = Str::of($docUser->email)->trim();
                $newUser->password = $newUser->setPasswordAttribute('demo1234');
                $newUserid = $newUser->save();

                if($docUser->user_type==2)
                {
                    $role = new Role();
                    $newUser->roles()->sync($role->getRoleBySlug("Doctor"));
                    echo $newUser->id;
                }else{
                    $role= new Role();
                    $newUser->roles()->sync($role->getRoleBySlug("User"));
                }
                $newUser->save();
                if(!empty($user->email)){
                echo $user->email.'\n';
                }

            }
        }
        return 0;
    }
}
