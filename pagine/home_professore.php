<?php
session_start();
//echo session_id();

require('../data/dati_connessione_db.php');

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
	<link rel="stylesheet" type="text/css" href="../stilee.css">
</head>

<body>
	<div class="nav">
		<div class="centratonav">
			<ul class="navlinks">
				<li id="active">Home</li>
				<li><a href="dati_professore.php">Dati Personali</a></li>
				<!-- <li><a href="ritira.php">Ritira</a></li> -->
				<!-- <li><a href="riconsegna.php">Riconsegna</a></li> -->
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
	</div>

	<div class="contenuto-altro">
		<h1 style="text-align: center; margin-top: 0px">ELENCO CLASSI PROFESSORE</h1>
	</div>


	<div class="contenuto">
		<?php
		$sql = "
			SELECT *
			FROM professore
			WHERE professore.email ='" . $email . "'";

		$ris = $conn->query($sql) or die("<p>Query fallita!</p>");

		$riga = $ris->fetch_assoc();
		echo "<p>Benvenuto <b>" . $riga["nome"] . " " . $riga["cognome"] . "</b><br></p>";

		$sql = "
			SELECT *
			FROM insegna_in JOIN professore ON insegna_in.matricola_professore = professore.matricola
			WHERE professore.email ='" . $email . "'";
		//echo $sql;

		$ris = $conn->query($sql) or die("<p>Query fallita!</p>");
		while ($riga = $ris->fetch_assoc()) {
			echo '<a href="./elenco.php?classe=' . $riga["anno"] . '_' . $riga["sezione"] . '"><br><p><b>' . $riga["anno"] . ' ' . $riga["sezione"] . '</b></p></a>';
		}
		?>

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