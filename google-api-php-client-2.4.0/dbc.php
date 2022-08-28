<?php

require_once 'config.php';

class Dbc extends Database{

    public function saveUserFromGoogleInDb($google_id, $name, $email, $profile_image){
        $sql = "INSERT INTO users (google_id, name, email, profile_image ) VALUES (:google_id, :name, :email, profile_image)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
         'google_id'=>$google_id,
         'name'=>$name,
         'email'=>$email,
         'profile_image'=>$profile_image
        ]);
        return true;
     }

     public function fetchUser($google_id){
       $sql = "SELECT google_id FROM users WHERE google_id=:google_id";
       $stmt = $this->conn->prepare($sql);
       $stmt->execute([
        'google_id'=>$google_id
       ]);
       $result = $stmt->fetch(PDO::FETCH_ASSOC);
       return $result;
     }
}