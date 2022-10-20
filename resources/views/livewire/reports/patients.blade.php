<div>
    <div class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table table-index w-full">
                <thead>
                <tr>
                    <th class="w-9">
                    </th>
                    <th>
                        {{ trans('cruds.reports.fields.month_year') }}
                    </th>
                    <th>
                        {{ trans('cruds.reports.fields.doctor') }}
                    </th>
                    <th>
                        {{ trans('cruds.reports.fields.patient') }}
                    </th>
                    <th>
                        {{ trans('cruds.reports.fields.session_count') }}
                    </th>
                    <th>
                        {{ trans('cruds.reports.fields.money_count') }}
                    </th>
                    <th>
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td></td>
                        <td>
                            {{ $item->month }} / {{ $item->year }}
                        </td>
                        <td>
                            {{ $item->doctor }}
                        </td>
                        <td>
                            {{ $item->patient }}
                        </td>
                        <td>
                            {{ $item->task_count }}
                        </td>
                        <td>
                            {{ $item->count_price }}
                        </td>
                        <td>
                            @can('task_for_patient_create')
                                <a class="btn btn-sm btn-info mr-2" href="{{ route('admin.task-for-patients.index', ['presetPatientId' => $item->patient_id]) }}">
                                    {{ trans('cruds.taskForPatient.actions.medical_procedure') }}
                                </a>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">No entries found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
