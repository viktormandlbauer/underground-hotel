<?php include 'src/views/includes/header.php'; ?>
<?php include 'src/views/includes/navbar.php'; ?>

<title name="login">Login</title>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
            <h1 class="text-center mt-5">Login</h1>
            <form id="loginForm" action="/auth/submit/login" method="POST" class="mt-4">

                <!-- This is hidden d-none -->
                <div class="alert alert-danger d-none" id="invalidAlert" role="alert">
                    Invalid login credentials. Please try again.
                </div>

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

<script>
    document.getElementById('loginForm').addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(event.target);
        try {
            const response = await fetch('/auth/submit/login', {
                method: 'POST',
                body: formData,
            });

            if (!response.ok) {
                const errorData = await response.json();
                if (errorData.status === 'error') {
                    const alert = document.getElementById('invalidAlert');
                    alert.classList.remove('d-none');
                }
            } else {
                const data = await response.json();
                if (data.status === 'success') {
                    window.location.href = '/profile';
                }
            }
        } catch (error) {
            console.error('An error occurred:', error);
        }
    });


    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>

<?php include 'src/views/includes/footer.php'; ?>