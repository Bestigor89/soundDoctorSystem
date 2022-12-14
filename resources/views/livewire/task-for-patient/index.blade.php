<div>
    <div class="card-controls sm:flex">
        <div class="w-full sm:w-1/2">
            Per page:
            <select wire:model="perPage" class="form-select w-full sm:w-1/6">
                @foreach($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>

            @can('task_for_patient_delete')
                <button class="btn btn-rose ml-3 disabled:opacity-50 disabled:cursor-not-allowed" type="button" wire:click="confirm('deleteSelected')" wire:loading.attr="disabled" {{ $this->selectedCount ? '' : 'disabled' }}>
                    {{ __('Delete Selected') }}
                </button>
            @endcan

            @if(file_exists(app_path('Http/Livewire/ExcelExport.php')))
                <livewire:excel-export model="TaskForPatient" format="csv" />
                <livewire:excel-export model="TaskForPatient" format="xlsx" />
                <livewire:excel-export model="TaskForPatient" format="pdf" />
            @endif




        </div>
        <div class="w-full sm:w-1/2 sm:text-right">
            Search:
            <input type="text" wire:model.debounce.300ms="search" class="w-full sm:w-1/3 inline-block" />
        </div>
    </div>
    <div wire:loading.delay>
        Loading...
    </div>

    <div class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table table-index w-full">
                <thead>
                    <tr>
                        <th class="w-9">
                        </th>
                        <th class="w-28">
                            {{ trans('cruds.taskForPatient.fields.id') }}
                            @include('components.table.sort', ['field' => 'id'])
                        </th>
                        <th>
                            {{ trans('cruds.taskForPatient.fields.pacient') }}
                            @include('components.table.sort', ['field' => 'pacient.name'])
                        </th>
                        <th>
                            {{ trans('cruds.taskForPatient.fields.cost') }}
                            @include('components.table.sort', ['field' => 'cost.price'])
                        </th>
                        <th>
                            {{ trans('cruds.taskForPatient.fields.mode') }}
                            @include('components.table.sort', ['field' => 'mode.name'])
                        </th>
                        <th>
                            {{ trans('cruds.taskForPatient.fields.status') }}
                            @include('components.table.sort', ['field' => 'taskForPatient.status'])
                        </th>
                        <th>
                            {{ trans('cruds.taskForPatient.fields.date_start') }}
                            @include('components.table.sort', ['field' => 'status'])
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($taskForPatients as $taskForPatient)
                        <tr>
                            <td>
                                <input type="checkbox" value="{{ $taskForPatient->id }}" wire:model="selected">
                            </td>
                            <td>
                                {{ $taskForPatient->id }}
                            </td>
                            <td>
                                @if($taskForPatient->pacient)
                                    <span class="badge badge-relationship">{{ $taskForPatient->pacient->name ?? '' }}</span>
                                @endif
                            </td>
                            <td>
                                @if($taskForPatient->cost)
                                    <span class="badge badge-relationship">{{ $taskForPatient->cost->price ?? '' }}</span>
                                @endif
                            </td>
                            <td>
                                @if($taskForPatient->mode)
                                    <span class="badge badge-relationship">{{ $taskForPatient->mode->name ?? '' }}</span>
                                @endif
                            </td>
                            <td>
                                <input class="disabled:opacity-50 disabled:cursor-not-allowed" type="checkbox" disabled {{ $taskForPatient->status ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ system_datetime_to_display($taskForPatient->date_start) }}
                            </td>
                            <td>
                                <div class="flex justify-end">
                                    @can('task_for_patient_show')
                                        <a class="btn btn-sm btn-info mr-2" href="{{ route('admin.task-for-patients.show', $taskForPatient) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
                                    @can('task_for_patient_edit')
                                        <a class="btn btn-sm btn-success mr-2" href="{{ route('admin.manager.edit', $taskForPatient) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan
                                    @can('task_for_patient_delete')
                                        <button class="btn btn-sm btn-rose mr-2" type="button" wire:click="confirm('delete', {{ $taskForPatient->id }})" wire:loading.attr="disabled">
                                            {{ trans('global.delete') }}
                                        </button>
                                    @endcan
                                </div>
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

    <div class="card-body">
        <div class="pt-3">
            @if($this->selectedCount)
                <p class="text-sm leading-5">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
            @endif
            {{ $taskForPatients->links() }}
        </div>
    </div>
</div>

@push('scripts')
    <script>
        Livewire.on('confirm', e => {
    if (!confirm("{{ trans('global.areYouSure') }}")) {
        return
    }
@this[e.callback](...e.argv)
})
    </script>
@endpush
