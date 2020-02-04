<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/style.css">
<center>
	<div style = "border-radius : 100px; background : white; width : 30%; padding : 10px;">
		<img src="<?php echo base_url(); ?>image/logo-gsb.png">
	</div>
</center>
<?php echo br(2) ?>
<div style = "margin: auto; width: 660px">
	<ul id="menu">
		<li><a href="conferenceBis">Les conférences</a></li>
		<li><a href="mesConf">Mes conférences</a></li>
		<li><a href="deconnexion">Se déconnecter </a></li>
	</ul>
</div>
<?php
	echo br(4);
	if (!empty($visiteur)) {
		foreach ($visiteur as $row){
			$nom = $row->nom;
			$prenom = $row->prenom ;
		}
?>
<!-- on affiche le nom et le prénom mdu visiteur ainsi que le nombre de conférence auxquelles il participe -->
<div class = "bienvenue">
	<h3><font color= "white">Bienvenue <?php echo $nom." ".$prenom; ?>, vous êtes inscrit dans <?php echo $nbIns; ?> conférence<?php if($nbIns > 1) {?>s<?php } ?></font></h3>
</div>
<?php
	}
	 echo br(1);
?>