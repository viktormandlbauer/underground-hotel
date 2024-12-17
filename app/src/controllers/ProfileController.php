<?php
require_once 'src/models/Room.php';
require_once 'src/util/validation.php';
require_once 'src/util/image.php';
require_once 'src/models/User.php';

global $request;
global $method;

switch ([$request, $method]) {

    case ['/profile', 'GET']:
        $username = $_SESSION['username'];
        $user = new User($username);
        $user->loadProfile();

        break;

    

    case ['/profile/update', 'POST']:


        $username = $_SESSION['username'];
        $user = new User($username);
        $user->loadProfile();
         // Sammeln der POST-Daten mit Fallback auf aktuelle Werte
         $pronouns = $_POST['pronouns'] ?? $user->pronouns;
         $givenname = $_POST['givenname'] ?? $user->givenname;
         $surname = $_POST['surname'] ?? $user->surname;
         $email = $_POST['email'] ?? $user->email;
         $telephone = $_POST['telephone'] ?? $user->telephone;
         $country = $_POST['country'] ?? $user->country;
         $postal_code = $_POST['postal_code'] ?? $user->postal_code;
         $city = $_POST['city'] ?? $user->city;
         $street = $_POST['street'] ?? $user->street;
         $house_number = $_POST['house_number'] ?? $user->house_number;

         // Aufrufen der saveProfile-Methode mit den gesammelten Daten
         $user->saveProfile($pronouns, $givenname, $surname, $email, $telephone, $country, $postal_code, $city, $street, $house_number);

         $_SESSION['flash_message'] = 'Profil erfolgreich aktualisiert.';

        header('Location: /profile');
        break;

    case ['/profile/changePassword', 'POST']:
        $oldPassword      = $_POST['old_password']      ?? '';
        $newPassword      = $_POST['new_password']      ?? '';
        $confirmPassword  = $_POST['confirm_password']  ?? '';
    
        try {
            $username = $_SESSION['username'];
            $user = new User($username);
            $user->loadProfile();
    
            $user->changePassword($oldPassword, $newPassword, $confirmPassword);
    
            $_SESSION['flash_message'] = 'Passwort erfolgreich geändert.';
        } catch (Exception $e) {
            $_SESSION['flash_message'] = 'Fehler beim Ändern des Passworts: ' . $e->getMessage();
        }
    
        header("Location: /profile");
        break;

    case ['/profile/pictureUpload', 'POST']:

        break;

    case ['/profile/delete', 'POST']:
        //@TODO delete user
        break;

    default:
        break;
}