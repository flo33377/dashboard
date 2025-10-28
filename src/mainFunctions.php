
<?php

    /* CONNEXION DB */
function connect(string $path): PDO { // connexion à la BDD
    $dbpath = $path;
    try {
        $mysqlClient = new PDO("sqlite:{$dbpath}");
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }

    return $mysqlClient;
}

    /* Récupération des datas du projet */
function getAllDatas(string $path, string $dbTableName) : array { // get all analytics datas from DB
    $SQL = "SELECT * FROM " . $dbTableName;
    $statement = connect($path)->prepare($SQL);
    $statement->execute();

    $datas = $statement->fetchAll();
    return $datas;
}


?>
