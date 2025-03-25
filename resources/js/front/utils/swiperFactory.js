import Swiper from "swiper/bundle";
import "swiper/swiper-bundle.css";

export function createSwiper(
    container,
    breakpoints,
    nextEl,
    prevEl,
    disableOnLargeScreen = false,
    autoplayOptions = null,
    loop = false
) {
    let swiperInstance = null;
    function initSwiper() {
        if (disableOnLargeScreen && window.innerWidth > 1024) {
            if (swiperInstance) {
                swiperInstance.destroy(true, true);
                swiperInstance = null;
            }
        } else if (!swiperInstance) {
            const swiperConfig = {
                slidesPerView: 1,
                spaceBetween: 10,
                preloadImages: false,
                lazy: true,
                loop: loop,
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
            };

            // Tambahkan autoplay jika parameter disediakan
            if (autoplayOptions) {
                swiperConfig.autoplay = autoplayOptions;
            }

            swiperInstance = new Swiper(container, swiperConfig);
        }
    }
    initSwiper();

    window.addEventListener("resize", initSwiper);

    return swiperInstance;
}
