<?php
if (isset($_POST["password"])) $password = $_POST["password"];
else $password = "";
if (isset($_POST["conferma"])) $conferma = $_POST["conferma"];
else $conferma = "";
if (isset($_POST["nome"])) $nome = $_POST["nome"];
else $nome = "";
if (isset($_POST["cognome"])) $cognome = $_POST["cognome"];
else $cognome = "";
if (isset($_POST["email"])) $email = $_POST["email"];
else $email = "";
if (isset($_POST["data_nascita"])) $data_nascita = $_POST["data_nascita"];
else $data_nascita = "";
if (isset($_POST["materia"])) $materia = $_POST["materia"];
else $materia = "";
if (isset($_POST["tipologia"])) $tipologia = $_POST["tipologia"];
else $tipologia = "utenti";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../stile.css">
    <title>Registrazione</title>
</head>

<body>

    <div class="utile reveal">
        <div class="header">
            <img src="../img/prof.jpg">
            <h1>PROFESSORE</h1>
            <h2>Registrazione</h2>
        </div>

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="input-group">
                <label> Nome </label>
                <input type="text" name="nome" <?php echo "value = '$nome'" ?> required>
            </div>
            <div class="input-group">
                <label> Cognome </label>
                <input name="cognome" <?php echo "value = '$cognome'" ?> required>
            </div>
            <div class="input-group">
                <label> Data di nascita </label>
                <input type="data" name="data_nascita" <?php echo "value = '$data_nascita'" ?> required>
            </div>
            <div class="input-group">
                <label> Materia </label>
                <input type="text" name="materia" <?php echo "value = '$materia'" ?> required>
            </div>
            <div class="input-group">
                <label> Email </label>
                <input type="text" name="email" <?php echo "value = '$email'" ?> required>
            </div>
            <div class="input-group">
                <label> Password </label>
                <input type="password" name="password" <?php echo "value = '$password'" ?> required>
            </div>
            <div class="input-group">
                <label> Conferma psw </label>
                <input type="password" name="conferma" <?php echo "value = '$conferma'" ?> required>
            </div>

            <div class="input-group">
                <button type="submit" name="Registrati" class="btn button insta-button"> Registrati </button>
            </div>

            <p>
                Se sei già registrato: <a href="login_professore.php"> vai al login </a>
            </p>
            <br>
            <p>
                <?php
                if (isset($_POST["email"]) and isset($_POST["password"])) {
                    if ($_POST["email"] == "" or $_POST["password"] == "") {
                        echo '<p div class = "error"> email e password non possono essere vuoti! <p>';
                    } elseif ($_POST["password"] != $_POST["conferma"]) {
                        echo '<p div class = "error"> Le password inserite non corrispondono<p>';
                    } else {
                        $conn = new mysqli("localhost", "root", "", "database_bb");
                        if ($conn->connect_error) {
                            die("<p>Connessione al server non riuscita: " . $conn->connect_error . "</p>");
                        }

                        $myquery = "SELECT email 
						    FROM professore 
						    WHERE email='" . $_POST["email"] . "'";

                        $ris = $conn->query($myquery) or die("<p>Query fallita!</p>");
                        if ($ris->num_rows > 0) {
                            echo '<p div class = "error">Questo profilo esiste già</p>';
                        } else {
                            $conn->query('SET FOREIGN_KEY_CHECKS= 0;');
                            $myquery = "INSERT INTO professore (email, password, nome, cognome, data_nascita, materia)
                                    VALUES ('$email', '$password', '$nome', '$cognome','$data_nascita','$materia')";
                            $conn->query('SET FOREIGN_KEY_CHECKS= 1;');
                            if ($conn->query($myquery) === true) {
                                session_start();
                                $_SESSION["email"] = $email;

                                $conn->close();

                                echo '<p div class = "ok"> Registrazione effettuata con successo!<br>Sarai ridirezionato alla home tra 5 secondi.</p>';
                                header('Refresh: 5; URL=home_professore.php');
                            } else {
                                echo "Non è stato possibile effettuare la registrazione per il seguente motivo: " . $conn->error;
                            }
                        }
                    }
                }
                ?>
            </p>
        </form>
    </div>
    <br><br>
    </div>
    <?php
    error_reporting(E_ALL ^ E_WARNING);
    include('footer.php');

    ?>
</body>

</html>