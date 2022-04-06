<?php
	session_start();
	//echo session_id();

	require('data/dati_connessione_db.php');
	// $servername = "localhost";
	// $db_name = "biblioteca";
	// $db_username = "root";
	// $db_password = "";

	if(isset($_SESSION['username'])){
		header('location: pagine/home.php');
	}

	if(isset($_POST["username"])){
		$username = $_POST["username"];
	}
	else{
		$username = "";
	}
	
	if (isset($_POST["password"])){
		$password = $_POST["password"];
	}
	else {
		$password = "";
	}

?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<title>Biblioteca - Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="nav">
		<div class="centratonav">
			<ul class="navlinks">
				<li><a href="pagine/registrazione.php">Registrati</a></li>
			</ul>
		</div>
	</div>
	<div class="contenuto">
		<h1>Biblioteca Online</h1>
		<h2>Pagina di Login</h2>

		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<table class="tab_input">
				<tr>
					<td>Username:</td> <td><input type="text" name="username" value="<?php echo $username; ?>" required></td>
				</tr>
				<tr>
					<td>Password:</td> <td><input type="password" name="password" value="<?php /*echo $password; */?>" required></td>
				</tr>
                <tr>
                    <td colspan="2" style="text-align: center">
                        Utente <input type="radio" name="tipologia" value="utenti" checked>
                        Bibliotecario <input type="radio" name="tipologia" value="bibliotecari">
                    </td>
                </tr>
			</table>
			<p><input type="submit" value="Accedi"></p>
		</form>
		<?php
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				if( empty($_POST["username"]) or empty($_POST["password"])) {
					echo "<p>Campi lasciati vuoti</p>";
				} else {
					$conn = new mysqli($db_servername,$db_username,$db_password,$db_name);
					if($conn->connect_error){
						die("<p>Connessione al server non riuscita: ".$conn->connect_error."</p>");
					}
					//echo "connessione riuscita";
					
                    $tabella = $_POST["tipologia"];
					
					$myquery = "SELECT username, password 
								FROM $tabella 
								WHERE username='$username'
									AND password='$password'";

					$ris = $conn->query($myquery) or die("<p>Query fallita! ".$conn->error."</p>");

					if($ris->num_rows == 0){
						echo "<p>Utente non trovato o password errata</p>";
						$conn->close();
					} 
					else {
						$_SESSION["username"]=$username;
                        $_SESSION["tipologia"]=$_POST["tipologia"];
												
						$conn->close();
						header("location: pagine/home.php");

					}

					/*
					// Versione con l'uso dell'hash

					$myquery = "SELECT username, password 
								FROM $tabella 
								WHERE username='$username'";

					$ris = $conn->query($myquery) or die("<p>Query fallita! ".$conn->error."</p>");

					if($ris->num_rows == 0 or password_verify($password, $ris->fetch_assoc()['password'])){
						echo "<p>Utente non trovato o password errata</p>";
						$conn->close();
					} 
					else {
						$_SESSION["username"]=$username;
                        $_SESSION["tipologia"]=$_POST["tipologia"];
												
						$conn->close();
						header("location: pagine/home.php");
					}
					*/

				}
			}
			?>	
	</div>
	<!-- <div class="footer">
		<em>"Biblioteca Online"</em>, esempio di sito dinamico in PHP realizzato da Francesco Tormene
	</div> -->
	<?php 
		include('pagine/footer.php')
	?>
</body>
</html>