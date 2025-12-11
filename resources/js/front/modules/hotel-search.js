// Hotel Search Guest Dropdown Handler
document.addEventListener('DOMContentLoaded', function() {
    initGuestDropdown();
    initCityFilters();
});

function initGuestDropdown() {
    const guestBtn = document.getElementById('guestDropdownBtn');
    const guestDropdown = document.getElementById('dropdown-guests');
    const guestDisplayWrapper = document.getElementById('guestDisplayWrapper');
    const roomsInput = document.getElementById('roomsInput');
    const adultsInput = document.getElementById('adultsInput');
    const childrenInput = document.getElementById('childrenInput');
    const roomsCount = document.getElementById('roomsCount');
    const adultsCount = document.getElementById('adultsCount');
    const childrenCount = document.getElementById('childrenCount');
    const roomsDecrease = document.getElementById('roomsDecrease');
    const roomsIncrease = document.getElementById('roomsIncrease');
    const adultsDecrease = document.getElementById('adultsDecrease');
    const adultsIncrease = document.getElementById('adultsIncrease');
    const childrenDecrease = document.getElementById('childrenDecrease');
    const childrenIncrease = document.getElementById('childrenIncrease');

    if (!guestBtn || !guestDropdown) return;

    let rooms = parseInt(roomsInput?.value || 1);
    let adults = parseInt(adultsInput?.value || 2);
    let children = parseInt(childrenInput?.value || 0);

    function updateGuestDisplay() {
        let guestText = '';

        if (adults > 0) {
            guestText = `${adults} dewasa`;
        }

        if (children > 0) {
            guestText += children === 1 ? ', 1 anak' : `, ${children} anak`;
        }

        const roomText = rooms === 1 ? '1 kamar' : `${rooms} kamar`;

        if (guestDisplayWrapper) {
            guestDisplayWrapper.innerHTML = `
                <div class="text-gray-700 font-medium">${guestText}</div>
                <div class="text-xs text-gray-500 mt-0.5">${roomText}</div>
            `;
        }

        if (roomsInput) roomsInput.value = rooms;
        if (adultsInput) adultsInput.value = adults;
        if (childrenInput) childrenInput.value = children;
        if (roomsCount) roomsCount.textContent = rooms;
        if (adultsCount) adultsCount.textContent = adults;
        if (childrenCount) childrenCount.textContent = children;

        // Update button states
        if (roomsDecrease) roomsDecrease.disabled = rooms <= 1;
        if (adultsDecrease) adultsDecrease.disabled = adults <= 1;
        if (childrenDecrease) childrenDecrease.disabled = children <= 0;
    }

    // Toggle dropdown (mirip navbar)
    guestBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (guestDropdown.style.display === 'none' || guestDropdown.style.display === '') {
            guestDropdown.style.display = 'block';
        } else {
            guestDropdown.style.display = 'none';
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!guestBtn.contains(e.target) && !guestDropdown.contains(e.target)) {
            guestDropdown.style.display = 'none';
        }
    });

    // Prevent dropdown from closing when clicking inside
    guestDropdown.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Rooms counter
    roomsDecrease?.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (rooms > 1) {
            rooms--;
            updateGuestDisplay();
        }
    });

    roomsIncrease?.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (rooms < 10) {
            rooms++;
            updateGuestDisplay();
        }
    });

    // Adults counter
    adultsDecrease?.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (adults > 1) {
            adults--;
            updateGuestDisplay();
        }
    });

    adultsIncrease?.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (adults < 20) {
            adults++;
            updateGuestDisplay();
        }
    });

    // Children counter
    childrenDecrease?.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (children > 0) {
            children--;
            updateGuestDisplay();
        }
    });

    childrenIncrease?.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (children < 20) {
            children++;
            updateGuestDisplay();
        }
    });

    // Initialize display
    updateGuestDisplay();
}

function initCityFilters() {
    const cityButtons = document.querySelectorAll('.city-filter-btn');
    const hotelCards = document.querySelectorAll('.hotel-card');
    const searchInput = document.getElementById('searchInput');

    if (!cityButtons.length) return;

    cityButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            cityButtons.forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white');
                btn.classList.add('text-blue-600');
            });

            this.classList.add('active', 'bg-blue-600', 'text-white');
            this.classList.remove('text-blue-600');

            const selectedCity = this.dataset.city.toLowerCase();

            hotelCards.forEach(card => {
                const hotelCity = card.dataset.city.toLowerCase();

                if (selectedCity === '' || hotelCity.includes(selectedCity)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });

            if (searchInput) {
                if (selectedCity !== '') {
                    searchInput.value = this.textContent.trim();
                } else {
                    searchInput.value = '';
                }
            }
        });
    });

    if (searchInput) {
        const currentSearch = searchInput.value.toLowerCase();
        if (currentSearch) {
            cityButtons.forEach(button => {
                if (button.dataset.city.toLowerCase() === currentSearch) {
                    button.click();
                }
            });
        }
    }
}
