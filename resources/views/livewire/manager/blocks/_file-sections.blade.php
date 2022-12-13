<div class="w-full sm:w-1/2 mt-4">
    @foreach($this->listsForFields['sections'] as $sectionItem)
        <button
            class="btn btn-secondary @if(data_get($section, 'id') === $sectionItem->id) btn-success @endif mb-3"
            wire:click.prevent="setSection({{ $sectionItem->id }})"
        >{{ $sectionItem->name }}</button>
    @endforeach
    <button
        class="btn btn-secondary @if(!blank($section) && !$section->exists) btn-success @endif mb-3"
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
<div class="w-full sm:w-1/2">
    <input type="text" wire:model.debounce.300ms="searchFile" name="searchFile" id="searchFile" class="block w-full form-control" placeholder="{{ __('global.search_file_placeholder') }}">
    <div class="flex justify-center items-center" wire:loading.grid wire:target="searchFile">
        @lang('global.loading')
    </div>
</div>
