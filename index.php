<?php
session_start();
//echo session_id();

require('data/dati_connessione_db.php');

if (isset($_SESSION['email'])) {
	header('location: pagine/home.php');
}

if (isset($_POST["email"])) {
	$email = $_POST["email"];
} else {
	$email = "";
}

if (isset($_POST["password"])) {
	$password = $_POST["password"];
} else {
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
	<title>Registro</title>
	<link rel="stylesheet" type="text/css" href="stile.css">
</head>

<body>

	<div class="utile reveal">
		<div class="header">
			<h1>Benvenuto nel tuo registro elettronico!</h1>
			<h2>Sei uno studente o un professore?</h2>
			<br>
		</div>

		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<table id="tab_index">
				<tr>
					<td width="50%">Studente <input type="radio" name="tipologia" value="alunno" checked> </td>
					<td width="50%">Professore <input type="radio" name="tipologia" value="professore"></td>
				</tr>
				<tr>
					<td width="50%"><img width="100%" src="./img/studenti.jpg"></td>
					<td width="50%"><img width="100%" src="./img/prof.jpg"></td>
				</tr>
			</table>

			<div class="input-group">
				<button type="submit" value="Avanti" class="btn"> AVANTI </button>
			</div>
		</form>
	</div>

	<div class="contenuto reveal">
		<img src="./img/onda_sdf_grigia.png">

		<?php
		if (isset($_POST["tipologia"])) {
			$tabella = $_POST["tipologia"];
			$_SESSION["tipologia"] = $_POST["tipologia"];

			if ($_POST["tipologia"] == "alunno") {
				header('location: pagine/login_studente.php');
			}
			if ($_POST["tipologia"] == "professore") {
				header('location: pagine/login_professore.php');
			}
		}
		?>
	</div>

	<?php
	include('pagine/footer.php')
	?>

</body>

</html>