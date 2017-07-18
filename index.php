<?php

/* 
 * On définit une fonction de chargement des 
 * classes qui va prendre le nom de la classe
 * changer les \ en / puis faire un require
 * de ce nom de classe (le nom de classe contient
 * le namespace, donc normalement c'est bon)
 * 
 */
function myLoader($className) {
    $class = str_replace('\\', '/', $className);
    require($class . '.php');
}

//On donne à la fonction d'autochargement notre
//fonction de chargement de classe myLoader.
//Cette fonction se déclenchera dès qu'elle
//rencontrera un use ou une classe pour la require
spl_autoload_register('myLoader');

//Lorsqu'on utilise une classe d'un autre namespace
//il faut indiquer qu'on l'utilise avec le
//mot clef use
use entities\SmallDoggo;

var_dump(new SmallDoggo('test', 'test', new DateTime(), false));

// ça c'est pas important là
// mysql://localhost:3306/first_db

/* Le try-catch permet d'exécuter un bloc de code en surveillant
 * une levée d'erreur spécifique indiquée dans le catch. Si jamais
 * le bloc  try déclenche une erreur du type indiquée, le code
 * ne plantera pas mais l'exécution du bloc try s'arrêtera pour
 * passer à l'intérieur du bloc catch
 * 
 * 
 */
try {
    //On crée une instance de pdo en lui fournissant le domaine où
    //se trouve notre bdd mysql, on lui indique le nom de la 
    //bdd à laquelle on se connecte avec dbname
    //puis on lui donne le username et le password en deuxième et
    //troisième argument
    $db = new PDO('mysql:host=localhost;dbname=first_db', 'admin', 'simplon');
    //On utilise la méthode query de notre db PDO qui 
    //attend en argument une requête SQL classique.
    //Ici, on sélectione tous les small_doggo.
    $query = $db->query('SELECT * FROM small_doggo');

    /*
     * On utilise le fetch() pour positionner le curseur sur
     * la ligne de résultat suivant.
     * On le fait à l'intérieur d'un while afin de récupérer
     * tous les résultats de notre requête.
     */
    /* $query->fetchAll() //renvoie tous les résultats en tableau
     * foreach($query as $value) {} //fonctionne aussi
     */
    $chiens = [];
    while ($ligne = $query->fetch()) {
        //créer des instances de chien à partir des lignes
        echo '<ul>';
        echo '<li>' . $ligne['id'] . '</li>';
        echo '<li>' . $ligne['name'] . '</li>';
        echo '<li>' . $ligne['race'] . '</li>';
        echo '<li>' . $ligne['birthdate'] . '</li>';
        echo '<li>' . $ligne['is_good'] . '</li>';
        echo '</ul>';
    }
    var_dump($chiens);
} catch (PDOException $exception) {
    echo $exception->getMessage();
}