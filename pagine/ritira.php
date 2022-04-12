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
	
	$username = $_SESSION["alunno"];
	//echo $username;

	$conn = new mysqli($db_servername,$db_username,$db_password,$db_name);
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$libri = isset($_POST['cod_libri']) ? $_POST['cod_libri'] : array();
		foreach($libri as $libro) {
  			//echo $libro . '<br/>';
  			$sql = "UPDATE libri
  					SET username_utente = '".$username."'
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
	<title>Biblioteca - Ritira</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
	<div class="nav">
		<div class="centratonav">
			<ul class="navlinks">
				<li><a href="home_personale.php">Home</a></li>
				<li><a href="dati_professore.php">Dati personali</a></li>
				<li id="active">Ritira</li>
				<li><a href="riconsegna.php">Riconsegna</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
	</div>
	<div class="contenuto">
		<h1 style="text-align: center; margin-top: 0px">Ricerca e ritiro dei libri</h1>
		<p>Cerca il libro che vuoi ritirare</p>
		<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
			<table id="tab_dati_personali">
				<tr>
					<td>Titolo:</td> <td><input class="input_ricerca" type="text" name="titolo_libro" value="<?php echo isset($_POST['titolo_libro']) ? $_POST['titolo_libro'] : ''; ?>"></td>
				</tr>
				<tr>
					<td>Nome autore:</td> <td><input class="input_ricerca" type="text" name="nome_autore" value="<?php echo isset($_POST['nome_autore']) ? $_POST['nome_autore'] : ''; ?>"></td>
				</tr>
				<tr>
					<td>Cognome autore:</td> <td><input class="input_ricerca" type="text" name="cognome_autore" value="<?php echo isset($_POST['cognome_autore']) ? $_POST['cognome_autore'] : ''; ?>"></td>
				</tr>
				<tr>
					<td style="text-align: center; padding-top: 10px" colspan="2"><input type="submit" value="Cerca"/></td>
				</tr>
			</table>
		</form>

		<p></p>

		<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
			
				<?php
					if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["titolo_libro"]) and isset($_POST["nome_autore"]) and isset($_POST["cognome_autore"])) {
						$titolo = $_POST["titolo_libro"];
						$nome = $_POST["nome_autore"];
						$cognome = $_POST["cognome_autore"];


						$sql = "SELECT libri.cod_libro, libri.titolo, autori.nome, autori.cognome, libri.username_utente 
								FROM libri JOIN autori ON libri.cod_autore = autori.cod_autore  
								WHERE titolo LIKE '%$titolo%'
									AND nome LIKE '%$nome%'
									AND cognome LIKE '%$cognome%'";
						//echo $_POST["titolo_da_cercare"];
						$ris = $conn->query($sql) or die("<p>Query fallita!</p>");
						if ($ris->num_rows > 0) {
							echo "<p>Scegli tra le soluzioni trovate i libri da ritirare.</p>";
							echo "<table id='tabella_selezione_libri'>";
							echo "<tr> <th></th> <th>Titolo</th> <th>Autore</th> <th>Disponibile</th> </tr>";
						
							foreach($ris as $riga){
								if ($riga["username_utente"]){
									$preso = "disabled";
									$disponibile = "No";
								}
								else {
									$preso = "";
									$disponibile = "Sì"; 
								}
								$cod_libro = $riga["cod_libro"];
								$titolo = $riga["titolo"];
								$nome = $riga["nome"];
								$cognome = $riga["cognome"];
								
								echo "
									<tr>
										<td><input type='checkbox' name='cod_libri[]' value='$cod_libro' $preso/></td>
										<td>$titolo</td>
										<td>$nome $cognome</td>
										<td>$disponibile</td>
									</tr>";
							}
						}
						echo "</table>";
					}
	
				?>
				<p style="text-align: center; padding-top: 10px"><input type="submit" value="Conferma"/></p>
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