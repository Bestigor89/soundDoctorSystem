<div>
    <div class="card-header">

    </div>
    <div class="card-body">
        <form wire:submit.prevent="submit" class="pt-3">
            <div class="sm:flex mb-6">
                <div class="w-full card-header-container">
                    <div class="w-full sm:w-1/4 text-left">
                        <a href="{{ route('admin.task-for-patients.index', ['presetPatientId' => $this->presetPatientId]) }}" class="btn btn-secondary">
                            {{ trans('global.cancel') }}
                        </a>
                    </div>
                    <div class="w-full sm:w-1/4 text-right">
                        <div class="form-group {{ $errors->has('date_start') ? 'invalid' : '' }}">
                            <x-date-picker id="date_start" name="date_start" wire:model="date_start" placeholder="{{ trans('cruds.taskForPatient.fields.date_start') }}" />
                            <div class="validation-message">
                                {{ $errors->first('date_start') }}
                            </div>
                        </div>
                    </div>
                    <div class="w-full sm:w-1/4 text-right" style="text-align: right;">
                        <button class="btn btn-indigo mr-2" type="submit">
                            {{ trans('global.save') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full">
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
            let duration = $('#fileDuration-' + id).val();
            Livewire.emit('updatedFileDuration', id, duration);
        });
    </script>
@endpush
