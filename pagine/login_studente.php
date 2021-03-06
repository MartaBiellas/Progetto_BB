<?php
session_start();
//echo session_id();

require('../data/dati_connessione_db.php');

if (isset($_SESSION['email'])) {
    header('location: pagine/home.php');
}

if (isset($_POST["email"])) {
    $email = $_POST["email"];
} else {
    $email = "";
}

if (isset($_POST["password"])) {
    $password = $_POST["password"];
} else {
    $password = "";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../stile.css">
    <title>Login</title>
</head>

<body>

    <div class="utile reveal">
        <div class="header">
            <div class="immagine">
                <a href="../index.php"><img src="../img/freccia.png"></a>
            </div>

            <img src="../img/studenti.jpg">
            <h1>STUDENTE</h1>
            <h2>Login</h2>
        </div>

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="input-group">
                <label> Email </label>
                <input type="text" name="email" <?php echo "value = '$email'" ?> required>
            </div>
            <div class="input-group">
                <label> Password </label>
                <input type="password" name="password" <?php echo "value = '$password'" ?> required>
            </div>

            <div class="input-group">
                <button type="submit" name="login" class="btn button insta-button"> Login </button>
            </div>

            <p>
                Se non ti sei ancora registrato: <a href="registrazione_studente.php"> vai alla registrazione </a>
            </p>

            <br>

            <p>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (empty($_POST["email"]) or empty($_POST["password"])) {
                        echo "<p>Campi lasciati vuoti</p>";
                    } else {
                        $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
                        if ($conn->connect_error) {
                            die("<p>Connessione al server non riuscita: " . $conn->connect_error . "</p>");
                        }
                        //echo "connessione riuscita";

                        $tabella = $_SESSION["tipologia"];

                        $myquery = "SELECT email, password 
                        FROM $tabella 
                        WHERE email='$email'
                            AND password='$password'";

                        $ris = $conn->query($myquery) or die("<p>Query fallita! " . $conn->error . "</p>");

                        if ($ris->num_rows == 0) {
                            echo '<p div class = "error">Attenzione: utente non trovato o password errata!</p>';
                            $conn->close();
                        } else {
                            $_SESSION["email"] = $email;

                            $conn->close();
                            header("location: home_studente.php");
                        }
                    }
                }
                ?>
            </p>
        </form>
    </div>
    </div>
    <br>
    <?php
    error_reporting(E_ALL ^ E_WARNING);
    include('footer.php');

    ?>
</body>

</html>