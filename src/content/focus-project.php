
<!-- librairy chart.js pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

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
                <div id="project_maincolor" class="project_color" style="background-color: <?= $focusedProject['mainColor'] ?>">
                    <p><?= $focusedProject['mainColor'] ?></p>
                </div>
                <div id="project_secondcolor" class="project_color" style="background-color: <?= $focusedProject['secondaryColor'] ?>">
                <p><?= $focusedProject['secondaryColor'] ?></p>
                </div>
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
        <div>
            <div class="data_icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21.92,11.6C19.9,6.91,16.1,4,12,4S4.1,6.91,2.08,11.6a1,1,0,0,0,0,.8C4.1,17.09,7.9,20,12,20s7.9-2.91,9.92-7.6A1,1,0,0,0,21.92,11.6ZM12,18c-3.17,0-6.17-2.29-7.9-6C5.83,8.29,8.83,6,12,6s6.17,2.29,7.9,6C18.17,15.71,15.17,18,12,18ZM12,8a4,4,0,1,0,4,4A4,4,0,0,0,12,8Zm0,6a2,2,0,1,1,2-2A2,2,0,0,1,12,14Z"/></svg>
            </div>
            <div class='imported_data' id="impressions_nbr"></div>Visite(s)
        </div>

        <div>
            <div class="data_icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M10 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM4 8a6 6 0 1 1 12 0A6 6 0 0 1 4 8zm12.828-4.243a1 1 0 0 1 1.415 0 6 6 0 0 1 0 8.486 1 1 0 1 1-1.415-1.415 4 4 0 0 0 0-5.656 1 1 0 0 1 0-1.415zm.702 13a1 1 0 0 1 1.212-.727c1.328.332 2.169 1.18 2.652 2.148.468.935.606 1.98.606 2.822a1 1 0 1 1-2 0c0-.657-.112-1.363-.394-1.928-.267-.533-.677-.934-1.349-1.102a1 1 0 0 1-.727-1.212zM6.5 18C5.24 18 4 19.213 4 21a1 1 0 1 1-2 0c0-2.632 1.893-5 4.5-5h7c2.607 0 4.5 2.368 4.5 5a1 1 0 1 1-2 0c0-1.787-1.24-3-2.5-3h-7z"/></svg>
            </div>
            <div class='imported_data' id="visitors_nbr"></div>Utilisateur(s) unique(s)
        </div>

        <div>
            <div class="data_icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M23,11a1,1,0,0,1-1,1H19.659l-2.74,6.394a1.015,1.015,0,0,1-.982.6,1,1,0,0,1-.9-.724L12.064,7.865,8.97,20.242A1,1,0,0,1,8.057,21L8,21a1,1,0,0,1-.937-.648L4.307,13H2a1,1,0,0,1,0-2H5a1,1,0,0,1,.937.648l1.872,4.994L11.03,3.758a1,1,0,0,1,1.931-.032l3.228,11.3,1.892-4.415A1,1,0,0,1,19,10h3A1,1,0,0,1,23,11Z"/></svg>
            </div>
            <div class='imported_data' id="average_sessions_nbr"></div> visite(s) en moyenne par utilisateur
        </div>

        <div>
            <div class="data_icon">
                <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.8915 7.43518L20.4414 17.3574C20.0843 19.7973 17.0969 20.7868 15.3509 19.0437L11.8104 15.5032C11.6003 15.7403 11.4156 15.9542 11.2943 16.0967C6.3969 22.4235 6.93893 31.4757 12.6488 37.1856C18.8962 43.4349 29.0289 43.4349 35.2765 37.1855C41.5239 30.938 41.5239 20.8071 35.2764 14.5576C34.8859 14.167 34.886 13.5338 35.2766 13.1434C35.6671 12.7529 36.3003 12.753 36.6908 13.1436C43.7192 20.1741 43.7192 31.5712 36.6908 38.5996C29.6622 45.6302 18.2629 45.6302 11.2345 38.5997C4.81059 32.1758 4.20088 21.9931 9.73995 14.8389C9.90671 14.6417 10.138 14.3737 10.3937 14.0865L6.88025 10.5731C5.13778 8.82761 6.12729 5.84024 8.56736 5.48309L18.4885 4.03321C20.4751 3.73979 22.1825 5.44862 21.8915 7.43518ZM11.7911 12.6555L8.29507 9.15947C7.71429 8.57768 8.04444 7.58094 8.85679 7.46203L18.7804 6.01179C19.4403 5.91411 20.0095 6.4837 19.9125 7.1456L18.4625 17.068C18.3436 17.8801 17.3469 18.2103 16.7645 17.6289L13.2057 14.0701L14.8023 12.5667C15.2044 12.188 15.2233 11.5551 14.8446 11.1531C14.466 10.7511 13.8331 10.7321 13.431 11.1108L11.7911 12.6555Z"/>
                </svg>
            </div>
            Dernière visite<div class='imported_data' id="last_visit"></div>
        </div>
    </div>
</div>

<div class="chart">
    <p>Répartition des visites dans le temps</p>
<div id='periodSelection'>
        <input type='radio' id='days' name='periodRadio' value='days' checked>
        <label for='days'>7 derniers<br>jours</label>
        <input type='radio' id='months' name='periodRadio' value='months'>
        <label for='months'>6 derniers mois</label>
        <div class="slider"></div>
    </div>

    <div id='chartContainer'></div>
</div>


<div id="split_line">
    <div id="device_bloc" class="split_charts">
        <canvas id="device_split"></canvas>
    </div>

    <div id="browser_bloc" class="split_charts">
        <canvas id="browser_split"></canvas>
    </div>
</div>


<?= $focusedProject['dbUrl'] ?>

<?php
echo '<pre>';
print_r($datas);
echo '<pre>';
?>



