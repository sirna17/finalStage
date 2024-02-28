<?php

require_once 'db.php';

if (isset($_POST['valider'])) {
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['email'],  $_POST['password'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        /* Si tous les champs sont vides */
        if (empty($nom) && empty($prenom) && empty($email) &&  empty($password)) {
            $_SESSION['messageInfos'] = '<h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Vous devez remplir tous les champs</h2>';
            header('location: creer_compte.php');
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

        
        header('Location: creer_compte.php');

        exit();
    }
} else {
   
    header('Location: creer_compte.php');

    exit();
}
