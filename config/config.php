<?php
class Connection
{
  private $servername = "studmysql01.fhict.local";
  private $username = "dbi427638";
  private $password = "ayaPHPMYADMIN1";

  protected function connect(){
    try {
      $conn = new PDO("mysql:host=$this->servername;dbname=dbi427638", $this->username, $this->password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      catch(PDOException $e)
      {
        echo "<script>alert('Connecion failed')</script>";
      }
      return $conn;
    }
}
?>
