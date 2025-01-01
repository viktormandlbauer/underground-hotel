<?php include 'src/views/includes/header.php'; ?>
<link rel="stylesheet" href="/public/css/dashboard.css">

<body>
    
    <?php include 'src/views/includes/navbar.php'; ?>

    <div class="container align-items-center d-flex content-wrapper">
        <div class="row container mt-5 content">
            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center custom-card" onclick="location.href='/admin/manage/bookings'"
                    style="cursor: pointer;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-calendar-alt fa-5x card-icon mb-3"></i>
                        <h5 class="card-title mt-auto">Buchungen verwalten</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center custom-card" onclick="location.href='/admin/manage/news'"
                    style="cursor: pointer;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-newspaper fa-5x card-icon mb-3"></i>
                        <h5 class="card-title mt-auto">News verwalten</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center custom-card" onclick="location.href='/admin/manage/rooms'"
                    style="cursor: pointer;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-bed fa-5x card-icon mb-3"></i>
                        <h5 class="card-title mt-auto">Zimmer verwalten</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center custom-card" onclick="location.href='/admin/manage/users'"
                    style="cursor: pointer;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-users fa-5x card-icon mb-3"></i>
                        <h5 class="card-title mt-auto">Benutzer verwalten</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center custom-card" onclick="location.href='/profile'"
                    style="cursor: pointer;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-user fa-5x card-icon mb-3"></i>
                        <h5 class="card-title mt-auto">Mein Profil</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center custom-card" onclick="location.href='/bookings'"
                    style="cursor: pointer;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-users fa-5x card-icon mb-3"></i>
                        <h5 class="card-title mt-auto">Meine Buchungen</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>


<?php include 'src/views/includes/footer.php'; ?>