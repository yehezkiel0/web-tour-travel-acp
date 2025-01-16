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
    // return new Swiper(container, {
    //     slidesPerView: 1,
    //     spaceBetween: 10,
    //     lazy: true,
    //     navigation: {
    //         nextEl: nextEl,
    //         prevEl: prevEl,
    //     },
    //     pagination: {
    //         el: ".swiper-pagination",
    //         clickable: true,
    //     },
    //     breakpoints: breakpoints,
    //     on: {
    //         slideChange: function () {
    //             const prevButton = document.querySelector(prevEl);
    //             if (prevButton) {
    //                 prevButton.style.display =
    //                     this.activeIndex === 0 ? "none" : "block";
    //             }
    //         },
    //     },
    // });
    initSwiper();

    // Tambahkan event listener untuk mengatur ulang Swiper saat layar diubah
    window.addEventListener("resize", initSwiper);

    return swiperInstance;
}
