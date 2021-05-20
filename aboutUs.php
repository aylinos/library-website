<?php
  require "config/session_init.php";
  $pageName = "About us";
  require "includes/head.php";
?>

  <body>
  <?php require "includes/Navigation.php"; ?>

  <div class="background-image-aboutus"></div>
  <div class="grid-container-aboutus">
  <div class="grid-item-history">
    <h2 class= "aboutus">Library history</h2>
    <br> <br> <br>
    <p class= "aboutus">This librarry was built in the 18th century by volunteers from the city. However during the Second World War it was completely
      demolished and shortly after that the whole building has been rebuilt. The architects at that time decided not to keep the original architecture
    , but to come up with entirely new and modern design.
    They wanted for their kids to be intelligent </p>
  </div>
  <div class="image Library"></div>
  <div class="image Building"></div>
  <div class="grid-item-info">
    <h3 class= "aboutus">Opening hours: </h3> <p class= "aboutus"> Monday - Friday: 9:00 - 17:00</p>
    <h3 class= "aboutus">Email:</h3> <p class= "aboutus">librarymarta@abv.bg</p>
  </div>
  <div class="grid-item-location">
    <h3 class= "aboutus">Location: </h3> <p class= "aboutus">Gravesandestraat 26, Eindhoven, Netherlands</p>
  </div>
  <div class="map">
    <div class="mapouter">
      <div class="gmap_canvas">
        <iframe  id="gmap_canvas"
      src="https://maps.google.com/maps?q=gravesandestraat%2026%2C%20eindhoven&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
      ></iframe>
      <a href="https://www.embedgooglemap.net">embedgooglemap.net</a>
    </div>
  </div>
  </div>
</div>
  </body>
  <?php require 'includes/footer.php'; ?>
</html>
