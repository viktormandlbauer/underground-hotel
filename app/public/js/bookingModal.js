document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.booking-row').forEach(function (row) {
        row.addEventListener('click', function (e) {
            if (e.target.tagName.toLowerCase() === 'a' || e.target.tagName.toLowerCase() === 'i') {
                return;
            }

            

            var roomName = this.getAttribute('data-room-name');
            var roomDescription = this.getAttribute('data-room-description');
            var roomType = this.getAttribute('data-room-type');
            var roomPrice = this.getAttribute('data-room-price');
            var roomImagePath = this.getAttribute('data-room-image');
            var checkIn = this.getAttribute('start_date');
            var checkOut = this.getAttribute('end_date');

            document.getElementById('bookingRoomImage').src   = roomImagePath;
            document.getElementById('bookingRoomDescription').textContent     = roomDescription;
            document.getElementById('bookingRoomPrice').textContent  = roomPrice;
            document.getElementById('bookingArrivalDate').textContent = checkIn;
            document.getElementById('bookingDepartureDate').textContent = checkOut;
        
            var editModal = new bootstrap.Modal(document.getElementById('bookingModal'));
            editModal.show();
        });
    });

});
