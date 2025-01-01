document.addEventListener('DOMContentLoaded', function () {
    function calculateNights(checkIn, checkOut) {
        const start = new Date(checkIn);
        const end = new Date(checkOut);
        const diffTime = end - start;
        const diffDays = diffTime / (1000 * 60 * 60 * 24);
        return diffDays > 0 ? diffDays : 0;
    }

    function updateTotalPrice(modalId, basePriceElementId, breakfastCheckboxId, parkingCheckboxId, breakfastPriceElementId, parkingPriceElementId, totalPriceElementId) {
        const modal = document.getElementById(modalId);
        const pricePerNight = parseFloat(modal.getAttribute('data-price-per-night')) || 0;

        const checkIn = modal.querySelector(`#${modalId} #editCheckInDate`).value;
        const checkOut = modal.querySelector(`#${modalId} #editCheckOutDate`).value;
        const nights = calculateNights(checkIn, checkOut);

        const basePrice = pricePerNight * nights;
        const breakfastPrice = document.getElementById(breakfastCheckboxId).checked ? 10 * nights : 0;
        const parkingPrice = document.getElementById(parkingCheckboxId).checked ? 7 * nights : 0;
        const totalPrice = basePrice + breakfastPrice + parkingPrice;

        document.getElementById(basePriceElementId).textContent = basePrice.toFixed(2);
        document.getElementById(breakfastPriceElementId).textContent = breakfastPrice.toFixed(2);
        document.getElementById(parkingPriceElementId).textContent = parkingPrice.toFixed(2);
        document.getElementById(totalPriceElementId).textContent = totalPrice.toFixed(2);
    }

    function populateEditModal(row) {

        let bookingId = row.getAttribute('data-booking-id');
        let userId = row.getAttribute('data-user-id');
        let username = row.getAttribute('data-username');
        let roomNumber = row.getAttribute('data-room-number');
        let checkIn = row.getAttribute('data-check-in');
        let checkOut = row.getAttribute('data-check-out');
        let pricePerNight = parseFloat(row.getAttribute('data-price-per-night')) || 0;
        let status = row.getAttribute('data-status');
        let breakfast = row.getAttribute('data-breakfast') === '1';
        let parking = row.getAttribute('data-parking') === '1';
        let pet = row.getAttribute('data-pet') === '1';
        let remarks = row.getAttribute('data-additional-info');

        document.getElementById('editBookingId').value = bookingId;
        document.getElementById('editUserId').value = userId;
        document.getElementById('editRoomNumber').value = roomNumber;
        document.getElementById('editCheckInDate').value = checkIn;
        document.getElementById('editCheckOutDate').value = checkOut;
        document.getElementById('editStatus').value = status;
        document.getElementById('editBreakfast').checked = breakfast;
        document.getElementById('editParking').checked = parking;
        document.getElementById('editPet').checked = pet;
        document.getElementById('editRemarks').value = remarks;

        let nights = calculateNights(checkIn, checkOut);
        let basePrice = pricePerNight * nights;
        document.getElementById('editBasePrice').textContent = basePrice.toFixed(2);

        document.getElementById('editBookingModal').setAttribute('data-price-per-night', pricePerNight);


        updateTotalPrice('editBookingModal', 'editBasePrice', 'editBreakfast', 'editParking', 'editBreakfastPrice', 'editParkingPrice', 'editTotalPrice');
    }

    document.querySelectorAll('.booking-row').forEach(function (row) {
        row.addEventListener('click', function () {
            populateEditModal(this);
            let editModal = new bootstrap.Modal(document.getElementById('editBookingModal'));
            editModal.show();
        });
    });

    document.getElementById('editCheckInDate').addEventListener('change', function () {
        updateTotalPrice('editBookingModal', 'editBasePrice', 'editBreakfast', 'editParking', 'editBreakfastPrice', 'editParkingPrice', 'editTotalPrice');
    });

    document.getElementById('editCheckOutDate').addEventListener('change', function () {
        updateTotalPrice('editBookingModal', 'editBasePrice', 'editBreakfast', 'editParking', 'editBreakfastPrice', 'editParkingPrice', 'editTotalPrice');    });

    document.getElementById('editBreakfast').addEventListener('change', function () {
        updateTotalPrice('editBookingModal', 'editBasePrice', 'editBreakfast', 'editParking', 'editBreakfastPrice', 'editParkingPrice', 'editTotalPrice');    });

    document.getElementById('editParking').addEventListener('change', function () {
        updateTotalPrice('editBookingModal', 'editBasePrice', 'editBreakfast', 'editParking', 'editBreakfastPrice', 'editParkingPrice', 'editTotalPrice');    });


    function updateAddTotalPrice() {
        const addRoomNumber = document.getElementById('addRoomNumber').value;
        const checkIn = document.getElementById('addCheckInDate').value;
        const checkOut = document.getElementById('addCheckOutDate').value;

        let roomPrice = roomPrices[addRoomNumber] || 0;
        let nights = calculateNights(checkIn, checkOut);
        let basePrice = roomPrice * nights;

        document.getElementById('addBasePrice').textContent = basePrice.toFixed(2);

        let breakfastPrice = document.getElementById('addBreakfast').checked ? 10 * nights : 0;
        let parkingPrice = document.getElementById('addParking').checked ? 7 * nights : 0;

        let totalPrice = basePrice + breakfastPrice + parkingPrice;

        document.getElementById('addBreakfastPrice').textContent = breakfastPrice.toFixed(2);
        document.getElementById('addParkingPrice').textContent = parkingPrice.toFixed(2);
        document.getElementById('addTotalPrice').textContent = totalPrice.toFixed(2);
    }

    document.getElementById('addRoomNumber').addEventListener('change', updateAddTotalPrice);
    document.getElementById('addCheckInDate').addEventListener('change', updateAddTotalPrice);
    document.getElementById('addCheckOutDate').addEventListener('change', updateAddTotalPrice);
    document.getElementById('addBreakfast').addEventListener('change', updateAddTotalPrice);
    document.getElementById('addParking').addEventListener('change', updateAddTotalPrice);
    document.getElementById('addPet').addEventListener('change', updateAddTotalPrice);
});
