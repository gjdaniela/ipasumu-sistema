<section id="password-reset-section">

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Paroles nomaiņa') }}
        </h2>

       
    </header>

    <form method="post" action="{{ route('password.update') }}" id = "password-reset-form" class="mt-6 space-y-6">
        @csrf
        @method('put')

       
            <x-input-label for="current_password" :value="__('Pašreizējā parole')" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        

      
            <x-input-label for="password" :value="__('Jaunā parole')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        

        
            <x-input-label for="password_confirmation" :value="__('Atkārtoti jaunā parole')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />

           
             <x-primary-button class="button  form-button password" >{{ __('Saglabāt') }}</x-primary-button>

        <div class="flex items-center ">
           
            
            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Parole ir nomainīta.') }}</p>
            @endif
        </div>
    </form>
</section>
