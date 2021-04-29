<!-- File: index.php
   Author: Cody Schaefer -->

   <?php 

   error_reporting(E_ALL);
   ini_set('display_errors', '1');

   session_start();

   $year = date('Y');

   if (!isset($_SESSION["username"])) {
      header("Location: loginForm.php");
      die;
   }

   function getValue($key) {
      if (isset($key)) {
          return htmlspecialchars(trim($key));
      }
      else {
          return "";
      }
  }

  function getPostback() {
      return getValue($_SERVER['PHP_SELF']);
   }

   function getDSN() {
      $dsn = "mysql:host=localhost;port=8889;dbname=project";
      return $dsn;
   }

   function getUsername() {
      return "root";
   }

   function getPassword() {
      return "root";
   }

   function getPDO() {
      $pdo = new PDO(getDSN(), getUsername(), getPassword());
      return $pdo;
   }

   function welcomeMessage() {
      echo "Welcome, $_SESSION[username]!";
   }

   function selectMovies() {
      return "SELECT *
               FROM movie;";
   }

   function selectAvgUserNumStars($movieId) {
      return "SELECT ROUND(AVG(numStars), 1) as 'avg'
               FROM review
               WHERE movie\$id = $movieId;";
   }
   
   function selectReviewsForMovie($movieId) {
      return "SELECT *
               FROM review
               WHERE movie\$Id = '$movieId'";
   }

   function displayMovies() {
      $pdo = getPDO();
      $pdo2 = getPDO();
      $pdoMovieStatement = $pdo->query(selectMovies());
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $movieBuild = "";
      $numMovie = 1;
      foreach ($pdoMovieStatement as $movie) {
         $pdoReviewStatement = $pdo2->query(selectAvgUserNumStars($movie['movieId']));
         $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $movieBuild .= "<div class=\"w3-card w3-margin w3-round-small\">";
         $movieBuild .= "<header class=\"w3-container w3-red w3-round-small\">";
         $movieBuild .= "<h3>$movie[title]</h3>";
         $movieBuild .= "</header>";
         $movieBuild .= "<div class=\"w3-container\">";
         $movieBuild .= "<img src=\"/posters/$movie[poster]\" alt=\"Poster\" class=\"w3-card w3-left w3-margin\" style=\"max-width:200px\">";
         $movieBuild .= "<p>";
         $movieBuild .= "Released: $movie[releaseYear]";
         $movieBuild .= "</p>";
         $movieBuild .= "<p>";
         $movieBuild .= "Director: $movie[director]";
         $movieBuild .= "</p>";
         $movieBuild .= "<p>";
         $movieBuild .= "Rating: $movie[rating]";
         $movieBuild .= "</p>";
         $movieBuild .= "<p>";
         foreach ($pdoReviewStatement as $usrReview) {
            $movieBuild .= "Average User Score: $usrReview[avg]/5.0";
         }
         $movieBuild .= "</p>";
         $movieBuild .= "</div>";
         $movieBuild .= "<hr>";
         $movieBuild .= "<button class=\"w3-btn w3-red w3-margin w3-round\" onclick=\"document.getElementById('$numMovie').style.display='block'\">Show User Reviews</button>";
         $movieBuild .= "<a class=\"w3-button w3-red w3-round\" href=\"addReview.php\">Leave a Review</a>";
         //$movieBuild .= "<input type=\"button\" class=\"w3-button w3-red w3-round\" value=\"$numMovie\">";
         $movieBuild .= displayReviews($movie['movieId'], $numMovie);
         $movieBuild .= "</div>";

         ++$numMovie;
      }

      return $movieBuild;
   }

   function displayReviews($movieId, $numMovie) {
      $pdo = getPDO();
      $pdoStatement = $pdo->query(selectReviewsForMovie($movieId));

      $reviewBuild = "";
      $reviewBuild .= "<div id=\"$numMovie\" class=\"w3-panel w3-display-container\" style=\"display:none\">
      <span onclick=\"this.parentElement.style.display='none'\"
      class=\"w3-button w3-display-topright w3-margin w3-red w3-round w3-hover-pale-red\">Close Reviews</span>";

      foreach($pdoStatement as $review) {
         $reviewBuild .= "<hr>";
         $reviewBuild .= "<div class=\"w3-cell-row\">";
         $reviewBuild .= "<div class=\"w3-cell\" style=\"width:20%\"><p>Posted By:</p><p><strong>$review[reviewer]</strong></p></div>";
         $reviewBuild .= "<p>$review[typedReview]</p>";
         $reviewBuild .= "<p>Rating: $review[numStars]/5</p>";
         $reviewBuild .= displayDelete($review['reviewId']);
         $reviewBuild .="</div>";
      }

      $reviewBuild .="</div>";
      
      return $reviewBuild;
   }

   // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   //    if (isset($_POST['logout'])) {
   //       session_destroy();
   //       header("Location: loginForm.php");
   //       die;
   //    }
   // }

   function determineModerator($username) {
      $pdo = getPdo();
      $sql = "SELECT username FROM registration WHERE moderator = TRUE;";

      $pdoStatement = $pdo->query($sql);

      foreach ($pdoStatement as $queryUsername) {
         if ($username == $queryUsername['username']) {
            return true;
         }
      }

      return false;
   }

   function displayDelete($reviewId) {
      if (determineModerator($_SESSION['username'])) {
         return "<form action=\"\" method=\"POST\"><button class=\"w3-button w3-red w3-round w3-margin-right w3-margin-bottom w3-right w3-hover-pale-red\" name=\"deleteReview\" value=\"$reviewId\">Delete</button></form>";
      }
      else {
         return "";
      }
   }

   function deleteReviewStatement() {
      return "DELETE FROM review
               WHERE reviewId = '$_POST[deleteReview]';";
   }

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['logout'])) {
         session_destroy();
         header("Location: loginForm.php");
         die;
      }
      elseif (isset($_POST['deleteReview'])) {
         $pdo = getPDO();
         $pdo->query(deleteReviewStatement());
      }
   }
   
   ?>

   <html>
      <head>
         <title>Cody's Review World</title>
         <meta charset="utf-8">
         <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
         <link rel="icon" href="/234ProjIcon2.png">
      </head>
      <body>
         <header class="w3-container w3-middle w3-red w3-text-black"><h1><img src="234ProjIconLarge.png" alt="Logo" style="max-width:65px"><strong> Cody's Review World</strong></h1></header>
         <div>
            <?php welcomeMessage() ?>
            <!-- <?php echo determineModerator($_SESSION['username']); ?> -->
         </div>
         <div class="w3-cell-row">
            <div class="w3-container w3-cell w3-center">
               <h1><strong>Recent Releases</strong></h1>
            </div>
         </div>
         <div>
            <?php echo displayMovies() ?>
         </div>
         <div>
            <form action ="<?php getPostback(); ?>" method="POST">
               <button class="w3-button w3-red w3-round w3-margin-right w3-right w3-hover-pale-red" name="logout">Logout</button>
            </form>
         </div>
         <footer class="w3-panel w3-center w3-text-gray w3-small">
            &copy; <?php echo $year ?> Cody Schaefer
         </footer>
      </body>
   </html>