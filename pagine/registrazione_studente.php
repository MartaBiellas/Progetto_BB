<?php 
    if(isset($_POST["password"])) $password = $_POST["password"];  else $password = "";
    if(isset($_POST["conferma"])) $conferma = $_POST["conferma"];  else $conferma = "";
    if(isset($_POST["nome"])) $nome = $_POST["nome"];  else $nome = "";
    if(isset($_POST["cognome"])) $cognome = $_POST["cognome"];  else $cognome = "";
    if(isset($_POST["email"])) $email = $_POST["email"];  else $email = "";
    if(isset($_POST["data_nascita"])) $data_nascita = $_POST["data_nascita"];  else $data_nascita = "";
    if(isset($_POST["sezione"])) $sezione = $_POST["sezione"];  else $sezione = "";
    if(isset($_POST["anno"])) $anno = $_POST["anno"];  else $anno = "";
    if(isset($_POST["tipologia"])) $tipologia = $_POST["tipologia"];  else $tipologia = "utenti";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../stile.css">
    <title>Registro online - Registrazione</title>
</head>

<body>

    <div class="header">
    <img src="../img/studenti.jpg">
        <h1>STUDENTE</h1>
        <h2>Registrazione</h2>
    </div>  
       
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="input-group">
            <label> Nome </label>
            <input type="text" name="nome" <?php echo "value = '$nome'" ?>>
        </div>
        <div class="input-group">
            <label> Cognome </label>
            <input type="text" name="cognome" <?php echo "value = '$cognome'" ?>>
        </div>
        <div class="input-group">
            <label> Data di nascita </label>
            <input type="data" name="nascita" <?php echo "value = '$data_nascita'" ?> required>
        </div>
        <div class="input-group">
            <label> Sezione </label>
            <input type="text" name="sezione" <?php echo "value = '$sezione'" ?> required>
        </div>
        <div class="input-group">
            <label> Anno </label>
            <input type="text" name="anno" <?php echo "value = '$anno'" ?> required>
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
            <button type="submit" name="Registrati" class="btn"> Registrati </button>
        </div>

            <p>
                Se sei già registrato: <a href="login_studente.php"> vai al login </a> 
            </p>
        </form>

<br>

        <p>
            <?php
            if(isset($_POST["email"]) and isset($_POST["password"])) {
                if ($_POST["email"] == "" or $_POST["password"] == "") {
                    echo "email e password non possono essere vuoti!";
                } elseif ($_POST["password"] != $_POST["conferma"]){
                    echo "Le password inserite non corrispondono";
                } else {
                    $conn = new mysqli("localhost", "root", "", "database_bb");
                    if($conn->connect_error){
                        die("<p>Connessione al server non riuscita: ".$conn->connect_error."</p>");
                    }

                    $myquery = "SELECT email 
						    FROM alunni 
						    WHERE email='" . $_POST["email"] . "'";
                    //echo $myquery;

                    $ris = $conn->query($myquery) or die("<p>Query fallita!</p>");
                    if ($ris->num_rows > 0) {
                        echo "Questo profilo esiste già";
                    } else {

                        $myquery = "INSERT INTO $tipologia (email, password, nome, cognome, data_nascita, sezione, anno)
                                    VALUES ('$email', '$password', '$nome', '$cognome','$data_nascita','$sezione','$anno')";

                        if ($conn->query($myquery) === true) {
                            session_start();
                            $_SESSION["email"]=$email;
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