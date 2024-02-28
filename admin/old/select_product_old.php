<?php
session_start();

require_once 'db.php';

if (isset($_SESSION['administrateurID'])) {
    $administrateurID = $_SESSION['administrateurID'];
    $prenom = $_SESSION['prenom'];
} else {
    header('location:../index.php');
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once('inc/meta.php'); ?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/confirmation.css">
    <link rel="stylesheet" href="css/list_product.css">
    <title>Technomania - Sélection de produits </title>
    <style>
        table tbody td a{
            color: #000;
        }
    </style>
</head>
<body>


<header>
        <h1>TECHNOMANIA - List Products</h1>

        <div>
            <span><a href="deconnexion.php"><i class="fa-solid fa-user"></i></a></span>
            <h2><?php echo ucfirst($prenom); ?></h2>
        </div>

    </header>
    
    <main>
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

    <?php //include_once('inc/navigation.php'); ?>
    <div id="conteneur_tableau">
        <table>
            <thead>
                <tr>
                    <th style="width:30px;"><i class="fa-solid fa-hashtag"></i> ID</th>
                    <th style="width:300px;"><i class="fa-solid fa-file"></i> Titre</th>
                    <th style="width:50px;"><i class="fa-solid fa-dollar-sign"></i> Prix</th>
                    <th style="width:50px;"><i class="fa-solid fa-dollar-sign"></i> Prix barré</th>
                    <th style="width:30px;" class="update"><i class="fa-solid fa-file-pen"></i></th>
                    <th style="width:30px;" class="delete"><i class="fa-solid fa-trash-can"></i></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $req = $db->query('SELECT * FROM produits');
                $data = null;

                while($data = $req->fetch(PDO::FETCH_OBJ)) : ?>
                <tr>
                    <td><?php echo $data->id_produit; ?></td>
                    <td style="text-align:left; padding-left: 10px";><?php echo mb_strimwidth($data->titre, 0, 80, '...');  ?></td>
                    <td>$<?php echo $data->prix;  ?> </td>
                    <td>$<?php echo $data->prix_reduit;  ?> </td>
                    <td class="update"><a href="update_product.php?id_produit=<?php echo $data->id_produit; ?>"><i class="fa-solid fa-file-pen"></i></a></td>
                    <td class="delete"><a href="delete_product.php?id_produit=<?php echo $data->id_produit; ?>"><i class="fa-solid fa-trash-can supp"></i></a></td>
                </tr>
            <?php endwhile; ?>   
            </tbody>
        </table>
    </div>

    <!-- Boîte de confirmation de suppression -->
    <div id="confirmation">
        <p><i class="fa-solid fa-triangle-exclamation"></i></p>
        <p>Voulez-vous supprimer cette information ?</p>
        <div>
            <button class="oui" value="oui">Oui</button>
            <button class="non" value="non">Non</button>
        </div>
    </div>

    <script>
        const confirmation = document.querySelector('#confirmation');
        const supps = document.querySelectorAll('i.supp');

        supps.forEach(supp => {
            supp.addEventListener('click', (e) => {
                e.preventDefault();
                confirmation.style.display = 'block';

                const oui = document.querySelector('.oui');
                const non = document.querySelector('.non');

                oui.addEventListener('click', () => {
                    const id_produit = supp.closest('a').getAttribute('href').split('=')[1];
                    document.location.href = `delete_product.php?id_produit=${id_produit}`;
                    confirmation.style.display = 'none';
                });

                non.addEventListener('click', () => {
                    document.location.href = 'select_product.php';
                    confirmation.style.display = 'none';
                });
            });
        });
    </script>

</body>
</html>