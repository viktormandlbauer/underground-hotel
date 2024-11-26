<?php include 'src/views/includes/header.php'; ?>
<?php include 'src/views/includes/navbar.php'; ?>
<?php include 'src/controllers/ProfileController.php' ?>

<title>Profilverwaltung</title>

<div class="container mt-5">
    <h1 class="mb-4">Profilverwaltung</h1>


    <form method="POST" action="/profile/update" enctype="multipart/form-data">
        <div id="profileInfo" class="card p-3 mb-3">

            <!-- Profile Picture Section -->
            <div class="d-flex align-items-center mb-3">
                <img id="profile_picture" src="/public/images/not-implemented.gif" onerror="default_picture()" alt="Profile Picture" class="img-fluid me-2" style="width: 100px; height: auto;" />
                <div>
                    <h2 id="username" class="h5 mb-1"></h2>
                    <small class="text-muted" id="userRole">role</small>
                </div>
            </div>

            <!-- Pronouns Field -->
            <div class="row mb-2">
                <label for="pronouns" class="col-sm-3 col-form-label">Pronomen:</label>
                <div class="col-sm-9">
                    <input type="text" id="pronouns" class="form-control form-control-sm" value="" readonly aria-label="Pronouns">
                </div>
            </div>

            <!-- First Name Field -->
            <div class="row mb-2">
                <label for="givenname" class="col-sm-3 col-form-label">Vorname:</label>
                <div class="col-sm-9">
                    <input type="text" id="givenname" class="form-control form-control-sm" value="" readonly aria-label="First Name">
                </div>
            </div>

            <!-- Last Name Field -->
            <div class="row mb-2">
                <label for="surname" class="col-sm-3 col-form-label">Nachname:</label>
                <div class="col-sm-9">
                    <input type="text" id="surname" class="form-control form-control-sm" value="" readonly aria-label="Last Name">
                </div>
            </div>

            <!-- Email Field -->
            <div class="row mb-2">
                <label for="email" class="col-sm-3 col-form-label">E-Mail:</label>
                <div class="col-sm-9">
                    <input type="email" id="email" class="form-control form-control-sm" value="" readonly aria-label="Email">
                </div>
            </div>

            <!-- Telephone Field -->
            <div class="row mb-2">
                <label for="phone" class="col-sm-3 col-form-label">Telefonnummer:</label>
                <div class="col-sm-9">
                    <input type="tel" id="phone" class="form-control form-control-sm" value="" readonly aria-label="Telephone Number">
                </div>
            </div>

            <!-- Address Section -->
            <div class="row mb-2">
                <label for="country" class="col-sm-3 col-form-label">Land:</label>
                <div class="col-sm-9">
                    <input type="text" id="country" class="form-control form-control-sm" value="" readonly aria-label="Country">
                </div>
            </div>

            <div class="row mb-2">
                <label for="postal_code" class="col-sm-3 col-form-label">Postleitzahl:</label>
                <div class="col-sm-9">
                    <input type="text" id="postal_code" class="form-control form-control-sm" value="" readonly aria-label="Postal Code">
                </div>
            </div>

            <div class="row mb-2">
                <label for="city" class="col-sm-3 col-form-label">Stadt:</label>
                <div class="col-sm-9">
                    <input type="text" id="city" class="form-control form-control-sm" value="" readonly aria-label="City">
                </div>
            </div>

            <div class="row mb-2">
                <label for="street" class="col-sm-3 col-form-label">Straße:</label>
                <div class="col-sm-9">
                    <input type="text" id="street" class="form-control form-control-sm" value="" readonly aria-label="Street">
                </div>
            </div>

            <div class="row mb-2">
                <label for="housenumber" class="col-sm-3 col-form-label">Hausnummer:</label>
                <div class="col-sm-9">
                    <input type="text" id="housenumber" class="form-control form-control-sm" value="" readonly aria-label="House Number">
                </div>
            </div>

            <!-- Buttons -->
            <div class="text-end mt-2">
                <button id="editProfileBtn" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">Profil bearbeiten</button>
                <button id="changePasswordBtn" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Passwort ändern</button>
                <button id="privacySettingsBtn" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#privacySettingsModal">Datenschutzeinstellungen</button>
            </div>

            <!-- Modals -->
            <!-- Change password -->
            <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Passwort ändern</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="changePasswordForm">
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
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit profile -->
            <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Profil bearbeiten</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Privacy settings -->
            <div class="modal fade" id="privacySettingsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Datenschutz einstellungen</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
<script src="/public/js/profile.js"></script>

<?php include 'src/views/includes/footer.php'; ?>