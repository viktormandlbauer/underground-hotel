<?php include 'src/views/includes/header.php'; ?>
<?php include 'src/views/includes/navbar.php'; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <h1 class="text-center mt-5">Registrierung</h1>
                <form action="/auth/submit/registration" method="POST" class="mt-4">
                    
                    <!-- Pronouns -->
                    <div class="form-group">
                        <label for="pronouns">Anrede:</label>
                        <select id="pronouns" name="anrede" class="form-control" required>
                            <option value="">Bitte wählen</option>
                            <option value="Herr">Herr</option>
                            <option value="Frau">Frau</option>
                            <option value="Divers">Divers</option>
                        </select>
                    </div>
    
                    <!-- Givenname -->
                    <div class="form-group">
                        <label for="givenname">Vorname:</label>
                        <input type="text" id="givenname" name="surname" class="form-control" pattern="[A-Za-zÄäÖöÜüß]+" title="Bitte nur Buchstaben verwenden" required>
                    </div>
    
                    <!-- Surname -->
                    <div class="form-group">
                        <label for="surname">Nachname:</label>
                        <input type="text" id="surname" name="nachname" class="form-control" pattern="[A-Za-zÄäÖöÜüß]+" title="Bitte nur Buchstaben verwenden" required>
                    </div>
    
                    <!-- E-Mail -->
                    <div class="form-group">
                        <label for="email">E-Mail-Adresse:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
    
                    <!-- Username -->
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" class="form-control" minlength="3" maxlength="20" required>
                    </div>
    
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Passwort:</label>
                        <input type="password" id="password" name="password" class="form-control" minlength="8" required>
                    </div>
    
                    <!-- Password confirm -->
                    <div class="form-group">
                        <label for="password_confirm">Passwort bestätigen:</label>
                        <input type="password" id="password_confirm" name="password_confirm" class="form-control" minlength="8" required>
                    </div>
    
                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary btn-block">Registrieren</button>
    
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="/public/validation.js">
    
    <?php include 'src/views/includes/footer.php'; ?>