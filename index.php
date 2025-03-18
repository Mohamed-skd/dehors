<?php
require_once $_SERVER["DOCUMENT_ROOT"] .  "/config.php";

if (isset($_POST["search"])) {
  $search = $strFn->sanitize($_POST["search"]);
  $products = $search ? $prodCtrl->getProduct($search) : $prodCtrl->list;
  if (!$products) {
    echo "<h2>Aucun produit: \"$search\"</h2>";
    exit;
  }

  echo "<h2>" . (isset($search) ? "Recherche: " : "Produits") . "</h2>";
  echo "<div class=\"grid\">";
  foreach ($products as &$prod) {
    require CMPS . "product.php";
  }
  echo "</div>";
  exit;
} elseif (isset($_POST["cat"])) {
  $cat = $strFn->sanitize($_POST["cat"]);
  $products = $cat ? $prodCtrl->getCat($cat) : $prodCtrl->list;
  if (!$products) {
    echo "<h2>Aucun produit pour: \"$cat\"</h2>";
    exit;
  }

  echo "<h2>" . (isset($cat) ? ucfirst($products[0]["cat"]) : "Produits") . "</h2>";
  echo "<div class=\"grid\">";
  foreach ($products as &$prod) {
    require CMPS . "product.php";
  }
  echo "</div>";
  exit;
}

if (isset($_GET["search"])) {
  $search = $strFn->sanitize($_GET["search"]);
  $products = $search ? $prodCtrl->getProduct($search) : $prodCtrl->list;
} elseif (isset($_GET["cat"])) {
  $cat = $strFn->sanitize($_GET["cat"]);
  $products = $cat ? $prodCtrl->getCat($cat) : $prodCtrl->list;
} else {
  $products = $prodCtrl->list;
}

$cats = array_keys($prodCtrl->cats);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <?php require_once CMPS . "head.php" ?>
</head>

<body>
  <?php require_once CMPS . "header.php" ?>

  <main>
    <section>
      <nav>
        <input type="search" name="search" placeholder="🔍" maxlength="100">

        <div class="flex">
          <button class="<?= isset($cat) ? "bt" : "bt selected" ?>">☀️</button>
          <?php foreach ($cats as &$catname): ?>
          <button
            class="<?= strtolower($cat) === strtolower($catname) ? "bt selected" : "bt" ?>"><?= ucfirst($catname) ?></button>
          <?php endforeach ?>
        </div>
      </nav>

      <div id="products">
        <?php if (!$products): ?>
        <h2>Aucun produit <?= isset($search) ? ": $search" : "pour: $cat" ?></h2>
        <?php else: ?>
        <h2><?= isset($cat) ? ucfirst($cat) : (isset($search) ? "Recherche: " : "Produits") ?></h2>
        <div class="grid">
          <?php foreach ($products as &$prod): ?>
          <?php require CMPS . "product.php" ?>
          <?php endforeach ?>
          <?php endif ?>
        </div>
      </div>
    </section>
  </main>

  <?php require_once CMPS . "footer.php" ?>
</body>

</html>