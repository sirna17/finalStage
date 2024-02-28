<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/02b1d6d912.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/add_product.css">
    <title>Formulaire Produit</title>
    <style>
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
    <?php
        if (isset($_SESSION['messageInfos'])) {
            echo $_SESSION['messageInfos'];
            unset($_SESSION['messageInfos']);
        }
    ?>
     <!-- Formulaire pour l'ajout de produit -->
     <!-- En utilisant enctype="multipart/form-data", j'indiquez au navigateur que le formulaire contient des champs de fichier (<input type="file">), et cela permettra au serveur de traiter correctement les données binaires des fichiers lors de la soumission du formulaire vers insert_product.php. "action="insert_product.php" : Spécifie l'URL du script PHP qui sera appelé lors de la soumission du formulaire. Dans votre cas, le script insert_product.php recevra les données du formulaire pour le traitement.
    "method="post" : Détermine la méthode HTTP à utiliser pour l'envoi du formulaire. Vous utilisez "post", ce   qui signifie que les données seront incluses dans le corps de la requête HTTP.-->
    <form action="insert_product.php" method="post" enctype="multipart/form-data">
        <div id="header-form">
            <i class="fa-solid fa-circle-plus"></i>
            <h1>Ajouter un produit</h1>
        </div>

        <div id="container-box"><!-- Début container-box -->

            <div id="box-left"><!-- Début box-left -->   
                <div class="container-input">
                    <i class="fa-solid fa-pen"></i>
                    <input type="text" name="titre" placeholder="Title" required>
                </div>
                
                <div class="container-input">
                    <i class="fa-solid fa-dollar-sign"></i>
                    <input type="number" name="prix" placeholder="Price" step="0.01" required>
                </div>
                
                
                <div class="container-input">
                    <i class="fa-solid fa-tag"></i>
                    <input type="number" name="prix_reduit" placeholder="Crossed out price" step="0.01">
                </div>
                
                
                <div class="container-input">
                    <i class="fa-solid fa-star"></i>
                    <input type="text" name="nb_etoiles" placeholder="Stars numbers" max="5">
                </div>
                
                
                <div class="container-input">
                    <i class="fa-solid fa-book"></i>
                    <input type="number" name="ratings" placeholder="Ratings">
                </div>
                
                
                <div class="container-input">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <input type="number" name="achat_mensuel" placeholder=" Bought in past month">
                </div>
                
                
                <div class="container-input">
                    <i class="fa-solid fa-link"></i>
                    <input type="text" name="lien_amazon" placeholder="Amazon link">
                </div>

                <div class="container-input">
                    <i class="fa-solid fa-image"></i>
                    <input type="file" name="img_principale" accept="image/*" required>
                </div>
                
                
                <div class="container-input">
                    <i class="fa-solid fa-image"></i>
                    <input type="file" name="img_thumbs[]" accept="image/*" multiple>
                </div>
            </div><!-- Fin box-left -->
        
            <div id="box-right"><!-- Début box-right -->
                <div class="container-textarea">
                    <i class="fa-solid fa-sun"></i>
                    <textarea name="avantages" placeholder="Advantages" required></textarea>
                </div>
                
                <div class="container-textarea">
                    <i class="fa-solid fa-heart"></i>
                    <textarea name="avantages_produit" placeholder="Product Advantage" required></textarea>
                </div>
                
                <div class="container-textarea">
                    <i class="fa-solid fa-face-smile"></i>
                    <textarea name="commentaires" placeholder="Ratings" required></textarea>
                </div>
            </div><!-- Fin box-right -->
        </div><!-- Fin container-box -->
        <!--  champ pour l'ajout de produit-->
        <div class="container-submit">
           <input type="submit" value="Ajouter Produit">
       </div>

    </form>
   
</body>

</html>
