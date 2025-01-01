document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.booking-row').forEach(function (row) {
        row.addEventListener('click', function (e) {
            if (e.target.tagName.toLowerCase() === 'a' || e.target.tagName.toLowerCase() === 'i') {
                return;
            }

            var roomName = this.getAttribute('data-room-name');
            var roomNumber = this.getAttribute('data-room-number');
            var roomDescription = this.getAttribute('data-room-description');
            var roomType = this.getAttribute('data-room-type');
            var roomPrice = this.getAttribute('data-room-price');
            var roomImagePath = this.getAttribute('data-room-image');
            var checkIn = document.getElementById('start_date').value;
            var checkOut = document.getElementById('end_date').value;
            var pricePerNight = parseFloat(this.getAttribute('data-price-per-night')) || 0;

            var nights = calculateNights(checkIn, checkOut);
            var basePrice = roomPrice * nights;
            var breakfastPrice = 0;
            var parkingPrice = 0;

            document.getElementById('bookingRoomNumber').value = roomNumber;
            document.getElementById('bookingRoomImage').src = roomImagePath;
            document.getElementById('bookingRoomDescription').textContent = roomDescription;
            document.getElementById('bookingRoomPrice').textContent = roomPrice;
            document.getElementById('bookingArrivalDate').value = checkIn;
            document.getElementById('bookingDepartureDate').value = checkOut;
            document.getElementById('bookingRoomPricePerNight').value = pricePerNight.toFixed(2);

            document.getElementById('bookingBasePrice').textContent = basePrice.toFixed(2);
            document.getElementById('bookingBreakfastPrice').textContent = breakfastPrice.toFixed(2);
            document.getElementById('bookingParkingPrice').textContent = parkingPrice.toFixed(2);
            document.getElementById('bookingTotalPrice').textContent = (basePrice + breakfastPrice + parkingPrice).toFixed(2);


            var editModal = new bootstrap.Modal(document.getElementById('bookingModal'));
            editModal.show();
        });
    });

    const breakfastCheckbox = document.getElementById('bookingBreakfast');
    const parkingCheckbox = document.getElementById('bookingParking');

    if (breakfastCheckbox || parkingCheckbox) {
        function updateTotalPrice() {
            const base = parseFloat(document.getElementById('bookingBasePrice').textContent || '0');
            const breakfastUnitPrice = 10.0;
            const parkingUnitPrice = 10.0;

            const checkIn = document.getElementById('bookingArrivalDate').value;
            const checkOut = document.getElementById('bookingDepartureDate').value;

            const nights = calculateNights(checkIn, checkOut);

            const breakfastPrice = breakfastCheckbox.checked ? breakfastUnitPrice * nights : 0;
            const parkingPrice = parkingCheckbox.checked ? parkingUnitPrice * nights : 0;

            const totalPrice = base + breakfastPrice + parkingPrice;

            document.getElementById('bookingBreakfastPrice').textContent = breakfastPrice.toFixed(2);
            document.getElementById('bookingParkingPrice').textContent = parkingPrice.toFixed(2);
            document.getElementById('bookingTotalPrice').textContent = totalPrice.toFixed(2);
        }

        if (breakfastCheckbox) {
            breakfastCheckbox.addEventListener('change', updateTotalPrice);
        }

        if (parkingCheckbox) {
            parkingCheckbox.addEventListener('change', updateTotalPrice);
        }
    }
});

function calculateNights(startStr, endStr) {
    if (!startStr || !endStr) return 0;

    const start = new Date(startStr);
    const end = new Date(endStr);

    // Differenz in Millisekunden
    const diffMs = end - start;
    // Ms -> Tage
    const diffDays = diffMs / (1000 * 60 * 60 * 24);

    return diffDays > 0 ? diffDays : 0;
}