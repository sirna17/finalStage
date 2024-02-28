<?php

require 'db.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="css/style.css">
    <title>TECHNOMANIA - Create account</title>
    <style>
        h2.valide {
            color: #0f0;
            text-align: center;
        }

        h2.invalide {
            color: #f00;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1><i class="fa-solid fa-user-plus"></i> Create account </h1>
    <?php // include_once('inc/navigation.php'); ?>
    <section>
        <div id="formulaire">
            <form action="insert_compte.php" method="post" novalidate>
                
                <div class="form">
                    <i class="fa-solid fa-user-gear"></i>
                    <input type="text" name="nom" id="nom" placeholder="Name" require>
                </div>

                <div class="form">
                    <i class="fa-solid fa-user-gear"></i>
                    <input type="text" name="prenom" id="prenom" placeholder="First Name" require>
                </div>
                <div class="form">
                    <i class="fa-solid fa-at"></i>
                    <input type="email" name="email" id="email" placeholder="Email" require>
                </div>

                <div class="form">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Password" require>
                </div>

                <div id="reset_submit">
                    <input type="reset" value="Annuler compte">
                    <input type="submit" name="valider" value="Créer compte">
                </div>
            </form>
        </div>
    </section>
</body>

</html>