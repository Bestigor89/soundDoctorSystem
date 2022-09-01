<?php

namespace App\Http\Livewire\Manager;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public array $listsForFields = [];

    /**
     * @var int|null
     */
    public $presetPatientId = null;

    /**
     * @var Patient|null
     */
    public $patient = null;

    /**
     * @var string|null
     */
    public $searchPatient = null;

    /**
     * @var array
     */
    public $patientList = [];

    protected $queryString = [
        'presetPatientId',
    ];

    /**
     * @return void
     */
    public function mount()
    {
        $this->initListsForFields();
        if ($this->presetPatientId) {
            $patient = Patient::query()->find($this->presetPatientId);
            $this->patientList[] = $patient;
            $this->patient = $patient;
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.manager.index');
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function updatingSearchPatient(string $value = null)
    {
        $result = Patient::query();
        if (blank($value)) {
            $this->patientList = [];

            return;
        }

        $user = Auth::user();
        $this->patientList = $result
            ->when(! $user->is_admin, function (Builder $builder) use ($user) {
                return $builder->whereHas('doctor', function (Builder $builder) use ($user) {
                    return $builder->where('user_id', $user->id);
                });
            })
            ->where('name', 'LIKE', "%{$value}%")
            ->get();
    }

    /**
     * @param $id
     * @return void
     */
    public function setPatient($id)
    {
        $this->patient = Patient::query()->find($id);
        $this->patientList = [];
        $this->searchPatient = null;
    }

    /**
     * @return void
     */
    protected function initListsForFields(): void
    {
        // ...
    }
}
