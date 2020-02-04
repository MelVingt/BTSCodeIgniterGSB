<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
</head>
<body>
<center>
	<div style = "border-radius : 100px; background : white; width : 33%; padding : 3px;">
		<h2>Conférence(s) de <?php echo $nom.' '.$prenom; ?></h2>
	</div>
	<table border="1">
		<tr>
			<td><b>Nom thème</b></td>
			<td><b>Durée</b></td>
			<td><b>Date</b></td>
			<td><b>Heure</b></td>
			<td><b>Salle</b></td>
			<td><b>Nombre de place</b></td>
			<td><b>Animateur</b></td>
			<td><b>Place dispo.</b></td>
			<td><b>Réserver</b></td>
		</tr>
		<?php echo br(2);?>
		<?php echo $tableau;?>
	</table>
</center>