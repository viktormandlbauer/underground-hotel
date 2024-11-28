<?php include 'src/views/includes/header.php'; ?>
<?php include 'src/views/includes/navbar.php'; ?>

<style>
    .btn-block {
        width: 100%;
    }

    .position-relative {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
    }
</style>

<title name="login">Login</title>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
            <h1 class="text-center mt-5">Login</h1>
            <form action="/auth/submit/login" method="POST" class="mt-4">

                <?php if (isset($_SESSION['flash_message'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['flash_message'];
                        unset($_SESSION['flash_message']); ?>
                    </div>
                <?php endif; ?>

                <!-- Username -->
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                        required />
                    <label for="username">Username</label>
                </div>

                <!-- Passwort -->
                <div class="form-floating position-relative mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Passwort"
                        required />
                    <label for="password">Passwort</label>
                    <i class="fa fa-eye-slash toggle-password" id="togglePassword"></i>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary btn-block">Login</button>

            </form>
        </div>
    </div>
</div>

<script src="public/js/showPassword.js"></script>

<?php include 'src/views/includes/footer.php'; ?>