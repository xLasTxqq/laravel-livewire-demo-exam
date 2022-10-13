let slideIndex = 1;
        let slides = document.querySelectorAll("#item");
        if (slides.length > 1) {
            document.querySelector('.previous').classList.remove('hidden')
            document.querySelector('.next').classList.remove('hidden')
        }
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

            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }

            for (let slide of slides) {
                slide.style.display = "none";
            }
            if (slides[slideIndex - 1])
                slides[slideIndex - 1].style.display = "block";
        }