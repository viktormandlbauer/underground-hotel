<?php include 'src/views/includes/header.php'; ?>
<?php include 'src/views/includes/navbar.php'; ?>

<div class="container">
    <div class="date-range">
        <div class="checkin-picker"></div>
        <div class="checkout-picker"></div>
    </div>
    <p>
        <span id="display-checkin"></span>
        <span id="display-checkout"></span>
    </p>
    <div class="rooms" id="rooms-list"></div>
</div>

<link rel="stylesheet" href="/public/css/datepicker.css">
<script src="/public/js/rooms.js"></script>

<?php include 'src/views/includes/footer.php'; ?>