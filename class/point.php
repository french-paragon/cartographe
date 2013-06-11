<?php
    class point extends coordonnee
    {
		/* Vars */
		protected $modelName;
		protected $modelParams;
		protected $message;
		
		/* Constantes */
		const DELFAUTMODELNAME = "delfaut";
		const USEDELFAUTMODELMESSAGE = -1;
		const NOMODELFOUNDMESSAGE = -2;
		
		/*functions*/
		
		function __construct($cords, $pmodelName, $pmodelParams) {
			parent::__construct($cords);
			
			if ($conf && isset($conf_values['rootFolder'])) { //si la configuration en chargée.
			
				$rootF = $conf_values['rootFolder']; 
				
			} else { //sinon on parcourt les dossiers en chemin relatif
			
				$rootF = '';
				
			}
			
			if (file_exists($rootF.'points_models/'.$pmodelName)) { //si le dossier du model existe
					
				$this->modelName = $pmodelName; //on charge le modèle mais pas de message.
					
			} else if (file_exists($rootF.'points_models/'.self::DELFAUTMODELNAME)) { //sinon si un modèle par défaut existe.
				
				$this->modelName = self::DELFAUTMODELNAME; //on le charge normallement
				$this->message = self::USEDELFAUTMODELMESSAGE;
				
			} else { //sinon
				
				$this->modelName = self::DELFAUTMODELNAME; //on donne le nom par défaut
				$this->message = self::NOMODELFOUNDMESSAGE; //et on indique que le modèle n'existe pas
					
			}
			
			$this->modelParams = $pmodelParams;
			
		}
		
	}
?>
