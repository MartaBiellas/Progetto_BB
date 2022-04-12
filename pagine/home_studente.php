<?php
    session_start();
    //echo session_id();
    require_once('../data/dati_connessione_db.php');
    if(!isset($_SESSION['email'])){
        header('location: ../index.php');
    }
    if( $_SESSION["tipologia"]!="alunno"){
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
    <title>Profilo</title>
    <link rel="stylesheet" type="text/css" href="../stile.css">
</head>
<body>
    <div class="nav">
        <div class="centratonav">
            <ul class="navlinks">
                <li id="active">Home</li>
                <li><a href="dati_studente.php">Profilo studente</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="contenuto">
        <h1 style="text-align: center; margin-top: 0px">VOTI DI</h1>
        <?php
            $conn = new mysqli($db_servername,$db_username,$db_password,$db_name);
            if($conn->connect_error){
                die("<p>Connessione al server non riuscita: ".$conn->connect_error."</p>");
            }
            $sql = "SELECT email, nome, cognome 
                    FROM alunno 
                    WHERE email='$email'";
            //echo $sql;
            $ris = $conn->query($sql) or die("<p>Query fallita!</p>");
            foreach($ris as $riga){
                echo "<p><b>".$riga["nome"]." ".$riga["cognome"]."</b></p>";
            }
        ?>
       <div class="elenco_libri">
            <h2>Voti</h2>
            <?php
                $sql = "SELECT voto.valutazione, voto.tipo, voto.data, voto.materia 
                        FROM alunno JOIN voto ON alunno.matricola = voto.matricola_alunno  
                        WHERE email='$email'";   
                $ris = $conn->query($sql) or die("<p>Query fallita!</p>");
                if ($ris->num_rows == 0) {
                    echo "<p style='text-align:center'>Nessuno";
                }
            ?>
            <ol>
                <?php
                    foreach($ris as $riga){
                        echo "
                            <li>";
                                echo $riga["valutazione"]." - ".$riga["tipo"]." ".$riga["data"]." ".$riga["materia"]."
                            </li>";
                        }
                ?>      
            </ol>
        </div>
            
    </div>
    <?php 
	    include('footer.php');
    ?>  
    
</body>
</html>
<?php
    $conn->close();
?>