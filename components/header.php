<header>
  <aside id="notifications">
    <?php if (isset($_SESSION["notification"])): ?>
    <p class="<?= $_SESSION["notification"]["type"] ?>"><?= $_SESSION["notification"]["content"] ?></p>
    <?php unset($_SESSION["notification"]) ?>
    <?php endif ?>
  </aside>

  <h1><?= $title ?></h1>
</header>