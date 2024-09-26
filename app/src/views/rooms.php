<?php include 'src/views/includes/header.php'; ?>
<?php include 'src/views/includes/navbar.php'; ?>

<div class="container">
    <div class="well">
        <h1>Select your booking dates:</h1>
        <div class="date-range">
            <div class="datepicker"></div>
        </div>
        <p>
            <a class="btn btn-success" href="#" role="button">
                Search availabilities from <span id="display-checkin"></span>
                to <span id="display-checkout"></span>
            </a>
        </p>
    </div>
</div>

<link rel="stylesheet" href="/public/css/datepicker.css">
<script src="/public/js/rooms.js"></script>

<?php include 'src/views/includes/footer.php'; ?>