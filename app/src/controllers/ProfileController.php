<?php
require_once 'src/models/Room.php';
require_once 'src/util/validation.php';
require_once 'src/util/Image.php';
require_once 'src/models/User.php';

global $request;
global $method;

switch ([$request, $method]) {

    case ['/profile', 'GET']:
        $username = $_SESSION['username'];
        $user = new User($username);
        $user->loadProfile();

        break;

    
    case (['/profile/update', 'POST']):

        $username = $_SESSION['username'];
        $user = new User($username);

        if(isset($_POST['pronouns']) && isset($_POST['givenname']) && isset($_POST['surname']) && isset($_POST['email'])) {
            $user->loadProfile();
        

        if(isset($_POST['pronouns']) && isValidArray($_POST['pronouns'], [ValidationTypes::strict_string])) {
            $user->setPronouns($_POST['pronouns']);
        }

        if (isset($_POST['givenname']) && isValidArray($_POST['givenname'], [ValidationTypes::strict_string])) {
            $user->setGivenname($_POST['givenname']);
        }
        if (isset($_POST['surname']) && isValidArray($_POST['surname'], [ValidationTypes::strict_string])) {
            $user->setSurname($_POST['surname']);
        }
        if (isset($_POST['email']) && isValidArray($_POST['email'], [ValidationTypes::email])) {
            $user->setEmail($_POST['email']);
        }
        if (isset($_POST['telephone']) && isValidArray($_POST['telephone'], [ValidationTypes::open_string])) {
            $user->setTelephone($_POST['telephone']);
        }
        if (isset($_POST['country']) && isValidArray($_POST['country'], [ValidationTypes::strict_string])) {
            $user->setCountry($_POST['country']);
        }
        if (isset($_POST['postal_code']) && isValidArray($_POST['postal_code'], [ValidationTypes::integer])) {
            $user->setPostalCode($_POST['postal_code']);
        }
        if (isset($_POST['city']) && isValidArray($_POST['city'], [ValidationTypes::strict_string])) {
            $user->setCity($_POST['city']);
        }
        if (isset($_POST['street']) && isValidArray($_POST['street'], [ValidationTypes::strict_string])) {
            $user->setStreet($_POST['street']);
        }
        if (isset($_POST['house_number']) && isValidArray($_POST['house_number'], [ValidationTypes::integer])) {
            $user->setHouseNumber($_POST['house_number']);
        }

        $_SESSION['flash_message'] = 'Profil erfolgreich aktualisiert.';

        header('Location: /profile');}
        else {
            $_SESSION['flash_message'] = 'Bitte füllen Sie alle Felder aus';
            header('Location: /profile');
        }
        break;
        


    case (['/profile/changePassword', 'POST']):
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

    case (['/profile/delete', 'POST']):
        $username = $_SESSION['username'];
        $user = new User($username);
        if (User::login($username, $_POST['password'])) {
            $user->deleteUser();
            session_destroy();
            $_SESSION['flash_message'] = 'Löschen des Profils erfolgreich.';
            header('Location: /');

        } else {

            $_SESSION['flash_message'] = 'Falsches Passwort';
            header('Location: /profile');

        }
        break;

    default:
        break;
}