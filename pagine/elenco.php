<?php
session_start();
//echo session_id();

require('../data/dati_connessione_db.php');

if (isset($_GET['classe']) && !empty($_GET['classe'])) {

	$stringa = urldecode($_GET['classe']);

	$chiavi = explode("_", $stringa);

	$anno = intval($chiavi[0]);

	$_SESSION['anno'] = $anno;

	$sezione = $chiavi[1];

	$_SESSION['sezione'] = $sezione;
} else {
	$anno = $_SESSION['anno'];
	$sezione = $_SESSION['sezione'];
}

if (!isset($_SESSION['email'])) {
	header('location: ../index.php');
}
if ($_SESSION["tipologia"] != "professore") {
	header('location: logout.php');
}
$email = $_SESSION["email"];
//echo $username;

$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<title>Professore - Home Professore</title>
	<link rel="stylesheet" type="text/css" href="../stile.css">
</head>

<body>
	<div class="nav">
		<div class="centratonav">
			<ul class="navlinks">
				<li><a href="home_professore.php">Home</a></li>
				<li id="active">Elenco studenti</li>
				<li><a href="assegnazione_voti.php">Assegnazione voti</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
	</div>
	<div class="contenuto-altro">
		<h1 style="text-align: center; margin-top: 0px">
			<?php
			$sql = "
            SELECT *
            FROM classe
            WHERE classe.sezione= '$sezione' AND classe.anno = '$anno'";

			$ris = $conn->query($sql) or die("<p>Query fallita!</p>");

			$riga = $ris->fetch_assoc();
			echo '<p>Classe: <b>' . $riga["anno"] . ' ' . $riga["sezione"] . '</b><br></p>';

			?>
		</h1>
	</div>


	<div class="contenuto">
		<div class="elenco_voti">
			<table id="tab_dati_personali">

				<?php

				$sql = "
					SELECT *
					FROM alunno
					WHERE alunno.sezione= '$sezione' AND alunno.anno = '$anno'";

				$dati_studenti = $conn->query($sql) or die("<p>Query fallita!</p>");

				$sql = "
					SELECT *
					FROM professore
					WHERE professore.email = '$email'";

				$dati_professore = $conn->query($sql) or die("<p>Query fallita!</p>");

				$dati_professore = $dati_professore->fetch_assoc();

				$incremento = 0;

				while ($riga = $dati_studenti->fetch_assoc()) {

					$sql = "SELECT * 
								FROM voto 
								WHERE matricola_alunno ='$riga[matricola]' AND matricola_professore ='$dati_professore[matricola]'";

					$ris1 = $conn->query($sql) or die("<p>Query fallita!</p>");

					echo '<td>';
					echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
								<script>
								$(document).ready(function(){
									$("#menuButton' . $incremento . '").click(function(){
									$("#menu' . $incremento . '").slideToggle();
									}); 
								});
								</script>';

					$sql = "SELECT AVG(valutazione) AS media
								FROM voto
								WHERE matricola_alunno ='$riga[matricola]' AND matricola_professore ='$dati_professore[matricola]'";

					$ris2 = $conn->query($sql) or die("<p>Query fallita!</p>");

					$tmp = $ris2->fetch_assoc();
					echo '<br>';
					echo "<tr><td><b>" . $riga["nome"] . ' ' . $riga["cognome"] . " </td>";
					echo '<tr><td><button id="menuButton' . $incremento . '"  class = btn1> ' . $tmp["media"] . ' </button>';
					echo '<div id="menu' . $incremento . '" style="display:none;">';
					if ($ris1->num_rows == 0) {
						echo '<p> Nessuno </p>';
					} else {
						echo '<ul><br>';
						while ($riga = $ris1->fetch_assoc()) {
							echo '<li>';
							echo $riga["data"] . " - " . $riga["tipo"] . ":<b> " . $riga["valutazione"] . "</b>";
							echo '</li>';
						}
						echo '</ul>';
					}
					echo '</td>';
					echo '</tr>';

					$incremento = $incremento + 1;

					$ris1 = null;
					$ris2 = null;
					echo "</div>";
				}

				?>

			</table>
		</div>
	</div>

	<br>
	<br>

	<?php
	include('footer.php')
	?>

</body>

</html>

<?php
$conn->close();
?>