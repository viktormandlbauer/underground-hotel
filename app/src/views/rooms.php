<?php include 'src/views/includes/header.php'; ?>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-3">
                <h2 class="text-center">Filter</h2>
                <div class="p-3">
                    <form method="GET" action="/rooms">
                        <div class="mx-4">
                            <link rel="stylesheet"
                                href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
                            <link rel="stylesheet" href="/public/css/datepicker.css">
                            <div class="datepicker"></div>

                            <input type="hidden" id="checkin" name="checkin">
                            <input type="hidden" id="checkout" name="checkout">

                            <label for="person_count" class="form-label">Personen</label>

                            <output id="personCountValue" class="form-label"><?= $person_count ?></output>
                            <input type="range" class="form-range" min="1" max="5" value="<?= $person_count ?>"
                                id="person_count" name="person_count"
                                oninput="document.getElementById('personCountValue').innerText = this.value">

                            <label for="price_min" class="form-label">min </label>
                            <output id="minPriceValue" class="form-label"><?= $price_min ?>€</output>
                            <input type="range" class="form-range" min="0" max="300" value="<?= $price_min ?>"
                                id="price_min" name="price_min"
                                oninput="document.getElementById('minPriceValue').innerText = this.value + '€'">

                            <label for="price_max" class="form-label">max </label>
                            <output id="maxPriceValue" class="form-label"><?= $price_max ?>€</output>
                            <input type="range" class="form-range" min="0" max="300" value="<?= $price_max ?>"
                                id="price_max" name="price_max"
                                oninput="document.getElementById('maxPriceValue').innerText = this.value + '€'">

                            <button type="submit"
                                class="btn btn-success d-flex justify-content-center mt-3">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-9">
                <h2 class="text-center">Verfügbare Zimmer</h2>
                <div class="p-3">
                    <table id="rooms_table" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Bezeichnung</th>
                                <th scope="col">Beschreibung</th>
                                <th scope="col">Typ</th>
                                <th scope="col">Preis pro Nacht</th>
                                <th scope="col">Bild</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rooms as $room): ?>
                                <tr>
                                    <td><?= $room['name'] ?></td>
                                    <td><?= $room['description'] ?></td>
                                    <td><?= $room['type'] ?></td>
                                    <td><?= $room['price_per_night'] ?>€</td>
                                    <td><img src="<?= $room['image_path'] ?>" alt="No Image" width="100"></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    function formatDateToDDMMYYYY(date) {
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${year}-${month}-${day}`;
    }

    // selected dates from datepicker
    let checkin_date, checkout_date;

    // create checkin datepicker
    datepicker_div = $('.datepicker').datepicker({
        startDate: new Date(),
        format: "yyyy-mm-dd",
        startView: 0,
        weekStart: 1,
        clearBtn: true,
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

        datepicker.update();

        if (checkin_date === undefined) {
            checkin_date = event.date;
        } else if (checkin_date > event.date && checkout_date === undefined) {
            checkin_date = event.date;
        } else if (checkin_date !== undefined && checkout_date !== undefined) {
            checkin_date = event.date;
            checkout_date = undefined;
        } else {
            checkout_date = event.date;
        }

        datepicker.update();

        console.log(checkin_date, checkout_date);

        // set hidden input values
        if (checkin_date !== undefined && checkout_date !== undefined) {
            $('#checkin').val(formatDateToDDMMYYYY(checkin_date));
            $('#checkout').val(formatDateToDDMMYYYY(checkout_date));
        }
    });
</script>

<?php include 'src/views/includes/footer.php'; ?>