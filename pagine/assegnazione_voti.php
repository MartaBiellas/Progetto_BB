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
				<li><a href="home_professore.php">Home</a></li>
				<li><a href="elenco.php">Elenco studenti</a></li>
                <li id="active">Assegnazione voti</li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
	</div>
	
	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<table id="tab_index">
				<tr>
					<td>Nome:</td> <td><input type="text" name="nome" value="<?php echo $nome; ?>" required></td>
				</tr>
				<tr>
					<td>Password:</td> <td><input type="text" name="cognome" value="<?php echo $cognome; ?>" required></td>
				</tr>
				<tr>
					<td width = "50%" >Orale <input type="radio" name="tipologia" value="alunno" checked> </td> 
					<td width = "50%" >Scritto <input type="radio" name="tipologia" value="professore"></td> 
				</tr>
			</table>

		<div class="input-group">
            <button type="submit" value="Avanti" class="btn"> assegna voto </button>
		</div>
		</form>


		<?php
            if(isset($_POST["tipologia"])){
				$tabella = $_POST["tipologia"];
				$_SESSION["tipologia"]=$_POST["tipologia"];

				if($_POST["tipologia"]=="alunno"){
					header('location: pagine/login_studente.php');
				}
				if($_POST["tipologia"]=="professore"){
					header('location: pagine/login_professore.php');
				}
			}
		?>
		
	<?php 
		include('footer.php')
	?>
</body>
</html>
<?php
	$conn->close();
?>