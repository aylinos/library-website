<?php
// require "models/Book.php";
require_once(realpath(dirname(__FILE__) . '/..') . '/models/Book.php');

if (isset($_POST['btnAddBook'])) {
  addBook();
}

function getBook($bookID)
{
  $book = new Book();
  return $book->getBook($bookID);
}

function getBooks()
{
  $book = new Book();
  $books = $book->getAllBooks();
  return $books;
}

function addBook()
{
  $book = new Book();
  // Get image name
  $bookData['image'] = $_FILES['image']['name'];
  $bookData['bResume'] = trim($_POST['bookResume']);
  $bookData['bName'] = trim($_POST['bookName']);
  $bookData['bAuthor'] = trim($_POST['bookAuthor']);
  $bookData['bPublishDate'] = trim($_POST['bookPublishDate']);
  $bookData['bGenre'] = trim($_POST['genresInput']);
  $bookData['bPages'] = trim($_POST['bookNumberOfPages']);

  // image file directory
  $target = "images/".basename($bookData['image']);

  // execute query
  if($book->addNewBook($bookData))
  {
   move_uploaded_file($_FILES['image']['tmp_name'], $target);
  }
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
  if(isset($_POST['pd']))
  {
    ReserveBook();
  }
  else if(isset($_POST['btnReserve']))
  {
    ChangeAvailabilityImage();
  }
  else if(isset($_POST['availabilityText']))
  {
    ChangeAvailabilityText();
  }else if (isset($_POST['bookName']) && $_POST['bookName'] != "")
  {
    FindBook($_POST['bookName']);
  } else if (isset($_POST['bookNameSearch']) && $_POST['bookNameSearch'] != "")
  {
    FindBook($_POST['bookNameSearch']);
  }else if (isset($_POST['deleteId']))
  {
    $id = $_POST['deleteId'];
    DeleteBook($id);
  }else if (isset($_POST['editedBook']))
  {
    header('Content-Type: text/plain');
    $editedBook = utf8_encode($_POST['editedBook']); // encoding
    $data = json_decode($editedBook);
    EditBook($data);
  }
}
if($_SERVER["REQUEST_METHOD"] == "GET")
{
  if(isset($_GET['q']))
  {
    GetBooksByCategory();
  }
}

function ReserveBook()
{
    $book = new Book();
    return $book->ReserveBook();
}

function ChangeAvailabilityImage()
{
  $book = new Book();
  return $book->ChangeAvailabilityImage();
}

function ChangeAvailabilityText()
{
  $book = new Book();
  return $book->ChangeAvailabilityText();
}

function GetBooksByCategory()
{
  $book = new Book();
  if($_GET['q'] === ""){
    $q = 'allBooks';
  }else{
  $q = $_GET['q'];
  }

  if($q === 'allBooks'){
    // $sql="SELECT * FROM books";
    $selected_books = $book->getAllBooks();
  }else{
    $selected_books = $book->getBooksByCategory($q);
  }
  $num_selected_books = count($selected_books);
  if($num_selected_books > 0)
  { foreach ($selected_books as $book) {$_SESSION['bid'] = $book->id;?>

  <div class = "book-card">
  <a href="BookPage.php?id=<?php echo $book->id; ?>"><?php echo "<img class='bookcoverimg' src='images/".$book->cover_image."' alt='bookDetails'>";?> </a>
  <!-- <?php //require "../includes/ChangeAvailabilityImage.php"; ?> -->
  <span class="bookdescription">
  <h4 class="allbooks"><b><?php echo $book->name; ?></b></h4>
  <h4 class="allbooks"><?php echo $book->author; ?></h4>
  </span>
  </div>
  <?php }}
}

//New functions
function FindBook($bookName)
  {
      $book = new Book;
      $return_arr = $book->findBook($bookName);
      if($return_arr != null)
      {
        $bookJSON = json_encode($return_arr);
        echo $bookJSON;
      } else
      {
        echo "This book was not found.";
      }
  }

function DeleteBook($id) {
  $book = new Book;
  if($book->deleteBook($id)){
  echo "Sucess";
  }
}

function EditBook ($data)
{
    $book = new Book;
    if($book->editBook($data))
    {
      echo "Book updated successfully";
    }

}


?>
