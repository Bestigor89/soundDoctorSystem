<div>
    <div class="card-header">

    </div>
    <div class="card-body">
        <form wire:submit.prevent="submit" class="pt-3">
            <div class="sm:flex mb-6">
                <div class="w-full card-header-container">
                    <a href="{{ route('admin.task-for-patients.index', ['presetPatientId' => $this->presetPatientId]) }}" class="btn btn-secondary">
                        {{ trans('global.cancel') }}
                    </a>
                    <button class="btn btn-indigo mr-2" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </div>
            <div class="sm:flex">
                @include('livewire.manager.blocks._patient')
            </div>
            <div class="sm:flex @if(blank($patient)) disabled__block @endif">
                @include('livewire.manager.blocks._module')
            </div>
            <div class="sm:flex @if(!$mod->exists) disabled__block @endif">
                @include('livewire.manager.blocks._file-list')
            </div>
            <div class="sm:flex mt-8 @if(!$mod->exists) disabled__block @endif">
                @include('livewire.manager.blocks._file-sections')
            </div>
        </form>

        @stack('forms')
    </div>
</div>

@push('scripts')
    <script>
        Livewire.on('saveModule', () => {
            @this.set('mod.name', $('#searchModule').val());
            $('#save__module').click();
        });

        Livewire.on('fileDurationChanged', (id) => {
            console.log(id);
            let duration = $('#fileDuration-' + id).val();
            Livewire.emit('updatedFileDuration', id, duration);
        });
    </script>
@endpush
