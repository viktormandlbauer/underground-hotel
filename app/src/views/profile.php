<?php
// src/views/profile.php

// Überprüfen, ob $user gesetzt ist
if (!isset($user)) {
    echo "Fehler: Benutzer nicht definiert.";
    exit();
}
?>

<?php include 'src/views/includes/header.php'; ?>
<?php include 'src/views/includes/navbar.php'; ?>

<body>
    <div class="d-flex justify-content-center align-items-center content-wrapper">
        <div class="container mt-5 content">
            <div class="bg-dark text-white p-5 rounded">
                <h1 class="mb-4">Profilverwaltung</h1>

                <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-info alert-dismissible fade show" id="flashMessage">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <?= htmlspecialchars($_SESSION['flash_message'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <script src='/public/js/flashMessage.js'></script>
            <?php endif; ?>

                <!-- Profilinformationen -->
                <div id="profileInfo" class="card bg-dark text-white p-3 mb-3">
                    <!-- Profilbild und Benutzerinformationen -->
                    <div class="d-flex align-items-center mb-3">
                        <img id="profile_picture" src="" alt="Profile Picture" class="img-fluid me-2" style="width: 100px; height: auto;" />
                        <div>
                            <h2 id="username" class="h5 mb-1"><?= $user->username ?></h2>
                            <small class="text-muted" id="userRole"><?= $user->role ?></small>
                        </div>
                    </div>

                    <!-- Pronomen Field -->
                    <div class="row mb-2">
                        <label for="pronouns" class="col-sm-3 col-form-label">Pronomen:</label>
                        <div class="col-sm-9">
                            <input type="text" id="pronouns" class="form-control bg-secondary text-white" value="<?= $user->pronouns ?>" readonly aria-label="Pronouns">
                        </div>
                    </div>

                    <!-- First Name Field -->
                    <div class="row mb-2">
                        <label for="givenname" class="col-sm-3 col-form-label">Vorname:</label>
                        <div class="col-sm-9">
                            <input type="text" id="givenname" class="form-control bg-secondary text-white" value="<?= $user->givenname ?>" readonly aria-label="First Name">
                        </div>
                    </div>

                    <!-- Last Name Field -->
                    <div class="row mb-2">
                        <label for="surname" class="col-sm-3 col-form-label">Nachname:</label>
                        <div class="col-sm-9">
                            <input type="text" id="surname" class="form-control bg-secondary text-white" value="<?= $user->surname ?>" readonly aria-label="Last Name">
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="row mb-2">
                        <label for="email" class="col-sm-3 col-form-label">E-Mail:</label>
                        <div class="col-sm-9">
                            <input type="email" id="email" class="form-control bg-secondary text-white" value="<?= $user->email ?>" readonly aria-label="Email">
                        </div>
                    </div>

                    <!-- Telephone Field -->
                    <div class="row mb-2">
                        <label for="phone" class="col-sm-3 col-form-label">Telefonnummer:</label>
                        <div class="col-sm-9">
                            <input type="tel" id="phone" class="form-control bg-secondary text-white" value="<?= $user->telephone ?>" readonly aria-label="Telephone Number">
                        </div>
                    </div>

                    <!-- Address Section -->
                    <div class="row mb-2">
                        <label for="country" class="col-sm-3 col-form-label">Land:</label>
                        <div class="col-sm-9">
                            <input type="text" id="country" class="form-control bg-secondary text-white" value="<?= $user->country ?>" readonly aria-label="Country">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="postal_code" class="col-sm-3 col-form-label">Postleitzahl:</label>
                        <div class="col-sm-9">
                            <input type="text" id="postal_code" class="form-control bg-secondary text-white" value="<?= $user->postal_code ?>" readonly aria-label="Postal Code">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="city" class="col-sm-3 col-form-label">Stadt:</label>
                        <div class="col-sm-9">
                            <input type="text" id="city" class="form-control bg-secondary text-white" value="<?= $user->city ?>" readonly aria-label="City">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="street" class="col-sm-3 col-form-label">Straße:</label>
                        <div class="col-sm-9">
                            <input type="text" id="street" class="form-control bg-secondary text-white" value="<?= $user->street ?>" readonly aria-label="Street">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="housenumber" class="col-sm-3 col-form-label">Hausnummer:</label>
                        <div class="col-sm-9">
                            <input type="text" id="housenumber" class="form-control bg-secondary text-white" value="<?= $user->house_number ?>" readonly aria-label="House Number">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="text-end mt-2">
                        <button type="button" id="editProfileBtn" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">Profil bearbeiten</button>
                        <button type="button" id="changePasswordBtn" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Passwort ändern</button>
                        <button type="button" id="privacySettingsBtn" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#privacySettingsModal">Datenschutzeinstellungen</button>
                        <button type="button" class="btn btn-outline-light btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#privacyPolicyModal">Datenschutzrichtlinien anzeigen</button>
                        <button type="button" id="deleteProfileBtn" class="btn btn-danger btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#deleteProfileModal">Profil löschen</button>
                    </div>
                </div>

                <!-- Modals -->

                <!-- Edit Profile Modal -->
                <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content bg-dark text-white">
                            <form method="POST" action="/profile/update">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProfileLabel">Profil bearbeiten</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label for="edit_givenname" class="form-label">Vorname:</label>
                                        <input type="text" id="edit_givenname" name="givenname" class="form-control bg-secondary text-white" 
                                            value="<?= $user->givenname ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_surname" class="form-label">Nachname:</label>
                                        <input type="text" id="edit_surname" name="surname" class="form-control bg-secondary text-white" 
                                            value="<?= $user->surname ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_email" class="form-label">E-Mail:</label>
                                        <input type="email" id="edit_email" name="email" class="form-control bg-secondary text-white" 
                                            value="<?= $user->email?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_phone" class="form-label">Telefonnummer:</label>
                                        <input type="tel" id="edit_phone" name="telephone" class="form-control bg-secondary text-white" 
                                            value="<?= $user->telephone ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_country" class="form-label">Land:</label>
                                        <input type="text" id="edit_country" name="country" class="form-control bg-secondary text-white" 
                                            value="<?= $user->country ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_postal_code" class="form-label">Postleitzahl:</label>
                                        <input type="text" id="edit_postal_code" name="postal_code" class="form-control bg-secondary text-white" 
                                            value="<?= $user->postal_code ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_city" class="form-label">Stadt:</label>
                                        <input type="text" id="edit_city" name="city" class="form-control bg-secondary text-white" 
                                            value="<?= $user->city ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_street" class="form-label">Straße:</label>
                                        <input type="text" id="edit_street" name="street" class="form-control bg-secondary text-white" 
                                            value="<?= $user->street ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_house_number" class="form-label">Hausnummer:</label>
                                        <input type="text" id="edit_house_number" name="house_number" class="form-control bg-secondary text-white" 
                                            value="<?= $user->house_number ?>">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                    <button type="submit" class="btn btn-primary">Änderungen speichern</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Change Password Modal -->
                <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content bg-dark text-white">
                            <form method="POST" action="/profile/changePassword">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changePasswordLabel">Passwort ändern</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="old_password" class="form-label">Altes Passwort:</label>
                                        <input type="password" name="old_password" class="form-control bg-secondary text-white" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Neues Passwort:</label>
                                        <input type="password" name="new_password" class="form-control bg-secondary text-white" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Neues Passwort bestätigen:</label>
                                        <input type="password" name="confirm_password" class="form-control bg-secondary text-white" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                    <button type="submit" class="btn btn-primary">Änderungen speichern</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Privacy Settings Modal -->
                <div class="modal fade" id="privacySettingsModal" tabindex="-1" aria-labelledby="privacySettingsLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content bg-dark text-white">
                            <form method="POST" action="/profile/privacy_settings">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="privacySettingsLabel">Datenschutzeinstellungen</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Newsletter Subscription -->
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="1" id="newsletter" name="newsletter" >
                                        <label class="form-check-label" for="newsletter">
                                            Newsletter abonnieren
                                        </label>
                                    </div>

                                    <!-- Data Deletion Request -->
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="1" id="data_deletion" name="data_deletion">
                                        <label class="form-check-label" for="data_deletion">
                                            Persönliche Daten löschen lassen
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                    <button type="submit" class="btn btn-primary">Einstellungen speichern</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Datenschutzrichtlinien Modal -->
                <div class="modal fade" id="privacyPolicyModal" tabindex="-1" aria-labelledby="privacyPolicyLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content bg-dark text-white">
                            <div class="modal-header">
                                <h5 class="modal-title" id="privacyPolicyLabel">Datenschutzrichtlinien</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                <h5>Einleitung</h5>
                                <p>
                                    Willkommen zu unseren Datenschutzrichtlinien. Ihre Privatsphäre ist uns wichtig, und wir verpflichten uns, Ihre persönlichen Daten zu schützen.
                                </p>
                                
                                <h5>Datenerhebung</h5>
                                <p>
                                    Wir erheben verschiedene Arten von Informationen, um Ihnen einen besseren Service bieten zu können.
                                </p>
                                
                                <h5>Datennutzung</h5>
                                <p>
                                    Die von uns gesammelten Informationen werden für verschiedene Zwecke verwendet, einschließlich zur Verbesserung unserer Dienstleistungen.
                                </p>
                                
                                <h5>Datenweitergabe</h5>
                                <p>
                                    Wir geben Ihre persönlichen Daten nur dann weiter, wenn dies gesetzlich vorgeschrieben ist oder Sie ausdrücklich zugestimmt haben.
                                </p>
                                
                                <h5>Ihre Rechte</h5>
                                <p>
                                    Sie haben das Recht, auf Ihre persönlichen Daten zuzugreifen, sie zu korrigieren oder deren Löschung zu verlangen.
                                </p>
                                
                                <h5>Sicherheit</h5>
                                <p>
                                    Wir setzen angemessene Sicherheitsmaßnahmen ein, um Ihre Daten vor unbefugtem Zugriff zu schützen.
                                </p>
                                
                                <h5>Änderungen der Datenschutzrichtlinien</h5>
                                <p>
                                    Wir behalten uns das Recht vor, diese Datenschutzrichtlinien jederzeit zu ändern. Änderungen werden auf dieser Seite veröffentlicht.
                                </p>
                                
                                <h5>Kontakt</h5>
                                <p>
                                    Wenn Sie Fragen zu unseren Datenschutzrichtlinien haben, kontaktieren Sie uns bitte unter <a href="mailto:datenschutz@example.com" class="text-primary">datenschutz@example.com</a>.
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Profile Modal -->
                <div class="modal fade" id="deleteProfileModal" tabindex="-1" aria-labelledby="deleteProfileLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content bg-dark text-white">
                            <form method="POST" action="/profile/delete">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteProfileLabel">Profil löschen</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Sind Sie sicher, dass Sie Ihr Profil löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.</p>
                                    <div class="mb-3">
                                        <label for="delete_password" class="form-label">Passwort zur Bestätigung:</label>
                                        <input type="password" id="password" name="password" class="form-control bg-secondary text-white" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                                    <button type="submit" class="btn btn-danger">Profil löschen</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<?php include __DIR__ . '/includes/footer.php'; ?>