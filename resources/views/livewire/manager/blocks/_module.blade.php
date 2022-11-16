<div class="w-full sm:w-1/2 form-group {{ $errors->has('mod.name') ? 'invalid' : '' }}">
    <label for="searchModule" class="form-label">@lang('models.mod.labels.label')</label>
    <input type="text" wire:model.debounce.300ms="searchModule" name="searchModule" id="searchModule"
           class="block w-full form-control"
    >
    <div class="validation-message">
        {{ $errors->first('mod.name') }}
    </div>
    <div class="flex justify-center items-center" wire:loading.grid wire:target="searchModule">
        @lang('global.loading')
    </div>
    @push('forms')
        <form wire:submit.prevent="saveModule" class="hidden">
            <input type="text" id="mod.name" name="mod.name" wire:model="mod.name" />
            <button type="submit" id="save__module"></button>
        </form>
    @endpush
    @if(!blank($searchModule))
        <button class="btn btn-indigo mt-2" type="button" wire:click.prevent="$emit('saveModule')">
            {{ trans('models.mod.actions.create') }}
        </button>
    @endif
    @if(isset($moduleList) && !blank($moduleList))
        <div class="bg-white py-5 sm:grid sm:grid-cols-3 sm:gap-4 mt-2 w-full">
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                <ul class="divide-y divide-gray-200 rounded-md border border-gray-200">
                    @foreach($moduleList as $moduleItem)
                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm {{ $moduleItem->id === data_get($mod, 'id') ? 'bg-green-500' : '' }}">
                            <div class="flex w-0 flex-1 items-center">
                                <span class="ml-2 w-0 flex-1 truncate">{{ $moduleItem->name }}</span>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                @if($moduleItem->id !== data_get($mod, 'id'))
                                    <a class="font-medium text-indigo-600 hover:text-indigo-500 cursor-pointer"
                                       wire:click.prevent="setModule({{ $moduleItem->id }})"
                                    >@lang('models.mod.labels.set')</a>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </dd>
        </div>
    @endif

    <div class="w-full mt-8">
        <label for="searchPatient" class="form-label sm:flex">
            <div class="w-full sm:w-1/2">
                @lang('models.file_for_mods.labels.label')
            </div>
            <div class="w-full sm:w-1/2 file__durations text-center">
                {{ $fileDurations }}
            </div>
        </label>
        <div class="bg-white sm:grid sm:grid-cols-3 sm:gap-4 mt-2 w-full">
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                <div class="flex justify-center items-center" wire:loading.grid wire:target="mod.files">
                    @lang('global.loading')
                </div>
                <ul class="divide-y divide-gray-200 rounded-md border border-gray-200" id="sortable__items">
                    @forelse($files as $file)
                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm sortable__item" data-order-attribute="{{ $loop->index }}" data-id="{{ data_get($file, 'id') }}">
                            <div class="flex w-0 flex-1 items-center">
                            <span class="ml-2 w-0 flex-1 truncate mt-1 mb-1">
                                {{ data_get($file, 'name') }}
                            </span>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                - {{ data_get($file, 'pivot.durations') ?? data_get($file, 'durations') }}
                                <input type="number"
                                       value="{{ data_get($file, 'pivot.durations') ?? data_get($file, 'durations') }}"
                                       id="fileDuration-{{ data_get($file, 'pivot.id') ?? data_get($file, 'id') }}"
                                       name="fileDuration-{{ data_get($file, 'pivot.id') ?? data_get($file, 'id') }}"
                                       class="inline-block w-20 form-control file__duration__input"
                                       min="0"
                                />
                                <a class="btn btn-sm btn-info mr-2"
                                   wire:click.prevent="$emit('fileDurationChanged', {{ data_get($file, 'pivot.id') ?? data_get($file, 'id') }})"
                                ><i class="fas fa-save"></i></a>
                                <a
                                        class="font-medium text-indigo-600 hover:text-indigo-500 cursor-pointer"
                                        wire:click.prevent="detachFileFromMod({{ data_get($file, 'id') }})"
                                >
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </li>
                    @empty
                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm sortable__item">
                            <div class="flex w-0 flex-1 items-center">
                                <span class="ml-2 w-0 flex-1 truncate">@lang('models.file_for_mods.labels.file_list_empty')</span>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </dd>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                let list = document.getElementById('sortable__items');

                let sortable = Sortable.create(list, {
                    animation: 150,
                    draggable: '.sortable__item',

                    onEnd: function (evt) {
                        updateOrder();
                    },
                });

                let updateOrder = function() {
                    let orderList = [];
                    $('#sortable__items .sortable__item').each((index, element) => {
                        let id = $(element).attr('data-id');
                        $(element).attr('data-order-attribute', index);

                        let order = $(element).attr('data-order-attribute');

                        orderList.push({id: Number(id), order: Number(order)});
                    });

                    Livewire.emit('orderChanged', orderList);
                };
            });
        </script>
    @endpush

