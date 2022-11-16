<div class="w-full sm:w-1/2 mt-4">
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
