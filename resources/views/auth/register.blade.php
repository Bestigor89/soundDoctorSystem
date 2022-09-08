@extends('layouts.app')

@push('body-class', 'bg-white')

@section('content')
    @include('layouts.parts._header')
        <form class="font-sans text-sm rounded w-full sm:max-w-sm mx-auto my-8 px-8 pt-6 pb-8 auth__form" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="relative border rounded mb-4 shadow appearance-none label-floating @error('name') has-error @enderror">
                <input class="w-full py-2 px-3 text-gray-700 leading-normal rounded" id="name" name="name" type="text" placeholder="{{ __('cruds.user.fields.name') }}" value="{{ old('name') }}">
                <label class="absolute block text-gray-700 top-0 left-0 w-full px-3 py-2 leading-normal" for="name">
                    {{ __('cruds.user.fields.name') }}
                </label>
            </div>
            <div class="relative border rounded mb-4 shadow appearance-none label-floating @error('email') has-error @enderror">
                <input class="w-full py-2 px-3 text-gray-700 leading-normal rounded" id="email" name="email" type="text" placeholder="{{ __('cruds.user.fields.email') }}" value="{{ old('email') }}">
                <label class="absolute block text-gray-700 top-0 left-0 w-full px-3 py-2 leading-normal" for="email">
                    {{ __('cruds.user.fields.email') }}
                </label>
            </div>
            <div class="relative border rounded mb-4 shadow appearance-none label-floating @error('phone') has-error @enderror">
                <input class="w-full py-2 px-3 text-gray-700 leading-normal rounded" id="phone" name="phone" type="text" placeholder="{{ __('cruds.patient.fields.phone') }}" value="{{ old('phone') }}">
                <label class="absolute block text-gray-700 top-0 left-0 w-full px-3 py-2 leading-normal" for="phone">
                    {{ __('cruds.patient.fields.phone') }}
                </label>
            </div>
            <div class="relative border rounded mb-4 shadow appearance-none label-floating @error('password') has-error @enderror">
                <input class="w-full py-2 px-3 text-gray-700 leading-normal rounded" id="password" name="password" type="password" placeholder="{{ __('global.login_password') }}" required autocomplete="new-password" />
                <label class="absolute block text-gray-700 top-0 left-0 w-full px-3 py-2 leading-normal" for="password">
                    {{ __('global.login_password') }}
                </label>
            </div>
            <div class="relative border rounded mb-4 shadow appearance-none label-floating @error('password_confirmation') has-error @enderror">
                <input class="w-full py-2 px-3 text-gray-700 leading-normal rounded" id="password_confirmation" name="password_confirmation" type="password" placeholder="{{ __('global.confirm_password') }}" required autocomplete="new-password" />
                <label class="absolute block text-gray-700 top-0 left-0 w-full px-3 py-2 leading-normal" for="password">
                    {{ __('global.confirm_password') }}
                </label>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-black hover:bg-black text-white py-2 px-4 w-full" type="submit">
                    {{ __('global.register') }}
                </button>
            </div>
        </form>
    @include('layouts.parts._footer')
@endsection
