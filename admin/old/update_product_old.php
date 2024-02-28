<?php
    session_start();

    require_once 'db.php';

    if(!isset($_SESSION['prenom']) && empty($_SESSION['prenom'])){
        header('location:../index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="css/add_product.css">
    <script src="https://kit.fontawesome.com/02b1d6d912.js" crossorigin="anonymous"></script>
    <title>Technomania - Mise à jour des produits - </title>
    <style>
        h2.valide{
            color: #0f0;
        }

        h2.invalide{
            color: #f00;
            text-align: center;
        }
    </style>
</head>
<body>

    <section>

    <div id="formulaire">
            <form action="insert_update_product.php" method="post" novalidate>
                <?php 
                    if(isset($_SESSION['messageInfos'])) {
                        echo $_SESSION['messageInfos'];
                        unset($_SESSION['messageInfos']);
                    }
                ?>
                <?php
                    $req = $db->prepare('SELECT * FROM produits WHERE id_produit = :id_produit');
                    $req->bindParam(':id_produit', $_GET["id_produit"], PDO::PARAM_INT);
                    $req->execute();
                    
                   
                    
                    while($data = $req->fetch(PDO::FETCH_OBJ)):
                ?>

        <div id="header-form">
            <i class="fa-solid fa-rotate"></i>
            <h1>Mettre à jour les produits</h1>
        </div>

        <div id="container-box"><!-- Début container-box -->
            <div id="box-left"><!-- Début box-left -->
                <div class="container-input">
                    <i class="fa-solid fa-pen"></i>
                    <input type="text" name="titre" placeholder="Titre" required value="<?= $data->titre ?>">
                </div>

                <div class="container-input">
                    <i class="fa-solid fa-dollar-sign"></i>
                    <input type="number" name="prix" placeholder="Prix" step="0.01" required value="<?= $data->prix ?>">
                </div>


                <div class="container-input">
                    <i class="fa-solid fa-tag"></i>
                    <input type="number" name="prix_reduit" placeholder="Prix réduit" step="0.01" value="<?= $data->prix_reduit ?>">
                </div>

                <div class="container-input">
                    <i class="fa-solid fa-at"></i>
                    <input type="number" name="achat_mensuel" placeholder="Nombre d'achats dans le mois" value="<?= $data->achat_mensuel ?>">
                </div>

                <div class="container-input">
                    <i class="fa-solid fa-star"></i>
                    <input type="text" name="nb_etoiles" placeholder="Stars numbers" max="5" value="<?=$data->nb_etoiles ?>">
                </div>


                <!-- <div class="container-input">
                    <i class="fa-solid fa-book"></i>
                    <input type="number" name="ratings" placeholder="Ratings">
                </div> -->

                <!-- <div class="container-input">
                <i class="fa-solid fa-image"></i>
                    <input type="file" name="img_principale" accept="image/" required>
                </div>


                <div class="container-input">
                    <i class="fa-solid fa-image"></i>
                    <input type="file" name="img_thumbs[]" accept="image/" multiple>
                </div> -->

                <!-- <div class="container-input">
                    <i class="fa-solid fa-heart"></i>
                    <textarea name="avantages_produit" placeholder="Product Advantage" required></textarea>
                </div>


                <div class="container-input">
                <i class="fa-solid fa-face-smile"></i>
                    <textarea name="commentaires" placeholder="Ratings" required></textarea>
                </div> -->


                <input type="hidden" name="id_produit" value="<?php echo $data->id_produit; ?>">
            </div><!-- Fin box-left -->

            <div id="box-right"><!-- Début box-right -->
            <div class="container-textarea">
                <i class="fa-solid fa-sun"></i>
                <textarea name="avantages" placeholder="Avantages" required rows="5" cols="10"><?= $data->avantages ?></textarea>
            </div>
            </div><!-- Fin box-right -->
        </div><!-- Fin container-box -->


        <div class="container-submit">
            <input type="submit" name="valider" value="Update product">
        </div>
        <?php endwhile;?>

    </form>
    
    </section>

    
</body>
</html>