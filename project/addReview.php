<!-- File: addReview.php
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

    function insertReview() {
        return "INSERT INTO review (numStars, typedReview, movie\$Id, reviewer)
                VALUES ($_POST[numStars], '$_POST[typedReview]', $_POST[movieId], '$_SESSION[username]');";
    }

    function submitReview() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pdo = getPDO();
            $pdo->query(insertReview());
            echo "Thank you for giving us your thoughts!";
        }
    }

?>

<html>
    <head>
         <title>Add Review - Cody's Review World</title>
         <meta charset="utf-8">
         <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
         <link rel="icon" href="/234ProjIcon2.png">
    </head>
    <body>
        <header class="w3-container w3-red w3-text-black"><h1><img src="234ProjIconLarge.png" alt="Logo" style="max-width:65px"> Add a Review</h1></header>

        <main>
        <a class="w3-button w3-red w3-round w3-margin-left w3-margin-top" href="index.php">Back to Home Page</a>
        <form class="w3-card-4 w3-margin" action="<?php getPostback() ?>" method="POST">
            <header class="w3-container w3-red w3-round-small w3-margin-top">
                <h3>Let's hear your thoughts!</h3>
            </header>
            <div>
                <select class="w3-select w3-margin" name="movieId" style="width:300px" required>
                    <option value="" disabled selected>Pick a Movie</option>
                    <option value="1">Godzilla vs. Kong</option>
                    <option value="2">Mortal Kombat</option>
                    <option value="3">Zack Snyder's Justice League</option>
                </select>
            </div>
            <div class="w3-margin-left w3-margin-top">
                How many stars would you give it?
            </div>
            <div class="w3-margin-left">
                <label>1</label>
                <input class="w3-radio" type="radio" name="numStars" value="1" required>
                <input class="w3-radio" type="radio" name="numStars" value="2">
                <input class="w3-radio" type="radio" name="numStars" value="3">
                <input class="w3-radio" type="radio" name="numStars" value="4">
                <input class="w3-radio" type="radio" name="numStars" value="5">
                <label>5</label>
            </div>
            <div class="w3-margin-left w3-margin-top">
                Tell us a bit more!
            </div>
            <div>
                <!-- <input class="w3-margin-left w3-margin-top" type="text" maxlength="240" placeholder="Write your review here." name="typedReview" required> -->
                <textarea id="typedReview" name="typedReview" placeholder="Write your review here. (max 240 characters)" rows="4" cols="60" maxlength="240" class="w3-margin-left w3-margin-top" required></textarea>
            </div>
            <div>
                <input type="submit" value="Submit Review" class="w3-red w3-button w3-round w3-margin">
            </div>
            <div class="w3-margin-left w3-margin-bottom">
                <?php submitReview() ?>
            </div>
        </form>
        </main>
        <footer class="w3-panel w3-center w3-text-gray w3-small">
            &copy; <?php echo $year ?> Cody Schaefer
        </footer>
    </body>
</html>