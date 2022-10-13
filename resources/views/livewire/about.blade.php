<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('О нас') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex py-12 items-center sm:justify-evenly justify-center flex-col sm:flex-row border-b border-gray-200">
                    <img class="sm:w-1/5 w-3/5 rounded-full aspect-square" src="{{sprintf('%s/storage/images/about_img.jpeg',route('about'))}}">
                    <h2 class="sm:w-1/2 w-full text-lg sm:my-6 mb-0 mt-6">Кинотеа́тр — общественное здание или его часть с оборудованием для публичной демонстрации кинофильмов. Главное помещение кинотеатра — зрительный зал с экраном большого размера и системой воспроизведения звука.</h2>
                </div>
                <div id="slider" class="mx-0 sm:mx-auto w-full sm:w-2/3 py-4 relative">
                    <h2 class="sm:text-5xl text-3xl py-4 font-bold text-center">Новые сеансы</h2>
                    @forelse($sessions as $session)
                    <div id="item">
                        <!-- object-contain  -->
                        <img class="w-full rounded-md aspect-video" src="{{sprintf('%s/storage/images/%s',route('about'),$session->image)}}">
                        <h2 class="text-center sm:text-3xl text-xl my-2 font-semibold">{{$session->name}}</h2>
                    </div>
                    @empty
                    <div id="item">
                        <h2 class="text-center sm:text-3xl text-xl my-2 font-semibold">На данный момент нет новых сеансов</h2>
                    </div>
                    @endforelse

                    <a class="previous text-xl md:text-3xl text-bold hidden" onclick="previousSlide()">&#10094;</a>
                    <a class="next text-xl md:text-3xl text-bold hidden" onclick="nextSlide()">&#10095;</a>
                </div>

            </div>
        </div>
    </div>
    <link rel="stylesheet" href="{{asset('css/livewire-about.css')}}"></link>
    <script src="{{asset('js/livewire-about.js')}}"></script>
</div>