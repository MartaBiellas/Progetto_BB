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
	$email = $_SESSION["email"];
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
    <title>Professore - Home Professore</title>
	<link rel="stylesheet" type="text/css" href="../stilee.css">
</head>
<body>
	<div class="nav">
		<div class="centratonav">
			<ul class="navlinks">
				<li id="active">Home</li>
				<li><a href="dati_professore.php">Profilo</a></li>
				<!-- <li><a href="ritira.php">Ritira</a></li> -->
				<!-- <li><a href="riconsegna.php">Riconsegna</a></li> -->
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
	</div>
	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
	<div class="contenuto-altro">
		<h1 style="text-align: center; margin-top: 0px">ELENCO CLASSI PROFESSORE</h1>
	</div>
	
	<div class="contenuto">
		<?php
			$sql = "SELECT email, nome, cognome 
					FROM alunno 
					WHERE email='".$email."'";
			//echo $sql;
			$ris = $conn->query($sql) or die("<p>Query fallita!</p>");
			foreach($ris as $riga){
				echo "<p>Benvenuto <b>".$riga["nome"]." ".$riga["cognome"]."</b></p>";
			}

		?>
		
	</div>
	<?php 
		include('footer.php')
	?>
</body>
</html>
<?php
	$conn->close();
?>