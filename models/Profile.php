<?php

 include "../config/config.php";
class Profile extends Connection
{
  public function updateprofile($data)
  {
    $sql = "UPDATE users_website SET first_name = :fname, last_name = :lname, email = :bEmail, age= :bAge, address= :bAddress, phone= :bPhone WHERE id = :bId;";
    if($stmt = $this->connect()->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":bId", $data->id, PDO::PARAM_STR);
    $stmt->bindParam(":fname", $data->first_name, PDO::PARAM_STR);
    $stmt->bindParam(":lname", $data->last_name, PDO::PARAM_STR);
    $stmt->bindParam(":bEmail", $data->email, PDO::PARAM_STR);
    $stmt->bindParam(":bAge", $data->age, PDO::PARAM_STR);
    $stmt->bindParam(":bAddress", $data->address, PDO::PARAM_STR);
    $stmt->bindParam(":bPhone", $data->phone, PDO::PARAM_STR);
    // execute query
    $stmt->execute();
    }
  }
}

 ?>
