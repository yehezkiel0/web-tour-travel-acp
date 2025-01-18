import Swiper from "swiper/bundle";
import "swiper/swiper-bundle.css";

export function createSwiper(
    container,
    breakpoints,
    nextEl,
    prevEl,
    disableOnLargeScreen = false
) {
    let swiperInstance = null;
    function initSwiper() {
        if (disableOnLargeScreen && window.innerWidth > 1024) {
            if (swiperInstance) {
                swiperInstance.destroy(true, true);
                swiperInstance = null;
            }
        } else if (!swiperInstance) {
            swiperInstance = new Swiper(container, {
                slidesPerView: 1,
                spaceBetween: 10,
                preloadImages: false,
                lazy: true,
                navigation: {
                    nextEl: nextEl,
                    prevEl: prevEl,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                breakpoints: breakpoints,
                on: {
                    slideChange: function () {
                        const prevButton = document.querySelector(prevEl);
                        if (prevButton) {
                            prevButton.style.display =
                                this.activeIndex === 0 ? "none" : "block";
                        }
                    },
                },
            });
        }
    }
    initSwiper();

    window.addEventListener("resize", initSwiper);

    return swiperInstance;
}
