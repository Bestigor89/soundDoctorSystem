<div>
    <div class="card-controls sm:flex">
        <div class="w-full sm:w-1/2">
            Per page:
            <select wire:model="perPage" class="form-select w-full sm:w-1/6">
                @foreach($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>

            @can('patient_delete')
                <button class="btn btn-rose ml-3 disabled:opacity-50 disabled:cursor-not-allowed" type="button" wire:click="confirm('deleteSelected')" wire:loading.attr="disabled" {{ $this->selectedCount ? '' : 'disabled' }}>
                    {{ __('Delete Selected') }}
                </button>
            @endcan

            @if(file_exists(app_path('Http/Livewire/ExcelExport.php')))
                <livewire:excel-export model="Patient" format="csv" />
                <livewire:excel-export model="Patient" format="xlsx" />
                <livewire:excel-export model="Patient" format="pdf" />
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
                            {{ trans('cruds.patient.fields.id') }}
                            @include('components.table.sort', ['field' => 'id'])
                        </th>
                        <th>
                            {{ trans('cruds.patient.fields.name') }}
                            @include('components.table.sort', ['field' => 'name'])
                        </th>
                        <th>
                            {{ trans('cruds.patient.fields.doctor') }}
                            @include('components.table.sort', ['field' => 'doctor.name'])
                        </th>
                        <th>
                            {{ trans('cruds.patient.fields.phone') }}
                            @include('components.table.sort', ['field' => 'phone'])
                        </th>
                        <th>
                            {{ trans('cruds.patient.fields.status') }}
                            @include('components.table.sort', ['field' => 'status'])
                        </th>
                        <th>
                            {{ trans('cruds.patient.fields.user') }}
                            @include('components.table.sort', ['field' => 'user.name'])
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                            @include('components.table.sort', ['field' => 'user.email'])
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>
                                <input type="checkbox" value="{{ $patient->id }}" wire:model="selected">
                            </td>
                            <td>
                                {{ $patient->id }}
                            </td>
                            <td>
                                {{ $patient->name }}
                            </td>
                            <td>
                                @if($patient->doctor)
                                    <span class="badge badge-relationship">{{ $patient->doctor->name ?? '' }}</span>
                                @endif
                            </td>
                            <td>
                                {{ $patient->phone }}
                            </td>
                            <td>
                                <input class="disabled:opacity-50 disabled:cursor-not-allowed" type="checkbox" disabled {{ $patient->status ? 'checked' : '' }}>
                            </td>
                            <td>
                                @if($patient->user)
                                    <span class="badge badge-relationship">{{ $patient->user->name ?? '' }}</span>
                                @endif
                            </td>
                            <td>
                                @if($patient->user)
                                    <a class="link-light-blue" href="mailto:{{ $patient->user->email ?? '' }}">
                                        <i class="far fa-envelope fa-fw">
                                        </i>
                                        {{ $patient->user->email ?? '' }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                <div class="flex justify-end">
                                    @can('task_for_patient_create')
                                        <a class="btn btn-sm btn-indigo mr-2" href="{{ route('admin.task-for-patients.index', ['presetPatientId' => $patient]) }}">
                                            {{ trans('cruds.taskForPatient.actions.medical_procedure') }}
                                        </a>
                                    @endcan
                                    @can('patient_show')
                                        <a class="btn btn-sm btn-info mr-2" href="{{ route('admin.patients.show', $patient) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
                                    @can('patient_edit')
                                        <a class="btn btn-sm btn-success mr-2" href="{{ route('admin.patients.edit', $patient) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan
                                    @can('patient_delete')
                                        <button class="btn btn-sm btn-rose mr-2" type="button" wire:click="confirm('delete', {{ $patient->id }})" wire:loading.attr="disabled">
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
            {{ $patients->links() }}
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
