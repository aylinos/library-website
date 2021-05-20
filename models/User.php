<?php
require_once(realpath(dirname(__FILE__) . '/..') . '/config/config.php');
// include "config/config.php";
class User extends Connection
{

  public function login($data)
  {
    $sql = "SELECT id, email, password from users_website WHERE email = :email;";

    if($stmt = $this->connect()->prepare($sql)){
        $stmt->bindParam(":email", $data['user_email'], PDO::PARAM_STR);
        if($stmt->execute()){
            // Check if username exists, if yes then verify password
            if($stmt->rowCount() == 1){
                if($row = $stmt->fetch()){
                    $id = $row["id"];
                    // $user_email = $row["email"];
                    $hashed_password = $row["password"];
                    if (password_verify($data['password'], $hashed_password)){

                        // Store data in session variables
                        session_start();
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["email"] = $data['user_email'];

                       $checkRole = $this->connect()->prepare("SELECT role from users_website WHERE email=?");
                       $checkRole->execute([$data['user_email']]);
                       $user_role = $checkRole->fetch();
                       $_SESSION['userrole'] = $user_role[0];

                       //Remember me:
                       if(!empty($_POST["remember"]))
                       {
                         setcookie("rememberme", encryptCookie($id), time() + (30 * 24 * 60 * 60 * 1000)); //30 days
                         setcookie("remember_email", encryptCookie($_POST["email"]), time() + (10*365*24*60*60));
                         setcookie("remember_password", encryptCookie($_POST["password"]), time() + (10*365*24*60*60));
                       }
                       else
                       {
                          if(isset($_COOKIE["remember_email"]))
                          {
                            setcookie("remember_email", "");
                          }
                          if(isset($_COOKIE["remember_password"]))
                          {
                            setcookie("remember_password", "");
                          }
                       }
                        // Redirect user to welcome page
                       header("location: index.php");
                    } else{
                        // Display an error message if password is not valid
                        $data['password_err'] = "The password you entered was not valid.";
                    }
                }
            } else{
                // Display an error message if username doesn't exist
                $data['user_email_err'] = "No account found with that username.";
            }
          } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
      }
            // Close statement
       unset($stmt);
       // Close connection
    unset($conn);
    return $data;
  }

  public function findemail($email)
  {
    $check_email = "SELECT id FROM users_website WHERE email = :email";
    $check_email = $this->connect()->prepare($check_email);
    // Bind variables to the prepared statement as parameters
    $check_email->bindParam(":email", $email, PDO::PARAM_STR);

    $check_email->execute();

    $row = $check_email->rowCount();
    // Close statement
    unset($check_email);
    if($row > 0){
      return true;
    }else
    {return false;}
  }

  public function signup($sign_up_data)
  {
    $sql = "INSERT INTO users_website (first_name, last_name, email, password) VALUES (:fname, :lname, :email, :password)";
    $query = $this->connect()->prepare($sql);
    // Bind variables to the prepared statement as parameters
    $query->bindParam(":fname", $sign_up_data['first_name'], PDO::PARAM_STR);
    $query->bindParam(":lname", $sign_up_data['last_name'], PDO::PARAM_STR);
    $query->bindParam(":email", $sign_up_data['email'], PDO::PARAM_STR);
    $query->bindParam(":password", $param_password, PDO::PARAM_STR);
    $param_password = password_hash($sign_up_data['password'], PASSWORD_DEFAULT);
    return $query->execute();
  }



  public function resetpassword($email, $password)
  {
    $newsql = "UPDATE users_website SET password = :password WHERE email = :email";
    if($stmt = $this->connect()->prepare($newsql)){
        $stmt->bindParam(":email", $param_reset_email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $param_reset_password, PDO::PARAM_STR);

        $param_reset_password = password_hash($password, PASSWORD_DEFAULT);
        $param_reset_email = $email;
        $stmt->execute();
      }
  }

  public function getuser()
  {
    $sql = "SELECT * FROM users_website where id = :id";
    if($stmt = $this->connect()->prepare($sql))
    {
        $stmt->bindParam(":id", $_SESSION["id"], PDO::PARAM_INT);
        if($stmt->execute())
        {
            $user = $stmt->fetch(PDO::FETCH_OBJ);
        }
    }
    if($user->role === '2')
    {
        $user->role = "READER";
    }
    else {$user->role = "ADMINISTRATOR";}
    return $user;
  }

  public function updateprofilepict($picture)
  {
    $sql = "UPDATE users_website SET picture = :bPicture WHERE id = :bId;";
    if($stmt = $this->connect()->prepare($sql)){
      // Bind variables to the prepared statement as parameters
      $stmt->bindParam(":bId", $picture['userId'], PDO::PARAM_STR);
      $stmt->bindParam(":bPicture", $picture['profileimage'], PDO::PARAM_STR);
      $bool = $stmt->execute();
      $stmt = null;
      return $bool;
    }
  }

  public function getUserBookHistory($readBooks)
  {
    // $readBooks = [];
    $booksNames = array();
    $booksAuthors = array();
    $userReservations;
    $count;
    $sql = "SELECT * FROM reservations where user_id = :id";
    if($stmt = $this->connect()->prepare($sql))
    {
        $stmt->bindParam(":id", $_SESSION['id'], PDO::PARAM_INT);
        if($stmt->execute())
        {
            $userReservations = $stmt->fetchAll(PDO::FETCH_OBJ);
            $count = count($userReservations);
            if($count > 0)
            {
              $i = 0;
                foreach($userReservations as $reservation)
                {
                    $sql = "SELECT * FROM books where id = :id";
                    if($stmt = $this->connect()->prepare($sql))
                    {
                        $stmt->bindParam(":id", $reservation->book_id, PDO::PARAM_INT);
                        if($stmt->execute())
                        {
                            $book = $stmt->fetch(PDO::FETCH_OBJ);
                            array_push($booksNames, $book->name);
                            array_push($booksAuthors, $book->author);
                        }
                    } 
                    $readBooks[] = (object) ['title' => $book->name, 'author' => $book->author, 'take_date' => $reservation->take_date, 'return_date' => $reservation->return_date];
                    $i++;
                }
            }
        }
    }
    return $readBooks;
  }


  //Statistics:
  public function getAdmins()
  {
    $admins = [];
    $sql = "SELECT count(id) from users_website WHERE role = 1;";
    if($stmt = $this->connect()->prepare($sql))
    {
      if($stmt->execute())
        {
          $admins[] = (int)$stmt->fetchColumn();
        }
    }
    return $admins;
  }

  public function getReaders()
  {
    $readers = [];
    $sql = "SELECT count(id) from users_website WHERE role = 2;";
    if($stmt = $this->connect()->prepare($sql))
    {
      if($stmt->execute())
        {
          $readers[] = (int)$stmt->fetchColumn();
        }
    }
    return $readers;
  }

  public function getUsersAges()
  {
    $ages;
    $sql = "SELECT age as age, COUNT(age) as nrUsers from users_website WHERE age IS NOT NULL GROUP BY age ORDER BY nrUsers desc LIMIT 7;";
    if($stmt = $this->connect()->prepare($sql))
    {
      if($stmt->execute())
        {
          $ages = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
    return $ages;
  }

}

 ?>
