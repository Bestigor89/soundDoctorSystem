@extends('layouts.app')

@push('body-class', 'bg-white')

@section('content')
    @include('layouts.parts._header')
    <form class="font-sans text-sm rounded w-full sm:max-w-sm mx-auto my-8 px-8 pt-6 pb-8 auth__form" method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="relative border rounded mb-4 shadow appearance-none label-floating @error('password') has-error @enderror">
            <input class="w-full py-2 px-3 text-gray-700 leading-normal rounded" id="password" name="password" type="password" placeholder="{{ __('global.login_password') }}" required autocomplete="new-password" />
            <label class="absolute block text-gray-700 top-0 left-0 w-full px-3 py-2 leading-normal" for="password">
                {{ __('global.login_password') }}
            </label>
        </div>
        <div class="flex">
            <button class="bg-black hover:bg-black text-white py-2 px-4 w-full" type="submit">
                {{ __('global.confirm_password') }}
            </button>
            @if(Route::has('password.request'))
                <a class="inline-block align-baseline text-gray-500 hover:text-gray-700" href="{{ route('password.request') }}">
                    {{ __('global.forgot_password') }}
                </a>
            @endif
        </div>
    </form>
    @include('layouts.parts._footer')
@endsection
