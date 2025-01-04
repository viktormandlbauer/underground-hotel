<?php include 'src/views/includes/header.php'; ?>

<body>
    <?php include 'src/views/includes/navbar.php'; ?>

    <title name="login"> Login</title>

    <div class="container d-flex content-wrapper align-items-center justify-content-center">
        <div class="row justify-content-center w-100">
            <div class="bg-dark text-white rounded p-5 col-md-6 col-lg-4">
                <h1 class="text-center mb-4">Login</h1>
                <form action="/auth/submit/login" method="POST">

                    <?php if (isset($_SESSION['flash_message'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['flash_message'];
                            unset($_SESSION['flash_message']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Username -->
                    <div class="form-floating mb-3 bg-dark">
                        <input type="text" class="form-control bg-dark" id="username" name="username" placeholder=""
                            required />
                        <label class="" for="username">Username</label>
                    </div>

                    <!-- Passwort -->
                    <div class="form-floating position-relative mb-3 bg-dark">
                        <input type="password" class="form-control bg-dark" id="password" name="password" placeholder="Passwort"
                            required />
                        <label class="" for="password">Passwort</label>
                        <i class="fa fa-eye-slash toggle-password" id="togglePassword"></i>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-lg btn-outline-light w-100 rounded-pill">Login</button>

                </form>
            </div>
        </div>
    </div>
    <?php include 'src/views/includes/footer.php'; ?>
</body>
<style>
    .toggle-password {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
    }
</style>
<script src="public/js/showPassword.js"></script>

</html>