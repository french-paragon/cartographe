<?php
    class point extends coordonnee
    {
		/* Vars */
		protected $id;
		protected $model;
		protected $modelParams; //stocké sous forme de string ou de tableau
		protected $message;
		
		protected $width;
		protected $heigth;
		
		/* Constantes */
		const DELFAUTMODELNAME = "delfautPointModel";
		const NOMODELMESSAGE = 0;
		const USEDELFAUTMODELMESSAGE = -1;
		const NOMODELFOUNDMESSAGE = -2;
		
		/*functions*/
		
		function __construct($cords, $pModel, $pmodelParams, $pId) {
			parent::__construct($cords);
			
			$this->modelParams = $pmodelParams;
			$this->id = $pId;
			
			if (isset($conf_values['rootFolder'])) { //si la configuration en chargée.
			
				$rootF = $conf_values['rootFolder']; 
				
			} else { //sinon on parcourt les dossiers en chemin relatif
			
				$rootF = '';
				
			}
			
			if (is_a($pModel, 'pointModel')) {
				
				$this->model = $pModel; //si le paramètre est un model on le charge sans message
				$this->message = self::NOMODELMESSAGE;
				
			} else if (file_exists($rootF.'class/'.$pModel.'.php')) { //si c'est un nom qui est spécifié et si la classe du model existe
					
				$this->model = new $pModel(); //on charge le modèle mais pas de message.
				$this->message = self::NOMODELMESSAGE;
					
			} else if (file_exists($rootF.'class/'.self::DELFAUTMODELNAME.'.php')) { //sinon si un modèle par défaut existe.
				
				$class = self::DELFAUTMODELNAME;
				$this->model = new $class(); //on le charge normallement
				$this->message = self::USEDELFAUTMODELMESSAGE;
				
			} else { //sinon
				
				$this->model = null; //sinon le point n'a pas de model
				$this->message = self::NOMODELFOUNDMESSAGE; //et on indique que le modèle n'existe pas
					
			}
			
		}
		
		public function drawPoint() {
			
			if ($this->message != self::NOMODELFOUNDMESSAGE) { //si un model a bien été chargé.
				
				return $this->model->drawPointModel($this);
				
			}
			
		}
		
		public function drawPointInfos($contextSize) {
			
			if ($this->message != self::NOMODELFOUNDMESSAGE) { //si un model a bien été chargé.
				
				return $this->model->drawPointInfosModel($this, $contextSize);
				
			}
			
		}
		
		public function drawPointEditable(){
			
			if ($this->message != self::NOMODELFOUNDMESSAGE) { //si un model a bien été chargé.
				
				return $this->model->drawPointEditableModel($this, $contextSize);
				
			}
			
		}

		public function setID ($pID) {

			$this->id = $pID;

		}

		public function getID () {

			return $this->id;

		}

		public function getInfoID () {

			return $this->id.'infos';

		}

		public function getModelParam(){

			return $this->modelParams;

		}

		public function setModelParam($pModelPamams){

			$this->modelParams = $pModelPamams;

		}
		
		public function getWidth() {
			return $this->width;
		}
		
		public function setWidth($pW){
			$this->width = $pW;
		}
		
		public function getHeigth() {
			return $this->heigth;
		}
		
		public function setHeigth($pH){
			$this->heigth = $pH;
		}
		
	}
?>
