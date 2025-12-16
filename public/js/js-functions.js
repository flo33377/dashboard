
/* FONCTION D'AFFICHAGE DYNAMIQUE DE LA CARD AVEC LES INFOS PROJET */

const cardBloc = document.getElementById('card_focus');
const cardImg = document.getElementById('card_img');
const cardTitle = document.getElementById('card_title');
const cardMainColor = document.getElementById('card_maincolor');
const cardLink = document.getElementById('card_link');
const radios = document.querySelectorAll('input[name="radio_choice_logo"]');

function updateCard(projectKey) {
    const project = projects[projectKey];
    if (!project) return;

    // Étape 1 : lance l’animation de fermeture
    cardBloc.classList.add('flipping');

    // Étape 2 : attend la moitié de la transition avant de changer le contenu
    setTimeout(() => {
        cardBloc.style.backgroundColor = project.mainColor;
        cardBloc.style.border = "4px solid " + project.secondaryColor;
        cardImg.src = project.logo;
        cardTitle.textContent = project.name;
        cardLink.href = '/dashboard/?project=' + projectKey; // en local = retirer "/dashboard" 
        cardLink.style.backgroundColor = project.secondaryColor;
    }, 500); // plus de la moitié de la durée de l'anim pour que le changement se fasse quand c'est masqué

    // Étape 3 : réouvre la carte
    setTimeout(() => {
        cardBloc.classList.remove('flipping');
    }, 600);

}

    // ✅ Initialisation au chargement (radio cochée par défaut)
const defaultChecked = document.querySelector('input[name="radio_choice_logo"]:checked');
if (defaultChecked) {
    updateCard(defaultChecked.value);
}

    // ✅ Mise à jour dynamique au clic
radios.forEach(radio => {
    radio.addEventListener('change', () => updateCard(radio.value));
});


/* FONCTIONS DE CALCUL DES DONNEES */

function calculateAndDisplayImpressions(datasRange) {
    // calcule le total des impressions - argument = la plage de données sur laquelle calculer
    let totalImpression = 0;
    for(let index = 0; index < datasRange.length; index++) {
        const impressionsNbr = parseInt(datasRange[index]["impressions"]);
        totalImpression += impressionsNbr;
    }
    
    let impressionsNbrBloc = document.getElementById('impressions_nbr');
    impressionsNbrBloc.innerHTML = totalImpression;
}


function calculateAndDisplayUniqueVisitors(datasRange) {
    // calcule le total des visiteurs unique - argument = la plage de données sur laquelle calculer
    let totalVisitors = 0;
    for(let index = 0; index < datasRange.length; index++) {
        const visitorsNbr = parseInt(datasRange[index]["unique_visitors"]);
        totalVisitors += visitorsNbr;
    }
    
    let userNbrBloc = document.getElementById('visitors_nbr');
    userNbrBloc.innerHTML = totalVisitors;
}


function calculateAndDisplayAverageSessionsPerUser(datasRange) {
    // calcule le nbr moyen de session par user - argument = la plage de données sur laquelle calculer
    let totalImpression = 0;
    for(let index = 0; index < datasRange.length; index++) {
        const impressionsNbr = parseInt(datasRange[index]["impressions"]);
        totalImpression += impressionsNbr;
    }

    let totalVisitors = 0;
    for(let index = 0; index < datasRange.length; index++) {
        const visitorsNbr = parseInt(datasRange[index]["unique_visitors"]);
        totalVisitors += visitorsNbr;
    }

    let averageSessionsPerUser = totalImpression / totalVisitors;
    averageSessionsPerUser = parseFloat(averageSessionsPerUser.toFixed(1)); // toFixed renvoie une string
    
    let averageSessionsPerUserBloc = document.getElementById('average_sessions_nbr');
    averageSessionsPerUserBloc.innerHTML = averageSessionsPerUser;
}


function displayLastVisit(allDatas) {
    // calcule la date de la dernière visite
    if (!allDatas || allDatas.length === 0) return; // sécurité si pas de données

    // Trouve la dernière date en prenant la plus grande clé primaire
    const lastEntry = allDatas.reduce((latest, current) =>
        parseInt(current.date_id) > parseInt(latest.date_id) ? current : latest
    );

    const lastDateStr = lastEntry.date_recorded; // récupère la dernière date depuis la clé primaire
    const lastDate = new Date(lastDateStr);
    
    // Calcul de la différence avec la date d'aujourd'hui
    const today = new Date();
    const diffTime = today.setHours(0,0,0,0) - lastDate.setHours(0,0,0,0);
    const diffDays = diffTime / (1000 * 60 * 60 * 24);

    // Déterminer le texte à afficher
    let text;
    if (diffDays === 0) {
        text = "Aujourd'hui";
    } else if (diffDays === 1) {
        text = "Hier";
    } else if (diffDays === 2) {
        text = "Avant-hier";
    } else {
        // format dd/mm/yyyy
        const day = String(lastDate.getDate()).padStart(2, '0');
        const month = String(lastDate.getMonth() + 1).padStart(2, '0');
        const year = lastDate.getFullYear();
        text = `${day}/${month}/${year}`;
    }

    // Affichage dans le DOM
    const lastVisitBloc = document.getElementById('last_visit');
    if (lastVisitBloc) {
        lastVisitBloc.innerHTML = text;
    }
}


