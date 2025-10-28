
<?php if(isset($errorMessage) && $errorMessage == "unknown_project") : ?>
      <div id="error_message">Ce project est introuvable, merci d'utiliser les liens ci-dessous</div>
  <?php endif ?>

<h1 class="content_title">Quel site vous intéresse ?</h1>

<?php foreach ($projects as $key => $project): ?>
    <div class="project" style="border-left: 6px solid <?= $project['secondaryColor'] ?>; background-color: <?= $project['mainColor'] ?>">
        <img class="project-logo" src="<?= $project['logo'] ?>" alt="<?= $project['name'] ?>">
        <a href="<?= BASE_URL ?>?project=<?= $key ?>">
            <div class="project-name"><?= $project['name'] ?></div>
            <p>Accéder au dashboard →</p>
        </a>
    </div>
<?php endforeach; ?>
