<?php include 'src/views/includes/header.php'; ?>
<link rel="stylesheet" href="/public/css/modal.css">

<body>

    <?php include 'src/views/includes/navbar.php'; ?>

    <div class="container mt-5 content-wrapper">
        <div class="row bg-dark text-white py-4 rounded">
            <h1 id="Pages" class="mb-4 text-center display-3">Buchungen</h1>

            <?php include 'src/views/includes/flashmessage.php'; ?>

            <div class="table-responsive">
                <table id="sortedTable" class="table table-dark table-bordered align-middle table-hover tablesorter">
                    <thead>
                        <tr>
                            <th data-sort="number">Buchungs-ID</th>
                            <th data-sort="text">Benutzername</th>
                            <th data-sort="text">Zimmernummer</th>
                            <th data-sort="text">Anreise</th>
                            <th data-sort="text">Abreise</th>
                            <th data-sort="text">Frühstück</th>
                            <th data-sort="text">Parkplatz</th>
                            <th data-sort="text">Haustier</th>
                            <th data-sort="text">Preis</th>
                            <th data-sort="text">Status</th>
                            <th>Stornieren</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        <?php foreach ($bookings as $booking): ?>
                            <tr class="user-row" data-booking-id="<?= $booking['booking_id'] ?>"
                                data-user-id="<?= $booking['user_id'] ?>"
                                data-username="<?= User::getUsernameByID($booking['user_id']) ?>"
                                data-room-number="<?= $booking['room_number'] ?>"
                                data-check-in="<?= $booking['check_in_date'] ?>"
                                data-check-out="<?= $booking['check_out_date'] ?>"
                                data-price-per-night="<?= $booking['price_per_night'] ?>"
                                data-status="<?= $booking['status'] ?>" data-breakfast="<?= $booking['breakfast'] ?>"
                                data-parking="<?= $booking['parking'] ?>" data-pet="<?= $booking['pet'] ?>"
                                data-additional-info="<?= $booking['additional_info'] ?>">

                                <td><?= $booking['booking_id'] ?></td>
                                <td><?= User::getUsernameByID($booking['user_id']) ?></td>
                                <td><?= $booking['room_number'] ?></td>
                                <td><?= $booking['check_in_date'] ?></td>
                                <td><?= $booking['check_out_date'] ?></td>
                                <td><?= $booking['breakfast'] ? 'Ja' : 'Nein' ?></td>
                                <td><?= $booking['parking'] ? 'Ja' : 'Nein' ?></td>
                                <td><?= $booking['pet'] ? 'Ja' : 'Nein' ?></td>
                                <td><?= number_format($booking['total_price'],2) ?> €</td>
                                <td>
                                    <?php if ($booking['status'] == 'new'): ?>
                                        <span class="status-indicator bg-info"></span>
                                        <span class="text-end">Neu</span>

                                    <?php elseif ($booking['status'] == 'approved'): ?>
                                        <span class="status-indicator bg-success"></span>
                                        <span class="text-end">Bestätigt</span>

                                    <?php else: ?>
                                        <span class="status-indicator bg-danger"></span>
                                        <span class="text-end">Storniert</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($booking['status'] == 'new'): ?>
                                        <button type="button" class="btn btn-danger cancel-booking" 
                                        onclick="openCancelModal(<?= $booking['booking_id'] ?>)"
                                        data-bs-toggle="modal" data-bs-target="#cancelBookingModal">Stornieren</button>
                                    <?php else: ?>
                                        <button class="btn btn-secondary" disabled>Stornieren</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="cancelBookingModal" tabindex="-1" aria-labelledby="cancelBookingModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/booking/cancel" method="POST">
                        <input type="hidden" name="booking_id" id="bookingId" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelBookingModalLabel">Buchung stornieren</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Möchten Sie die Buchung wirklich stornieren?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button type="submit" class="btn btn-danger" id="confirmCancelBooking">Stornieren</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include 'src/views/includes/footer.php'; ?>
</body>

<script>
    function openCancelModal(bookingId) {

        document.getElementById('bookingId').value = bookingId;
    }
</script>