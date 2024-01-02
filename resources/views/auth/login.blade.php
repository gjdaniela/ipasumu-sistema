<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div style="font-size: 30px; color: #333333; width: 500px; border-radius: 10px; overflow: hidden; padding: 55px 55px 55px 55px; background: #9152f8; background: -webkit-linear-gradient(top, #E7D27C, #BFBFBF); background: -o-linear-gradient(top, #E7D27C, #BFBFBF); background: -moz-linear-gradient(top, #E7D27C, #BFBFBF); background: linear-gradient(top, #E7D27C, #BFBFBF);">

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h2 style="font-size: 2rem; font-weight: bold; text-align: center; color: #333333; margin-bottom: 15px;">Pieslēgšanās tabulu sistēmā</h2>
            
            <!-- Email Address -->
            <div style="margin-bottom: 20px;">
                <label for="email" style="font-weight: bold; font-size: 1.2rem; color: #333333;  display: block;">E-pasts</label>
                <x-text-input id="email" class="block w-full rounded-lg p-2" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" style="display: block; margin-bottom: 5px; border-radius: 10px; background-color: #f0f0f0; padding: 15px; width: 90%;" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div style="margin-bottom: 20px;">
                <label for="password" style="font-weight: bold; font-size: 1.2rem; color: #333333;  display: block;">Parole</label>
                <x-text-input id="password" class="block w-full rounded-lg p-2" type="password" name="password" required autocomplete="current-password" style="display: block; margin-bottom: 5px; border-radius: 10px; background-color: #f0f0f0; width: 90%; padding: 15px;" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div style="margin-bottom: 20px;">
                <label for="remember_me" class="inline-flex items-center" style="font-weight: bold; font-size: 1.2rem; color: #333333;">
                    <input id="remember_me" type="checkbox" style="border: 1px solid #ccc; border-radius: 5px; padding: 8px; margin-right: 10px;" name="remember">
                    <span>{{ __('Atcerēties mani') }}</span>
                </label>
            </div>

            <div style="text-align: right;">
                @if (Route::has('password.request'))
                    <a style="font-size: 1rem; color: #fff; text-decoration: none; margin-right: 10px;" href="{{ route('password.request') }}">
                        {{ __('Aizmirsta parole?') }}
                    </a>
                @endif

                <button type="submit" style="background-color: #4CAF50; color: #fff; font-weight: bold; font-size: 1.2rem; border: none; border-radius: 10px; padding: 15px 30px; cursor: pointer;">{{ __('Ienākt') }}</button>
            </div>
        </form>
    </div>
</x-guest-layout>
