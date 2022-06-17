<form wire:submit.prevent="submit" class="pt-3">

    <div class="form-group {{ $errors->has('fileLibrary.name') ? 'invalid' : '' }}">
        <label class="form-label required" for="name">{{ trans('cruds.fileLibrary.fields.name') }}</label>
        <input class="form-control" type="text" name="name" id="name" required wire:model.defer="fileLibrary.name">
        <div class="validation-message">
            {{ $errors->first('fileLibrary.name') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.fileLibrary.fields.name_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('mediaCollections.file_library_sound_file') ? 'invalid' : '' }}">
        <label class="form-label required" for="sound_file">{{ trans('cruds.fileLibrary.fields.sound_file') }}</label>
        <x-dropzone id="sound_file" name="sound_file" action="{{ route('admin.file-libraries.storeMedia') }}" collection-name="file_library_sound_file" max-file-size="500" max-files="1" />
        <div class="validation-message">
            {{ $errors->first('mediaCollections.file_library_sound_file') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.fileLibrary.fields.sound_file_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('fileLibrary.durations') ? 'invalid' : '' }}">
        <label class="form-label required" for="durations">{{ trans('cruds.fileLibrary.fields.durations') }}</label>
        <input class="form-control" type="number" name="durations" id="durations" required wire:model.defer="fileLibrary.durations" step="1">
        <div class="validation-message">
            {{ $errors->first('fileLibrary.durations') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.fileLibrary.fields.durations_helper') }}
        </div>
    </div>

    <div class="form-group">
        <button class="btn btn-indigo mr-2" type="submit">
            {{ trans('global.save') }}
        </button>
        <a href="{{ route('admin.file-libraries.index') }}" class="btn btn-secondary">
            {{ trans('global.cancel') }}
        </a>
    </div>
</form>