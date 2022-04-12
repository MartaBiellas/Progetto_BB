<?php
	session_start();
	//echo session_id();

	require('../data/dati_connessione_db.php');

	if(!isset($_SESSION['email'])){
		header('location: ../index.php');
	}
	if( $_SESSION["tipologia"]!="professore"){
	    header('location: logout.php');
	}

	$username = $_SESSION["email"];
	//echo $username;

	$conn = new mysqli($db_servername,$db_username,$db_password,$db_name);
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$libri = isset($_POST['cod_libri_riconsegnati']) ? $_POST['cod_libri_riconsegnati'] : array();
		foreach($libri as $libro) {
  			//echo $libro . '<br/>';
  			$sql = "UPDATE libri
  					SET username_utente = NULL
  					WHERE cod_libro = '".$libro."'";
			$conn->query($sql) or die("<p>Query fallita!</p>");
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<title>Biblioteca - Riconsegna</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
	<div class="nav">
		<div class="centratonav">
			<ul class="navlinks">
				<li><a href="home_professore.php">Home Classi</a></li>
				<li><a href="dati_professore.php">Dati personali</a></li>
				<!-- <li><a href="ritira.php">Ritira</a></li> -->
				<!-- <li id="active">assegna voti</li> -->
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
	</div>
	<div class="contenuto">
		<h1 style="text-align: center; margin-top: 0px">Pagina personale</h1>
		<p>Seleziona i libri da riconsegnare</p>

		<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
			<table id="tabella_selezione_libri">
				<?php
					$sql = "SELECT libri.cod_libro, libri.titolo, autori.nome, autori.cognome 
							FROM utenti JOIN libri ON utenti.username = libri.username_utente 
										JOIN autori ON libri.cod_autore = autori.cod_autore  
							WHERE username='".$username."'";
					$ris = $conn->query($sql) or die("<p>Query fallita!</p>");
					foreach($ris as $riga){
						echo "
							<tr>
								<td> 
									<input type='checkbox' name='cod_libri_riconsegnati[]' value='".$riga["cod_libro"]."'/>
										".$riga["titolo"]." - ".$riga["nome"]." ".$riga["cognome"]."
								</td>
							</tr>";
					}
				?>
				<tr>
					<td style="text-align: center; padding-top: 10px"><input type="submit" value="Conferma"/></td>
				</tr>
			</table>
		</form>	
	</div>
	<?php 
		include('footer.php')
	?>	
</body>
</html>
<?php
	$conn->close();
?>