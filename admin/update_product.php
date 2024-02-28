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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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

        #mini_galerie{
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            align-items: center;
            padding: 10px;
        }

        #img_principale{
            width: 30%;
        }

        #img_principale img{
            width: 220px;
            border-radius: 8px;
            border: solid 1px #ccc;
            box-shadow: 0 1px 2px rgba(0,0,0,0.5);
            transition: 0.5s;
        }

        /*
        #img_principale img:hover{
            cursor: pointer;
            transition: 0.5s;
            transform: scale(1.2);
        }
        */

        #imgs_thumbs{
            width: 70%;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 15px;
        }

        #imgs_thumbs img{
            width: 100px;
            border-radius: 8px;
            border: solid 1px #ccc;
            box-shadow: 0 1px 2px rgba(0,0,0,0.5);
            transition: 0.5s;
        }

        /*
        #imgs_thumbs img:hover{
            cursor: pointer;
            transition: 0.5s;
            transform: scale(1.3);
        }
        */

        .popup{
            width: 60%;
            padding: 10px;
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>

    <section>

    <div id="formulaire">
            <form action="insert_update_product.php" method="post" novalidate>
                <?php
                    $req = $db->prepare(
                        '   SELECT 
                                p.id_produit, p.titre, p.avantages, p.prix, p.prix_reduit, p.lien_amazon, p.achat_mensuel, p.nb_etoiles, p.ratings,
                                im_mini.id_image_miniature, 
                                im_mini.img_thumbs,
                                im_princ.id_image_principale,
                                im_princ.img_principale
                            FROM produits p
                            LEFT JOIN images_miniatures im_mini ON p.id_produit = im_mini.id_produit
                            LEFT JOIN images_principales im_princ ON p.id_produit = im_princ.id_produit
                            WHERE p.id_produit = :id_produit
                        ');
            
                    $req->bindParam(':id_produit', $_GET["id_produit"], PDO::PARAM_INT);
                    $req->execute();

                    $data = $req->fetch(PDO::FETCH_OBJ);
                ?>

        <div id="header-form">
            <i class="fa-solid fa-rotate"></i>
            <h1>Mettre à jour les produits</h1>
        </div>

        <div id="container-box"><!-- Début container-box -->

            <div id="box-left"><!-- Début box-left -->   
                <div class="container-input">
                    <i class="fa-solid fa-pen"></i>
                    <input type="text" name="titre" placeholder="Title" value="<?=$data->titre ?>" required>
                </div>
                
                <div class="container-input">
                    <i class="fa-solid fa-dollar-sign"></i>
                    <input type="number" name="prix" placeholder="Price" step="0.01" value="<?=$data->prix ?>" required>
                </div>
                
                
                <div class="container-input">
                    <i class="fa-solid fa-tag"></i>
                    <input type="number" name="prix_reduit" placeholder="Crossed out price" step="0.01" value="<?=$data->prix_reduit ?>">
                </div>
                
                
                <div class="container-input">
                    <i class="fa-solid fa-star"></i>
                    <input type="text" name="nb_etoiles" placeholder="Stars numbers" max="5" value="<?=$data->nb_etoiles ?>">
                </div>
                
                
                <div class="container-input">
                    <i class="fa-solid fa-book"></i>
                    <input type="number" name="ratings" placeholder="Ratings" value="<?=$data->ratings ?>">
                </div>
                
                
                <div class="container-input">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <input type="number" name="achat_mensuel" placeholder=" Bought in past month" value="<?=$data->achat_mensuel ?>">
                </div>
                
                
                <div class="container-input">
                    <i class="fa-solid fa-link"></i>
                    <input type="text" name="lien_amazon" placeholder="Amazon link" value="<?=$data->lien_amazon ?>">
                </div>

                <!--
                <div class="container-input">
                    <i class="fa-solid fa-image"></i>
                    <input type="file" name="img_principale" accept="image/*" required>
                </div>
                
                
                <div class="container-input">
                    <i class="fa-solid fa-image"></i>
                    <input type="file" name="img_thumbs[]" accept="image/*" multiple>
                </div>
                -->

               
                <!--
                <div class="container-input">
                    <i class="fa-solid fa-image"></i>
                    <input type="file" name="img_principale" accept="image/*" required>
                </div>
                
                
                <div class="container-input">
                    <i class="fa-solid fa-image"></i>
                    <input type="file" name="img_thumbs[]" accept="image/*" multiple>
                </div>
                -->
                <input type="hidden" name="id_produit" value="<?= $_GET['id_produit']; ?>">
            </div><!-- Fin box-left -->
        
            <div id="box-right"><!-- Début box-right -->
                <div class="container-textarea">
                    <i class="fa-solid fa-sun"></i>
                    <textarea name="avantages" placeholder="Avantages" required rows="5" cols="10"><?=$data->avantages ?></textarea>
                </div>
                
                <!--
                <div class="container-textarea">
                    <i class="fa-solid fa-heart"></i>
                    <textarea name="avantages_produit" placeholder="Product Advantage" required></textarea>
                </div>
                
                <div class="container-textarea">
                    <i class="fa-solid fa-face-smile"></i>
                    <textarea name="commentaires" placeholder="Ratings" required></textarea>
                </div>
                -->
            </div><!-- Fin box-right -->
        </div><!-- Fin container-box -->

        <div id="mini_galerie"><!-- Début mini galerie -->
            <div id="img_principale">
                <?php
                    echo '<img src="'.$data->img_principale.'" alt="">';
                ?>
            </div>
            <div id="imgs_thumbs">
                <?php
                    $sqlImgThumbs = 'SELECT im.img_thumbs FROM images_miniatures AS im
                    JOIN produits AS p ON im.id_produit = p.id_produit
                    WHERE p.id_produit = :id_produit';

                    $req = $db->prepare($sqlImgThumbs);
                    $req->bindParam(':id_produit', $_GET["id_produit"], PDO::PARAM_INT);
                    $req->execute();

                    $data;

                    while($data = $req->fetch(PDO::FETCH_OBJ)){
                        echo '<img src="'.$data->img_thumbs.'" alt="">';
                    }
                ?>
            </div>
        </div><!-- Fin mini galerie -->

        <div class="container-submit">
            <input type="submit" name="valider" value="Update product">
        </div>
    </form>

   <div class="popup">
       <form action="change_image_principale.php" method="post" enctype="multipart/form-data">
           <div class="container-input">
               <i class="fa-solid fa-image"></i>
               <input type="file" name="img_principale" accept="image/*" required>
               <input type="hidden" name="id_produit" value="<?= $_GET['id_produit']; ?>">
            </div>
            
            <div class="container-submit">
                <input type="submit" name="valider" value="Changer l'image">
            </div>
        </form>
    </div>
    </section>

    <script>
        const image_principale = document.querySelector('#img_principale img');
        const popup = document.querySelector('.popup');

        image_principale.addEventListener('click', () =>{
            popup.style.display = 'block';
        });

        function updateImage() {
        var formData = new FormData($('#formImage')[0]);

        $.ajax({
            url: 'update_product.php?id_produit=<?php echo $_GET["id_produit"]; ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data); 
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    </script>                
</body>
</html>