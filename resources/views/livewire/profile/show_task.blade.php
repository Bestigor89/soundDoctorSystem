<div>
    <div class="w-full sm:w-1/2 text-center p-4">
        <a class="btn btn-sm btn-info mr-2 player__play"><i class="fa fa-play"></i></a>
        <a class="btn btn-sm btn-info mr-2 player__pause"><i class="fa fa-pause"></i></a>
{{--        <a class="btn btn-sm btn-info mr-2 player__stop"><i class="fa fa-stop"></i></a>--}}
    </div>
    <div class="w-full sm:w-1/2 pb-32">
        <ul class="divide-y divide-gray-200 rounded-md border border-gray-200">
            @forelse($taskForPatient->mode->files as $item)
                <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm play__item" data-url="{{ data_get($item->sound_file->first(), 'url') }}" data-duration="{{ data_get($item, 'pivot.durations') ?? data_get($item, 'durations') }}">
                    <div class="flex w-0 flex-1 items-center">
                        <span class="ml-2 w-0 flex-1 truncate mt-1 mb-1">
                            {{ data_get($item, 'name') }}
                        </span>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        {{ data_get($item, 'pivot.durations') }}
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
    </div>
</div>

@push('scripts')
    <script>
        let items = [],
            playing = false,
            fullDuration = true,
            playingInterval = null,
            playerInterval = null,
            event = null,
            sound;

        $('.play__item').each((index, element) => {
            items.push($(element).attr('data-url'));
        });

        function getDurationByUrl(url) {
            let duration;

            $('.play__item').each((index, element) => {
                if ($(element).attr('data-url') === url) {
                    duration = $(element).attr('data-duration');
                }
            });

            return duration;
        }

        function stopInterval(id) {
            clearInterval(id);
        }

        function autoplay(i, list) {
            sound = new Howl({
                src: [list[i]],
                preload: true,
                onend: function () {
                    let duration = getDurationByUrl(list[i]);
                    if (Number(duration) > sound.duration()) {
                        autoplay([i], list);
                        stopInterval(playingInterval);
                        return;
                    }

                    if ((i + 1) == list.length) {
                        playing = false;
                        Livewire.emit('taskFinished');
                        // autoplay(0, list);
                    } else {
                        autoplay(i + 1, list);
                    }
                },
                onplay: function () {
                    let duration = getDurationByUrl(list[i]);
                    playingInterval = setInterval(function () {
                        let seek;
                        if (fullDuration === false) {
                            seek = sound.duration() + sound.seek();
                        } else {
                            seek = sound.seek();
                        }

                        if (Number(duration) < seek) {
                            sound.stop();
                            stopInterval(playingInterval);

                            if (list.length  == (i + 1)) {
                                sound.stop();
                                playing = false;
                                Livewire.emit('taskFinished');
                                return;
                            }

                            autoplay(i + 1, list);
                            fullDuration = true;
                        }
                    }, 1000);
                },
            });

            sound.play();
        }

        $('.player__play').click(function () {
            if (playing === false) {
                playing = true;
                if (sound instanceof Howl) {
                    sound.play();
                } else {
                    autoplay(0, items);
                }
            }
        });

        $('.player__stop').click(function () {
            if (playing === true) {
                playing = false;
                stopInterval(playingInterval);
                sound.stop();
            }
        });

        $('.player__pause').click(function () {
            if (playing === true) {
                playing = false;
                sound.pause();
            }
        });
    </script>
@endpush
