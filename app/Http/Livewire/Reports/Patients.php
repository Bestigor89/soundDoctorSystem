<?php

namespace App\Http\Livewire\Reports;

use App\Enums\TaskForPatientStatusEnum;
use App\Models\TaskForPatient;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Patients extends Component
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $user = Auth::user();

        $query = TaskForPatient::query()
            ->select(DB::raw('COUNT(task_for_patients.id) as task_count, SUM(costs.price) as count_price, patients.id as patient_id, doctors.id, patients.name as patient, doctors.name as doctor, YEAR(date_start) year, MONTH(date_start) month'))
            ->join('costs', 'task_for_patients.cost_id', 'costs.id')
            ->join('patients', 'task_for_patients.pacient_id', 'patients.id')
            ->join('doctors', 'patients.doctor_id', 'doctors.id')
            ->when(! $user->is_admin, function (Builder $builder) use ($user) {
                return $builder->where('doctors.user_id', $user->id);
            })
            ->where('task_for_patients.status', '=', TaskForPatientStatusEnum::FINISHED)
            ->groupby('year','month', 'patients.id', 'doctors.id');

        $items = $query->get();

        return view('livewire.reports.patients', compact('query', 'items'));
    }
}
