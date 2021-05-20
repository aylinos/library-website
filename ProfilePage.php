<?php
require "config/session_init.php";
require 'includes/session.php';
$pageName = "Profile page";
require "includes/head.php";
require "Controllers/UserController.php";

$useri = getuserinfo();
?>


    <!-- <?php
    // $pageName = "Profile page";
    // require "includes/head.php";
    ?> -->

  <body>
     <?php require "includes/Navigation.php"; ?>

    <div class="grid-profile">
    <div class="infoSection">
      <div class = "card-profile">
        <h1 id = "role"><?php echo $useri->role; ?></h1>
        <div id="userImage">
          <img id="profile_picture" class="img-profile" src = "images/<?php echo $useri->picture; ?>">
        </div>
        <div>  <!-- contentedible = "true" -->
          <h2 id = "userName"><?php echo $useri->first_name; ?> <?php echo $useri->last_name; ?></h2>
        </div>
        <form class="editUserForm" name="editUserForm" action="" method="post">
          <table id="editTable" name=<?php echo $useri->id; ?>>
            <tr>
              <td><label for="">First name:</label></td>
              <td><input type="text" id="pr-first-name" name="editFName" value="<?php echo $useri->first_name; ?>" required></td>

            </tr>
            <tr>
              <td><label for="">Last name:</label></td>
              <td><input type="text" id="pr-last-name" name="editLName" value="<?php echo $useri->last_name; ?>" required></td>
            </tr>
            <tr>
              <td><label for="">Email:</label></td>
              <td><input type="text" id="pr-email" name="editEmail" value="<?php echo $useri->email; ?>" required></td>
            </tr>
            <tr>
              <td><label for="">Age:</label></td>
              <td><input type="text" id="pr-age" name="editAge" value="<?php echo $useri->age; ?>"></td>
            </tr>
            <tr>
              <td><label for="">Phone:</label></td>
              <td><input type="text" id="pr-phone" name="editPhone" value="<?php echo $useri->phone; ?>"></td>
            </tr>
            <tr>
              <td><label for="">Address:</label></td>
              <td><input type="text" id="pr-address" name="editAddress" value="<?php echo $useri->address; ?>"></td>
            </tr>
          </table>
          </form>
          <br>

        <form class="pictureUpload" action="ProfilePage.php" method="POST" enctype="multipart/form-data">
        <button type="button" class="editButton" name="edit" id="edit">Edit profile</button>
        <button type="button" class="editButton" name="uploadPic" id="filebuttonid">Upload a photo</button>
        <button type="submit" class="editButton" name="savePicture" id="savepic">Save</button>
        <input type="file" name="fileid" id="fileid">
        </form>


      </div>
    </div>

    <div class="bookHistorySection">
      <h1 id = "HistoryHead">Book History</h1>
      <?php  $count = count($readBooks); if($count > 0)
    {
      $i = 0;
      //code for checking whether a book is reserved:
      while($i < $count)
      {?>
      <h3 class="takenBooks"> <?php echo $readBooks[$i]->title;?> | <?php echo $readBooks[$i]->author;?> | <?php echo $readBooks[$i]->take_date;?> | <?php echo $readBooks[$i]->return_date;?> </h3>
      <?php $i++;}}
      else echo "No taken books";?>
    </div>
    </div>
  </body>

</html>
