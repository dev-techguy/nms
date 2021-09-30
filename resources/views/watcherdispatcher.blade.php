<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo/>
        </x-slot>

        <x-jet-validation-errors class="mb-4"/>

        <h1 class="display-5 text-center mb-10">Select User Type</h1>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('watchers.dispatchers.settype') }}">
            @csrf

            <div class="form-group">
                <label for="usertype">User Type</label>
                <select name="usertype" id="usertype" class="form-control @error('usertype') is-invalid @enderror"
                        required="">
                    <option value="">Select User Type</option>
                    <option value="Dispatcher">Dispatcher</option>
                    <option value="Watcher">Watcher</option>
                </select>
                @error('usertype')
                <div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-jet-button class="ml-4">
                    {{ __('Log in') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
