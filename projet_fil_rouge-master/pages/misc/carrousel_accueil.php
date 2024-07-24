<main class="carousel-container">
    <div class="carousel">
        <?php foreach ($images as $image) { ?>
            <div class="item active">
                <a href="/pages/produits.php?id_produit=<?= $image["id_produit"] ?>">
                    <img class="img-carrousel" src="<?= $image["image_produit"] ?>" alt="" />
                </a>
            </div>
        <?php } ?>
    </div>
    <button class="btn prev">Prev</button>
    <button class="btn next">Next</button>
    <div class="dots mt-1"></div>
</main>