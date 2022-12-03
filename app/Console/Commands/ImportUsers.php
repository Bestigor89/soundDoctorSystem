<?php

namespace App\Console\Commands;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command add relation from old user';

    /**
     * @var \Illuminate\Database\Connection|\Illuminate\Database\ConnectionInterface
     */
    protected $dataBase;

    /**
     * @var array
     */
    protected $roleMap = [
        0 => Role::TITLE_PATIENT,
        1 => Role::TITLE_ADMIN,
        2 => Role::TITLE_DOCTOR,
    ];

    /**
     * @var int
     */
    protected $chunkCount = 100;

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
     */
    public function handle()
    {
        $users = $this->dataBase->table('doc_users')->get();

        foreach ($users as $user) {
            $this->handleItem($user);
        }

        return self::SUCCESS;
    }

    /**
     * @param $item
     * @return void
     */
    protected function handleItem($item)
    {
        $user = $this->createUser($item);
        $this->createDoctor($item, $user);
        $this->createPatient($item, $user);
    }

    /**
     * @param $item
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|User
     */
    protected function createUser($item)
    {
        if ($exist = $this->userExist($item)) {
            return $exist;
        }

        $attributes = $this->prepareUser($item);

        $user = new User;

        $user->forceFill($attributes)->save();

        $user->roles()->attach($this->getUserRole($item));

        return $user;
    }

    /**
     * @param $item
     * @param User $user
     * @return void
     */
    protected function createPatient($item, User $user)
    {
        if (! $user->hasRole(Role::TITLE_PATIENT)) {
            return;
        }

        $patient = new Patient;

        $patient->forceFill($this->preparePatient($item, $user))->save();
    }

    /**
     * @param $item
     * @param User $user
     * @return void
     */
    protected function createDoctor($item, User $user)
    {
        if (! $user->hasRole(Role::TITLE_DOCTOR)) {
            return;
        }

        $doctor = new Doctor;

        $doctor->forceFill($this->prepareDoctor($item, $user))->save();
    }

    /**
     * @param $item
     * @return array
     */
    protected function prepareUser($item)
    {
        return [
            'name' => trim(data_get($item, 'login')),
            'email' => trim(data_get($item, 'email')),
            'email_verified_at' => now(),
            'locale' => trim(data_get($item, 'user_lang')),
            'status' => trim(data_get($item, 'active')),
            'password' => bcrypt('demo1234'),
        ];
    }

    /**
     * @param $item
     * @param User $user
     * @return array
     */
    protected function preparePatient($item, User $user)
    {
        return [
            'name' => trim(data_get($item, 'fio') ?? data_get($item, 'login')),
            'user_id' => $user->id,
            'status' => trim(data_get($item, 'active')),
            'phone' => trim(data_get($item, 'tel')),
        ];
    }

    /**
     * @param $item
     * @param User $user
     * @return array
     */
    protected function prepareDoctor($item, User $user)
    {
        return [
            'name' => data_get($item, 'login'),
            'user_id' => $user->id,
            'status' => trim(data_get($item, 'active')),
        ];
    }

    /**
     * @param $item
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function userExist($item)
    {
        return User::query()->firstWhere('email', trim(data_get($item, 'email')));
    }

    /**
     * @param $item
     * @return Role
     */
    protected function getUserRole($item)
    {
        $role = Arr::get($this->roleMap, data_get($item, 'user_type'));

        return Role::byTitle($role);
    }
}
