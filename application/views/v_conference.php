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
			<h1>Les conférences</h1>
		</div>
	</center>
	<br>
	<center>
		<table border="1">
			<tr>
				<td><b>Nom thème</b></td>
				<td><b>Durée</b></td>
				<td><b>Date</b></td>
				<td><b>Heure</b></td>
				<td><b>Salle</b></td>
				<td><b>Nombre de places</b></td>
				<td><b>Animateur</b></td>
				<td><b>Place dispo.</b></td>
				<td><b>Réserver</b></td>
			</tr>
			<?php
			echo $tableau;
	echo "</center>";
			if (!empty($message)){
				echo $message;
				echo br(2);
			}
			?>
	<center>
		</table>
		<br></br>
		<h2><font  color= "white">Rechercher les conférences par animateur</font></h2>
		<form method="post" action="confAnni">
		<div class="dropdown">
			<select class = "dropdown-select" name="idAnni" />
			<?php foreach ($anni as $conf){
					$id = $conf->id;?>
				<option value="<?php echo $id ?>"><?php echo $conf->nom.' '.$conf->prenom;?></option>
			<?php } ?>      
			</select>
		</div>
		<button type="hidden" type="submit" class="btn btn-primary btn-block btn-large">Valider</button>
		</form>
	</center>
	
	