<?php 
    if(isset($_POST["username"])) $username = $_POST["username"];  else $username = "";
    if(isset($_POST["password"])) $password = $_POST["password"];  else $password = "";
    if(isset($_POST["conferma"])) $conferma = $_POST["conferma"];  else $conferma = "";
    if(isset($_POST["nome"])) $nome = $_POST["nome"];  else $nome = "";
    if(isset($_POST["cognome"])) $cognome = $_POST["cognome"];  else $cognome = "";
    if(isset($_POST["email"])) $email = $_POST["email"];  else $email = "";
    if(isset($_POST["telefono"])) $telefono = $_POST["telefono"];  else $telefono = "";
    if(isset($_POST["comune"])) $comune = $_POST["comune"];  else $comune = "";
    if(isset($_POST["indirizzo"])) $indirizzo = $_POST["indirizzo"];  else $indirizzo = "";
    if(isset($_POST["tipologia"])) $tipologia = $_POST["tipologia"];  else $tipologia = "utenti";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style.css">
    <title>Biblioteca - Rsgistrazione</title>
</head>

<body>
    <div class="nav">
        <div class="centratonav">
            <ul class="navlinks">
                <li><a href="../index.php">Login</a></li>
            </ul>
        </div>
    </div>
    <div class="contenuto">
        <h1>Registrazione</h1>
        <p>Inserisci i tuoi dati. Username e password sono obbligatori per la registrazione. Tutti i dati tranne l'userneme saranno modificabili successivamente</p>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <table id="tab_dati_personali">
                <tr>
                    <td>Username:</td>
                    <td><input class="input_dati_personali" type="text" name="username" <?php echo "value = '$username'" ?> required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input class="input_dati_personali" type="password" name="password" <?php echo "value = '$password'" ?> required></td>
                </tr>
                <tr>
                    <td>Conferma psw:</td>
                    <td><input class="input_dati_personali" type="password" name="conferma" <?php echo "value = '$conferma'" ?> required></td>
                </tr>
                <tr>
                    <td>Nome:</td>
                    <td><input class="input_dati_personali" type="text" name="nome" <?php echo "value = '$nome'" ?>></td>
                </tr>
                <tr>
                    <td>Cognome:</td>
                    <td><input type="text" class="input_dati_personali" name="cognome" <?php echo "value = '$cognome'" ?>></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" class="input_dati_personali" name="email" <?php echo "value = '$email'" ?>></td>
                </tr>
                <tr>
                    <td>Telefono:</td>
                    <td><input type="text" class="input_dati_personali" name="telefono" <?php echo "value = '$telefono'" ?>></td>
                </tr>
                <tr>
                    <td>Comune:</td>
                    <td><input type="text" class="input_dati_personali" name="comune" <?php echo "value = '$comune'" ?>></td>
                </tr>
                <tr>
                    <td>Indirizzo:</td>
                    <td><input type="text" class="input_dati_personali" name="indirizzo" <?php echo "value = '$indirizzo'" ?>></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center">
                        Utente <input type="radio" name="tipologia" value="utenti" <?php if($tipologia=="utenti") echo "checked"?>>
                        Bibliotecario <input type="radio" name="tipologia" value="bibliotecari" <?php if($tipologia=="bibliotecari") echo "checked"?>>
                    </td>
                </tr>
            </table>
            <p style="text-align: center">
                <input type="submit" value="Invia">
            </p>
        </form>
        <p>
            <?php
            if(isset($_POST["username"]) and isset($_POST["password"])) {
                if ($_POST["username"] == "" or $_POST["password"] == "") {
                    echo "username e password non possono essere vuoti!";
                } elseif ($_POST["password"] != $_POST["conferma"]){
                    echo "Le password inserite non corrispondono";
                } else {
                    $conn = new mysqli("localhost", "root", "", "biblioteca");
                    if($conn->connect_error){
                        die("<p>Connessione al server non riuscita: ".$conn->connect_error."</p>");
                    }

                    $myquery = "SELECT username 
						    FROM utenti 
						    WHERE username='" . $_POST["username"] . "'";
                    //echo $myquery;

                    $ris = $conn->query($myquery) or die("<p>Query fallita!</p>");
                    if ($ris->num_rows > 0) {
                        echo "Questo username è già stato usato";
                    } else {

                        $myquery = "INSERT INTO $tipologia (username, password, nome, cognome, email, telefono, comune, indirizzo)
                                    VALUES ('$username', '$password', '$nome', '$cognome','$email','$telefono','$comune','$indirizzo')";

                        /*
                        // Versione con l'uso dell'hash
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);

                        $myquery = "INSERT INTO utenti (username, password, nome, cognome, email, telefono, comune, indirizzo)
                                    VALUES ('$username', '$password_hash', '$nome', '$cognome','$email','$telefono','$comune','$indirizzo')";
                        */

                        if ($conn->query($myquery) === true) {
                            session_start();
                            $_SESSION["username"]=$username;
                            $_SESSION["tipologia"]=$_POST["tipologia"];
                            
						    $conn->close();

                            echo "Registrazione effettuata con successo!<br>sarai ridirezionato alla home tra 5 secondi.";
                            header('Refresh: 5; URL=home.php');

                        } else {
                            echo "Non è stato possibile effettuare la registrazione per il seguente motivo: " . $conn->error;
                        }
                    }
                }
            }
            ?>
        </p>
    </div>
    <?php 
        error_reporting(E_ALL ^ E_WARNING); // metodo globale ^ significa tranne e funziona da qui in poi
		include('footer.php');
		// @include('footerrr.php');  // con @ evito la generazione di warnings o errors da parte della funzione
	?>
</body>

</html>