<?php
require_once(realpath(dirname(__FILE__) . '/..') . '/config/config.php');
class Book extends Connection
{

  public function getBook($bookID)
  {
    $sql = "SELECT * FROM books where id = $bookID";
    if($stmt = $this->connect()->prepare($sql))
    {
      if($stmt->execute())
      {
        $book = $stmt->fetch(PDO::FETCH_OBJ);
      }
    }
    return $book;
  }

  public function getAllBooks()
  {
    $sql = "SELECT * FROM books";
    if($stmt = $this->connect()->prepare($sql))
    {
      if($stmt->execute())
      {
      $books = $stmt->fetchAll(PDO::FETCH_OBJ);
      }
    }
    $stmt = null;
    return $books;
  }

  public function getBooksByCategory($q)
  {
    $sql="SELECT * FROM books WHERE genre LIKE '".$q."'";

    if($stmt = $this->connect()->prepare($sql))
    {
      if($stmt->execute())
      {
      $selected_books = $stmt->fetchAll(PDO::FETCH_OBJ);
      }
    }
    return $selected_books;
  }

  public function addNewBook($bookData)
  {
    $sql = "INSERT INTO books (name, author, publish_date, genre, pages, resume, cover_image) VALUES (:bName, :bAuthor, :bPublishDate, :bGenre, :bPages, :bResume, :bimage)";
    if($stmt = $this->connect()->prepare($sql)){
      // Bind variables to the prepared statement as parameters
      $stmt->bindParam(":bName", $bookData['bName'], PDO::PARAM_STR);
      $stmt->bindParam(":bAuthor", $bookData['bAuthor'], PDO::PARAM_STR);
      $stmt->bindParam(":bPublishDate", $bookData['bPublishDate'], PDO::PARAM_STR);
      $stmt->bindParam(":bGenre", $bookData['bGenre'], PDO::PARAM_STR);
      $stmt->bindParam(":bPages", $bookData['bPages'], PDO::PARAM_INT);
      $stmt->bindParam(":bResume", $bookData['bResume'], PDO::PARAM_STR);
      $stmt->bindParam(":bimage", $bookData['image'], PDO::PARAM_STR);
    }
      return $stmt->execute();
  }

  public function editBook($data)
  {
    $sql = "UPDATE books SET name = :bname, author = :bauthor, pages = :bpages, genre= :bgenre, publish_date= :bdate, resume= :bresume WHERE id = :bId;";
    if($stmt = $this->connect()->prepare($sql)){
      // Bind variables to the prepared statement as parameters
      $stmt->bindParam(":bId", $data->id, PDO::PARAM_INT);
      $stmt->bindParam(":bname", $data->name, PDO::PARAM_STR);
      $stmt->bindParam(":bauthor", $data->author, PDO::PARAM_STR);
      $stmt->bindParam(":bpages", $data->pages, PDO::PARAM_INT);
      $stmt->bindParam(":bgenre", $data->genre, PDO::PARAM_STR);
      $stmt->bindParam(":bdate", $data->date, PDO::PARAM_STR);
      $stmt->bindParam(":bresume", $data->resume, PDO::PARAM_STR);

      // execute query
      if($stmt->execute())
      {
        return true;
      }
    }
  }

  public function deleteBook($id)
  {
    $sql = "DELETE FROM reservations WHERE book_id = :bId; DELETE FROM books WHERE id = :bId";
    if ($stmt = $this->connect() -> prepare($sql)) {
      $stmt -> bindParam(":bId", $bId, PDO::PARAM_INT);
      $bId = trim($id);
      if ($stmt -> execute()) {
        return true;
      }
    }
  }

  public function findBook($bookName)
  {
    $sql = "SELECT * FROM books WHERE name LIKE :bname LIMIT 1;";
    if ($stmt = $this->connect()-> prepare($sql)) {
      $stmt -> bindParam(":bname", $bname, PDO::PARAM_STR);
      $bname = trim($bookName).
      '%';
      if ($stmt -> execute()) {
        $book = $stmt -> fetch(PDO::FETCH_OBJ);
        if ($book != "") {

          $return_arr[] = array("id" => $book -> id,
            "name" => $book -> name,
            "image" => $book -> cover_image,
            "author" => $book -> author,
            "pages" => $book -> pages,
            "genre" => $book -> genre,
            "date" => $book -> publish_date,
            "resume" => $book -> resume);
          }
        }
      }
      return $return_arr;
  }


