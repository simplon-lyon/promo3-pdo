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

//var_dump(new SmallDoggo('test', 'test', new DateTime(), false));

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
    //On paramètre PDO afin qu'il nous renvoie les erreurs SQL
    $db->setAttribute(PDO::ATTR_ERRMODE, 
            PDO::ERRMODE_EXCEPTION);
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
        //On fait un new SmallDoggo en lui fournissant comme
        //argument les informations de la ligne actuelle,
        //en oubliant pas de convertir certaines lignes dans
        //le type voulu (le birthdate convertit en DateTime)
        $chien = new SmallDoggo($ligne['name'],
                $ligne['race'], 
                new DateTime($ligne['birthdate']), 
                $ligne['is_good'], 
                $ligne['id']);
        $chiens[] = $chien;
    }
    
    //Refaire la même chose, mais pour récupérer un small_doggo
    //spécifique selon son id, l'id en question étant celui
    //indiqué dans la variable $id ci dessous.
    $id = 1;
    /*
     * Dans le cas de requête avec argument, plutôt que de 
     * concaténer ceux ci dans une query, on préfèrera utiliser
     * la méthode ->prepare, qui, contrairement à ->query, ne
     * va pas exécuter la requête tout de suite, mais la mettre
     * de côté jusqu'à ce qu'on lui demande explicitement de
     * l'exécuter. Dans cette requête, on pourra mettre des 
     * placeholder pour nos paramètre sous la forme :param auquels
     * on pourra assigner des valeurs soit via la méthode
     * bindParam('param', 'valeur') soit directement dans le execute
     * sous forme d'un array associatif ->execute(['param'=>'valeur'])
     */
    $queryId = $db->prepare('SELECT * FROM small_doggo WHERE id=:id');
    //On assigne au paramètre :id la valeur de notre variable $id
    //et on lui indique que ce paramètre doit être de type INT
    $queryId->bindParam('id', $id, PDO::PARAM_INT);
    //On exécute la requête préparée
    $queryId->execute();
    //On vérifie qu'on a bien un seul résultat pour cette requête
    if($queryId->rowCount() == 1) { //optionnel
        //On récupère le résultat en question qu'on place dans
        //$ligneid
        $ligneid = $queryId->fetch();
        //on utilise $ligneid pour créer un SmallDoggo
        $chien = new SmallDoggo($ligneid['name'],
                $ligneid['race'], 
                new DateTime($ligneid['birthdate']), 
                $ligneid['is_good'], 
                $ligneid['id']);
        var_dump($chien);
    }
    
    
    
    
} catch (PDOException $exception) {
    echo $exception->getMessage();
}