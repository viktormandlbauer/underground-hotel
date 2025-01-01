<?php include 'src/views/includes/header.php'; ?>
<link rel="stylesheet" href="/public/css/modal.css">
<?php include 'src/controllers/BookingController.php'; ?>
<body>
    <?php include 'src/views/includes/navbar.php'; ?>

    <div class="container mt-5 content-wrapper">
        <div class="row bg-dark text-white py-4 rounded">
            <h1 id="Pages" class="mb-4 text-center display-3">Buchungsverwaltung</h1>

            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-info alert-dismissible fade show" id="flashMessage">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <?= htmlspecialchars($_SESSION['flash_message'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <script src='/public/js/flashMessage.js'></script>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="sortedTable" class="table table-dark table-bordered align-middle table-hover tablesorter">
                    <thead>
                        <tr>
                            <th data-sort="number">Buchungs-ID</th>
                            <th data-sort="text">Benutzername</th>
                            <th data-sort="text">Zimmernummer</th>
                            <th data-sort="date">Anreise</th>
                            <th data-sort="date">Abreise</th>
                            <th data-sort="text">Frühstück</th>
                            <th data-sort="text">Parkplatz</th>
                            <th data-sort="text">Haustier</th>
                            <th data-sort="text">Status</th>
                        </tr>
                    </thead>
                    <tbody id="bookingTableBody">
                        <?php foreach ($bookings as $booking): ?>
                            <tr class="booking-row" onclick="href='#editBookingModal'" data-bs-toggle="modal" data-bs-target="#editBookingModal"
                                data-booking-id="<?= $booking['booking_id'] ?>"
                                data-user-id="<?= $booking['user_id'] ?>"
                                data-username="<?= User::getUsernameByID($booking['user_id']) ?>"
                                data-room-number="<?= $booking['room_number'] ?>"
                                data-check-in="<?= $booking['check_in_date'] ?>"
                                data-check-out="<?= $booking['check_out_date'] ?>"
                                data-price-per-night="<?= $booking['price_per_night'] ?>"
                                data-status="<?= $booking['status'] ?>"
                                data-breakfast="<?= $booking['breakfast'] ?>" 
                                data-parking="<?= $booking['parking'] ?>"
                                data-pet="<?= $booking['pet'] ?>" 
                                data-additional-info="<?= $booking['additional_info'] ?>">

                                <td><?= $booking['booking_id'] ?></td>
                                <td><?= User::getUsernameByID($booking['user_id']) ?></td>
                                <td><?= $booking['room_number'] ?></td>
                                <td><?= $booking['check_in_date'] ?></td>
                                <td><?= $booking['check_out_date'] ?></td>
                                <td><?= $booking['breakfast'] ? 'Ja' : 'Nein' ?></td>
                                <td><?= $booking['parking'] ? 'Ja' : 'Nein' ?></td>
                                <td><?= $booking['pet'] ? 'Ja' : 'Nein' ?></td>
                                <td>
                                    <?php
                                    switch ($booking['status']) {
                                        case 'new':
                                            echo '<span class="status-indicator bg-info">Neu</span>';
                                            break;
                                        case 'approved':
                                            echo '<span class="status-indicator bg-success">Genehmigt</span>';
                                            break;
                                        case 'canceled':
                                            echo '<span class="status-indicator bg-danger">Storniert</span>';
                                            break;
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="9" class="text-center">
                                <button type="button" id="addRow" class="add-row btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#addBookingModal">
                                    <i class="fas fa-plus"></i> Neue Buchung
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Zurück</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active">
                            <a class="page-link" href="#">2 <span class="bg-success sr-only">(current)</span></a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Weiter</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Add Booking Modal -->
    <div class="modal fade" id="addBookingModal" tabindex="-1" aria-labelledby="addBookingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="addBookingForm" action="/bookings/create" method="POST">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBookingModalLabel">Neue Buchung erstellen</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Schließen"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addUserId" class="form-label">Benutzer</label>
                            <select class="form-select" id="addUserId" name="user_id" required>
                                <option value="">Bitte wählen</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['user_id'] ?>"> <?= ($user['username']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="addRoomNumber" class="form-label">Zimmernummer</label>
                            <select class="form-select" id="addRoomNumber" name="room_number" required>
                                <option value="">Bitte wählen</option>
                                <?php foreach ($rooms as $room): ?>
                                    <option value="<?= $room['number'] ?>">
                                        <?= $room['number'] . ' - ' . $room['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="addCheckInDate" class="form-label">Anreise</label>
                                <input type="date" class="form-control bg-dark text-white" id="addCheckInDate"
                                    name="check_in_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="addCheckOutDate" class="form-label">Abreise</label>
                                <input type="date" class="form-control bg-dark text-white" id="addCheckOutDate"
                                    name="check_out_date" required>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input bg-dark text-white" type="checkbox" id="addBreakfast"
                                name="with_breakfast" value="1">
                            <label class="form-check-label" for="addBreakfast">
                                Mit Frühstück
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input bg-dark text-white" type="checkbox" id="addParking"
                                name="with_parking" value="1">
                            <label class="form-check-label" for="addParking">
                                Mit Parkplatz
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input bg-dark text-white" type="checkbox" id="addPet"
                                name="with_pet" value="1">
                            <label class="form-check-label" for="addPet">
                                Mit Haustier
                            </label>
                        </div>

                        <div class="mb-3">
                            <label for="addRemarks" class="form-label">Bemerkungen</label>
                            <textarea class="form-control bg-dark text-white" id="addRemarks" name="remarks" rows="3"
                                placeholder="Ihre Bemerkungen hier..."></textarea>
                        </div>

                        <h5>Preis-Aufschlüsselung</h5>
                        <table class="table table-borderless table-sm table-dark text-white">
                            <tr>
                                <td class="text-end">Grundpreis:</td>
                                <td class="text-end"><span id="addBasePrice">0.00</span> €</td>
                            </tr>
                            <tr>
                                <td class="text-end">Aufpreis Frühstück:</td>
                                <td class="text-end"><span id="addBreakfastPrice">0.00</span> €</td>
                            </tr>
                            <tr>
                                <td class="text-end">Aufpreis Parkplatz:</td>
                                <td class="text-end"><span id="addParkingPrice">0.00</span> €</td>
                            </tr>
                            <tr>
                                <td class="text-end">Aufpreis Haustier:</td>
                                <td class="text-end"><span id="addPetPrice">0.00</span> €</td>
                            </tr>
                            <tr class="fw-bold">
                                <td class="text-end">Gesamt:</td>
                                <td class="text-end"><span id="addTotalPrice">0.00</span> €</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-light">Buchung erstellen</button>
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Abbrechen</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Booking Modal -->
    <div class="modal fade" id="editBookingModal" tabindex="-1" aria-labelledby="editBookingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editBookingForm" action="/admin/manage/bookings/edit" method="POST">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBookingModalLabel">Buchung bearbeiten</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Schließen"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editBookingId" name="booking_id">

                        <div class="mb-3">
                            <label for="editUserId" class="form-label">Benutzer</label>
                            <select class="form-select" id="editUserId" name="user_id" required>
                                <option value="">Bitte wählen</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['user_id'] ?>"><?= $user['username'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="editRoomNumber" class="form-label">Zimmernummer</label>
                            <select class="form-select" id="editRoomNumber" name="room_number" required>
                                <option value="">Bitte wählen</option>
                                <?php foreach ($rooms as $room): ?>
                                    <option value="<?= $room['number'] ?>"><?= $room['number'] . ' - ' . $room['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editCheckInDate" class="form-label">Anreise</label>
                                <input type="date" class="form-control bg-dark text-white" id="editCheckInDate"
                                    name="check_in_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editCheckOutDate" class="form-label">Abreise</label>
                                <input type="date" class="form-control bg-dark text-white" id="editCheckOutDate"
                                    name="check_out_date" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Status</label>
                            <select class="form-select" id="editStatus" name="status" required>
                                <option value="new">Neu</option>
                                <option value="approved">Genehmigt</option>
                                <option value="canceled">Storniert</option>
                            </select>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input bg-dark text-white" type="checkbox" id="editBreakfast"
                                name="with_breakfast" value="1">
                            <label class="form-check-label" for="editBreakfast">
                                Mit Frühstück
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input bg-dark text-white" type="checkbox" id="editParking"
                                name="with_parking" value="1">
                            <label class="form-check-label" for="editParking">
                                Mit Parkplatz
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input bg-dark text-white" type="checkbox" id="editPet"
                                name="with_pet" value="1">
                            <label class="form-check-label" for="editPet">
                                Mit Haustier
                            </label>
                        </div>

                        <div class="mb-3">
                            <label for="editRemarks" class="form-label">Bemerkungen</label>
                            <textarea class="form-control bg-dark text-white" id="editRemarks" name="remarks" rows="3"
                                placeholder="Ihre Bemerkungen hier..."></textarea>
                        </div>

                        <h5>Preis-Aufschlüsselung</h5>
                        <table class="table table-borderless table-sm table-dark text-white">
                            <tr>
                                <td class="text-end">Grundpreis:</td>
                                <td class="text-end"><span id="editBasePrice">0.00</span> €</td>
                            </tr>
                            <tr>
                                <td class="text-end">Aufpreis Frühstück:</td>
                                <td class="text-end"><span id="editBreakfastPrice">0.00</span> €</td>
                            </tr>
                            <tr>
                                <td class="text-end">Aufpreis Parkplatz:</td>
                                <td class="text-end"><span id="editParkingPrice">0.00</span> €</td>
                            </tr>
                            <tr class="fw-bold">
                                <td class="text-end">Gesamt:</td>
                                <td class="text-end"><span id="editTotalPrice">0.00</span> €</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-light">Speichern</button>
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Abbrechen</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include 'src/views/includes/footer.php'; ?>
</body>

<script src="/public/js/editBookingModal.js"></script>

</html>