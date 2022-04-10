<?php 
    require("../data/dati_connessione_db.php");
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
    <link rel="stylesheet" href="../stile.css">
    <title>Login</title>
</head>

<body>
    <!-- <div class="nav">
        <div class="centratonav">
            <ul class="navlinks">
                <li><a href="../index.php">Login</a></li>
            </ul>
        </div> 
    </div> -->

    <div class="header">
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
            <button type="submit" name="login" class="btn"> Login </button>
        </div>
        
<!--                 <tr>
                    <td colspan="2" style="text-align: center">
                        Utente <input type="radio" name="tipologia" value="utenti" <?php if($tipologia=="utenti") echo "checked"?>>
                        Bibliotecario <input type="radio" name="tipologia" value="bibliotecari" <?php if($tipologia=="bibliotecari") echo "checked"?>>
                    </td>
                </tr>
            </table> -->

            <p>
                Se non ti sei ancora registrato: <a href="registrazione.php"> vai alla registrazione </a> 
            </p>
        </form>

        <br>

        <p>
        <?php
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				if( empty($_POST["email"]) or empty($_POST["password"])) {
					echo "<p> Campi lasciati vuoti </p>";
				} else {
					$conn = new mysqli($db_servername,$db_username,$db_password,$db_name);
					if($conn->connect_error){
						die("<p>Connessione al server non riuscita: ".$conn->connect_error."</p>");
					}
					//echo "connessione riuscita";
					
                    $tabella = $_POST["tipologia"];
					
					$myquery = "SELECT email, password 
								FROM $tabella 
								WHERE email='$email'
									AND password='$password'";

					$ris = $conn->query($myquery) or die("<p>Query fallita! ".$conn->error."</p>");

					if($ris->num_rows == 0){
						echo "<p>Utente non trovato o password errata</p>";
						$conn->close();
					} 
					else {
						$_SESSION["email"]=$email;
                        $_SESSION["tipologia"]=$_POST["tipologia"];
												
						$conn->close();
						header("location: pagine/home.php");

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