// Appelle les fonctions qui print les données
// (mais vérifie que allDatas existe pour éviter les erreurs console)
if (typeof allDatas !== 'undefined' && Array.isArray(allDatas) && allDatas.length > 0) {
    calculateAndDisplayImpressions(allDatas);
    calculateAndDisplayUniqueVisitors(allDatas);
    calculateAndDisplayAverageSessionsPerUser(allDatas);
    displayLastVisit(allDatas);
}


/* FONCTION D'AFFICHAGE DU GRAPH */

    // CAS 1 : 7 derniers jours

function display7LastDaysChart() {
    // suppr le canvas 6 months
    const sixMonthsCanvas = document.getElementById('last6MonthsChart');
    if (sixMonthsCanvas) sixMonthsCanvas.remove();

    // créé le canvas pour les 7 jours
    const container = document.getElementById('chartContainer');
    const canvas = document.createElement('canvas');
    canvas.id = 'last7DaysChart';
    container.appendChild(canvas);

    function formatYMDLocal(date) {
        // Formate une Date en "YYYY-MM-DD" en heure locale (évite toISOString UTC)
        const y = date.getFullYear();
        const m = String(date.getMonth() + 1).padStart(2, '0');
        const d = String(date.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    }
    
    function parseDateRecordedToISO(s) {
        // Gère "DD/MM/YYYY" ou "YYYY-MM-DD" ou "YYYY-MM-DDTHH:..." et renvoie "YYYY-MM-DD"
        if (!s) return null;
        if (s.includes('/')) { // DD/MM/YYYY
        const [dd, mm, yyyy] = s.split('/');
        return `${yyyy}-${mm.padStart(2,'0')}-${dd.padStart(2,'0')}`;
        }
        // si c'est "YYYY-MM-DD..." on prend les 10 premiers caractères
        return s.slice(0, 10);
    }
    
    // ---------- Génération des N derniers jours (local) ----------
    function getLastNDays(n, endDate = new Date()) {
        const days = [];
        // base = minuit local du endDate (évite off-by-one lié à heure)
        const base = new Date(endDate.getFullYear(), endDate.getMonth(), endDate.getDate());
        for (let i = n - 1; i >= 0; i--) {
        const d = new Date(base);
        d.setDate(base.getDate() - i);
        days.push(formatYMDLocal(d));
        }
        return days;
    }
    
    // ---------- Construire la map à partir de allDatas (somme si doublons) ----------
    function buildDataMapFromAllDatas(allDatas) {
        const map = Object.create(null); // "objet propre" sans prototype
        allDatas.forEach(item => {
        const iso = parseDateRecordedToISO(item.date_recorded); // UTILISER date_recorded
        if (!iso) return;
        if (!map[iso]) map[iso] = { date: iso, impressions: 0, unique_visitors: 0 };
        map[iso].impressions += Number(item.impressions) || 0;
        map[iso].unique_visitors += Number(item.unique_visitors) || 0;
        });
        return map;
    }
    
    // ---------- Construire le tableau complet des N derniers jours ----------
    function buildCompleteLastNDays(allDatas, n = 7, endDate = new Date()) {
        const lastDays = getLastNDays(n, endDate);
        const dataMap = buildDataMapFromAllDatas(allDatas);
        return lastDays.map(date => dataMap[date] || { date, impressions: 0, unique_visitors: 0 });
    }

    let currentDate = new Date;
    let last7DaysDatas = buildCompleteLastNDays(allDatas, 7, currentDate);


    // récup les données et les mappe
    const dates = last7DaysDatas.map(item => item["date"]);
    const impressions = last7DaysDatas.map(item => parseInt(item["impressions"]));
    const visitors = last7DaysDatas.map(item => parseInt(item["unique_visitors"]));

    // calcule le max global
    const maxValue = Math.max(...impressions, ...visitors);

    // détermine dynamiquement le step
    let stepSize = 1;
    if (maxValue > 100) stepSize = 20;
    else if (maxValue > 50) stepSize = 10;
    else if (maxValue > 10) stepSize = 5;

    // get le canvas HTML à afficher
    const ctx = canvas.getContext('2d');

    // créé l'objet graphique
    new Chart(ctx, {
        type: 'line', // line ou bar
        data: {
            labels: dates,
            datasets: [{
                label: 'Impressions par jour',
                data: impressions,
                backgroundColor: '#D198EF',
                borderColor: '#D198EF',
                borderWidth: 2,
                tension: 0.4, // courbes plus lissées
                pointRadius: 0, // taille des points
                pointHoverRadius: 5, // taille au survol
                yAxisID: 'y'
            },
            {
                label: 'Visiteurs uniques par jour',
                data: visitors,
                backgroundColor: '#FD97EF',
                borderColor: '#FD97EF',
                borderWidth: 2,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 5,
                yAxisID: 'y'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // permet de contrôler la hauteur via CSS
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                x: {
                    ticks: {
                        color: 'black'
                    },
                    grid: {
                        color: ''
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: stepSize,
                        color: 'black'
                    },
                    grid: {
                        color: ''
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'black'
                    }
                }
            }
        }
    });
}


    // CAS 2 : 6 derniers mois

function buildLast6MonthsData(allDatas, currentDate = new Date()) {
    // 1. Générer la liste des 6 derniers mois (format YYYY-MM)
    const months = [];
    for (let i = 5; i >= 0; i--) {
        const d = new Date(currentDate.getFullYear(), currentDate.getMonth() - i, 1); // récup le mois
        const key = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}`;
        months.push(key);
    }

    // 2. Regrouper les données existantes par mois
    const monthMap = {};
    allDatas.forEach(item => {
        const d = new Date(item.date_recorded);
        const key = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}`;
        if (!monthMap[key]) {
            monthMap[key] = { impressions: 0, unique_visitors: 0 };
        }
        monthMap[key].impressions += item.impressions;
        monthMap[key].unique_visitors += item.unique_visitors;
    });

    // 3. Compléter les mois manquants
    const completeData = months.map(key => {
        if (monthMap[key]) {
            return { month: key, ...monthMap[key] };
        } else {
            return { month: key, impressions: 0, unique_visitors: 0 };
        }
    });

    return completeData;

}

