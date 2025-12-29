
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

  <link rel="apple-touch-icon" sizes="180x180" href="https://fneto-prod.fr/dashboard/public/img/logo-dashboard.png">
  <link rel="icon" type="image/png" sizes="32x32" href="https://fneto-prod.fr/dashboard/public/img/logo-dashboard.png">
  <link rel="icon" type="image/png" sizes="16x16" href="https://fneto-prod.fr/dashboard/public/img/logo-dashboard.png">

  <title>Fneto-prod Dashboard</title>
</head>


<body>

  <header>

    <div>
      <a href='<?= BASE_URL ?>'>
        <img src="https://fneto-prod.fr/dashboard/public/img/logo-dashboard.png" alt="logo dashboard">
        <p class="bold">Analytics</p>
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