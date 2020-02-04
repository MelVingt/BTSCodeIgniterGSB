<?php
defined('BASEPATH')OR exit('No direct script access allowed');
class MonControleur extends CI_Controller{
	public function index(){
        $this->load->model('modele');
		$this->load->view('connexion');
		
	}
	
	/**
	 * Vérifie les données entrées dans le formulaires et nous connecter ou non
	 
	*/
	public function connexion(){
		
		$this->load->model('modele');
		//pour le formulaire d'insertion
		$this->form_validation->set_rules('login', 'login', 'required');
		$this->form_validation->set_rules('pass', 'pass', 'required');
		if($this->form_validation->run() == FALSE){
			echo"erreur";
			$this->load->view('connexion');
		}
		else{
			$login = $this->input->post('login');
			$pass = $this->input->post('pass');
			$pass = md5($pass);
			$req = $this->modele->getVisiteur($login, $pass);
			$_SESSION['login'] = $login;
			foreach ($req as $row){
				$resul = $row->login;
			}
			if(!empty($resul)){
				$req = $this->modele->getVis($_SESSION['login']);
				foreach ($req as $row){
					$_SESSION['idVis'] = $row->id;
				}
				$this->conference("");			
			}
			else{
				$message = '<div class="message">';
				$message = $message."<center><font size = 3 face='Tahoma'> Erreur </font></center>";
				$message = $message.'</div>';
				$data['message'] = $message;
				$this->load->view('connexion', $data);
			}
		}
	}
	
	/**
	 * Permet de se déconnecter en détruisant les variables de session
	 
	*/
	public function deconnexion(){
		$_SESSION['login'] = NULL;
		$_SESSION['idVis'] = NULL;
		$this->load->view('connexion');
	}
	
	/**
	 * Vérifie si l'on peut s'inscrire a une conférence et nous y inscrit si on remplis les conditions
	 * Génère aussi un message d'erreur ou de confirmation
	 
	*/
	public function reserver(){
		$this->load->model('modele');
		$idConf =  $_POST['idconf'];
		$req = $this->modele->getVis($_SESSION['login']);
		foreach ($req as $row){
			$idVis = $row->id;
		}
		//vérifie si le visiteur a deja réserver ses conférences
		$req = $this->modele->getInscription($idConf,$idVis);
		foreach ($req as $row){
			$resul = $row->id;
		}
		
		if(empty ($resul)){
			$bool = $this->modele->inscription($idConf, $idVis);
			$message = "";
			if($bool == 1) {
				$message = '<div class="message">';
				$message = $message."<center><font size = 3 face='Tahoma'>Inscription réussie</font></center>";
				$message = $message.'</div>';
				$this->conference($message);
			}
			else {
				$message = '<div class="message">';
				$message = $message."<center><font size = 3 face='Tahoma'> Cette salle n'a plus de place disponible, ou bien elle a déja eu lieu : inscription impossible</font></center>";
				$message = $message.'</div>';
				
				$this->conference($message);
			}
		}
		else{
			$message = '<div class="message">';
			$message = $message."<center><font size = 3 face='Tahoma'> Vous êtes déjà inscrit pour cette conférence</font></center>";
			$message = $message.'</div>';
			$this->conference($message);
		}
		
	}
	
	/**
	 * Affiche toutes les conférences (en avoir 2 simplifiais la tâche)
	 
	*/
	public function conferenceBis(){ 
		$this->load->model('modele');
		$req = $this->modele->getConference();
		$chaine = $this->generTab($req);
		$anni = $this->modele->getAnnimateur();
		$vis = $this->modele->getVisid($_SESSION['idVis']);
		$nb = $this->modele->getNbInscription($_SESSION['idVis']);
		$data['visiteur'] = $vis;
		$data['anni'] = $anni;
		$data['tableau'] = $chaine;
		$data['nbIns'] = $nb;
		$this->load->view('v_menue', $data);
		$this->load->view('v_conference', $data);
	}
	
