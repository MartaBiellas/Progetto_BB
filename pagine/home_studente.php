<?php
    session_start();
    //echo session_id();
    require_once('../data/dati_connessione_db.php');
    if(!isset($_SESSION['username'])){
        header('location: ../index.php');
    }
    if( $_SESSION["tipologia"]!="utenti"){
        header('location: logout.php');
    }
    $username = $_SESSION["username"];
    //echo $username;
    
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Biblioteca - Home Personale</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div class="nav">
        <div class="centratonav">
            <ul class="navlinks">
                <li id="active">Home</li>
                <li><a href="dati_personali.php">Dati personali</a></li>
                <li><a href="ritira.php">Ritira</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="contenuto">
        <h1 style="text-align: center; margin-top: 0px">Pagina personale</h1>
        <?php
            $conn = new mysqli($db_servername,$db_username,$db_password,$db_name);
            if($conn->connect_error){
                die("<p>Connessione al server non riuscita: ".$conn->connect_error."</p>");
            }
            $sql = "SELECT username, nome, cognome 
                    FROM utenti 
                    WHERE username='$username'";
            //echo $sql;
            $ris = $conn->query($sql) or die("<p>Query fallita!</p>");
            foreach($ris as $riga){
                echo "<p>Benvenuto <b>".$riga["nome"]." ".$riga["cognome"]."</b></p>";
            }
        ?>
        <div class="elenco_libri">
            <h2>Libri presi in prestito</h2>
            <?php
                $sql = "SELECT libri.titolo, autori.nome, autori.cognome 
                        FROM utenti JOIN libri ON utenti.username = libri.username_utente 
                                    JOIN autori ON libri.cod_autore = autori.cod_autore  
                        WHERE username='$username'";
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
                                echo $riga["titolo"]." - ".$riga["nome"]." ".$riga["cognome"]."
                            </li>";
                        }
                ?>      
            </ol>
        </div>
            
    </div>
    <?php 
        include('footer.php')
    ?>  
    
</body>
</html>
<?php
    $conn->close();
?>