const heroSwiper = new Swiper(
    ".hero__swiper",
    {
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
        autoplay: {
            delay: 3000, // 5 seconds delay
            disableOnInteraction: false, // enable autoplay even on user interaction
        },
        effect: 'slide', // set slide effect
        speed: 1000
    }
);

const topProductSwiper = new Swiper(".top-product__swiper",
    {
        slidesPerView: 3,
        spaceBetween: 50,
        breakPoints: {
            600: {
                slidesPerView: 2
            },
            768: {
                slidesPerView: 3
            },
        },
        autoplay: {
            delay: 3000, // 5 seconds delay
            disableOnInteraction: true, // enable autoplay even on user interaction
        },
        effect: 'slide', // set slide effect
        speed: 700,
        loop: true
    }
);
const topProductSwiperBtn = document.querySelector("#top-product__swiper__btn")
topProductSwiperBtn.querySelector(".btn-next").addEventListener("click", ()=>{
    topProductSwiper.slideNext();
})

topProductSwiperBtn.querySelector(".btn-prev").addEventListener("click", ()=>{
    topProductSwiper.slidePrev();
})

const swiperWrapper = document.querySelectorAll('.top-product__swiper')
swiperWrapper.forEach(function(container) {
    container.addEventListener('mouseenter', function() {
      topProductSwiper.autoplay.stop();
     
    });
    
    container.addEventListener('mouseleave', function() {
      topProductSwiper.autoplay.start();
      
    });
  });