<main class="carousel-container">
    <div class="carousel">
        <?php foreach ($images as $image) { ?>
            <div class="item active">
                <img class="img-carrousel" src="/images/<?= $image["nom"] ?>" alt="" />
            </div>
        <?php } ?>
    </div>
    <button class="btn prev">Prev</button>
    <button class="btn next">Next</button>
    <div class="dots mt-1"></div>
</main>