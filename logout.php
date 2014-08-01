<?php 
	// Ripristino la sessione
	session_start();
	// Chiudo la sessione
	session_destroy();
	// Redirect verso index.php
	header("Location: index.php");
	exit();
?>