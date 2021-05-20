<?php
  require "config/session_init.php";
  require 'includes/session.php';
  require 'Controllers/ActivityController.php';
  require 'Controllers/BookController.php';

  $pageName = "Administration Page";
  require "includes/head.php";
?>

<body>
  <div class="grid-container-admin">
    <div class="grid-item-picture-admin"></div>
    <div class="grid-item-text-admin">

      <?php require "includes/Navigation.php"; ?>

      <div class="text">
        <!-- Add a new book -->
        <h1 type="button" id="addBook" class="adminH1" onclick="openBookForm()">Add a book</h1>

        <div class="BookForm-popup" id="bookForm">
          <form method="POST" action="AdministrationPage.php" enctype="multipart/form-data" class="bookForm-container" id="bookForm-container">
            <table>
              <tr>

                <td><label for="bookName"><b>Book name</b></label></td>
                <td><input type="text" placeholder="Enter name of the book" name="bookName" required></td>
              </tr>
              <tr>
                <td><label for="bookAuthor"><b>Author</b></label></td>
                <td><input type="text" placeholder="Enter author(s) name(s)" name="bookAuthor" required></td>
              </tr>
              <tr>
                <td> <label for="bookPublishDate"><b>Publish date</b></label></td>
                <td> <input type="date" name="bookPublishDate" required></td>
              </tr>
              <tr>
                <td><label for="bookGenre"><b>Genre</b></label></td>
              </tr>
              <tr>
                <td><select id="genres" name="genres" multiple required size="5">
                    <option value="science">SCIENCE</option>
                    <option value="drama">DRAMA</option>
                    <option value="teen drama">TEEN DRAMA</option>
                    <option value="school">SCHOOL</option>
                    <option value="university">UNIVERSITY</option>
                    <option value="kids">KIDS</option>
                    <option value="fantasy">FANTASY</option>
                    <option value="fashion">FASHION</option>
                    <option value="psychology">PSYCHOLOGY</option>
                    <option value="adventure">ADVENTURE</option>
                    <option value="ethics">ETHICS</option>
                  </select></td>
                <td><input type="text" name="genresInput" required></input></td>
              </tr>
              <tr>
                <td><label for="bookNumberOfPages"><b>Number of pages</b></label></td>
                <td><input type="text" placeholder="Enter number of pages" name="bookNumberOfPages" required></td>
              </tr>
              <tr>
                <!-- add image of book -->
                <td> <input type="hidden" name="size" value="1000000"></td>
                <td> <input type="file" name="image" required></td>
              </tr>

              <tr>
                <td><label for="bookResume"><b>Book resume</b></label></td>
                <td> <textarea id="text" cols="20" rows="10" name="bookResume" placeholder="Write book resume here ..." required></textarea></td>
              </tr>
            </table>

            <!-- integrate buttons -->
            <button type="submit" name="btnAddBook" class="btnAdd">Add new book</button>
            <button type="reset" class="btnReset">Clear all fields</button>
            <button type="button" class="btnCancel" onclick="closeBookForm()">Close</button>
          </form>
        </div>

        <h1 id="editBook" type="button" class="adminH1" onclick="openEditForm()">Edit book</h1>
        <div class="EditBook-popup" id="editBookForm">
          <label for="bookName">Enter a book name</label>
          <input type="text" id="bookName" name="bookName" value="">
          <button type="button" name="btnFindBook" id="btnFindBook" class="editButton">Find Book</button>
          <button type="button" class="editButton" onclick="closeEditForm()">Close</button>
          <div id="resultBook">
            <div class="card1" id="foundBookId">
                <img class='boardCardImg' id="findBookImg" alt='bookDetails'></a>
                <div class="cardInfo">
                  <span class "textCard">
                    <h3 id="h3Cards"></h3>
                    <p id="findBookCaption"></p>
                  </span>
                </div>
              </a>
            </div>
            <br>
            <button type="button" class="editButton" id="editSelectedBook">Edit book</button>
            <button type="button" class="editButton" id="deleteSelectedBook">Delete book</button>
          </div>
          <div class="editBookFrm" id="editBookFrm">
            <table>
              <tr>
                <td>Book name</td>
                <td><input type="text" placeholder="Enter name of the book" id="ebookName" required></td>
              </tr>
              <tr><td>Author</td>
                <td><input type="text" placeholder="Enter author(s) name(s)" id="ebookAuthor" required></td></tr>
              <tr><td> Publish date</td>
                <td> <input type="date" id="ebookPublishDate" required></td></tr>
              <tr><td>Genre</td>
                <td><input type="text" id="egenresInput" required></input></td></tr>
              <tr><td>Number of pages</td>
                <td><input type="text" placeholder="Enter number of pages" id="ebookNumberOfPages" required></td></tr>
              <tr><td>Book resume</b></td>
                <td> <input id="ebookResume" placeholder="Write book resume here ..." required></input></td></tr>
                <tr>
                  <td> </td>
                  <td> <button type="button" name="button" class="editButton" id="confirmBookChanges">Confirm changes</button> </td>
                </tr>
            </table>
          </div>
        </div>

        <h1 id="addAct" type="button" class="adminH1" onclick="openActivityForm()">Add an activity</h1>

        <div class="ActivityForm-popup" id="activityForm">
          <form method="POST" action="AdministrationPage.php" enctype="multipart/form-data" onsubmit="return validateActivityForm()" name="activityForm" class="actForm">

            <table>
              <tr>
                <td> <label for="event-name"><strong>Name of event</strong></label> </td>
                <td><input type="text" id="event-name" placeholder="Enter the name of the activity" name="actName" required> </td>
              </tr>
              <tr>
                <td><label for="event-description"><strong>Event description</strong></label></td>
                <td>
                  <textarea type="description" placeholder="Enter an event description" id="event-description" name="actDescr" cols="20" rows="100" required></textarea></td>
              </tr>
              <tr>
                <td><label for="place"><strong>Place of event</strong></label></td>
                <td><input type="text" id="place" placeholder="Enter the place of the activity" name="actPlace" required></td>
              </tr>
              <tr>
                <td> <label for="date"><strong>Event date</strong></label></td>
                <td> <input type="date" id="date" placeholder="Enter the date of the activity" name="actDate" required>
              </tr>
              <tr>
                <td><label for="email"><strong>Email of organizator</strong></label></td>
                <td><input type="text" id="pr-email" placeholder="Enter a contact email" name="actEmail" required></td>
              </tr>
            </table>

            <br>
            <br>
            <br>
            <button type="submit" name="btnAddActivity" class="btnAdd">Add new activity</button>
            <button type="reset" class="btnReset">Clear all fields</button>
            <button type="button" class="btnCancel" onclick="closeActivityForm()">Close</button>

          </form>
        </div>

        <h1 type="button" id="statistics" class="adminH1" onclick="openStatistics()">Statistics</h1>
        <div class="Statistics-popup" id="stats">

         <button type="button" class="btnCancel" onclick="closeStatistics()">
          <span aria-hidden="true">&times;</span>
         </button>
         <div class="scrollStatistics">


         <br>
         <h2>Administrators vs Readers</h2>
         <canvas id="rolePie"></canvas>
         <br>
         <h2>Top 5 Most Reserved Books</h2>
         <canvas id="mostReservedHorizontalBar"></canvas>
         <br>
         <h2>Users age</h2>
         <canvas id="usersAgePolarArea"></canvas>
        </div>
        </div>

      </div>
    </div>
  </div>
</body>

</html>
