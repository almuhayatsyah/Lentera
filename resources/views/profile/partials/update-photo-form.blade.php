<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Foto Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Upload foto profil Anda. Maksimal 2MB, format JPG/PNG.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.photo') }}" class="mt-6" enctype="multipart/form-data">
        @csrf

        <div class="flex items-center gap-6">
            <!-- Current Photo Preview -->
            <div class="shrink-0">
                @if($user->photo_url)
                    <img class="h-20 w-20 object-cover rounded-full border-2 border-gray-200" 
                         src="{{ $user->photo_url }}" 
                         alt="{{ $user->name }}">
                @else
                    <div class="h-20 w-20 rounded-full bg-indigo-600 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </span>
                    </div>
                @endif
            </div>
            
            <div class="flex-1">
                <input type="file" 
                       name="photo" 
                       id="photo"
                       accept="image/jpeg,image/png,image/jpg"
                       class="block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-indigo-50 file:text-indigo-700
                              hover:file:bg-indigo-100">
                <p class="mt-1 text-xs text-gray-500">JPG, JPEG, atau PNG. Maksimal 2MB.</p>
                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
            </div>
        </div>

        <div class="flex items-center gap-4 mt-4">
            <x-primary-button>{{ __('Upload Foto') }}</x-primary-button>

            @if (session('status') === 'photo-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Foto berhasil diupload.') }}</p>
            @endif
        </div>
    </form>
</section>
