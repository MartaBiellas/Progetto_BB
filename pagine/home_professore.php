<?php
	session_start();
	//echo session_id();

	require('../data/dati_connessione_db.php');

/* 	if(!isset($_SESSION['email'])){
		header('location: ../index.php');
	} 
	if( $_SESSION["tipologia"]!="bibliotecari"){
        header('location: logout.php');
    } */
	$username = $_SESSION["username"];
	//echo $username;
	
	$conn = new mysqli($db_servername,$db_username,$db_password,$db_name);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Biblioteca - Home Bibliotecario</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
	<div class="nav">
		<div class="centratonav">
			<ul class="navlinks">
				<li id="active">Home</li>
				<li><a href="dati_personali.php">Dati personali</a></li>
				<li><a href="ritira.php">Ritira</a></li>
				<li><a href="riconsegna.php">Riconsegna</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
	</div>
	<div class="contenuto">
		<h1 style="text-align: center; margin-top: 0px">Home del Bibliotecario</h1>
		<?php
			$sql = "SELECT username, nome, cognome 
					FROM utenti 
					WHERE username='".$username."'";
			//echo $sql;
			$ris = $conn->query($sql) or die("<p>Query fallita!</p>");
			foreach($ris as $riga){
				echo "<p>Benvenuto <b>".$riga["nome"]." ".$riga["cognome"]."</b></p>";
			}
		?>
		<br>
		<br>
		<br>
		<br>
		<p>La sezione del bibliotecario non è stata sviluppata!</p>
	</div>
	<?php 
		include('footer.php')
	?>
</body>
</html>
<?php
	$conn->close();
?>