<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background: url({{asset('storage/images/background.jpg')}}) no-repeat;background-position: center;background-size: cover; background-attachment: fixed;">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg" style="background-color: #212529;">
        {{ $slot }}
    </div>
</div>
