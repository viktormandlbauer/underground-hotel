<?php include 'src/views/includes/header.php'; ?>
<link rel="stylesheet" href="/public/css/modal.css">

<body>

    <?php include 'src/views/includes/navbar.php'; ?>

    <div class="container mt-5 content-wrapper">
        <div class="row bg-dark text-white py-4 rounded">
            <h1 id="Pages" class="mb-4 text-center display-3">Benutzerverwaltung</h1>

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
                            <th data-sort="text">Zimmernummer</th>
                            <th data-sort="text">Anreise</th>
                            <th data-sort="text">Abreise</th>
                            <th data-sort="text">Frühstücl</th>
                            <th data-sort="text">Parkplatz</th>
                            <th data-sort="text">Haustier</th>
                            <th data-sort="text">Preis</th>
                            <th data-sort="text">Status</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        <?php foreach ($bookings as $booking): ?>
                            <tr class="user-row" 
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
                                <td><?= $booking['price_per_night'] ?></td>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include 'src/views/includes/footer.php'; ?>
</body>