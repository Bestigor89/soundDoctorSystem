<form wire:submit.prevent="submit" class="pt-3">

    <div class="form-group {{ $errors->has('fileForeMod.file_id') ? 'invalid' : '' }}">
        <label class="form-label required" for="file">{{ trans('cruds.fileForeMod.fields.file') }}</label>
        <x-select-list class="form-control" required id="file" name="file" :options="$this->listsForFields['file']" wire:model="fileForeMod.file_id" />
        <div class="validation-message">
            {{ $errors->first('fileForeMod.file_id') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.fileForeMod.fields.file_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('fileForeMod.sort_order') ? 'invalid' : '' }}">
        <label class="form-label required" for="sort_order">{{ trans('cruds.fileForeMod.fields.sort_order') }}</label>
        <input class="form-control" type="number" name="sort_order" id="sort_order" required wire:model.defer="fileForeMod.sort_order" step="1">
        <div class="validation-message">
            {{ $errors->first('fileForeMod.sort_order') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.fileForeMod.fields.sort_order_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('fileForeMod.mod_id') ? 'invalid' : '' }}">
        <label class="form-label required" for="mod">{{ trans('cruds.fileForeMod.fields.mod') }}</label>
        <x-select-list class="form-control" required id="mod" name="mod" :options="$this->listsForFields['mod']" wire:model="fileForeMod.mod_id" />
        <div class="validation-message">
            {{ $errors->first('fileForeMod.mod_id') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.fileForeMod.fields.mod_helper') }}
        </div>
    </div>

    <div class="form-group">
        <button class="btn btn-indigo mr-2" type="submit">
            {{ trans('global.save') }}
        </button>
        <a href="{{ route('admin.file-fore-mods.index') }}" class="btn btn-secondary">
            {{ trans('global.cancel') }}
        </a>
    </div>
</form>