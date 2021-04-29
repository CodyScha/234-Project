<!-- File: registerForm.php
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

    function insertNewUser() {
        $username = getValue($_POST['usr']);
        $password = getValue($_POST['pwd']);
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO registration VALUES ('$username', '$passwordHash', FALSE);";

        $pdo = getPDO();
        $pdo->query($sql);

    }
    
    function register() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $username = getValue($_POST['usr']);
            $password = getValue($_POST['pwd']);
            $validUsr = true;

            $pdoStatement = queryUsernames();

            foreach ($pdoStatement as $queryUsrs) {
                if ($username == $queryUsrs['username']) {
                    $validUsr = false;
                    break;
                }
            }

            if ($validUsr) {
                insertNewUser();
                echo "Your account has been created.";
            }
            else {
                echo "Username <strong>$username</strong> has already been taken.";
            }

        }
    }

?>

<html>

<head>
     <title>Register - Cody's Review World</title>
     <meta charset="utf-8">
     <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
     <link rel="icon" href="/234ProjIcon2.png">

 </head>

 <body>
     <header class="w3-container w3-red w3-text-black"><h1><img src="234ProjIconLarge.png" alt="Logo" style="max-width:65px"> Cody's Review World Register</h1></header>
    
    <main>     <!-- <php getPostback(); ?> -->
        <form class="w3-border" action="" method="POST">
            <div class="w3-panel">
            <p>
                <input class="w3-input w3-border w3-light-grey" name="usr" placeholder="Username" required autofocus>
            </p>

            <p>
                <input class="w3-input w3-border w3-light-grey" type="password" name="pwd" placeholder="Password" required>
            </p>

            <p>
                <button class="w3-button w3-green w3-round" >Register</button>
            </p>
            </div>
        </form>
        <div>
            <p>
                <?php register() ?>
            </p>
            <p>
                Already have an account? Login <a href="loginForm.php">here!</a>
            </p>
        </div>
    </main>

     <footer class="w3-panel w3-center w3-text-gray w3-small">
         &copy; <?php echo $year ?> Cody Schaefer
    </footer>
 </body>
</html>