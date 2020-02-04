<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
</head>
<body>
<?php echo br(5);
 foreach ($vis as $row){
			$nom = $row->nom;
			$prenom = $row->prenom ;
}?>
<h2 align = "center ">Conférences de : <?php echo $nom.' '.$prenom ; ?></h2>
<?php echo br(5) ?>
<table>
	<tr>
		<td><b>Nom thème</b></td>
		<td><b>Durée</b></td>
		<td><b>Date</b></td>
		<td><b>Heure</b></td>
		<td><b>Salle</b></td>
		<td><b>Nombre de place</b></td>
		<td><b>Animateur</b></td>
	</tr>
	<?php echo $tableau;?>
</table>
</center>
