<?php
require "config/session_init.php";
require "Controllers/BookController.php";
$books = getBooks();
$num_books = count($books);

$pageName = "Homepage";
require "includes/head.php";
?>


<body>
  <?php require "includes/Navigation.php"; ?>

   <div class="grid-container">
     <div class="grid-item-background-image"></div>
     <!-- <div class="grid-item-search">
       <input id="search" type="text" placeholder="Search...">
     </div> -->
     <?php
     $titles = array("Trending", "Most recent", "Newest", "Trending");?>
   <?php for ($j=1; $j < 4; $j++) {  ?>
     <div class="grid-item-cards">
       <div class="headers">
         <h2 id="h2Cards"><?php echo $titles[$j]; ?></h2>
         <h4 class="cardsh4"><a class="cards" href="ViewMoreBooks.php">View more...</a></h4>
       </div>
       <div class="allCards">
         <div class="boardCards">
           <div class="leftArrow">
             <a class="prev round" onclick="plusSlides(-1)">&#10094;</a>
           </div>

           <?php if($num_books > 0){
           for ($i=1; $i < 5; $i++) {
             ?>

             <div class="card1">
               <a class="cards" href="BookPage.php?id=<?php echo $books[$i*$j]->id; ?>"><?php echo "<img class='boardCardImg' src='images/".$books[$i*$j]->cover_image."' alt='bookDetails'>";?> </a>
                 <div class="cardInfo">
                   <span class "textCard">
                     <h3 id="h3Cards"><?php echo $books[$i*$j]->name; ?></h3>
                     <p class="cardsp"><?php echo $books[$i*$j]->author; ?></p>
                   </span>
                 </div>
               </a>
             </div>
         <?php unset($booksOrder); } } ?>


           <div class="rightArrow">
               <a class="next round" onclick="plusSlides(1)">&#10095;</a>
           </div>
         </div>
       </div>
     </div>
     <?php  } ?>
  </div>

</body>
<?php require 'includes/footer.php'; ?>
</html>
