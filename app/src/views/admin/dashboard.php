<?php include 'src/views/includes/header.php'; ?>

<style>
    body {
        background-color: #f8f9fa;
    }

    .dashboard {
        margin-top: 50px;
    }

    .tile {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        transition: transform 0.2s;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .tile:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }

    .tile-icon {
        font-size: 50px;
        margin-bottom: 15px;
        color: #007bff;
    }

    .tile-title {
        font-size: 20px;
        font-weight: bold;
        color: #343a40;
    }
</style>

<body>

    <?php include 'src/views/includes/header.php'; ?>

    <div class="container dashboard">
        <h1 class="text-center mb-5">Admin Dashboard</h1>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="tile" onclick="location.href='/admin/manage/bookings'">
                    <div class="tile-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="tile-title">Buchungen verwalten</div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="tile" onclick="location.href='/admin/manage/news'">
                    <div class="tile-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="tile-title">News verwalten</div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="tile" onclick="location.href='/admin/manage/rooms'">
                    <div class="tile-icon">
                        <i class="fas fa-bed"></i>
                    </div>
                    <div class="tile-title">Zimmer verwalten</div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="tile" onclick="location.href='/admin/manage/users'">
                    <div class="tile-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="tile-title">Benutzer verwalten</div>
                </div>
            </div>
        </div>
    </div>

</body>
<?php include 'src/views/includes/footer.php'; ?>