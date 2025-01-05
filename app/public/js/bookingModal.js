document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.booking-row').forEach(function (row) {
        row.addEventListener('click', function () {
            populateBookingModal(this);
            const bookingModal = new bootstrap.Modal(document.getElementById('bookingModal'));
            bookingModal.show();
        });
    });

    const bookingArrivalDate = document.getElementById('bookingArrivalDate');
    const bookingDepartureDate = document.getElementById('bookingDepartureDate');
    const bookingBreakfast = document.getElementById('bookingBreakfast');
    const bookingParking = document.getElementById('bookingParking');


    bookingArrivalDate.addEventListener('change', updateTotalPrice);
    bookingDepartureDate.addEventListener('change', updateTotalPrice);
    bookingBreakfast.addEventListener('change', updateTotalPrice);
    bookingParking.addEventListener('change', updateTotalPrice);

});

function populateBookingModal(row) {
    const roomName = row.getAttribute('data-room-name');
    const roomNumber = row.getAttribute('data-room-number');
    const roomDescription = row.getAttribute('data-room-description');
    const roomType = row.getAttribute('data-room-type');
    const roomPrice = parseFloat(row.getAttribute('data-room-price')) || 0;
    const roomImagePath = row.getAttribute('data-room-image');
    const checkInDate = document.getElementById('start_date').value;
    const checkOutDate = document.getElementById('end_date').value;

    const bookingModal = document.getElementById('bookingModal');


    document.getElementById('bookingRoomNumber').value = roomNumber;
    document.getElementById('bookingRoomImage').src = roomImagePath;
    document.getElementById('bookingRoomDescription').textContent = roomDescription;
    document.getElementById('bookingArrivalDate').value = checkInDate;
    document.getElementById('bookingDepartureDate').value = checkOutDate;

    document.getElementById('bookingRoomPrice').textContent = roomPrice.toFixed(2);
    document.getElementById('bookingRoomPricePerNight').value = roomPrice.toFixed(2);

    bookingModal.setAttribute('data-room-price', roomPrice);

    updateTotalPrice();
}

function updateTotalPrice() {
    const bookingModal = document.getElementById('bookingModal');
    const roomPrice = parseFloat(bookingModal.getAttribute('data-room-price')) || 0;

    const checkIn = document.getElementById('bookingArrivalDate').value;
    const checkOut = document.getElementById('bookingDepartureDate').value;

    const nights = calculateNights(checkIn, checkOut);
    const basePrice = roomPrice * nights;

    const breakfastPrice = document.getElementById('bookingBreakfast').checked ? 10 * nights : 0;
    const parkingPrice = document.getElementById('bookingParking').checked ? 7 * nights : 0;
    const totalPrice = basePrice + breakfastPrice + parkingPrice;

    document.getElementById('bookingBasePrice').textContent = basePrice.toFixed(2);
    document.getElementById('bookingBreakfastPrice').textContent = breakfastPrice.toFixed(2);
    document.getElementById('bookingParkingPrice').textContent = parkingPrice.toFixed(2);
    document.getElementById('bookingTotalPrice').textContent = totalPrice.toFixed(2);
}

function calculateNights(startStr, endStr) {
    if (!startStr || !endStr) return 0;

    const startDate = new Date(startStr);
    const endDate = new Date(endStr);
    const diffTime = endDate - startDate;
    const diffDays = diffTime / (1000 * 60 * 60 * 24);

    return diffDays > 0 ? diffDays : 0;
}
