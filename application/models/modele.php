<?php
class modele extends CI_Model {
	
	/**
	 * Retourne les informations d'un visiteur
	 
	 * @param $login 
	 * @param $pass
	 * @return toutes les infos du visiteur sous la forme d'un tableau associatif 
	*/
	function getVisiteur($login,$pass) 
	{
		$this->db->select('login');
		$this->db->from('visiteur');
		$this->db->where(array('mdp' => $pass));
		$this->db->where(array('login' => $login));
		$query = $this->db->get();
		
		return $query->result();
	}
	
	/**
	 * Retourne l'id du visiteur qui possède le login donné en paramètre
	 
	 * @param $login 
	 * @return l'id du visiteur qui possède le login donné en paramètre sous la forme d'un tableau associatif 
	*/
	function getVis($login){
		$this->db->select('id');
		$this->db->from('visiteur');
		$this->db->where(array('login' => $login));
			
		$query = $this->db->get();
		
		return $query->result();
	}
	
	/**
	 * Retourne le nom et le prenom du visiteur qui possède le login donné en paramètre
	 
	 * @param $id 
	 * @return le nom et le prenom du visiteur qui possède le login donné en paramètre sous la forme d'un tableau associatif 
	*/
	function getVisid($id){
		$this->db->select('*');
		$this->db->from('visiteur');
		$this->db->where(array('id' => $id));
			
		$query = $this->db->get();
		
		return $query->result();
	}
	
	/**
	 * Retourne les informations de toutes les conférences
	 
	 * @return les informations de toutes les conférences sous la forme d'un tableau associatif 
	*/
	function getConference()
	{
		$this->db->select('id, id_theme, id_salle, id_animateur, heureD, dateConf, placeDispo');
		$this->db->from('conference');
	
		$query = $this->db->get();
		
		return $query->result();
	}
	
	/**
	 * Retourne l'id et la capacité de la salle qui possède l'id donné en paramètre
	 
	 * @param $id 
	 * @return l'id et la capacité de la salle sous la forme d'un tableau associatif 
	*/
	function getSalle($id){
			$this->db->select('id, capacite');
			$this->db->from('salle');
			$this->db->where(array('id' => $id));
			
			$query = $this->db->get();
		
			return $query->result();		
	}
	
	function getNbInscription($idVis){
		$this->db->count_all_results('inscris');
		$this->db->select('id');
		$this->db->where('id', $idVis);
		$this->db->from('inscris');
		
		$nb = $this->db->count_all_results();
		
		return $nb;		
	}
	/**
	 * Retourne l'id, le libellé et la durée du thème qui possède l'id donné en paramètre
	 
	 * @param $id 
	 * @return l'id, le libellé et la durée du thème sous la forme d'un tableau associatif 
	*/
	function getTheme($id){
			$this->db->select('id, libelleTheme, duree');
			$this->db->from('theme');
			$this->db->where(array('id' => $id));
			
			$query = $this->db->get();
		
			return $query->result();		
	}
	
	/**
	 * Retourne l'id, le nom et le prénom de l'animateur qui possède l'id donné en paramètre
	 
	 * @param $id 
	 * @return l'id, le nom et le prénom de l'animateur sous la forme d'un tableau associatif 
	*/
	function getAnimateur($id){
			$this->db->select('id, nom, prenom');
			$this->db->from('animateur');
			$this->db->where(array('id' => $id));
			
			$query = $this->db->get();
		
			return $query->result();		
	}
	
	/**
	 * Retourne un booléen qui confirme si l'incription a été réalisée
	 * Réalise l'inscription si la salle n'est pas pleine ou si 
	 * on est pas déja inscrit à la conférence
	 
	 * @param $idConf
	 * @param $loginVis
	 * @return un booléen qui confirme si l'incription a été réalisée sous la forme d'un entier
	*/
	function inscription($idConf, $loginVis){
		$bool = 0;
		$place = $this->getPlaceDisp($idConf);
		if ($place > 0) {
			$data = array(
				'id' => $loginVis,
				'id_conference' => $idConf,
             );
           
			$this->db->insert('inscris',$data);
			$this->db->set('placeDispo', 'placeDispo-1', FALSE);
			$this->db->where('id', $idConf);
			$this->db->update('conference');
			$bool = 1;
		}
		return $bool;
			
	}
	
