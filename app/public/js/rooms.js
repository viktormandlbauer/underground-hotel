// selected dates from datepicker
let checkin_date, checkout_date;

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
});

function load_rooms() {

    let person_count = document.getElementById('person_count').value;
    let price_min = document.getElementById('price_min').value;
    let price_max = document.getElementById('price_max').value;

    let tableBody = $('#rooms_table tbody');
    tableBody.empty();

    // Log the search parameters
    // console.log(JSON.stringify({ checkin_date, checkout_date, person_count, price_min, price_max }));

    fetch('/rooms/search', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ checkin_date, checkout_date, person_count, price_min, price_max })
    })
        .then(
            function (response) {
                // Handling errors from the server
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error("HTTP status " + response.status + " " + JSON.stringify(err));
                    });
                }
                return response;
            }
        ).then(response => {

            // No rooms available
            if (response.status === 204) {
                tableBody.append('<tr><td colspan="4">No rooms available</td></tr>');
                return;
            }
            
            // Display rooms
            response.json().forEach(room => {
                let row = $('<tr></tr>');
                row.append(`<td><img src="" alt="temp" class="img-fluid"></td>`);
                row.append(`<td>${room.room_number}</td>`);
                row.append(`<td></td>`);
                row.append(`<td>/night</td>`);
                tableBody.append(row);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
}