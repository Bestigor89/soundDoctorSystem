<form wire:submit.prevent="submit" class="pt-3">

    <div class="form-group {{ $errors->has('mod.name') ? 'invalid' : '' }}">
        <label class="form-label required" for="name">{{ trans('cruds.mod.fields.name') }}</label>
        <input class="form-control" type="text" name="name" id="name" required wire:model.defer="mod.name">
        <div class="validation-message">
            {{ $errors->first('mod.name') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.mod.fields.name_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('mod.section_id') ? 'invalid' : '' }}">
        <label class="form-label required" for="section">{{ trans('cruds.mod.fields.section') }}</label>
        <x-select-list class="form-control" required id="section" name="section" :options="$this->listsForFields['section']" wire:model="mod.section_id" />
        <div class="validation-message">
            {{ $errors->first('mod.section_id') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.mod.fields.section_helper') }}
        </div>
    </div>

    <div class="form-group">
        <button class="btn btn-indigo mr-2" type="submit">
            {{ trans('global.save') }}
        </button>
        <a href="{{ route('admin.mods.index') }}" class="btn btn-secondary">
            {{ trans('global.cancel') }}
        </a>
    </div>
</form>