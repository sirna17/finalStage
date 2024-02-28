<div id="menu_burger">

</div>
<section>
    <article>
        <div>
            <a href="../formulaire_product.php"><i class="fa-solid fa-file-circle-plus"></i><br> AJOUTER DES PRODUITS</a>
            <a href="select_product.php"><i class="fa-solid fa-eye"></i><br> VOIR LES PRODUITS</a>
            <a href="deconnexion.php"><i class="fa-solid fa-right-from-bracket"></i><br> ME DECONNECTER </a>
        </div>
    </article>
</section>
<script>
    let section = document.querySelector('section');
    let menuBurger = document.querySelector('#menu_burger');

    menuBurger.innerHTML = '<i class="fa-solid fa-xmark"></i>';

    function afficheSection() {
        section.style.display = 'block';
        menuBurger.innerHTML = '<i class="fa-solid fa-xmark"></i>';
    }

    function cacheSection() {
        section.style.display = 'none';
        menuBurger.innerHTML = '<i class="fa-solid fa-bars"></i>';
    }

    function toggleSection() {
        if (section.style.display === 'none') {
            afficheSection();
        } else {
            cacheSection();
        }
    }

    menuBurger.addEventListener('click', toggleSection);
</script>