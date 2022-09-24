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
                    <img class="sm:w-1/5 w-3/5 rounded-full aspect-square" src="{{sprintf('%s/storage/images/slider1.jpg',route('about'))}}">
                    <h2 class="sm:w-1/2 w-full text-lg sm:my-6 mb-0 mt-6">Как принято считать, диаграммы связей и по сей день остаются уделом либералов, которые жаждут быть в равной степени предоставлены сами себе. Кстати, предприниматели в сети интернет могут быть представлены в исключительно положительном свете.</h2>
                </div>
                <div id="slider" class="mx-0 sm:mx-auto w-full sm:w-2/3 py-4 relative">
                    <h2 class="sm:text-5xl text-3xl py-4 font-bold text-center">Новые сеансы</h2>
                    
                    @foreach($sessions as $session)
                    <div id="item">
                        <!-- object-contain  -->
                        <img class="w-full rounded-md aspect-video" src="{{sprintf('%s/storage/images/%s',route('about'),$session->image)}}">
                        <h2 class="text-center sm:text-3xl text-xl my-2 font-semibold">{{$session->name}}</h2>
                    </div>
                    @endforeach
                    
                <a class="previous text-xl md:text-3xl text-bold" onclick="previousSlide()">&#10094;</a>
                <a class="next text-xl md:text-3xl text-bold" onclick="nextSlide()">&#10095;</a>
            </div>

        </div>
    </div>
</div>
<style>
    #slider .previous,
    #slider .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        margin-top: -22px;
        padding: 16px;
        color: white;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
    }

    #slider .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }

    #slider .previous:hover,
    #slider .next:hover {
        background-color: rgba(0, 0, 0, 0.2);
    }

    #slider .item {
        animation-name: fade;
        animation-duration: 1.5s;
    }

    @keyframes fade {
        from {
            opacity: 0.4
        }

        to {
            opacity: 1
        }
    }
</style>

<script>
    let slideIndex = 1;
    showSlides(slideIndex);

    function nextSlide() {
        showSlides(slideIndex += 1);
    }

    function previousSlide() {
        showSlides(slideIndex -= 1);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        let slides = document.querySelectorAll("#item");

        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }

        for (let slide of slides) {
            slide.style.display = "none";
        }
        if(slides[slideIndex - 1])
        slides[slideIndex - 1].style.display = "block";
    }
</script>
</div>