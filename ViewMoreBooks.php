<?php
require "config/session_init.php";
require "Controllers/BookController.php";
$books = getBooks();
$num_books = count($books);
?>

  <?php
  $pageName = "View all books";
  require "includes/head.php";
  ?>
  <body>
    <div class = "grid-container-viewbooks">

      <div class = "navBar-bookpage">
      <?php require "includes/Navigation.php"; ?>
      </div>

      <div class = "gridSectionSearchBar">

        <div class = "searchBar">
          <input type="text" id="searchbook" name="searchbook" placeholder="Search...">
          <button class="searchButton" id="searchbookbtn" ><span class="magnifying-glass">&#128269;</span><i class="fa fa-search"></i></button>
        </div>

        <div class = "sortBar">
          <form>
<select name="categories-allbooks" class="selectbook" onchange="loadBooks(this.value)">
  <option value="allBooks">All</option>
  <option value="kids">Kids</option>
  <option value="fantasy">Fantasy</option>
  <option value="drama">Drama</option>
  <option value="psychological">Psychological</option>
  </select>
</form>
        </div>
      </div>
      <div class = "gridSectionleftNavBarBooks">
        <div class = "leftNavBarBooks">
          <p>GENRES</p>
         <table>
           <tr><td> <button type="button" name="genre" onclick='loadBooks("allBooks")'>ALL BOOKS</button></td></tr>
           <tr><td> <button type="button" name="genre" onclick="loadBooks('drama')">DRAMA</button></td></tr>
           <tr><td> <button type="button" name="genre" onclick="loadBooks('fantasy')">FANTASY</button></td></tr>
           <tr><td><button type="button" name="genre" onclick="loadBooks('kids')">KIDS</button></td></tr>
           <tr><td><button type="button" name="genre" onclick="loadBooks('psychological')">PSYCHOLOGICAL</button></td></tr>
         </table>
        </div>
      </div>

      <div class = "gridSectionBooksList">
        <div id="searchedBook">
          <h1 class="activity">Found Books:</h1>
          <div class="card1" id="searchBookId">
            <a id="booklink" href="#"><img class='boardCardImg' id="searchBookImg" alt='bookDetails'></a>
              <div class="cardInfo">
                <span class "textCard">
                  <h3 id="h3Card"></h3>
                  <p id="searchBookCaption"></p>
                </span>
              </div>

          </div>
          </div>
        <div class = "booksList" id="bookList">
          <script>
            loadBooks('allBooks');
          </script>
      </div>
    </div>

    </div>
  </body>
</html>
