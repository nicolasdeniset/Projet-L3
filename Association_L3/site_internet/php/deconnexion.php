<?php
	ob_start();
	session_start();
	echo '<DOCTYPE HTML>',
	'<HTML>',
	'<head> 
		<title>Deconnexion</title>',
	'</head>',
	'<body>',
	'<body>',
		'<html>';
	session_unset();
	session_destroy();
	header('location: accueil.php');
	exit();
	ob_end_flush();
?>
