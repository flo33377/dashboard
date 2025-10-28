
<!DOCTYPE html>
<html lang="fr">

<?php // dépendances
include_once(__DIR__ . "/src/main.php");
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="./public/css/design-system.css">

  <meta name="theme-color" content="#0000">

  <script src="./public/js/js-functions.js" defer></script>

  <link rel="apple-touch-icon" sizes="180x180" href="https://fneto-prod.fr/tag-game/public/img/tag-game-favicon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="https://fneto-prod.fr/tag-game/public/img/tag-game-favicon.png">
  <link rel="icon" type="image/png" sizes="16x16" href="https://fneto-prod.fr/tag-game/public/img/tag-game-favicon.png">

  <title>Fneto-prod Dashboard</title>
</head>


<body>

  <header>

    <div>
      <a href='<?= BASE_URL ?>'>
        <svg fill="#000000" viewBox="0 0 36 36" version="1.1"  preserveAspectRatio="xMidYMid meet">
          <path d="M 32 5 L 4 5 C 2.895 5 2 5.895 2 7 L 2 29 C 2 30.105 2.895 31 4 31 L 32 31 C 33.105 31 34 30.105 34 29 L 34 7 C 34 5.895 33.105 5 32 5 Z M 4 29 L 4 7 L 32 7 L 32 29 Z"></path>
          <polygon points="15.62 15.222 9.602 23.968 5.55 20.384 6.61 19.186 9.308 21.572 15.634 12.38 22.384 22.395 29.138 13.47 30.414 14.436 22.308 25.145"></polygon>
          <rect x="0" y="0" fill-opacity="0"/>
        </svg>
        <p>Analytics</p>
      </a>
    </div>

  </header>


  <main id='content'>

    <?php include($content); ?>

  </main>

  <footer>
    <p>© Copyright 2025 - Florian Neto. Tous droits réservés.</p>
  </footer>


</body>

</html>