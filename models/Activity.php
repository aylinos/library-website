<?php
include_once "config/config.php";
class Activity extends Connection
{


public function addActivity($activityData)
{
  $sql = "INSERT INTO activities_website (name, description, place, date, email) VALUES (:bName, :bDescr, :bPlace, :bDate, :bEmail)";
  if($stmt = $this->connect()->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":bName", $activityData['aName'], PDO::PARAM_STR);
    $stmt->bindParam(":bDescr", $activityData['aDescr'], PDO::PARAM_STR);
    $stmt->bindParam(":bPlace", $activityData['aPlace'], PDO::PARAM_STR);
    $stmt->bindParam(":bDate", $activityData['aDate'], PDO::PARAM_STR);
    $stmt->bindParam(":bEmail", $activityData['aEmail'], PDO::PARAM_STR);

    $stmt->execute();
    $stmt = null;
  }
}

public function getUpcommingActivities()
{
  $date = date("Y-m-d");
  $sql = "SELECT * FROM activities_website WHERE date > :date;";
  if($stmt = $this->connect()->prepare($sql))
  {
    $stmt->bindParam(":date", $date, PDO::PARAM_STR);
    if($stmt->execute())
    {
    $activities = $stmt->fetchAll(PDO::FETCH_OBJ);
    }
  }
  $stmt = null;
  return $activities;
}

}
?>
