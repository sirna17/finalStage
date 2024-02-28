<?php
session_start();

require_once 'db.php';

/*if (!isset($_SESSION['prenom']) && empty($_SESSION['prenom'])) {
    header('location:../index.php');
    exit();
}*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php //require_once('inc/meta.php'); ?>
   <!-- <link rel="stylesheet" href="css/style.css">-->
   <script src="https://kit.fontawesome.com/02b1d6d912.js" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="css/creer_compte.css">
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

        .messageInfos{
			width: 400px;
			margin: 20px auto;
			background-color: #fff;
			border-radius: 8px;
			box-shadow: 0 1px 2px rgba(0,0,0,0.5);
			padding: 10px;
		}

		.messageInfos h1, #messageInfos h2{
			font-family: Arial, Helvetica, sans-serif;
			font-size: 1rem;
			font-weight: bold;
		}
    </style>
</head>

<body>
    <section>
        <?php
           /* if (isset($_SESSION['messageInfos'])) {
                echo $_SESSION['messageInfos'];
                unset($_SESSION['messageInfos']);
            }*/
        ?>
        <div id="formulaire">
            <form action="insert_compte.php" method="post" novalidate>
                    <div id="header-form">
                        <i class="fa-solid fa-user-plus"></i>
                        <h1>Create Account</h1>
                    </div>
                    
                    <div class="container-input">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="nom" placeholder="Votre nom">
                    </div>

                    <div class="container-input">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="prenom" placeholder="Votre prénom">
                    </div>

                    <div class="container-input">
                        <i class="fa-solid fa-at"></i>
                        <input type="text" name="email" placeholder="Votre adresse email">
                    </div>

                    <div class="container-input">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" placeholder="Votre mot de passe">
                    </div>

                    <div class="container-submit">
                        <input type="submit" name="valider" value="Create Account">
                    </div>
                </form>
        </div>
    </section>
</body>

</html>


