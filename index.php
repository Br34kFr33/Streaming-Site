<?php

include_once("header.php");

$titleOrder = 'ASC';
$orderBy = 'title';

if (isset($_GET['title']) && $_GET['title'] === 'ASC') {
$titleOrder = 'ASC';
$orderBy = 'title';

} elseif (isset($_GET['title']) && $_GET['title'] === 'DESC') {
$orderBy = 'title';
$titleOrder = 'DESC';

} elseif(isset($_GET['added']) && $_GET['added'] === 'ASC') {
$orderBy = 'added';
$titleOrder = 'ASC';

} elseif(isset($_GET['added']) && $_GET['added'] === 'DESC') {
$orderBy = 'added';
$titleOrder = 'DESC';
}

$record_per_page = 82;
$page = '';
if(isset($_GET["page"]))
{
 $page = $_GET["page"];
}
else
{
 $page = 1;
}

$start_from = ($page-1)*$record_per_page;

if (isset($_GET['search'])) {
$search = $_GET['search'];
$search = str_ireplace('+', ' ', $search);
$result = $mysqli->query("SELECT title, poster, filename, id, genres, added, type FROM movies WHERE title LIKE '%$search%' UNION SELECT title, poster, filename, id, genres, added, type FROM tv_series WHERE title LIKE '%$search%' ORDER BY $orderBy $titleOrder LIMIT $start_from, $record_per_page") or die;
   $result->fetch_assoc();

} elseif (isset($_GET['type']) && $_GET['type'] === 'series') {
$result = $mysqli->query("SELECT * FROM tv_series ORDER BY $orderBy $titleOrder LIMIT $start_from, $record_per_page") or die;
   $result->fetch_assoc();

} elseif (isset($_GET['type']) && $_GET['type'] === 'movie') {
$result = $mysqli->query("SELECT * FROM movies ORDER BY $orderBy $titleOrder LIMIT $start_from, $record_per_page") or die;
   $result->fetch_assoc();

} elseif (isset($_GET['genre'])) {
$genre = $_GET['genre'];
$result = $mysqli->query("SELECT * FROM movies WHERE genres LIKE '%$genre%' ORDER BY $orderBy $titleOrder LIMIT $start_from, $record_per_page") or die;
   $result->fetch_assoc();

} else {
$result = $mysqli->query("SELECT title, poster, filename, id, genres, added, type FROM movies WHERE title != '' and tmdb_id != '' UNION SELECT title, poster, filename, id, genres, added, type FROM tv_series WHERE title != '' ORDER BY $orderBy $titleOrder LIMIT $start_from, $record_per_page") or die;
   $result->fetch_assoc();
}

?>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="includes/img/ny.jpg" alt="New York" width="1200" height="200">
        <div class="carousel-caption">
          <h3>New York</h3>
          <p>The atmosphere in New York is lorem ipsum.</p>
        </div>      
      </div>

      <div class="item">
        <img src="includes/img/chicago.jpg" alt="Chicago" width="1200" height="200">
        <div class="carousel-caption">
          <h3>Chicago</h3>
          <p>Thank you, Chicago - A night we won't forget.</p>
        </div>      
      </div>
    
      <div class="item">
        <img src="includes/img/la.jpg" alt="Los Angeles" width="1200" height="200">
        <div class="carousel-caption">
          <h3>LA</h3>
          <p>Even though the traffic was a mess, we had the best time playing at Venice Beach!</p>
        </div>      
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
</div>

<!-- Container -->

<div id="movies" class="container text-center">
      <?php while($row = $result->fetch_array()) { ?>
        <a href="<?php echo 'http://' . $_SERVER["SERVER_NAME"] . '/info.php?name=' . urlencode($row["title"]) . '&type=' . $row["type"]; ?>" title="<?php echo urlencode($row["title"]); ?>" type="<?php echo $row["type"]; ?>">
      <?php echo '<img src="pics/'.$row["poster"].'" alt="poster" title="'. $row["title"] .'">';?>  
        </a>
      <?php } ?>
</div>




<!-- Footer -->
<div id=footer">
<footer class="text-center">
  <a class="up-arrow" href="#myPage" data-toggle="tooltip" title="TO TOP">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a><br><br>
  <p>Copyright &copy; 2017 | iWatchIt.online</p> 
</footer>
</div>
<script>
$(document).ready(function(){
  // Initialize Tooltip
  $('[data-toggle="tooltip"]').tooltip(); 
  
  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {

      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
})
</script>

</body>
</html>
