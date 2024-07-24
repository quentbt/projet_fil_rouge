<div class="menu-mobile">
    <span class="material-icons" onclick="toggler()" id="toggler">
        menu
    </span>
</div>
<div class="menu">
    <div class="menu-container">
        <!-- Vérifié si utilisateur connecter -->
        <?php if (1 == 1) { ?>
            <!-- Si connecté -->

            <ul class="menu-listing">
                <li><a href="">Mes paramètres</a></li>
                <li><a href="">Mes commandes</a></li>
                <li><a href="">CGU</a></li>
                <li><a href="">Mentions Légales</a></li>
                <li><a href="">Contact</a></li>
                <li><a href="">A propos d'ÀIRNEIS</a></li>
                <li><a href="">Se déconnecter</a></li>
            </ul>
        <?php } else { ?>
            <!-- Si pas connecté -->

            <ul class="menu-listing">
                <li><a href="">Se connecter</a></li>
                <li><a href="">S'inscrire</a></li>
                <li><a href="">CGU</a></li>
                <li><a href="">Mentions Légales</a></li>
                <li><a href="">Contact</a></li>
                <li><a href="">A propos d'ÀIRNEIS</a></li>
            </ul>
        <?php } ?>
    </div>
</div>

<script src="js_files/navbar.js"></script>