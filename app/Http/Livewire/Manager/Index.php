<?php

namespace App\Http\Livewire\Manager;

use App\Http\Livewire\WithConfirmation;
use App\Http\Livewire\WithSorting;
use App\Models\Cost;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    public function mount()
    {
    }

    public function render()
    {

        return view('livewire.manager.index');
    }

}
