<?php include 'src/views/includes/header.php'; ?>
<link rel="stylesheet" href="/public/css/pagination.css">
<link rel="stylesheet" href="/public/css/slider.css">
<script src="/public/js/slider.js"></script>

<body>
    <?php include 'src/views/includes/navbar.php'; ?>
    <div class="container my-5 content-wrapper">
        <div class="row bg-dark text-white py-4 rounded">
            <div class="col-3">
                <div class="p-3">
                    <form method="GET" action="/rooms">
                        <div class="d-flex align-items-center flex-column">

                            <h2 class="text-center display-4" id="Pages">Filter</h2>
                            <?php include 'src/views/includes/datepicker.php'; ?>

                            <div class="w-75">
                                <div class="mt-2">
                                    Personenanzahl:
                                    <span id="personCountSpan">1</span>
                                    <input type="hidden" name="person_count" id="person_count" value="1">
                                    <div id="personCountSlider"></div>
                                </div>
                                <div class="mt-5">
                                    Preisbereich:
                                    <span id="priceSpan_min">0</span>€ - <span id="priceSpan_max">300</span>€
                                    <input type="hidden" name="price_min" id="price_min" value="0>">
                                    <input type="hidden" name="price_max" id="price_max" value="300">
                                    <div id="priceRangeSlider"></div>
                                </div>
                                <button type="submit" class="btn btn-outline-light mt-5 w-100">Suchen</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-9">
                <h2 class="text-center display-3" id="Pages">Zimmer</h2>
                <div class="p-3">
                    <table id="sortedTable"
                        class="table table-dark table-bordered table-striped align-middle table-hover tablesorter">
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
                                <tr class="booking-row" 
                                    data-room-name="<?= $room['name'] ?>"
                                    data-room-number="<?= $room['number'] ?>"
                                    data-room-description="<?= $room['description'] ?>"
                                    data-room-type="<?= $room["type"] ?>" 
                                    data-room-price="<?= $room['price_per_night'] ?>"
                                    data-room-image="<?= $room['image_path'] ?>" 
                                    data-start-date="2025-01-01"
                                    data-end-date="2025-01-15">
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
                            <li class="page-item">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item active">
                                <a class="page-link" href="#">2 <span class=" bg-success sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Booking Modal -->
        <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="bookingForm" action="/rooms/booking" method="POST">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bookingModalLabel">Zimmer buchen</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Schließen"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-4">
                                <div class="col-md-6 d-flex">
                                    <img id="bookingRoomImage" src="" alt="Zimmer Bild"
                                        class="img-fluid me-3 booking-image"
                                        style="max-height: 200px; object-fit: cover;">
                                    <div>
                                        <p id="bookingRoomDescription" class="mb-2"></p>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-end">
                                    <div class="price-per-night text-end" style="font-size: 1.5rem; font-weight: bold;">
                                        <span id="bookingRoomPrice"></span> € / Nacht
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bookingArrivalDate" class="form-label">Anreise</label>
                                        <input type="date" class="form-control bg-dark text-white"
                                            id="bookingArrivalDate" name="arrival_date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bookingDepartureDate" class="form-label">Abreise</label>
                                        <input type="date" class="form-control bg-dark text-white"
                                            id="bookingDepartureDate" name="departure_date" required>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input bg-dark text-white" type="checkbox"
                                            id="bookingBreakfast" name="with_breakfast" value="1">
                                        <label class="form-check-label" for="bookingBreakfast">
                                            Mit Frühstück
                                        </label>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input bg-dark text-white" type="checkbox"
                                            id="bookingParking" name="with_parking" value="1">
                                        <label class="form-check-label" for="bookingParking">
                                            Mit Parkplatz
                                        </label>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input bg-dark text-white" type="checkbox"
                                            id="bookingPet" name="with_pet" value="1">
                                        <label class="form-check-label" for="bookingPet">
                                            Mit Haustier
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label for="bookingRemarks" class="form-label">Bemerkungen</label>
                                        <textarea class="form-control bg-dark text-white" id="bookingRemarks"
                                            name="remarks" rows="3" placeholder="Ihre Bemerkungen hier..."></textarea>
                                    </div>
                                    <table class="table table-borderless table-sm table-dark text-white">
                                        <tr>
                                            <td class="text-end">Grundpreis:</td>
                                            <td class="text-end"><span id="bookingBasePrice">0.00</span> €</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">Aufpreis Frühstück:</td>
                                            <td class="text-end"><span id="bookingBreakfastPrice">0.00</span> €</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">Aufpreis Parkplatz:</td>
                                            <td class="text-end"><span id="bookingParkingPrice">0.00</span> €</td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td class="text-end">Gesamt:</td>
                                            <td class="text-end"><span id="bookingTotalPrice">0.00</span> €</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <input type="hidden" id="bookingRoomNumber" name="room_number" />
                            <input type="hidden" id="bookingRoomPricePerNight" name="price_per_night" />
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-light">Buchen</button>
                            <button type="button" class="btn btn-outline-light"
                                data-bs-dismiss="modal">Abbrechen</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'src/views/includes/footer.php'; ?>
</body>

<script src="/public/js/bookingModal.js"></script>