// 4. Fonction pour afficher le graphique Chart.js
function renderLast6MonthsChart(allDatas) {
     // 1. Supprimer le canvas 7 jours s'il existe
     const fifteenDaysCanvas = document.getElementById('last7DaysChart');
     if (fifteenDaysCanvas) fifteenDaysCanvas.remove();
 
     // 2. Créer le canvas pour les 6 mois
     const container = document.getElementById('chartContainer');
     const canvas = document.createElement('canvas');
     canvas.id = 'last6MonthsChart';
     container.appendChild(canvas);

    const completeData = buildLast6MonthsData(allDatas);

    // calcule le max global (pour le stepSize)
    const impressions = completeData.map(d => d.impressions);
    const uniqueVisitors = completeData.map(d => d.unique_visitors);
    const maxValue = Math.max(...impressions, ...uniqueVisitors);

    // détermine dynamiquement le stepSize
    let stepSize = 1;
    if (maxValue > 1000) stepSize = 200;
    else if (maxValue > 500) stepSize = 100;
    else if (maxValue > 100) stepSize = 20;
    else if (maxValue > 50) stepSize = 10;
    else if (maxValue > 10) stepSize = 5;

    // créé le graphique
    const ctx = canvas.getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: completeData.map(d => d.month),
            datasets: [
                {
                    label: 'Impressions sur le mois',
                    data: completeData.map(d => d.impressions),
                    backgroundColor: '#D198EF',
                    borderColor: '#D198EF',
                    borderWidth: 2,
                    tension: 0.4, // courbes plus lissées
                    pointRadius: 0, // taille des points
                    pointHoverRadius: 5, // taille au survol
                    yAxisID: 'y'
                },
                {
                    label: 'Visiteurs uniques sur le mois',
                    data: completeData.map(d => d.unique_visitors),
                    backgroundColor: '#FD97EF',
                    borderColor: '#FD97EF',
                    borderWidth: 2,
                    tension: 0.4, // courbes plus lissées
                    pointRadius: 0, // taille des points
                    pointHoverRadius: 5, // taille au survol
                    yAxisID: 'y'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // permet de contrôler la hauteur via CSS
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                x: {
                    ticks: {
                        color: 'black'
                    },
                    grid: {
                        color: ''
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: stepSize,
                        color: 'black'
                    },
                    grid: {
                        color: ''
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'black'
                    }
                }
            }
        }
    });
}


