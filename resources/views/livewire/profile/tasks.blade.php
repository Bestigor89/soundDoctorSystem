<div>
    <div class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table table-index w-full">
                <thead>
                <tr>
                    <th>
                        {{ trans('models.mod.labels.label') }}
                    </th>
                    <th>
                        {{ trans('cruds.reports.fields.doctor') }}
                    </th>
                    <th>
                        {{ trans('cruds.taskForPatient.fields.date_start') }}
                    </th>
                    <th>
                        {{ trans('cruds.taskForPatient.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.cost.fields.price') }}
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>
                            <a href="{{ route('patient.tasks.show', $item) }}">{{ $item->mode->name }}</a>
                        </td>
                        <td>
                            {{ $item->pacient->doctor->name }}
                        </td>
                        <td>
                            {{ system_datetime_to_display($item->date_start) }}
                        </td>
                        <td>
                            {{ $item->status_text }}
                        </td>
                        <td>
                            {{ $item->cost->price }}
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
