<?php include 'src/views/includes/header.php'; ?>
<?php include 'src/views/includes/navbar.php'; ?>
<?php require 'src/controllers/auth/login.php'; ?>
<?php $user = unserialize($_SESSION['user_data']); ?>


<div class="container mt-5">
    <h1 class="mb-4">Profilverwaltung</h1>

    <div class="card p-4 mb-4">
        <p>Angemeldet als: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
        <p>Pronomen: <strong><?php echo htmlspecialchars($user->getPronouns()); ?></strong></p>
        <p>Vorname: <strong><?php echo htmlspecialchars($user->getGivenname()); ?></strong></p>
        <p>Nachname: <strong><?php echo htmlspecialchars($user->getSurname()); ?></strong></p>
        <p>E-Mail: <strong><?php echo htmlspecialchars($user->getEmail()); ?></strong></p>
    </div>

    <!-- Formular zum Ändern der Profildaten -->
    <h2 class="mb-3">Profildaten aktualisieren</h2>
    <form method="post" action="update_profile.php" class="mb-4">
        <div class="mb-3">
            <label for="givenname" class="form-label">Vorname:</label>
            <input type="text" name="givenname" class="form-control" value="<?php echo $user->getGivenname(); ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="surname" class="form-label">Nachname:</label>
            <input type="text" name="surname" class="form-control" value="<?php echo $user->getSurname(); ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">E-Mail:</label>
            <input type="email" name="email" class="form-control" value="<?php echo $user->getEmail(); ?>" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Daten aktualisieren</button>
    </form>

    <!-- Formular zum Ändern des Passworts -->
    <h2 class="mb-3">Passwort ändern</h2>
    <form method="post" action="change_password.php">
        <div class="mb-3">
            <label for="old_password" class="form-label">Altes Passwort:</label>
            <input type="password" name="old_password" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="new_password" class="form-label">Neues Passwort:</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Neues Passwort bestätigen:</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Passwort ändern</button>
    </form>
</div>

<?php include 'src/views/includes/footer.php'; ?>