<article class="flex product">
  <h3><?= $prod["name"] ?></h3>

  <a href="<?= $prod["link"] ?>">
    <img src="<?= IMGS . $prod["img"] ?>" alt="<?= $prod["name"] ?>">
  </a>

  <p><?= $prod["desc"] ?></p>
</article>