<?php
include "../config.php";
$id = $_SESSION['bid'];

$bookIsReserved = false;

$sql = "SELECT * FROM reservations WHERE book_id = $id";
if($stmt = $conn->prepare($sql))
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
                if($reservation->take_date <= date("Y-m-d") && $reservation->return_date >= date("Y-m-d"))
                {
                    $bookIsReserved = true;
                    break;
                }
            }
        }
        if($bookIsReserved)
        {
            echo "<img src = '../images/crossmark.png' alt = 'availability' id = 'availabilityimg'>";
        }
        else
        {
            echo"<img src = '../images/checkmark.png' alt = 'availability' id = 'availabilityimg'>";
        }
    }
}

?>