  public function ReserveBook()
  {
      // require '/includes/CheckLoggedIn.php';
      require_once(realpath(dirname(__FILE__) . '/..') . '/config/session_init.php');
      $userID = 0;
      if(isLoggedIn() === true)
      {
        $userID = $_SESSION["id"];
      }
      $bookID = $_POST['bid'];
      $msg = "";
      $bookIsReserved = false;

      if($userID != 0)
      {
        //TODO: Check if date exists!
        // $pDate = $_POST['pd'];
        // if(checkdate(date("m",strtotime($pDate)), date("d",strtotime($pDate)), date("Y",strtotime($pDate))) === false)
        // {
        //   exit("Your pick-up date does not exist!");
        // }
        // else if(validateDate(strtotime($_POST['rd'])) === false)
        // {
        //   exit("Your return date does not exist!");
        // }
      //code for saving filled info
        $takeDate = date_format(date_create(trim($_POST['pd'])), "Y-m-d");
        $returnDate = date_format(date_create(trim($_POST['rd'])), "Y-m-d");

        if($takeDate < date("Y-m-d") || $returnDate < date("Y-m-d"))
        {
          exit("Cannot reserve for past days!");
        }
        else if($takeDate > date("Y-m-d", strtotime(" +7 months")))
        {
          exit("Cannot reserve for more than seven months ahead!");
        }
        else if($returnDate < $takeDate)
        {
          exit("Return date cannot be before take date!");
        }

      //code for checking whether there are any reservations in the database:
        $sql = "SELECT * FROM reservations WHERE book_id = $bookID";
        if($stmt = $this->connect()->prepare($sql))
        {
          if($stmt->execute())
          {
            $reservations = $stmt->fetchAll(PDO::FETCH_OBJ);
            $count = count($reservations);
            if($count > 0)
            {
              //code for checking whether a book is reserved:
              foreach($reservations as $reservation)
              {
                $bookTakeDate = $reservation->take_date;
                $bookReturnDate = $reservation->return_date;
                if(($takeDate < $bookTakeDate && $returnDate < $bookTakeDate) || ($takeDate > $bookReturnDate))
                {
                  $bookIsReserved = false;
                }
                else
                {
                  $bookIsReserved = true;
                  break;
                }
              }
            }
          }
        }

      $reservationSuccessful = false;

    //code for reserving a book
        if(!$bookIsReserved)
        {
          $sql = "INSERT INTO reservations (user_id, book_id, take_date, return_date) VALUES (:userID, :id, :takeDate, :returnDate)";
          if($stmt = $this->connect()->prepare($sql))
          {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
            $stmt->bindParam(":id", $bookID, PDO::PARAM_INT);
            $stmt->bindParam(":takeDate", $takeDate, PDO::PARAM_STR);
            $stmt->bindParam(":returnDate", $returnDate, PDO::PARAM_STR);

            if($stmt->execute())
            {
              $reservationSuccessful = true;
              $msg = "Successful reservation!";
            }
          }
        }
        else
        {
          $msg = "Book is currently read by someone else!";
        }
      }
      else
      {
        $msg = "Log in or sign up to reserve a book!";
      }
    echo $msg;
  }

  public function ChangeAvailabilityImage()
  {
    if(isset($_POST['btnReserve']))
    {
      $id = $_POST['bid'];
    }
    else { $id = $_SESSION['bid']; }

    $bookIsReserved = false;

    $sql = "SELECT * FROM reservations WHERE book_id = $id";
    if($stmt = $this->connect()->prepare($sql))
    {
      if($stmt->execute())
      {
        $reservations = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = count($reservations);
        if($count > 0)
        {
            foreach($reservations as $reservation)
            {
                if($reservation->take_date <= date("Y-m-d") && $reservation->return_date >= date("Y-m-d"))
                {
                  $bookIsReserved = true;
                  break;
                }
            }
        }
      }
    }
    if($bookIsReserved)
    {
      echo "<img src = '/images/crossmark.png' alt = 'availability' id = 'availabilityimg'>";
    }
    else
    {
      echo "<img src = '/images/checkmark.png' alt = 'availability' id = 'availabilityimg'>";
    }
  }

  public function ChangeAvailabilityText()
  {
    if(isset($_POST['availabilityText']))
    {
      $id = $_POST['bid'];
    }
    else { $id = $_SESSION['bid']; }

    $bookIsReserved = false;

    $reservations;
    $lastReservation;

    $currentDate = date("Y-m-d");
    $sql = "SELECT * FROM reservations WHERE book_id = $id";
    if($stmt = $this->connect()->prepare($sql))
    {
      if($stmt->execute())
      {
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = count($result);
        if($count > 0)
        {
          for($i = 0; $i < $count; $i++)
          {
            if($result[$i]->return_date > date("Y-m-d") || $result[$i]->take_date > date("Y-m-d"))
            {
              $bookIsReserved = true;
              $lastReservation[] = $result[$i];
            }
          }
        }
      }
    }
    if($bookIsReserved)
    {
      $finalOutput = "<th id='category-bookpX'> Reservations </th> <th id='valueTextUnavailable'>";
      foreach($lastReservation as $book)
      {$finalOutput .= "$book->take_date -> $book->return_date <br>";}
      $finalOutput .= "</th>";
      echo $finalOutput;
    }
    else
    {
      $finalOutput = "<th id='category-bookpV'> Reservations </th> <th id='valueTextAvailable'> This book is available at any time! </th>";
      echo $finalOutput;
    }
  }

  public function GetTop5ReservedBooks()
  {
    $top5books;
    $sql = "SELECT COUNT(r.book_id) as timesReserved, b.name as name from reservations r, books b WHERE b.id = r.book_id
            GROUP BY book_id ORDER BY timesReserved DESC LIMIT 5;";
    if($stmt = $this->connect()->prepare($sql))
    {
      if($stmt->execute())
      {
        $top5books = $stmt->fetchAll(PDO::FETCH_OBJ);
      }
    }
    return $top5books;
  }
}
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
?>
