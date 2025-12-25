
<?php if(isset($errorMessage) && $errorMessage == "unknown_project") : ?>
      <div id="error_message">Ce project est introuvable, merci d'utiliser les liens ci-dessous</div>
  <?php endif ?>

<h1 class="content_title">Quel site vous intéresse ?</h1>

<?php
/* echo '<pre>';
print_r($_SESSION);
echo '<pre>'; */
?>

<script>
    const projects = <?= json_encode($projects, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
</script>

<div id="project_selection_area">

    <div id='card_focus'>
        <img src='' id='card_img'>
        <p id="card_title"></p>
        <div class="card_btn">
            <a href="" id='card_project_url'>Accéder au site</a>

                <?php if($access_granted && $_SESSION['access_granted']) : ?>
                    <a href="" id='card_dashboard_link'>Dashboard →</a>
                <?php else : ?>
                    <button id='card_dashboard_link' data-popup-id="authenticate_content">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24">
                            <path d="M17,9V7c0-2.8-2.2-5-5-5S7,4.2,7,7v2c-1.7,0-3,1.3-3,3v7c0,1.7,1.3,3,3,3h10c1.7,0,3-1.3,3-3v-7C20,10.3,18.7,9,17,9z M9,7c0-1.7,1.3-3,3-3s3,1.3,3,3v2H9V7z"/>
                        </svg>
                </button>
                <?php endif ?>
        </div>
    </div>

    <div id='radio_panel'>
        <?php $first = true; ?>
        <?php foreach ($projects as $key => $project): ?>
            <input type='radio' id='<?= $key ?>' name='radio_choice_logo' value='<?= htmlspecialchars($key) ?>'
            <?php if($first) : ?> checked <?php $first = false; endif ?>>
            <label for='<?= $key ?>' class="radio_choice_logo" style='background-image: url(<?= $project['logo'] ?>)'>
            </label>
        <?php endforeach ?>
    </div>

</div>

<?php if(!$access_granted) : ?>
<dialog id="authenticate_content">
    <button class="close_popup" id="close_popup">X</button>
    <p>Pour accéder aux statistiques de chaque site, vous devez être authentifié.</p>

    <form action="" method="POST" id="authenticate_form">
    <input type='hidden' name="post_authenticate" required>
    <label for="password_proposition">Merci de saisir le mot de passe :</label>
    <input type="password" id="password_proposition" name="password_proposition" placeholder="Mot de passe" required>
    <input type="submit" id="authenticate_button" value="Valider">

    <div id="errorDiv"></div>
    
    </form>


</dialog>
<?php endif ?>