	/**
	 * Affiche toutes les conférences
	 
	*/
	public function conference($message){ 
		$this->load->model('modele');
		$req = $this->modele->getConference();
		$chaine = $this->generTab($req);
		$anni = $this->modele->getAnnimateur();
		$vis = $this->modele->getVisid($_SESSION['idVis']);
		$nb = $this->modele->getNbInscription($_SESSION['idVis']);
		$data['nbIns'] = $nb;
		$data['visiteur'] = $vis;
		$data['anni'] = $anni;
		$data['message'] = $message;
		$data['tableau'] = $chaine;
		$this->load->view('v_menue', $data);
		$this->load->view('v_conference', $data);
	}
	
	/**
	 * Affiche toutes les conférences de auxquelles l'utilisateur est inscrit
	 
	*/
	public function mesConf(){
		$message = '<div class="message">';
		$message = $message."<center><font size = 3 face='Tahoma'> Vous n'êtes inscrit dans aucune conférence</font></center>";
		$message = $message.'</div>';
		$this->load->model('modele');
		$log = $this->modele->getMesConf($_SESSION['idVis']);
		$vis = $this->modele->getVisid($_SESSION['idVis']);
		$nb = $this->modele->getNbInscription($_SESSION['idVis']);
		$chaine = "";
		foreach ($log as $conf){
		 $req = $this->modele->getMesConference($conf->id_conference);
		 $chaine = $chaine.$this->generTabMesConf($req);
		}
		$data['nbIns'] = $nb;
		$data['visiteur'] = $vis;
		$data['message'] = $message;
		$data['tableau'] = $chaine;
		
		$this->load->view('v_menue', $data);
		$this->load->view('v_mesConf', $data);	
	}
	
	/**
	 * Affiche toutes les conférence de l'animateur choisis par l'utilisateur
	 
	*/
	public function confAnni(){
		$this->load->model('modele');
		$idAnni =  $_POST['idAnni'];
		$id = $this->modele->getAnimateur($idAnni);
		foreach ($id as $idnp){
			$nom = $idnp->nom;
			$prenom = $idnp->prenom;
		}
		$data['nom'] = $nom;
		$data['prenom'] = $prenom;
		$message = '<div class="message">';
		$message = $message."<center><font size = 6 face='Tahoma'> Il ne possède aucune conférence</font></center>";
		$message = $message.'</div>';
		
		$this->load->view('v_menue');
		$idVis = $_SESSION['idVis'];
		$chaine = "";
		$log = $this->modele->getMesConferenceAnni($idAnni);
		foreach ($log as $conf){
		 $req = $this->modele->getMesConference($conf->id);
		 $chaine = $chaine.$this->generTabMesConfAnni($req);
		}
		
		$data['message'] = $message;
		$data['tableau'] = $chaine;
		$this->load->view('v_confAni', $data);	
	}

	/**
	 * Permet de se désinscrire d'une conférence
	 
	*/
	public function suppMesConf(){
		$this->load->model('modele');
		$idVis = $_SESSION['idVis'];
		$idConf =  $_POST['idconf'];
		$req = $this->modele->suppInscription($idVis,$idConf);
		$this->mesConf();
	}
	
	/**
	 * Paramètre et génère le pdf
	*/
	public function pdf()
	{ 
		//load mPDF library
		$this->load->model('modele');
		$this->load->view('v_menue');
		$idVis = $_SESSION['idVis'];
		$log = $this->modele->getMesConf($idVis);
		$chaine = "";
		foreach ($log as $conf){
		 $req = $this->modele->getMesConference($conf->id_conference);
		 $chaine = $chaine.$this->generTabMesConfpdf($req);
		}
		
		$vis = $this->modele->getVisid($idVis);
		$data['vis'] = $vis;		
		$data['tableau'] = $chaine;
		$this->load->library('m_pdf'); 
		//now pass the data//
		$html=$this->load->view('pdf',$data, true); //load the pdf.php by passing our data and get all data in $html varriable.
		$pdfFilePath ="webpreparations-".time().".pdf";		
		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		$stylesheet = '<style>'.file_get_contents(base_url().'css/style.css').'</style>';
		// apply external css
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		$pdf->Output($pdfFilePath, "D");
		exit;
	}

