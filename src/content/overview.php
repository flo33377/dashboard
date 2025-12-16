
<?php if(isset($errorMessage) && $errorMessage == "unknown_project") : ?>
      <div id="error_message">Ce project est introuvable, merci d'utiliser les liens ci-dessous</div>
  <?php endif ?>

<h1 class="content_title">Quel site vous intéresse ?</h1>

<script>
    const projects = <?= json_encode($projects, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
</script>

<div id="project_selection_area">

    <div id='card_focus'>
        <img src='' id='card_img'>
        <p id="card_title"></p>
        <div id='card_maincolor'></div>
        <a href="" id='card_link'>Voir le dashboard →</a>
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
