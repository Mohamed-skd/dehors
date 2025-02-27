<?php
require_once $_SERVER["DOCUMENT_ROOT"] .  "/config.php";

$products = $prodCtrl->list;
$cats = array_keys($prodCtrl->cats);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <?php require_once CMPS . "head.php" ?>
  <style>
  .grid {
    @media (width>40rem) {
      grid-template-columns: repeat(2, 1fr);
    }

    @media (width>60rem) {
      grid-template-columns: repeat(3, 1fr);
    }
  }
  </style>
</head>

<body>
  <?php require_once CMPS . "header.php" ?>

  <main>
    <section>
      <nav>
        <input type="search" name="search" placeholder="🔍">

        <div class="flex">
          <?php foreach ($cats as &$cat): ?>
          <button class="bt"><?= ucfirst($cat) ?></button>
          <?php endforeach ?>
        </div>
      </nav>

      <div class="grid">
        <?php foreach ($products as &$prod): ?>
        <article data-id="<?= $prod["id"] ?>">
          <h3><?= $prod["name"] ?></h3>

          <a href="<?= $prod["link"] ?>">
            <img src="<?= IMGS . $prod["img"] ?>" alt="<?= $prod["name"] ?>">
          </a>

          <p><?= $prod["desc"] ?></p>
        </article>
        <?php endforeach ?>
      </div>
    </section>
  </main>

  <?php require_once CMPS . "footer.php" ?>
</body>

</html>