	/**
	 * Extrait les informations de la requête donné en paramètre pour générer un tableau en html
	 * contenant ces données
	 * Affiche toutes les conférences
	 
	 * @param $req
	 * @return le tableau en html sous forme de chaîne
	*/
	function generTab($req){ 
		$chaine = "";
		foreach ($req as $row){ //on récupère les informations de chaque conférences
			$idConf =$row->id; 
			$idtheme = $this->modele->getTheme($row->id_theme);
			foreach ($idtheme as $idthemerow){
				$libelleTheme = $idthemerow->libelleTheme;
				$dureeTheme = $idthemerow->duree;
			}
			$idsalle = $this->modele->getSalle($row->id_salle);
			foreach ($idsalle as $idsallerow){
				$idSalle = $idsallerow->id;
				$capaciteSalle = $idsallerow->capacite;
			}
			$idAnimateur = $this->modele->getAnimateur($row->id_animateur);
			foreach ($idAnimateur as $idanimateurrow){
				$nomAnimateur = $idanimateurrow->nom;
				$prenomAnimateur = $idanimateurrow->prenom;
			}
			$heureD = $row->heureD; 
			$dateConf = $row->dateConf; 
			$place = $row->placeDispo;
			//après avoir récupérer chaque informations ongénère le code html
			// qui produira un tableau contenant les différentes données
			$chaine = $chaine.'
			<form method="post" action="reserver">
				<tr>
					<input type="hidden" name="idconf" value="'.$idConf.'" />
					<td>'.$libelleTheme.'</td>
					<td>'.$dureeTheme.' minutes</td>
					<td>'.$dateConf.'</td>
					<td>'.$heureD.'</td>
					<td>'.$idSalle.'</td>
					<td>'.$capaciteSalle.'</td>
					<td>'.$nomAnimateur.' '.$prenomAnimateur.'</td>
					<td>'.$place.'</td>
					<td>
					<button type="hidden" type="submit">Réserver</button>
					</td>
				</tr>
			</form>';
		}
		return $chaine;
	}

	/**
	 * Extrait les informations de la requête donné en paramètre pour générer un tableau en html
	 * contenant ces données
	 * Affiche toutes les conférences auxquelles le visiteur connecté est inscrit
	 
	 * @param $req
	 * @return le tableau en html sous forme de chaîne
	*/
	function generTabMesConf($req){ 
		$chaine = "";
		foreach ($req as $row){ //on récupère les informations de chaque conférences
			$idConf =$row->id; 
			$idtheme = $this->modele->getTheme($row->id_theme);
			foreach ($idtheme as $idthemerow){
				$libelleTheme = $idthemerow->libelleTheme;
				$dureeTheme = $idthemerow->duree;
			}
			$idsalle = $this->modele->getSalle($row->id_salle);
			foreach ($idsalle as $idsallerow){
				$idSalle = $idsallerow->id;
				$capaciteSalle = $idsallerow->capacite;
			}
			$idAnimateur = $this->modele->getAnimateur($row->id_animateur);
			foreach ($idAnimateur as $idanimateurrow){
				$nomAnimateur = $idanimateurrow->nom;
				$prenomAnimateur = $idanimateurrow->prenom;
			}
			$heureD = $row->heureD; 
			$dateConf = $row->dateConf; 
			$place = $row->placeDispo;
			//après avoir récupérer chaque informations ongénère le code html
			// qui produira un tableau contenant les différentes données
			$chaine = $chaine.'
			<form method="post" action="suppMesConf">
				<tr>
					<input type="hidden" name="idconf" value="'.$idConf.'" />
					<td>'.$libelleTheme.'</td>
					<td>'.$dureeTheme.' minutes</td>
					<td>'.$dateConf.'</td>
					<td>'.$heureD.'</td>
					<td>'.$idSalle.'</td>
					<td>'.$capaciteSalle.'</td>
					<td>'.$nomAnimateur.' '.$prenomAnimateur.'</td>
					<td>'.$place.'</td>
					<td>
					<button type="hidden" type="submit" >Supprimer</button>
					</td>
				</tr>
			</form>';
		}
		return $chaine;
	}

