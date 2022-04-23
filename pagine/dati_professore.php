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
$modifica = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST["modifica"] == true) {
		$modifica = true;
	} else {
		$sql = "UPDATE professore
					SET password = '" . $_POST["password"] . "', 
						nome = '" . $_POST["nome"] . "', 
						cognome = '" . $_POST["cognome"] . "', 
						email = '" . $_POST["email"] . "', 
						data_nascita = '" . $_POST["data_nascita"] . "', 
						materia = '" . $_POST["materia"] . "' 
					WHERE email = '" . $email . "'";
		if ($conn->query($sql) === true) {
			//echo "Record updated successfully";
		} else {
			echo "Error updating record: " . $conn->error;
		}
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
	<title>Biblioteca - Dati personali</title>
	<link rel="stylesheet" type="text/css" href="../stile.css">
</head>

<body>
	<div class="nav">
		<div class="centratonav">
			<ul class="navlinks">
				<li><a href="home_professore.php">Home</a></li>
				<li id="active">Dati personali</li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
	</div>

	<div class="utile reveal">
		<div class="header">
			<img src="../img/profilo.jpg">
			<h1>PROFESSORE</h1>
		</div>

		<?php
		$sql = "SELECT email, password, nome, cognome, data_nascita, materia 
			FROM professore 
			WHERE email='" . $email . "'";
		//echo $sql;
		$ris = $conn->query($sql) or die("<p>Query fallita!</p>");
		$row = $ris->fetch_array(MYSQLI_ASSOC);
		?>
		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<table id="tab_dati_personali">
				<tr>
					<td>
						<div class="input-group"><label> Nome </label></div>
					</td>
					<td>
						<div class="input-group"><input type="text" name="nome" value="<?php echo $row["nome"]; ?>" <?php if (!$modifica) echo "disabled='disabled'" ?>></div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="input-group"><label> Cognome </label></div>
					</td>
					<td>
						<div class="input-group"><input type="text" name="cognome" value="<?php echo $row["cognome"]; ?>" <?php if (!$modifica) echo "disabled='disabled'" ?>></div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="input-group"><label> Email </label></div>
					</td>
					<td>
						<div class="input-group"><input type="text" name="email" value="<?php echo $row["email"]; ?>" <?php if (!$modifica) echo "disabled='disabled'" ?>></div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="input-group"><label> Password </label></div>
					</td>
					<td>
						<div class="input-group"><input type="text" name="password" value="<?php echo $row["password"]; ?>" <?php if (!$modifica) echo "disabled='disabled'" ?>></div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="input-group"><label> Data nascita </label></div>
					</td>
					<td>
						<div class="input-group"><input type="data" name="data_nascita" value="<?php echo $row["data_nascita"]; ?>" <?php if (!$modifica) echo "disabled='disabled'" ?>></div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="input-group"><label> Materia </label></div>
					</td>
					<td>
						<div class="input-group"><input type="text" name="materia" value="<?php echo $row["materia"]; ?>" <?php if (!$modifica) echo "disabled='disabled'" ?>></div>
					</td>
				</tr>
			</table>
			<p style="text-align: center">
				<br>
				<input class="hidden" type="text" name="modifica" value="<?php if ($modifica == false) echo 'true';
																			else echo ''; ?>">
				<input type="submit" class="btn" value="<?php if ($modifica == false) echo 'Modifica';
														else echo 'Conferma'; ?>">
			</p>
		</form>
	</div>
	<br><br>
	<?php
	include('footer.php')
	?>
</body>

</html>