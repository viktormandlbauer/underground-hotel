<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierungsformular</title>
</head>
<body>

    <h1>Registrierung</h1>

    <form action="/submit_registration" method="POST">

        <!-- Anrede -->
        <label for="anrede">Anrede:</label>
        <select id="anrede" name="anrede" required>
            <option value="">Bitte wählen</option>
            <option value="Herr">Herr</option>
            <option value="Frau">Frau</option>
            <option value="Divers">Divers</option>
        </select>
        <br><br>

        <!-- Vorname -->
        <label for="givenname">Vorname:</label>
        <input type="text" id="givenname" name="givenname" pattern="[A-Za-zÄäÖöÜüß]+" title="Bitte nur Buchstaben verwenden" required>
        <br><br>

        <!-- Nachname -->
        <label for="surname">Nachname:</label>
        <input type="text" id="surname" name="surname" pattern="[A-Za-zÄäÖöÜüß]+" title="Bitte nur Buchstaben verwenden" required>
        <br><br>

        <!-- E-Mail-Adresse -->
        <label for="email">E-Mail-Adresse:</label>
        <input type="email" id="email" name="email" required>
        <br><br>

        <!-- Username -->
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" minlength="3" maxlength="20" required>
        <br><br>

        <!-- Passwort -->
        <label for="password">Passwort:</label>
        <input type="password" id="password" name="password" minlength="8" required>
        <br><br>

        <!-- Passwort bestätigen -->
        <label for="password_confirm">Passwort bestätigen:</label>
        <input type="password" id="password_confirm" name="password_confirm" minlength="8" required>
        <br><br>

        <!-- Submit -->
        <input type="submit" value="Registrieren">

    </form>

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