// Events qui déclenchent les affichages
let chartBlock = document.getElementById('chartContainer');
if(chartBlock) {
    let daysSelector = document.getElementById('days');
    daysSelector.addEventListener('change', () => {
        display7LastDaysChart();
    });

    let monthsSelector = document.getElementById('months');
    monthsSelector.addEventListener('change', () => {
        renderLast6MonthsChart(allDatas);
    });


    display7LastDaysChart(); // initialisation par défaut pour afficher les 7 derniers jours
}

// Graphiques du split device

let deviceSplit = document.getElementById('device_split');

if(deviceSplit) {
    const totalDesktop = allDatas.reduce((sum, day) => sum + (day.desktop || 0), 0);
    const totalTablet  = allDatas.reduce((sum, day) => sum + (day.tablet  || 0), 0);
    const totalMobile  = allDatas.reduce((sum, day) => sum + (day.mobile  || 0), 0);

    const labels = ['🖥️ Desktop', 'Tablette', '📱 Mobile'];
    const dataValues = [totalDesktop, totalTablet, totalMobile];

    const canvas = deviceSplit;
    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'pie', // ou 'doughnut'
        data: {
            labels: labels,
            datasets: [{
                label: 'Répartition des visiteurs',
                data: dataValues,
                backgroundColor: [
                    '#4D98ED',
                    '#A598EE',
                    '#FD97EF'
                ],
                borderColor: [
                    'white',
                    'white',
                    'white'
                ],
                borderWidth: 1,
                offset: 10
            }]
        },
        plugins: [ChartDataLabels],
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { 
                        color: 'black',
                        font: {
                            family: 'Poppins, sans-serif',
                            size: 13
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Répartition des utilisateurs par device',
                    color: 'black',
                    font: {
                        family: 'Poppins, sans-serif',
                        weight: 'bold'
                    }
                },
                datalabels: {
                    formatter: (value, context) => {
                        const dataset = context.chart.data.datasets[0].data;
                        const total = dataset.reduce((sum, val) => sum + val, 0);
                        const percentage = ((value / total) * 100).toFixed(1) + '%';
                        return percentage;
                },
                color: 'black',
                backgroundColor: 'rgba(240, 240, 240, 0.8)',
                borderRadius: 4,
                padding: 4,
                font: {
                    family: 'Poppins, sans-serif',
                    weight: 'bold'
                },
                anchor: 'end', // position de l’étiquette
                align: 'start', // angle relatif à la part
                clamp: true // évite les débordements visuels
            }
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
}

// Graphiques du split browser

let deviceBrowser = document.getElementById('browser_split');

if(deviceBrowser) {
    const totalChrome = allDatas.reduce((sum, day) => sum + (day.chrome || 0), 0);
    const totalFirefox  = allDatas.reduce((sum, day) => sum + (day.firefox  || 0), 0);
    const totalSafari  = allDatas.reduce((sum, day) => sum + (day.safari  || 0), 0);
    const totalEdge  = allDatas.reduce((sum, day) => sum + (day.edge  || 0), 0);
    const totalOther  = allDatas.reduce((sum, day) => sum + (day.other_browser  || 0), 0);

    const labels = ['Chrome', 'Firefox', 'Safari', 'Edge', 'Autre navigateur'];
    const dataValues = [totalChrome, totalFirefox, totalSafari, totalEdge, totalOther];

    const canvas = deviceBrowser;
    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'pie', // ou 'doughnut'
        data: {
            labels: labels,
            datasets: [{
                label: 'Répartition des visiteurs',
                data: dataValues,
                backgroundColor: [
                    'crimson',
                    'orangered',
                    'dodgerblue',
                    'lightskyblue',
                    'greenyellow'
                ],
                borderColor: [
                    'white',
                    'white',
                    'white',
                    'white',
                    'white'
                ],
                borderWidth: 1,
                offset: 10
            }]
        },
        plugins: [ChartDataLabels],
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: 'black',
                        family: 'Poppins, sans-serif',
                        size: 13
                    }
                },
                title: {
                    display: true,
                    text: 'Répartition des utilisateurs par navigateur',
                    color: 'black',
                    font: {
                        family: 'Poppins, sans-serif',
                        weight: 'bold'
                    }
                },
                datalabels: {
                    formatter: (value, context) => {
                        const dataset = context.chart.data.datasets[0].data;
                        const total = dataset.reduce((sum, val) => sum + val, 0);
                        const percentage = ((value / total) * 100).toFixed(1) + '%';
                        return percentage;
                    },
                    color: 'black',
                    backgroundColor: 'rgba(240, 240, 240, 0.8)',
                    borderRadius: 4,
                    padding: 4,
                    font: {
                        family: 'Poppins, sans-serif',
                        weight: 'bold'
                    },
                    anchor: 'end', // position de l’étiquette
                    align: 'start', // angle relatif à la part
                    clamp: true // évite les débordements visuels
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
}



