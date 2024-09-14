<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Eigene CSS Datei -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <h1 class="text-center mt-5">Registrierung</h1>
                <form action="/submit_registration" method="POST" class="mt-4">
                    
                    <!-- Anrede -->
                    <div class="form-group">
                        <label for="anrede">Anrede:</label>
                        <select id="anrede" name="anrede" class="form-control" required>
                            <option value="">Bitte wählen</option>
                            <option value="Herr">Herr</option>
                            <option value="Frau">Frau</option>
                            <option value="Divers">Divers</option>
                        </select>
                    </div>
    
                    <!-- Vorname -->
                    <div class="form-group">
                        <label for="vorname">Vorname:</label>
                        <input type="text" id="vorname" name="vorname" class="form-control" pattern="[A-Za-zÄäÖöÜüß]+" title="Bitte nur Buchstaben verwenden" required>
                    </div>
    
                    <!-- Nachname -->
                    <div class="form-group">
                        <label for="nachname">Nachname:</label>
                        <input type="text" id="nachname" name="nachname" class="form-control" pattern="[A-Za-zÄäÖöÜüß]+" title="Bitte nur Buchstaben verwenden" required>
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
    
                    <!-- Passwort -->
                    <div class="form-group">
                        <label for="password">Passwort:</label>
                        <input type="password" id="password" name="password" class="form-control" minlength="8" required>
                    </div>
    
                    <!-- Passwort bestätigen -->
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

    <script>
        // Password confirmation check
        document.querySelector("form").addEventListener("submit", function(event) {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("password_confirm").value;
            if (password !== confirmPassword) {
                alert("Passwörter stimmen nicht überein!");
                event.preventDefault();
            }
        });
    </script>
    
</body>
</html>
