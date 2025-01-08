<?php include 'src/views/includes/header.php'; ?>
<?php include 'src/util/validation.php'; ?>

<body>
    <?php include 'src/views/includes/navbar.php'; ?>

    <div class="container d-flex content-wrapper align-items-center justify-content-center">
        <div class="row justify-content-center w-100">
            <div class="bg-dark text-white rounded p-5 col-md-6 col-lg-4">
                <h1 class="text-center mt-5">Registrierung</h1>


                <?php if (isset($_SESSION['flash_message'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['flash_message'];
                        unset($_SESSION['flash_message']); ?>
                    </div>
                <?php endif; ?>

                <form action="/auth/submit/registration" method="POST" class="mt-4 needs-validation" novalidate>

                    <!-- Anrede -->
                    <div class="mb-3">
                        <label for="pronouns" class="form-label">Anrede:</label>
                        <select id="pronouns" name="pronouns" class="form-select bg-dark text-white" required>
                            <option value="" selected disabled>Bitte wählen</option>
                            <option value="Herr">Herr</option>
                            <option value="Frau">Frau</option>
                            <option value="Divers">Divers</option>
                        </select>
                        <div class="invalid-feedback">
                            Bitte wählen Sie eine Anrede.
                        </div>
                    </div>

                    <!-- Vorname -->
                    <div class="form-floating mb-3">
                        <input type="text" id="givenname" name="givenname" class="form-control bg-dark text-white"
                            placeholder="Vorname" pattern="[A-Za-zÄäÖöÜüß]+" required>
                        <label for="givenname text" class="">Vorname</label>
                        <div class="invalid-feedback">
                            Bitte geben Sie Ihren Vornamen ein (nur Buchstaben).
                        </div>
                    </div>

                    <!-- Nachname -->
                    <div class="form-floating mb-3">
                        <input type="text" id="surname" name="surname" class="form-control bg-dark text-white"
                            placeholder="Nachname" pattern="[A-Za-zÄäÖöÜüß]+" required>
                        <label for="surname" class="">Nachname</label>
                        <div class="invalid-feedback">
                            Bitte geben Sie Ihren Nachnamen ein (nur Buchstaben).
                        </div>
                    </div>

                    <!-- E-Mail -->
                    <div class="form-floating mb-3">
                        <input type="text" id="email" name="email" class="form-control bg-dark text-white"
                            placeholder="E-Mail Adresse" required>
                        <label for="email" class="">E-Mail-Adresse</label>
                        <div class="invalid-feedback">
                            Bitte geben Sie eine gültige E-Mail-Adresse ein.
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="form-floating mb-3">
                        <input type="text" id="username" name="username" class="form-control bg-dark text-white"
                            minlength="3" maxlength="20" placeholder="Username" required>
                        <label for="username" class="">Username</label>
                        <div class="invalid-feedback">
                            Bitte wählen Sie einen Benutzernamen (3-20 Zeichen).
                        </div>
                    </div>

                    <!-- Passwort -->
                    <div class="form-floating mb-3">
                        <input type="password" id="password" name="password" class="form-control bg-dark text-white"
                            minlength="8" placeholder="Passwort" required>
                        <label for="password" class="">Passwort</label>
                        <i class="fa fa-eye-slash toggle-password" id="togglePassword"></i>
                        <div class="invalid-feedback">
                            Bitte geben Sie ein Passwort mit mindestens 8 Zeichen ein.
                        </div>
                    </div>

                    <!-- Passwort bestätigen -->
                    <div class="form-floating mb-3">
                        <input type="password" id="password_confirm" name="password_confirm"
                            class="form-control bg-dark text-white" minlength="8" placeholder="Passwort bestätigen"
                            required>
                        <label for="password_confirm" class="">Passwort bestätigen</label>
                        <div class="invalid-feedback">
                            Die Passwörter stimmen nicht überein.
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-lg btn-outline-light w-100 rounded-pill">Registrieren</button>

                </form>
            </div>
        </div>
    </div>
</body>

<?php include 'src/views/includes/footer.php'; ?>

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
<script type="text/javascript" src="/public/js/validation.js"></script>