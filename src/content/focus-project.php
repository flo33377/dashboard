
<!-- librairy chart.js pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Analytics datas to get retrieved in JS -->
<?php if($datas) : 
    // case access admin ?>
<script> 
  const allDatas = <?php echo json_encode($datas); ?>; // jeu de datas
</script>

<?php else : 
    // case access unrecognized ?>
    <p class="warning_message">Données introuvables.<br>
    Merci de réessayer plus tard.</p>
<?php endif ?>


<div id="project_topline">

    <div id="project_general">

        <div id="project_da">
            <img src="<?= $focusedProject['logo'] ?>">
            <div id="project_colors">
                <div id="project_maincolor" class="project_color" style="background-color: <?= $focusedProject['mainColor'] ?>"></div>
                <div id="project_secondcolor" class="project_color" style="background-color: <?= $focusedProject['secondaryColor'] ?>"></div>
            </div>
        </div>

        <div>
            <p id="project_name"><?= $focusedProject['name'] ?></p>
            <div id="project_actionsbtn">
                    <a href="<?= $focusedProject['publicUrl'] ?>">Se rendre sur le site →</a>
            </div>
        </div>
    </div>

    <div id="project_topstats">
        <div><div class='imported_data' id="impressions_nbr"></div>Visite(s)</div>
        <div><div class='imported_data' id="visitors_nbr"></div>Utilisateur(s) unique(s)</div>
        <div><div class='imported_data' id="average_sessions_nbr"></div> visite(s) en moyenne par utilisateur</div>
        <div>Dernière visite<div class='imported_data' id="last_visit"></div></div>
    </div>
</div>

<div class="chart">
<div id='periodSelection'>
        <input type='radio' id='days' name='periodRadio' value='days' checked>
        <label for='days'>7 derniers<br>jours</label>
        <input type='radio' id='months' name='periodRadio' value='months'>
        <label for='months'>6 derniers mois</label>
        <div class="slider"></div>
    </div>

    <div id='chartContainer'></div>
</div>


<?= $focusedProject['dbUrl'] ?>

<?php
echo '<pre>';
print_r($datas);
echo '<pre>';
?>



