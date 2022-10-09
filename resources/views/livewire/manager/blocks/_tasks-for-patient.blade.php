<div class="ml-3 bg-white py-5 sm:gap-4 mt-1">
    <label for="searchPatient" class="form-label">@lang('models.task_for_patient.labels.list')</label>
    <div class="bg-white py-5 mt-2 w-full" style="height: 200px; overflow-y: scroll;">
        <table class="table table-index w-full">
            <thead>
                <tr>
                    <th>
                        {{ trans('cruds.taskForPatient.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.taskForPatient.fields.date_start') }}
                    </th>
                    <th>
                        {{ trans('cruds.taskForPatient.fields.status') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($patient->tasks as $task)
                    <tr>
                        <td>
                            {{ $task->id }}
                        </td>
                        <td>
                            {{ system_datetime_to_display($task->date_start) }}
                        </td>
                        <td>
                            @if ($task->status) <i class="fas fa-check"></i> @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
