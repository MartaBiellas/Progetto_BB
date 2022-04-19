<?php
	session_start();
	//echo session_id();

	require('../data/dati_connessione_db.php');

	if(isset($_GET['classe']) && !empty($_GET['classe'])){ 
		
		$stringa = urldecode ($_GET['classe']);

		$chiavi = explode("_",$stringa);

		$anno = intval($chiavi[0]);

		$_SESSION['anno']=$anno;

		$sezione = $chiavi[1];

		$_SESSION['sezione']=$sezione;
	
	}else{
		$anno= $_SESSION['anno'];
		$sezione=$_SESSION['sezione'];
	}

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
			echo '<p>Classe: <b>'.$riga["anno"].' '.$riga["sezione"].'</b><br></p>';
			
		?>
        </h1>
	</div>
	
	
	<div class="contenuto">
		<?php
			$sql = "
            SELECT *
            FROM alunno
            WHERE alunno.sezione= '$sezione' AND alunno.anno = '$anno'";

			$ris = $conn->query($sql) or die("<p>Query fallita!</p>");
           
			while($riga = $ris->fetch_assoc()){
				echo "<br><p><b>".$riga["nome"]." ".$riga["cognome"]."</b></p>";	
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