	/**
	 * Retourne le nombre de place disponible pour la conférence qui possède l'id donné en paramètre
	 
	 * @param $idConf
	 * @return le nombre de place disponible pour la conférence sous forme d'entier
	*/
	function getPlaceDisp($idConf) {
		$this->db->select('placeDispo');
		$this->db->from('conference');
		$this->db->where('id', $idConf);
		
		$query = $this->db->get();
		$resul = $query->result();
		foreach ($resul as $row){
			$place = $row->placeDispo;
		}
		return $place;
	}
	
	//NE FONCTIONNE PAS SOUS FIREFOX
	/* vérifie sa la conférence a déja eu lieu
	
	* @param $idConf
	* @return Un booléen pour nous dire si la conférence a déja eu lieux ou non
	
	function verifDate($idConf) {
		
		$bool = 1;
		$this->db->select('dateConf');
		$this->db->from('conference');
		$this->db->where('id', $idConf);
		
		$query = $this->db->get();
		$resul = $query->result();
		foreach ($resul as $row){
			$date1 = $row->dateConf;
		}
		$date2 = date("d/m/Y");
		if(strtotime($date1) < strtotime($date2) ){
		 $bool = 0;
		}
		
		return $bool;
	}
	*/
	
	function getInscription($idConf, $idVis){
			$this->db->select('id');
			$this->db->from('inscris');
			$this->db->where(array('id_conference'=> $idConf));
			$this->db->where(array('id'=> $idVis));
			
			$query = $this->db->get();
		
			return $query->result();
			
	}
	
	
	/**
	 * Retourne l'id des conférences, auxquelles le visiteur qui possède l'id donné en paramètre, est inscrit
	 
	 * @param $idVis
	 * @return les id des conférences sous forme d'un tableau associatif
	*/
	function getMesConf($idVis){
		$this->db->select('id_conference');
		$this->db->from('inscris');
		$this->db->where(array('id' => $idVis));
			
		$query = $this->db->get();
		
		return $query->result();	
	}
	
	/**
	 * Retourne toutes les infos de la conférences qui possède l'id donné en paramètre
	 
	 * @param $idConf
	 * @return l'id, l'id du thème, l'id de la salle, l'id de l'animateur, heure, la date et le 
	 * @nombre de place disponible de la conférences sous forme d'un tableau associatif
	*/
	function getMesConference($idConf){
		$this->db->select('id, id_theme, id_salle, id_animateur, heureD, dateConf, placeDispo');
		$this->db->from('conference');
		$this->db->where(array('id' =>  $idConf));
			
		$query = $this->db->get();
		
		return $query->result();
	}
	
	/**
	 * Permet au visiteur qui possède l'idVisiteur donné en paramètre de se désinscrire de la conférence
	 * qui possède l'idConférence
	 * Ajoute aussi une place disponible à la conférence
	 
	 * @param $idVis
	 * @param $idConf
	*/
	function suppInscription($idVis , $idConf){
		$this->db->where('id', $idVis);
		$this->db->where('id_conference', $idConf);
		$this->db->delete('inscris'); 
		$this->db->set('placeDispo', 'placeDispo+1', FALSE);
		$this->db->where('id', $idConf);
		$this->db->update('conference');
	}

	
	/**
	 * Affiche toutes les conférence de l'animateur donné en paramètre
	 
	 * @param $idAnni
	 * @return le résulstat de la requete sous forme de tableau associatif
	*/
	function getMesConferenceAnni($idAnni){
		$this->db->select('id, id_theme, id_salle, id_animateur, heureD, dateConf, placeDispo');
		$this->db->from('conference');
		$this->db->where(array('id_animateur' =>  $idAnni));
			
		$query = $this->db->get();
		
		return $query->result();
	}
	
	/**
	 * Affiche le nom, le prénom et l'id d'un animateur
	 
	 * @return le résultat de la requete sous forme de tableau associatif
	*/
	function getAnnimateur(){
		$this->db->select('id, nom, prenom');
		$this->db->from('animateur');
			
		$query = $this->db->get();
		
		return $query->result();
	}
}
?>