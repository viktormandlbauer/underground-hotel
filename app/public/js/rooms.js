let checkin_date, datepicker_div, datepicker,
    checkout_date;


// function for udpating displayed date in button
function update() {
    if (checkin_date !== undefined) {
        $('#display-checkin').html(checkin_date.toLocaleDateString());
    }
    if (checkout_date !== undefined) {
        $('#display-checkout').html(checkout_date.toLocaleDateString());
    }
}


// create checkin datepicker
datepicker_div = $('.datepicker').datepicker({
    autoclose: false,
    startDate: new Date(),
    startView: 0,
    weekStart: 1,
    beforeShowDay: function (date) {

        // display checkin date
        if (checkin_date !== undefined) {
            if (date.getDate() === checkin_date.getDate() &&
                date.getMonth() === checkin_date.getMonth() &&
                date.getFullYear() === checkin_date.getFullYear()) {
                return {
                    classes: 'check start'
                };
            }
        }

        if (checkout_date !== undefined) {

            // display checkout date in checkin datepicker
            if (date.getDate() === checkout_date.getDate() &&
                date.getMonth() === checkout_date.getMonth() &&
                date.getFullYear() === checkout_date.getFullYear()) {
                return {
                    classes: 'check end'
                };
            }
        }
        // display range dates in checkin datepicker
        if (checkin_date !== undefined && checkout_date !== undefined) {
            if (date > checkin_date && date < checkout_date) {
                return {
                    classes: 'is-between'
                };
            }
        }

        return true;
    }
});

// save checkin datepicker for later
datepicker = datepicker_div.data('datepicker');


// Handle search button click
function search_free_rooms() {

    if (checkin_date === undefined || checkout_date === undefined) {
        return;
    }

    fetch('/search/rooms', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ checkin_date, checkout_date })
    })
        .then(response => response.json())
        .then(data => {
            // Handle the response data
            console.log(data);

            // Clear the rooms list
            $('#rooms-list').empty();

            // Append the rooms to the list
            data.forEach(room => {
                $('#rooms-list').append(`
                    <p>${room.room_number}</p>
                `)
            });


        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Handle change event on datepicker
datepicker_div.on('changeDate', (event) => {

    if (checkin_date === undefined) {
        checkin_date = event.date;
    } else if (checkin_date > event.date && checkout_date === undefined) {
        checkin_date = event.date;
    }
    else if (checkin_date !== undefined && checkout_date !== undefined) {
        checkin_date = event.date;
        checkout_date = undefined;
    } else {
        checkout_date = event.date;
    }

    datepicker.update();
    update();
    search_free_rooms();
});