	/**
	 * Extrait les informations de la requête donné en paramètre pour générer un tableau en html
	 * contenant ces données
	 * Affiche toutes les conférences donné par l'animateur choisis
	 
	 * @param $req
	 * @return le tableau en html sous forme de chaîne
	*/
	function generTabMesConfAnni($req){ 
		$chaine = "";
		foreach ($req as $row){ //on récupère les informations de chaque conférences
			$idConf =$row->id; 
			$idtheme = $this->modele->getTheme($row->id_theme);
			foreach ($idtheme as $idthemerow){
				$libelleTheme = $idthemerow->libelleTheme;
				$dureeTheme = $idthemerow->duree;
			}
			$idsalle = $this->modele->getSalle($row->id_salle);
			foreach ($idsalle as $idsallerow){
				$idSalle = $idsallerow->id;
				$capaciteSalle = $idsallerow->capacite;
			}
			$idAnimateur = $this->modele->getAnimateur($row->id_animateur);
			foreach ($idAnimateur as $idanimateurrow){
				$nomAnimateur = $idanimateurrow->nom;
				$prenomAnimateur = $idanimateurrow->prenom;
			}
			$heureD = $row->heureD; 
			$dateConf = $row->dateConf; 
			$place = $row->placeDispo;
			//après avoir récupérer chaque informations ongénère le code html
			// qui produira un tableau contenant les différentes données
			$chaine = $chaine.'
			<form method="post" action="reserver">
				<tr>
					<input type="hidden" name="idconf" value="'.$idConf.'" />
					<td>'.$libelleTheme.'</td>
					<td>'.$dureeTheme.' minutes</td>
					<td>'.$dateConf.'</td>
					<td>'.$heureD.'</td>
					<td>'.$idSalle.'</td>
					<td>'.$capaciteSalle.'</td>
					<td>'.$nomAnimateur.' '.$prenomAnimateur.'</td>
					<td>'.$place.'</td>
					<td>
					<button type="hidden" type="submit" >Réserver</button>
					</td>
				</tr>
			</form>';
		}
		return $chaine;
	}

	/**
	 * Extrait les informations de la requête donné en paramètre pour générer un tableau en html
	 * contenant ces données
	 * Affiche toutes les conférences auxquelles le visiteur connecté est inscrit
	 
	 * @param $req
	 * @return le tableau en html sous forme de chaîne
	*/
	function generTabMesConfpdf($req){ 
		$chaine = "";
		foreach ($req as $row){ //on récupère les informations de chaque conférences
			$idConf =$row->id; 
			$idtheme = $this->modele->getTheme($row->id_theme);
			foreach ($idtheme as $idthemerow){
				$libelleTheme = $idthemerow->libelleTheme;
				$dureeTheme = $idthemerow->duree;
			}
			$idsalle = $this->modele->getSalle($row->id_salle);
			foreach ($idsalle as $idsallerow){
				$idSalle = $idsallerow->id;
				$capaciteSalle = $idsallerow->capacite;
			}
			$idAnimateur = $this->modele->getAnimateur($row->id_animateur);
			foreach ($idAnimateur as $idanimateurrow){
				$nomAnimateur = $idanimateurrow->nom;
				$prenomAnimateur = $idanimateurrow->prenom;
			}
			$heureD = $row->heureD; 
			$dateConf = $row->dateConf; 
			$place = $row->placeDispo;
			//après avoir récupérer chaque informations ongénère le code html
			// qui produira un tableau contenant les différentes données
			$chaine = $chaine.'
			<form method="post" action="suppMesConf">
				<tr>
					<input type="hidden" name="idconf" value="'.$idConf.'" />
					<td>'.$libelleTheme.'</td>
					<td>'.$dureeTheme.' minutes</td>
					<td>'.$dateConf.'</td>
					<td>'.$heureD.'</td>
					<td>'.$idSalle.'</td>
					<td>'.$capaciteSalle.'</td>
					<td>'.$nomAnimateur.' '.$prenomAnimateur.'</td>
				</tr>
			</form>';
		}
		return $chaine;
	}
}
?>