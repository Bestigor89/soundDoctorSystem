<div>
    <div class="card-controls sm:flex">
        <div class="w-full sm:w-1/2">
            Per page:
            <select wire:model="perPage" class="form-select w-full sm:w-1/6">
                @foreach($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>

            @can('file_fore_mod_delete')
                <button class="btn btn-rose ml-3 disabled:opacity-50 disabled:cursor-not-allowed" type="button" wire:click="confirm('deleteSelected')" wire:loading.attr="disabled" {{ $this->selectedCount ? '' : 'disabled' }}>
                    {{ __('Delete Selected') }}
                </button>
            @endcan

            @if(file_exists(app_path('Http/Livewire/ExcelExport.php')))
                <livewire:excel-export model="FileForeMod" format="csv" />
                <livewire:excel-export model="FileForeMod" format="xlsx" />
                <livewire:excel-export model="FileForeMod" format="pdf" />
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
                            {{ trans('cruds.fileForeMod.fields.id') }}
                            @include('components.table.sort', ['field' => 'id'])
                        </th>
                        <th>
                            {{ trans('cruds.fileForeMod.fields.file') }}
                            @include('components.table.sort', ['field' => 'file.name'])
                        </th>
                        <th>
                            {{ trans('cruds.fileLibrary.fields.durations') }}
                            @include('components.table.sort', ['field' => 'file.durations'])
                        </th>
                        <th>
                            {{ trans('cruds.fileForeMod.fields.sort_order') }}
                            @include('components.table.sort', ['field' => 'sort_order'])
                        </th>
                        <th>
                            {{ trans('cruds.fileForeMod.fields.mod') }}
                            @include('components.table.sort', ['field' => 'mod.name'])
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fileForeMods as $fileForeMod)
                        <tr>
                            <td>
                                <input type="checkbox" value="{{ $fileForeMod->id }}" wire:model="selected">
                            </td>
                            <td>
                                {{ $fileForeMod->id }}
                            </td>
                            <td>
                                @if($fileForeMod->file)
                                    <span class="badge badge-relationship">{{ $fileForeMod->file->name ?? '' }}</span>
                                @endif
                            </td>
                            <td>
                                @if($fileForeMod->file)
                                    {{ $fileForeMod->file->durations ?? '' }}
                                @endif
                            </td>
                            <td>
                                {{ $fileForeMod->sort_order }}
                            </td>
                            <td>
                                @if($fileForeMod->mod)
                                    <span class="badge badge-relationship">{{ $fileForeMod->mod->name ?? '' }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex justify-end">
                                    @can('file_fore_mod_show')
                                        <a class="btn btn-sm btn-info mr-2" href="{{ route('admin.file-fore-mods.show', $fileForeMod) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
                                    @can('file_fore_mod_edit')
                                        <a class="btn btn-sm btn-success mr-2" href="{{ route('admin.file-fore-mods.edit', $fileForeMod) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan
                                    @can('file_fore_mod_delete')
                                        <button class="btn btn-sm btn-rose mr-2" type="button" wire:click="confirm('delete', {{ $fileForeMod->id }})" wire:loading.attr="disabled">
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
            {{ $fileForeMods->links() }}
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