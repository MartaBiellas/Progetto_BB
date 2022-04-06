<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header('location: ../index.php');
	}
	if($_SESSION["tipologia"]=="utenti"){
		header('location: home_personale.php');
	}
	if($_SESSION["tipologia"]=="bibliotecari"){
		header('location: home_bibliotecario.php');
	}
?>