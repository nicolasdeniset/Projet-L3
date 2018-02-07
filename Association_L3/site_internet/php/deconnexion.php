<?php
session_start();
	echo '<DOCTYPE HTML>',
	'<HTML>',
	'<head> 
		<title>Deconnexion</title>',
	'</head>',
	'<body>';	
	session_unset();
	session_destroy();
	header('location: accueil.php');
	exit();
	echo '<body>',
		'<html>';
?>
