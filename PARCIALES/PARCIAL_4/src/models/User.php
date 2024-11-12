<?php

use Google\Service\Analytics\Resource\Data;

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/DataBase.php';

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function loginOrCreateUser($userInfo)
    {
        $sql = " INSERT INTO usuarios (email,nombre,google_id) VALUES (:email,:nombre,:google_id) ";
        try {
            // Preparar la consulta con ON DUPLICATE KEY UPDATE
            if ($stm = $this->pdo->prepare($sql)) {
                $stm->bindParam(":email", $userInfo->email);
                $stm->bindParam(":nombre", $userInfo->name);
                $stm->bindParam(":google_id", $userInfo->id);
                $success = $stm->execute();
                if ($success) {
                    echo "Usuario Guaradado";
                } else {
                    echo "Usuario no guardado";
                }
            }
            unset($stm);
            $this->pdo = null;
        } catch (PDOException $e) {
            // Captura y muestra el error de la base de datos
            echo "Error al guardar el usuario: " . $e->getMessage();
            return false;
        }
    }

    public function isLoginUser($userInfo) {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE google_id = :google_id AND email = :email";
        try {
           if($stm = $this->pdo->prepare($sql)){
            $stm->bindParam(':google_id',$userInfo->id);
            $stm->bindParam(':email',$userInfo->email);
            $stm->execute();
            $userExists = $stm->fetchColumn();
            if($userExists > 0){
                return true;
            }else{
                return false;
            }
           } 
        } catch (PDOException $e) {
            echo "Error al verificar usario: " . $e->getMessage();
        }

    }
}
