<?php
// Démarrer une session
session_start();
// Inclure le fichier de base de données
require_once 'db.php';

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
if (isset($_SESSION['administrateurID'])) {
    // Récupérer les informations de session
    $administrateurID = $_SESSION['administrateurID'];
    $prenom = $_SESSION['prenom'];
} else {
// Rediriger vers la page d'accueil si l'utilisateur n'est pas connecté
    header('location:../index.php');
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <?php require_once('inc/meta.php');// Inclure le fichier meta ?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/confirmation.css">
    <link rel="stylesheet" href="css/list_product.css"><!--réalisation personnel-->
    <title>Technomania - Sélection de produits </title>
    <style>
        table tbody td a{
            color: #000;
        }
    </style>
</head>
<body>


<header>
     <!-- En-tête avec le titre et les informations de l'utilisateur connecté -->
        <h1>TECHNOMANIA - List Products</h1>

        <div>
            <span><a href="deconnexion.php"><i class="fa-solid fa-user"></i></a></span>
            <h2><?php echo ucfirst($prenom); ?></h2>
        </div>

</header>
    
    <main>
    <!-- Liens vers différentes pages -->
    <a href="../index.php">
            <div class="card">
                <i class="fa-solid fa-users"></i>
                <h3>Home</h3>
            </div>
        </a>


        <a href="create_account.php">
            <div class="card">
                <i class="fa-solid fa-user"></i>
                <h3>Create account</h3>
            </div>
        </a>

        <a href="formulaire_product.php">
            <div class="card">
                <i class="fa-solid fa-circle-plus"></i>
                <h3>Add product</h3>
            </div>
        </a>

        <a href="select_product.php">
            <div class="card">
                <i class="fa-solid fa-rectangle-list"></i>
                <h3>List products</h3>
            </div>
        </a>
        
        <a href="deconnexion.php">
            <div class="card">
                <i class="fa-solid fa-power-off"></i>
                <h3>Logout</h3>
            </div>
        </a> 
    </main>
    <div id="conteneur_tableau">
    <!-- Tableau affichant les produits -->
        <table>
            <thead>
                <tr>
                    <th style="width:30px;"><i class="fa-solid fa-hashtag"></i> ID</th>
                    <th style="width:300px;"><i class="fa-solid fa-file"></i> Titre</th>
                    <th style="width:50px;"><i class="fa-solid fa-dollar-sign"></i> Prix</th>
                    <th style="width:80px;"><i class="fa-solid fa-dollar-sign"></i>  Prix barré</th>
                    <th style="width:30px;" class="update"><i class="fa-solid fa-file-pen"></i></th>
                    <th style="width:30px;" class="delete"><i class="fa-solid fa-trash-can"></i></th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Récupérer tous les produits de la base de données
                $req = $db->query('SELECT * FROM produits');//pour sélectionner tous les enregistrements de la table "produits" de la base de données. Le résultat de la requête est stocké dans la variable $req.
                $data = null;// Elle sera utilisée pour stocker les données de chaque produit à chaque itération de la boucle.
            // Afficher chaque produit dans une ligne du tableau
                while($data = $req->fetch(PDO::FETCH_OBJ)) : // continue tant qu'il y a des résultats dans la requête SQL.
                   // À chaque itération, la méthode fetch(PDO::FETCH_OBJ) récupère la prochaine ligne du résultat sous forme d'objet (en utilisant la classe stdClass de PDO) et stocke ces données dans la variable $data.?>
                <tr>
                    <!--Affichage des données du produit dans une ligne du tableau-->
                    <td><?php echo $data->id_produit; ?></td>
                    <td style="text-align:left; padding-left: 10px";><?php echo mb_strimwidth($data->titre, 0, 80, '...');  ?></td>
                    <td>$<?php echo $data->prix;  ?> </td>
                    <td>$<?php echo $data->prix_reduit;  ?> </td>
                    <!-- Liens pour mettre à jour et supprimer un produit -->
                    <td class="update"><a href="update_product.php?id_produit=<?php echo $data->id_produit; ?>"><i class="fa-solid fa-file-pen"></i></a></td>
                    <td class="delete"><a href="delete_product.php?id_produit=<?php echo $data->id_produit; ?>"><i class="fa-solid fa-trash-can supp"></i></a></td>
                </tr>
            <?php endwhile; ?>   
            </tbody>
        </table>
    </div>

    <!-- Boîte de confirmation de suppression Une boîte de confirmation apparaît lorsque l'utilisateur clique sur l'icône de suppression-->
    <div id="confirmation">
        <p><i class="fa-solid fa-triangle-exclamation"></i></p>
        <p>Voulez-vous supprimer cette information ?</p>
        <div>
            <button class="oui" value="oui">Oui</button>
            <button class="non" value="non">Non</button>
        </div>
    </div>
    <!-- Script JavaScript pour la confirmation de suppression  Ce script JavaScript gère l'affichage de la boîte de confirmation et les actions associées lorsqu'un utilisateur clique sur une icône de suppression-->
    <script>
        const confirmation = document.querySelector('#confirmation');/*Sélectionne l'élément du DOM avec l'ID "confirmation" (la boîte de confirmation)*/
        const supps = document.querySelectorAll('i.supp');/* Sélectionne tous les éléments <i> ayant la classe "supp".*/ 
        /*Boucle à travers les icônes de suppression
        Itère à travers chaque icône de suppression.*/
        supps.forEach(supp => {
            supp.addEventListener('click', (e) => {
                /*Prévention du comportement par défaut du lien */
                e.preventDefault();/*Empêche le comportement par défaut du lien pour éviter la navigation vers une autre page. */
                confirmation.style.display = 'block';/*Affiche la boîte de confirmation en modifiant la propriété CSS display à "block" */

                /*Sélection des boutons "Oui" et "Non" à l'intérieur de la boîte de confirmation */
                const oui = document.querySelector('.oui');
                const non = document.querySelector('.non');
                // Rediriger vers la page de suppression si l'utilisateur clique sur "Oui"
                //Ajout de gestionnaires d'événements aux boutons "Oui" et "Non"
                oui.addEventListener('click', () => {
                    //Action lors du clic sur le bouton "Oui" 
                    const id_produit = supp.closest('a').getAttribute('href').split('=')[1];// Récupère l'ID du produit à partir de l'attribut "href" du lien parent de l'icône de suppression.
                    document.location.href = `delete_product.php?id_produit=${id_produit}`;//Redirige l'utilisateur vers la page de suppression du produit avec l'ID correspondant.
                    confirmation.style.display = 'none';//Masque la boîte de confirmation.
                });
                // Rediriger vers la page de sélection de produits si l'utilisateur clique sur "Non"
                non.addEventListener('click', () => {
                    document.location.href = 'select_product.php';/* Redirige l'utilisateur vers la page de sélection de produits. */
                    confirmation.style.display = 'none'; /*Masque la boîte de confirmation */
                });
            });
        });
    </script>

</body>
</html>