</div>
<div class="w-full sm:w-1/2">
    <div class="ml-3 bg-white py-5 sm:gap-4 mt-1">
        <dd class="text-sm text-gray-900 sm:col-span-2 form-group {{ $errors->has('mod.id') ? 'invalid' : '' }}">
            <div class="divide-y divide-gray-200 rounded-md border border-gray-200">
                <div class="flex py-3 pl-3 pr-4 text-sm">
                    @if($mod->exists)
                        {{ $mod->name }} <span class="text-xs ml-4 inline-block py-1 pl-3 pr-4 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-green-500 text-white rounded">@lang('models.mod.labels.selected')</span>
                        <input type="hidden" wire:model="mod" />
                    @else
                        @lang('models.mod.labels.select')
                    @endif
                </div>
            </div>
            <div class="validation-message">
                {{ $errors->first('mod.id') }}
            </div>
        </dd>
    </div>
    @if(isset($patient) && $patient->tasks)
        @include('livewire.manager.blocks._tasks-for-patient')
    @endif
    <div class="w-full mt-8">
        <div class="w-full mt-4">
            <input type="text" wire:model.debounce.300ms="searchFile" name="searchFile" id="searchFile" class="block w-full form-control" placeholder="{{ __('global.search_file_placeholder') }}">
            <div class="flex justify-center items-center" wire:loading.grid wire:target="searchFile">
                @lang('global.loading')
            </div>
        </div>
        <div class="w-full mt-8">
            @foreach($this->listsForFields['sections'] as $sectionItem)
                <button
                        class="btn btn-secondary @if(data_get($section, 'id') === $sectionItem->id) btn-success @endif"
                        wire:click.prevent="setSection({{ $sectionItem->id }})"
                >{{ $sectionItem->name }}</button>
            @endforeach
            <button
                    class="btn btn-secondary @if(!$section->exists) btn-success @endif"
                    wire:click.prevent="setSection()"
            >All</button>
            @if (! blank($sectionFiles))
                <div class="bg-white py-5 sm:grid sm:grid-cols-3 sm:gap-4 mt-2 w-full">
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                        <ul class="divide-y divide-gray-200 rounded-md border border-gray-200">
                            @foreach($sectionFiles as $fileItem)
                                <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                    <div class="flex w-0 flex-1 items-center">
                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="ml-2 w-0 flex-1 truncate">{{ $fileItem->name }} ({{ $fileItem->durations }})</span>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        @if($files->where('id', $fileItem->id)->isEmpty())
                                            <a
                                                    class="font-medium text-indigo-600 hover:text-indigo-500 cursor-pointer"
                                                    wire:click.prevent="attachFileToMod({{ $fileItem->id }})"
                                            >@lang('models.file_for_mods.actions.attach')</a>
                                        @else
                                            @lang('models.file_for_mods.labels.already_attached')
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </dd>
                </div>
            @endif
        </div>
    </div>
</div>
