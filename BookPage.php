<?php
require "config.php";
require "Controllers/BookController.php";

$id = $_GET['id'];
$_SESSION['bid'] = $id;

$book = getBook($id);
?>


  <?php
  $pageName = "Book page";
  require "includes/head.php";
  ?>


  <body>

    <div class = grid-container-bookpage>

      <div class = "navBar-bookpage">
      	<?php require "includes/Navigation.php"; ?>
      </div>

      <div class = "BookCoverSection">
        <div class = "image-section">
          <?php if($book) { ?>
          <?php echo "<img src='images/".$book->cover_image."' alt='bookCover' id = 'bookCover'>";?>
        </div>
      </div>

      <div class = "BookInfoSection">
        <div class = "mainInfo-section">

          <table class="bookptable">
            <tr>
              <th id = "category-bookp"> Name </th>
              <th id = "value-bookp"> <?php echo $book->name ?> </th>
            </tr>
            <tr>
              <th id = "category-bookp"> Author </th>
              <th id = "value-bookp"> <?php echo $book->author ?> </th>
            </tr>
            <tr>
              <th id = "category-bookp"> Genre </th>
              <th id = "value-bookp"> <?php echo $book->genre ?> </th>
            </tr>
            <tr>
              <th id = "category-bookp"> Publish date </th>
              <th id = "value-bookp"> <?php echo $book->publish_date ?> </th>
            </tr>
            <tr>
              <th id = "category-bookp"> Pages </th>
              <th id = "value-bookp"> <?php echo $book->pages ?> </th>
            </tr>
            <tr>
              <th id = "category-bookp"> Available </th>
              <th id = "valueAvailable"> <?php ChangeAvailabilityImage(); ?> </th>
            </tr>
            <tr id = "availabilityText">
              <?php ChangeAvailabilityText(); ?> 
            </tr> 
          </table>

        </div>
      </div>

      <div class = "ReserveSection">
        <div class = "inside">
        <div class = "isAvailable-reserve-section">
          <div class="form">
            <form method = "POST" action="" class="form-container" name="reseve" id="reserve-form" >
              <h1 class="bookp">Reserve book</h1>
              <div class = "set-dates">
                <h5 class="bookp">* dd/mm/yy  * dd.mm.yy  * dd-mm-yy</h5>
              <label for="pick-up-date" id = "pick-up-date"><b>Pick-up date</b></label>
                    <!-- <h5 class="bookp">Required format - "Date.Month.Year"</h5> -->
              <input type="text" placeholder="Pick-up date" id = "pd" name="pick-up-date" required>


              <label for="return-date"><b>Return date</b></label>
                <!-- <h5 class="bookp">Required format - "Date.Month.Year"</h5> -->
              <input type="text" placeholder="Return date" id = "rd" name="return-date" required>



              <button type="button" class="btn" id = "btnReserve" onclick = "Reserve(<?php echo $id;?>)" name = "btnReserveBook">Reserve</button>
              <!-- <h5 class="bookp">Required format - "Date.Month.Year"</h5> -->
              </div>
              <!-- <button type="button" class="btn cancel">Refresh</button> -->
            </form>
          </div>
        </div>
        </div>
      </div>

    </div>

    <!-- Description section -->
    <div class = "description-section">
      <h4 class="bookp">DESCRIPTION</h4>
      <p class="bookp"><?php echo $book->resume ?></p>
    </div>
    <?php } ?>


  </body>
</html>
