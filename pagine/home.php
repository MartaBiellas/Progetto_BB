<?php
	session_start();
	if(!isset($_SESSION['email'])){
		header('location: ../index.php');
	}
	if($_SESSION["tipologia"]=="alunno"){
		header('location: home_studente.php');
	}
	if($_SESSION["tipologia"]=="professore"){
		header('location: home_professore.php');
	}
?>