<div>
    <div class="card-controls sm:flex">
        <div class="w-full sm:w-1/2">
            Per page:
            <select wire:model="perPage" class="form-select w-full sm:w-1/6">
                @foreach($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>

            @can('file_library_delete')
                <button class="btn btn-rose ml-3 disabled:opacity-50 disabled:cursor-not-allowed" type="button" wire:click="confirm('deleteSelected')" wire:loading.attr="disabled" {{ $this->selectedCount ? '' : 'disabled' }}>
                    {{ __('Delete Selected') }}
                </button>
            @endcan

            @if(file_exists(app_path('Http/Livewire/ExcelExport.php')))
                <livewire:excel-export model="FileLibrary" format="csv" />
                <livewire:excel-export model="FileLibrary" format="xlsx" />
                <livewire:excel-export model="FileLibrary" format="pdf" />
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
                            {{ trans('cruds.fileLibrary.fields.id') }}
                            @include('components.table.sort', ['field' => 'id'])
                        </th>
                        <th>
                            {{ trans('cruds.fileLibrary.fields.name') }}
                            @include('components.table.sort', ['field' => 'name'])
                        </th>
                        <th>
                            {{ trans('cruds.fileLibrary.fields.sound_file') }}
                        </th>
                        <th>
                            {{ trans('cruds.fileLibrary.fields.durations') }}
                            @include('components.table.sort', ['field' => 'durations'])
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fileLibraries as $fileLibrary)
                        <tr>
                            <td>
                                <input type="checkbox" value="{{ $fileLibrary->id }}" wire:model="selected">
                            </td>
                            <td>
                                {{ $fileLibrary->id }}
                            </td>
                            <td>
                                {{ $fileLibrary->name }}
                            </td>
                            <td>
                                @foreach($fileLibrary->sound_file as $key => $entry)
                                    <a class="link-light-blue" href="{{ $entry['url'] }}">
                                        <i class="far fa-file">
                                        </i>
                                        {{ $entry['file_name'] }}
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                {{ $fileLibrary->durations }}
                            </td>
                            <td>
                                <div class="flex justify-end">
                                    @can('file_library_show')
                                        <a class="btn btn-sm btn-info mr-2" href="{{ route('admin.file-libraries.show', $fileLibrary) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
                                    @can('file_library_edit')
                                        <a class="btn btn-sm btn-success mr-2" href="{{ route('admin.file-libraries.edit', $fileLibrary) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan
                                    @can('file_library_delete')
                                        <button class="btn btn-sm btn-rose mr-2" type="button" wire:click="confirm('delete', {{ $fileLibrary->id }})" wire:loading.attr="disabled">
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
            {{ $fileLibraries->links() }}
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