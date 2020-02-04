<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/style.css">
<center>
	<div style = "border-radius : 100px; background : white; width : 30%; padding : 20px;">
			<img src="<?php echo base_url(); ?>image/logo-gsb.png">
	</div>
</center>
<center>
<?php	
echo br(3);

	echo'<fieldset>';
	echo validation_errors();
	echo form_open('moncontroleur/connexion');
	
	echo form_label("Login : ","", 'class = "label"');
	echo form_input('login', set_value('login'), 'class = "input2"');
	echo br(2);
	echo form_label("mot de passe : ","", 'class = "label"');
	echo form_password('pass',set_value('pass'), 'class = "input2"');
	echo br(2);
	echo form_submit('button','APPUYEZ POUR ENVOYER', 'class = "input"');
	
	echo form_close();
	echo'</fieldset>';
	
	if (!empty($message)){
		echo br(2);
		echo $message;
	}
?>
</center>