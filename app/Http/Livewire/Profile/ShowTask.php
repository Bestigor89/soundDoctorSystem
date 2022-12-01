<?php

namespace App\Http\Livewire\Profile;

use App\Enums\TaskForPatientStatusEnum;
use App\Models\TaskForPatient;
use Livewire\Component;

class ShowTask extends Component
{
    public TaskForPatient $taskForPatient;

    /**
     * @var array
     */
    protected $listeners = [
        'taskFinished',
    ];

    public function mount(TaskForPatient $taskForPatient)
    {
        $this->taskForPatient = $taskForPatient;
        $this->taskForPatient->load('mode', 'mode.files');
    }

    public function render()
    {
        return view('livewire.profile.show_task');
    }

    /**
     * @return void
     */
    public function taskFinished()
    {
        $this->taskForPatient->fill([
            'status' => TaskForPatientStatusEnum::FINISHED,
        ])->save();

        session()->flash('message', trans('global.task_finished'));
    }
}
