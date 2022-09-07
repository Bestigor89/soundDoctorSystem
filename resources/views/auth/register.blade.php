@extends('layouts.app')

@push('body-class', 'bg-white')

@section('content')
{{--    @include('layouts.parts._header')--}}
{{--        <form class="font-sans text-sm rounded w-full sm:max-w-sm mx-auto my-8 px-8 pt-6 pb-8 auth__form" method="POST" action="{{ route('register') }}">--}}
{{--            @csrf--}}
{{--            <div class="relative border rounded mb-4 shadow appearance-none label-floating @error('name') has-error @enderror">--}}
{{--                <input class="w-full py-2 px-3 text-gray-700 leading-normal rounded" id="name" name="name" type="text" placeholder="{{ __('cruds.user.fields.name') }}" value="{{ old('name') }}">--}}
{{--                <label class="absolute block text-gray-700 top-0 left-0 w-full px-3 py-2 leading-normal" for="name">--}}
{{--                    {{ __('cruds.user.fields.name') }}--}}
{{--                </label>--}}
{{--            </div>--}}
{{--            <div class="relative border rounded mb-4 shadow appearance-none label-floating @error('email') has-error @enderror">--}}
{{--                <input class="w-full py-2 px-3 text-gray-700 leading-normal rounded" id="email" name="email" type="text" placeholder="{{ __('cruds.user.fields.email') }}" value="{{ old('email') }}">--}}
{{--                <label class="absolute block text-gray-700 top-0 left-0 w-full px-3 py-2 leading-normal" for="email">--}}
{{--                    {{ __('cruds.user.fields.email') }}--}}
{{--                </label>--}}
{{--            </div>--}}
{{--            <div class="relative border rounded mb-4 shadow appearance-none label-floating @error('phone') has-error @enderror">--}}
{{--                <input class="w-full py-2 px-3 text-gray-700 leading-normal rounded" id="phone" name="phone" type="text" placeholder="{{ __('cruds.patient.fields.phone') }}" value="{{ old('phone') }}">--}}
{{--                <label class="absolute block text-gray-700 top-0 left-0 w-full px-3 py-2 leading-normal" for="phone">--}}
{{--                    {{ __('cruds.patient.fields.phone') }}--}}
{{--                </label>--}}
{{--            </div>--}}
{{--            <div class="relative border rounded mb-4 shadow appearance-none label-floating @error('password') has-error @enderror">--}}
{{--                <input class="w-full py-2 px-3 text-gray-700 leading-normal rounded" id="password" name="password" type="password" placeholder="{{ __('global.login_password') }}" required autocomplete="new-password" />--}}
{{--                <label class="absolute block text-gray-700 top-0 left-0 w-full px-3 py-2 leading-normal" for="password">--}}
{{--                    {{ __('global.login_password') }}--}}
{{--                </label>--}}
{{--            </div>--}}
{{--            <div class="relative border rounded mb-4 shadow appearance-none label-floating @error('password_confirmation') has-error @enderror">--}}
{{--                <input class="w-full py-2 px-3 text-gray-700 leading-normal rounded" id="password_confirmation" name="password_confirmation" type="password" placeholder="{{ __('global.confirm_password') }}" required autocomplete="new-password" />--}}
{{--                <label class="absolute block text-gray-700 top-0 left-0 w-full px-3 py-2 leading-normal" for="password">--}}
{{--                    {{ __('global.confirm_password') }}--}}
{{--                </label>--}}
{{--            </div>--}}
{{--            <div class="flex items-center justify-between">--}}
{{--                <button class="bg-black hover:bg-black text-white py-2 px-4 w-full" type="submit">--}}
{{--                    {{ __('global.register') }}--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    @include('layouts.parts._footer')--}}
<section class="relative w-full h-full py-40 min-h-screen">
    <div class="container mx-auto px-4 h-full">
        <div class="flex content-center items-center justify-center h-full">
            <div class="w-full lg:w-6/12 px-4">
                <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-200 border-0">
                    <div class="rounded-t mb-0 px-6 py-6">
                        <div class="text-center mb-3">
                            <h6 class="text-blueGray-500 text-sm font-bold">
                                {{ __('global.register') }}
                            </h6>
                        </div>
                        <hr class="mt-6 border-b-1 border-blueGray-300" />
                    </div>
                    <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="name">
                                    {{ __('global.user_name') }}
                                </label>
                                <input id="name" name="name" type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full {{ $errors->has('name') ? ' ring ring-red-300' : '' }}" placeholder="{{ __('global.user_name') }}" required autofocus autocomplete="name" value="{{ old('name') }}" />
                                @error('name')
                                    <div class="text-red-500">
                                        <small>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="email">
                                    {{ __('global.login_email') }}
                                </label>
                                <input id="email" name="email" type="email" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full {{ $errors->has('email') ? ' ring ring-red-300' : '' }}" placeholder="{{ __('global.login_email') }}" required autocomplete="email" value="{{ old('email') }}" />
                                @error('email')
                                    <div class="text-red-500">
                                        <small>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="password">
                                    {{ __('global.login_password') }}
                                </label>
                                <input id="password" name="password" type="password" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full {{ $errors->has('password') ? ' ring ring-red-300' : '' }}" placeholder="{{ __('global.login_password') }}" required autocomplete="new-password" />
                                @error('password')
                                    <div class="text-red-500">
                                        <small>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="password_confirmation">
                                    {{ __('global.confirm_password') }}
                                </label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full" placeholder="{{ __('global.confirm_password') }}" required autocomplete="new-password" />
                            </div>
                            <div class="text-center mt-6">
                                <button class="bg-blueGray-800 text-white active:bg-blueGray-600 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full ease-linear transition-all duration-150">
                                    {{ __('global.register') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
