<?php include 'src/views/includes/header.php'; ?>
<?php include 'src/views/includes/navbar.php'; ?>

<title name="login">Login</title>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
            <h1 class="text-center mt-5">Login</h1>
            <form action="/auth/submit/login" method="POST" class="mt-4">

                <!-- Username -->
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required /><br>
                </div>

                <!-- Passwort -->
                <div class="form-group">
                    <label for="password">Passwort:</label>
                    <input type="password" class="form-control" id="password" name="password" required /><br>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary btn-block">Login</button>

            </form>
        </div>
    </div>
</div>

<?php include 'src/views/includes/footer.php'; ?>