<?php
session_start();
//echo session_id();

if (!isset($_SESSION['email'])) {
	header('location: ../index.php');
}
if ($_SESSION["tipologia"] != "professore") {
	header('location: logout.php');
}
$email = $_SESSION["email"];
//echo $username;
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
				<li><a href="home_professore.php">Home</a></li>
				<li><a href="elenco.php">Elenco studenti</a></li>
				<li id="active">Assegnazione voti</li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
	</div>
	<br>
	<br>

	<div class="utile reveal">
	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
		<div class="input-group">
			<label> Nome </label>
			<input type="text" name="nome" required>
		</div>
		<div class="input-group">
			<label> Cognome </label>
			<input type="text" name="cognome" required>
		</div>
		<div class="input-group">
			<label> Voto </label>
			<input type="number" min="2" max="10" name="voto" required>
		</div>
		<table id="tab_index">
			<tr>
				<td width="50%">Orale <input type="radio" name="tipologia" value="Orale" checked> </td>
				<td width="50%">Scritto <input type="radio" name="tipologia" value="Scritto"></td>
			</tr>
		</table>

		<div class="input-group">
			<button type="submit" name="login" class="btn"> assegna voto </button>
		</div>

	</form>

	<p>
		<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST["nome"]) or empty($_POST["cognome"])) {
				echo "<p>Campi lasciati vuoti</p>";
			} else {
				require('../data/dati_connessione_db.php');
				$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
				if ($conn->connect_error) {
					die("<p>Connessione al server non riuscita: " . $conn->connect_error . "</p>");
				}
				//echo "connessione riuscita";


				$myquery = "
						SELECT * 
                        FROM professore 
                        WHERE email='$email'";

				$ris = $conn->query($myquery) or die("<p>Query fallita! " . $conn->error . "</p>");

				$professore = $ris->fetch_assoc();

				$nome = $_POST['nome'];

				$cognome = $_POST['cognome'];

				$myquery = "
						SELECT *
						FROM alunno
						WHERE nome = '$nome' AND cognome='$cognome'";

				$ris = $conn->query($myquery) or die("<p>Query fallita! " . $conn->error . "</p>");

				$alunno = $ris->fetch_assoc();

				$myquery = "
						INSERT INTO voto (materia, data, tipo, valutazione, matricola_alunno, matricola_professore)

						VALUES ('" . $professore['materia'] . "','" . date("Y-m-d", time()) . "','" . $_POST['tipologia'] . "', '" . $_POST['voto'] . "', '" . $alunno['matricola'] . "', '" . $professore['matricola'] . "')

						";

				$conn->query('SET FOREIGN_KEY_CHECKS=0;');

				$conn->query($myquery) or die("<p>Query fallita! " . $conn->error . "</p>");

				$conn->query('SET FOREIGN_KEY_CHECKS=1;');

				$conn->close();
			}
		}
		?>
	</p>
	</div>
	<br>
	<br>
	<?php
	include('footer.php')
	?>
</body>

</html>