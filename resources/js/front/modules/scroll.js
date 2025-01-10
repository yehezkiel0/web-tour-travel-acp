export const initInfiniteScroll = () => {
    const itemLogo = document.querySelector(".item-logo");
    if (itemLogo) {
        const row = itemLogo.cloneNode(true);
        const scrollContainer = document.querySelector(".scroll");
        if (scrollContainer) {
            scrollContainer.appendChild(row);
        }
    }
};
