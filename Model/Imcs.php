<?php

namespace Model;

use PDO;
use PDOException;
use Model\Connection;

class Imcs {
    private $db; 

    public function __construct() {
        $this->db = Connection::getInstance();
    }

    public function createImc($weight, $height, $result) {
        try {
           $sql = "INSERT INTO imcs (weight, height, result, created_at)
           VALUES (:weight, :height, :result, NOW())"; 

           $stmt = $this->db->prepare($sql);

           $stmt->bindParam(":weight", $weight, PDO::PARAM_STR);
           $stmt->bindParam(":height", $height, PDO::PARAM_STR);
           $stmt->bindParam(":result", $result, PDO::PARAM_STR);

           return $stmt->execute();

        }

        catch(PDOException $error) {
            echo "Erro ao criar IMC: " . $error->getMessage();
            return false;
        }
    }
}


?>