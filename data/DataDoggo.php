<?php

namespace data;

use DateTime;
use entities\SmallDoggo;
use PDO;

/**
 * Une classe faite pour assurer les requête SQL liées au
 * SmallDoggo via PDO
 *
 * @author simplon
 */
class DataDoggo {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=first_db', 'admin', 'simplon');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    /**
     * Méthode qui récupère tous les SmallDoggo en SQL et les
     * renvoie sous forme d'un tableau d'objet chien
     * @return array Une liste de SmallDoggo
     */
    public function getAllDoggo() {
        //On exécute la requête de sélection
        $query = $this->db->query('SELECT * FROM small_doggo');
        //On crée un tableau vide qui accueillera nos chiens
        $chiens = [];
        //On boucle sur les résultats
        while ($ligne = $query->fetch()) {
            //On crée une instance de chien avec les valeurs
            //de chaque ligne de résultats
            $chien = new SmallDoggo($ligne['name'], $ligne['race'], new DateTime($ligne['birthdate']), $ligne['is_good'], $ligne['id']);
            //On ajoute l'instance en question au tableau
            $chiens[] = $chien;
        }
        //On renvoie le tableau
        return $chiens;
    }
    /**
     * Méthode qui récupère un SmallDoggo en SQL via son id
     * @param int $id l'id du chien à récupèrer
     * @return SmallDoggo Le chien correspondant à l'id fourni
     */
    public function getDoggoById(int $id) {
        //On prépare la requête de sélection par id avec un
        //placeholder pour la valeur de l'id
        $queryId = $this->db->prepare('SELECT * FROM small_doggo WHERE id=:id');
        //On assigne la valeur de l'id avec le paramètre
        //attendu par la fonction
        $queryId->bindValue('id', $id, PDO::PARAM_INT);
        //On exécute la requête
        $queryId->execute();
        //Si on a bien récupérée une seule ligne
        if ($queryId->rowCount() == 1) {
            //On fetch la ligne en question
            $ligneid = $queryId->fetch();
            //On crée une instance de chien à partir de cette ligne
            $chien = new SmallDoggo($ligneid['name'], $ligneid['race'], new DateTime($ligneid['birthdate']), $ligneid['is_good'], $ligneid['id']);
            //On retourne l'instance de chien en question
            return $chien;
        }
    }
    /**
     * Méthode qui prend un object SmallDoggo et l'ajoute
     * en base de données
     * @param SmallDoggo $doge le chien à ajouter en base
     * @return bool TRUE si ça a marché FALSE sinon
     */
    public function addDoggo(SmallDoggo $doge): bool {
        //On prépare la requête d'ajout avec des placeholders pour les
        //values
        $queryInsert = $this->db->prepare('INSERT INTO small_doggo '
                . '(name,race,birthdate,is_good) '
                . 'VALUES (:name,:race,:birthdate,:isGood)');
        //On assigne les paramètres en les récupérant depuis l'argument
        //chien
        $queryInsert->bindValue('name', $doge->getName(), PDO::PARAM_STR);
        $queryInsert->bindValue('race', $doge->getRace(), PDO::PARAM_STR);
        $queryInsert->bindValue('birthdate', $doge->getBirthdate()->format('Y-m-d'), PDO::PARAM_STR);
        $queryInsert->bindValue('isGood', $doge->getIsGood(), PDO::PARAM_BOOL);
        //On exécute en vérifiant si l'exécution fonctionne ou non
        if ($queryInsert->execute()) {
            //si oui on récupère l'id de la ligne qui vient d'être ajoutée
            //On le convertit en int et on l'assigne à notre chien
            $doge->setId(intval($this->db->lastInsertId()));
            //On renvoie true pour dire que tout s'est bien passé
            return true;
        }
        //On renvoie false si ya eu un problème quelconque
        return false;
    }
    /**
     * Méthode qui prend un object chien et le modifie en base 
     * de donnée en se basant sur son id
     * @param SmallDoggo $doge le chien à modifier, modification incluses
     * @return bool TRUE si ça a marché sinon FALSE
     */
    public function updateDoggo(SmallDoggo $doge):bool {
        //On prépare la requête d'update avec des placeholders pour les
        //values
        $queryUpdate = $this->db->prepare('UPDATE small_doggo '
                . 'SET name=:name, race=:race, birthdate=:birthdate,'
                . ' is_good=:isGood WHERE id=:id');
        //On assigne les paramètres en les récupérant depuis l'argument
        //chien
        $queryUpdate->bindValue('name', $doge->getName(), PDO::PARAM_STR);
        $queryUpdate->bindValue('race', $doge->getRace(), PDO::PARAM_STR);
        $queryUpdate->bindValue('birthdate', $doge->getBirthdate()->format('Y-m-d'), PDO::PARAM_STR);
        $queryUpdate->bindValue('isGood', $doge->getIsGood(), PDO::PARAM_BOOL);
        $queryUpdate->bindValue('id', $doge->getId(), PDO::PARAM_INT);
        //On exécute en vérifiant si l'exécution fonctionne ou non
        if ($queryUpdate->execute()) {
            return true;
        }
        //On renvoie false si ya eu un problème quelconque
        return false;
    }
    /**
     * Méthode qui prend un objet chien en argument et le
     * supprime en SQL en se basant sur son id
     * @param SmallDoggo $doge le chien à supprimer
     * @return bool TRUE si réussi, sinon FALSE
     */
    public function deleteDoggo(SmallDoggo $doge):bool {
        //On prépare la requête de suppression avec un placeholder
        //pour l'id du chien à supprimer
        $queryDel = $this->db->prepare('DELETE FROM small_doggo '
                . 'WHERE id=:id');
        //On assigne l'id du chien passé en argument comme paramètre
        //de la requête
        $queryDel->bindValue('id', $doge->getId(), PDO::PARAM_INT);
        //On execute la requête et on renvoie directement le booléen
        //du execute qui indique si la requête a marchée ou non.
        return $queryDel->execute();
        
    }

}
