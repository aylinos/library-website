<?php
require_once(realpath(dirname(__FILE__) . '/..') . '/models/Book.php');
require_once(realpath(dirname(__FILE__) . '/..') . '/models/User.php');

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST['compareRole']))
    {
        compareRole();
    }
    else if(isset($_POST['mostReserved']))
    {
        getTop5ReservedBooks();
    }
    else if(isset($_POST['usersAge']))
    {
        getUsersAge();
    }
}

function compareRole()
{
  $user = new User();
  $adminsReaders = [];
  $adminsReaders[] = $user -> getAdmins();
  $adminsReaders[] = $user -> getReaders();
  
  echo json_encode($adminsReaders);
}

function getTop5ReservedBooks()
{
    $book = new Book();
    $result = $book -> GetTop5ReservedBooks();

    echo json_encode($result);
}

function getUsersAge()
{
    $user = new User();
    $usersAges = array();
    $result = $user -> getUsersAges();

    foreach($result as $age)
    {
        $usersAges[] = $age;
    }
    echo json_encode($usersAges);
}
?>