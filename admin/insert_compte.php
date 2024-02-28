<?php
session_start();

require_once 'db.php';

if (!isset($_SESSION['prenom']) && empty($_SESSION['prenom'])) {
    header('location:../index.php');
    exit();
}

if (isset($_POST['valider'])) {
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['email'],  $_POST['password'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        /* Si tous les champs sont vides */
        if (empty($nom) && empty($prenom) && empty($email) &&  empty($password)) {
            $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Vous devez remplir tous les champs</h2></div>';
            header('location: create_account.php');
            exit();
        }


        /* Si nom est vide */
        if ($nom == '') {
            $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Vous devez saisir un nom</h2></div>';
            header('location: create_account.php');
            exit();
        }

        /* Si prénom est vide */
        if ($prenom == '') {
            $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Vous devez saisir un prénom</h2></div>';
            header('location: create_account.php');
            exit();
        }

        /* Si l'email est vide */
        if ($email == '') {
            $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Vous devez saisir une adresse email</h2></div>';
            header('location: create_account.php');
            exit();
        }

        /* Si mot de passe est vide */
        if ($password == '') {
            $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Vous devez saisir un mot de passe</h2></div>';
            header('location: create_account.php');
            exit();
        }

        $sql = 'INSERT INTO administrateurs (nom, prenom, email, pass) 
                    VALUES(:nom, :prenom , :email, :password)';

        $req = $db->prepare($sql);

        $req->bindParam(':nom', $nom, PDO::PARAM_STR);
        $req->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->bindParam(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);

        $req->execute();
    
        $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="valide"><i class="fa-solid fa-circle-info"></i> Le compte administrateur à bien été créer.</h2></div>';

        header('Location: create_account.php');

        exit();
    }
} else {
    $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Le compte administrateur na pas pu être créer.</h2></div>';

    header('Location: create_account.php');

    exit();
}
