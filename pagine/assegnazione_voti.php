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
	<br>
	<br>
	
	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="input-group">
            <label> Nome </label>
            <input type="text" name="nome" <?php echo "value = '$nome'" ?> required>
        </div>       
        <div class="input-group">
            <label> Cognome </label>
            <input type="password" name="cognome" <?php echo "value = '$cognome'" ?> required>
        </div>
		<table id="tab_index">
				<tr>
					<td width = "50%" >Orale <input type="radio" name="tipologia" value="alunno" checked> </td> 
					<td width = "50%" >Scritto <input type="radio" name="tipologia" value="alunno"></td> 
				</tr>
		</table>
		
		<div class="input-group">
            <button type="submit" name="login" class="btn"> assegna voto </button>
        </div>

    </form>

        <p>
        <?php
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				if( empty($_POST["email"]) or empty($_POST["password"])) {
					echo "<p>Campi lasciati vuoti</p>";
				} else {
					$conn = new mysqli($db_servername,$db_username,$db_password,$db_name);
					if($conn->connect_error){
						die("<p>Connessione al server non riuscita: ".$conn->connect_error."</p>");
					}
					//echo "connessione riuscita";
					
                    $tabella = $_SESSION["tipologia"];
                    
                        $myquery = "SELECT email, password 
                        FROM $tabella 
                        WHERE email='$email'
                            AND password='$password'";

                        $ris = $conn->query($myquery) or die("<p>Query fallita! ".$conn->error."</p>");

                        if($ris->num_rows == 0){
                            echo '<p div class = "error">Attenzione: utente non trovato o password errata!</p>';
                            $conn->close();
                        } else {
                            $_SESSION["email"]=$email;
                                                    
                            $conn->close();
                            header("location: home_professore.php");
                        }   
                    }
				}
			?>	
        </p>
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