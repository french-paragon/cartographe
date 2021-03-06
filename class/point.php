<?php
    class point extends coordonnee
    {
		
		/* Constantes */
		const DELFAUTMODELNAME = "delfautPointModel";
		const NOMODELMESSAGE = 0;
		const USEDELFAUTMODELMESSAGE = -1;
		const NOMODELFOUNDMESSAGE = -2;
		
		const IMAGEEDITOR = "points_models/delfaut/delfaut.png";
		
		const FORMLARGNESS = 300;
		
		const SHOWLARGNESS = 500;
		const SHOWHEIGNESS = 700;
		
		/* Vars */
		protected $id;
		protected $model;
		protected $modelParams; //stocké sous forme de string ou de tableau
		protected $message;
		
		protected $description;
		
		protected $width;
		protected $heigth;
		
		// valeurs utilisées dans la mise en place de l'aperçu.
		
		protected $showImage = self::IMAGEEDITOR;
		protected $showWidth = self::SHOWLARGNESS;
		protected $showHeight = self::SHOWHEIGNESS;
		protected $showYPos = 30;
		
		/*functions*/
		
		function __construct($cords, $pModel, $pmodelParams, $pId) {
			
			global $conf_values;
			
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
			
			$this->initOverviewParams();
			
		}
		
		public function initOverviewParams(){
			
			if($this->message != self::NOMODELFOUNDMESSAGE){
			
				$this->model->initModelRelatedParams($this);
				
			}
			
		}
		
		private function initSVG () {
			
			$SVGcontent = '<svg
			xmlns:dc="http://purl.org/dc/elements/1.1/"
			xmlns:cc="http://creativecommons.org/ns#"
			xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
			xmlns:svg="http://www.w3.org/2000/svg"
			xmlns:xlink="http://www.w3.org/1999/xlink"
			width="';

			$SVGcontent .= $this->showWidth;

			$SVGcontent .= '" height="';

			$SVGcontent .= $this->showHeight;

			$SVGcontent .= '" id="';

			$SVGcontent .= $this->id;

			$SVGcontent .= 'PTsvg"
			version="1.1">Une erreur est survenue, votre navigateur ne semble pas assez récent pour utiliser le svg. Mettez votre navigateur à jour et si le problème persiste essayez d\'en utiliser un autre!';
			
			return $SVGcontent;
			
		}
		
		private function endSVG () {

			return "</svg>";
			
		}
		
		public function drawOverview() {
		
			$oldXpos = $this->x;
			$oldYpos = $this->y;
			
			$this->x = (floatval($this->showWidth) - floatval($this->width))/2;
			$this->y = $this->showYPos;
			
			$retour = $this->initSVG();
			
			$retour .= $this->drawPoint();
			$retour .= $this->drawPointInfos(new coordonnee($this->showWidth.','.$this->showHeight));
			
			$retour .= $this->endSVG();
			
			$this->x = $oldXpos;
			$this->y = $oldYpos;
			
			return $retour;
			
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
		
		public function drawPointInfosBG($contextSize) {
			
			if ($this->message != self::NOMODELFOUNDMESSAGE) { //si un model a bien été chargé.
				
				return $this->model->drawPointInfosBGModel($this, $contextSize);
				
			}
			
		}
		
		public function drawPointInfosEditor(){
			
			global $conf, $conf_values;
			
			if(isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights()) {
			
				$page = new pageBuilder();
				
				$page->addToHead('<script> useAjax = false; </script>');
				$page->addToHead('<script type="text/javascript" src="js/functions.js"></script>');
				$page->addToHead('<script type="text/javascript" src="js/carte.js"></script>');
				$page->addToHead('<script type="text/javascript" src="js/carteEdit.js"></script>');
				
				$htmltext = '<table cellspacing="5" cellpadding="5" style="width: 95%"><tbody><tr><td id="form">';
				
				$htmltext .= "<form method=\"post\"  action=\"ajax/savePoint.php?point=".$this->id."\" target=\"saveFrame\" accept-charset=\"UTF-8\">\n";
				
				$htmltext .= '<fieldset><legend>Informations de base:</legend><br>
				<label for="descr">Description:&nbsp;&nbsp;&nbsp;</label><input id="descr" name="descr" type="text" width="'.self::FORMLARGNESS.'" value="'.$this->getDescription().'"><br><br>
				<label for="width">Largeur:&nbsp;&nbsp;&nbsp;</label><input id="width" name="width" type="text" width="'.self::FORMLARGNESS.'" value="'.$this->getWidth().'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="height">Hauteur:&nbsp;&nbsp;&nbsp;</label><input id="height" name="height" type="text" width="'.self::FORMLARGNESS.'" value="'.$this->getHeigth().'"><br><br>
				<label for="x">Position x:&nbsp;&nbsp;&nbsp;</label><input id="x" name="x" type="text" width="'.self::FORMLARGNESS.'" value="'.$this->getX().'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="y">Position y:&nbsp;&nbsp;&nbsp;</label><input id="y" name="y" type="text" width="'.self::FORMLARGNESS.'" value="'.$this->getY().'"><br></fieldset><br><br>';
								
				$htmltext .= '<fieldset><legend>Modèle et style:</legend><br>
				<label for="model">Nom du modèle:</label>
					<input id="model" list="'.$this->id.'list" name="model" type="text" width="'.self::FORMLARGNESS.'" value="'.$this->getModelName().'" 
					onblur="loadModelForm(\'model\' , \''.$this->id.'modelInfos\', \''.$this->id.'\');">
					<datalist id="'.$this->id.'list">';
				
				if($conf && is_array($conf_values['installed_points_model'])) { //config properly loaded
				
					foreach($conf_values['installed_points_model'] as $name){
						
						$htmltext .= '<option value="'.$name.'">';
						
					}
				
				}
				
				$htmltext .= '</datalist> (changer le focus pour mettre à jour le formulaire ci-dessous)<br><br><div id="'.$this->id.'modelInfos">'.$this->model->getParamForm($this).'</div></fieldset><br><br>';
				

				$htmltext .= "\n\n<div align=\"right\"><input type=\"submit\" name=\"sauver\" value=\"Sauver les changements\"></div>\n</form>";
				
				$htmltext .= '</td>
				<td id="apercu" width="600" height="100%"><div><iframe src="ajax/savePoint.php?point='.$this->id.'" width="560px" height="800px" name="saveFrame" id="saveFrame" frameborder="0"></iframe></div><br></td></tr></tbody></table>';
			
				$page->addToBody($htmltext);
			
				$page->drawPage();
				
			}
			
		}
		
		public function drawPointEditable(){

			$svgText = '<g  id="'.$this->getID().'pt" onmousedown="changeVisibility(\''.$this->getID().'_editP\'); setDragable(\''.$this->getID().'img\', evt)" onmousemove="move(\''.$this->getID().'\', evt)" onmouseup="unsetDragable(\''.$this->getID().'\');"  title="'.$this->getDescription().'">';
			$svgText .= '<image id="'.$this->getID().'img" '.$this->getXMLPos().' xlink:href="';
			
			$svgText .= (isset($this->showImage))? $this->showImage : self::IMAGEEDITOR;
			
			$svgText .= '" '.$this->getXMLSize().' viewbox="'.$this->getX().' '.$this->getY().' '.$this->getWidth().' '.$this->getHeigth().'" preserveAspectRatio="xMidYMid Slice" />';

			$svgText .= '<foreignobject id="'.$this->getID().'fo" '.$this->getXMLPos().' '.$this->getXMLSize().'><body xmlns="http://www.w3.org/1999/xhtml"><div></div></body></foreignobject></g>';

			$svgText .= '<g id="'.$this->getID().'_editP" transform="translate('.($this->getX() + $this->getWidth()/2 - 50).', '.($this->getY() + $this->getHeigth() + 5).')" style="visibility:hidden;" ><rect width="100" height="50" style="fill:rgb(255,255,255);stroke-width:3;stroke:rgb(0,0,0);" />';
			$svgText .= '<foreignobject width="100" height="45" y="5"><body xmlns="http://www.w3.org/1999/xhtml"><div align="center"><a href="pointEditor.php?point='.$this->getID().'" target="_blank">Editer le point</a></div></body></foreignobject></g>';

			return $svgText;
			
		}
		
		public function drawEditLinkTo(){
		
			$htmltext = "\n\n";
		
			$htmltext .= '<table id="'.$this->id.'beditlink" cellspacing="5" cellpadding="5" style="width: 100%"><tbody>
							<tr>
							  <td style="width: 60px;" rowspan="2" colspan="1"><img alt="image non trouvée!" src="';
			
			$htmltext .= (isset($this->showImage))? $this->showImage : self::IMAGEEDITOR;
			
			$htmltext .= '" width="50" height="50"/></td>
							  <td><div class="linkTitle"> Boutton: '.$this->id.'</div>'.$this->description.'</td>
							</tr>
							<tr>
							  <td><div class="editlinks"><a href="pointEditor.php?point='.$this->id.'" target="_blank">éditer</a> | <button onclick="delPoint(\''.$this->id.'\')" >delete</button></div></td>
							</tr>
						  </tbody><br></table>';
		
			$htmltext .= "\n\n";
						  
			return $htmltext;
			
		}

		public function setID ($pID) {

			$this->id = $pID;

		}

		public function getID () {

			return $this->id;

		}
		
		public function getMessage() {
			return $this->message;
		}

		public function getInfoID () {

			return $this->id.'infos';

		}
		
		public function getModel() {
			return $this->model;
		}
		
		public function getModelName() {
			return get_class($this->model);
		}

		public function getModelParam(){

			return $this->modelParams;

		}
		
		public function getStringModelParam(){
		
			if(isset($this->modelParams)){
			
				if(is_string($this->modelParams))
					return $this->modelParams;
				else 
					return implode(',', $this->modelParams);
					
			} else return null;
			
		}

		public function setModelParam($pModelPamams){

			$this->modelParams = $pModelPamams;

		}
		
		public function getWidth() {
			return $this->width;
		}
		
		public function setWidth($pW){
			$this->width = floatval($pW);
		}
		
		public function getHeigth() {
			return $this->heigth;
		}
		
		public function setHeigth($pH){
			$this->heigth = floatval($pH);
		}
		
		public function getXMLSize() {
			return 'width="'.$this->width.'" height="'.$this->heigth.'"';
		}
		
		public function getDescription() {
			return $this->description;
		}
		
		public function setDescription($pDescr) {
			$this->description = $pDescr;
		}
		
		public function setShowImage($pI){ $this->showImage = $pI;}
		public function setShowWidth($pL){ $this->showWidth = $pL;}
		public function setShowHeight($pH){ $this->showHeight = $pH;}
		public function setShowYPos($pY){ $this->showYPos = $pY;}
		
	}
?>
