<!-- File: loginForm.php
   Author: Cody Schaefer -->

<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    session_start();

    $year = date('Y');

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

    function selectUsernames() {
        return "SELECT username
                from registration;";
    }

    function queryUsernames() {
        $pdo = getPDO();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdoStatement = $pdo->query(selectUsernames());

        return $pdoStatement;
    }

    function selectPassword($inputUsername) {
        return "SELECT password
                FROM registration
                WHERE username = '$inputUsername'";
    }

    function verifyPassword($inputUsername) {
        $pdo = getPDO();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdoStatement = $pdo->query(selectPassword($inputUsername));

        foreach ($pdoStatement as $pass) {
            if (password_verify("$_POST[pwd]", $pass['password'])) {
                return true;
            }
            else {
                return false;
            }
        }

    }
    function verifyCredentials() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pdoStatement = queryUsernames();
            $validUsr = false;
            $usr = getValue($_POST['usr']);

            foreach ($pdoStatement as $username) {
                if ($usr == $username['username']) {
                    if(verifyPassword($usr)) {
                        //echo "this works.";
                        //$validUsr = true;
                        $_SESSION["username"] = $usr;
                        header("Location: index.php");
                        die;
                    }
                }
            }
            if (!$validUsr) {
                echo "Invalid username or password.";
            }

        }
    }

    //$hash = password_hash("admin", PASSWORD_BCRYPT);
    //echo "$hash \n";

    //if (password_verify("admin", $hash)) {
     //   echo "works";
    //}
    //else {
     //   echo "doesnt work";
    //}


?>

<html>

    <head>
         <title>Login - Cody's Review World</title>
         <meta charset="utf-8">
         <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
         <link rel="icon" href="/234ProjIcon2.png">

     </head>

     <body>
         <header class="w3-container w3-red w3-text-black"><h1><img src="234ProjIconLarge.png" alt="Logo" style="max-width:65px"> Cody's Review World Login</h1></header>
        
        <main>
            <form class="w3-border" action="<?php getPostback(); ?>" method="POST">
                <div class="w3-panel">
                <p>
                    <input class="w3-input w3-border w3-light-grey" name="usr" placeholder="Username" required autofocus>
                </p>

                <p>
                    <input class="w3-input w3-border w3-light-grey" type="password" name="pwd" placeholder="Password" required>
                </p>

                <p>
                    <button class="w3-button w3-green w3-round" >Login</button>
                </p>
                </div>
            </form>
            <p>
                <?php verifyCredentials() ?>
            </p>
            <div>
                <p>
                    Don't have an account? Register <a href="registerForm.php">here!</a>
                </p>
            </div>
        </main>

         <footer class="w3-panel w3-center w3-text-gray w3-small">
             &copy; <?php echo $year ?> Cody Schaefer
        </footer>
     </body>
</html>