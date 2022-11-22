<?php

namespace App\Http\Livewire\Profile;

use App\Models\TaskForPatient;
use Livewire\Component;

class Task extends Component
{
    public int $perPage;

    public function mount()
    {
        $this->perPage = 100;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $user = \Auth::user();

        $query = TaskForPatient::query()
            ->with(['mode', 'cost', 'pacient', 'pacient.doctor'])
            ->whereHas('pacient', function ($relation) use ($user) {
                $relation->where('user_id', $user->id);
            })
            ->whereRaw('DATE_ADD(`date_start`, INTERVAL 1 DAY) > ?', [now()])
            ->latest('date_start');

        $items = $query->paginate($this->perPage);

        return view('livewire.profile.tasks', compact('items'));
    }
}
