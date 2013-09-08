<?php
    class carte
    {
		const FORMLARGNESS = 300;
		
		protected $index;
		protected $name;
		protected $image_fond;
		protected $deco_style;
		protected $deco_style_params;
		protected $size;
		protected $description;
		protected $message;
		protected $gameName;
		protected $isPublic;
		protected $pts = array();
		
		const DELFAUTBACKGROUNDID = "fondCarte";
		 
		public function __construct($pIndex, $pName, $pImage_fond, $pDeco_style, $pDeco_style_params, $pX_size, $pY_size, $pDecription, $pPublic, $pGameName){
			
			if(is_string($pIndex) )
				$this->index = intval($pIndex);
			else
				$this->index = (int) $pIndex;
				
			$this->name = $pName;
			$this->image_fond = $pImage_fond;
			$this->deco_style = $pDeco_style;
			$this->deco_style_params = $pDeco_style_params;
			$this->size = new coordonnee($pX_size.','.$pY_size);
			$this->description = $pDecription;
			$this->isPublic = $pPublic;
			$this->gameName = $pGameName;
			
		}
		
		public function isPrivate() {
				return !$this->isPublic;
		}
		
		public function isPublic() {
			return $this->isPublic;
		}
		
		public function getId() {
			return $this->index;
		}
		
		/*public function setId($pIndex) {
			
			if(!isset($this->index)){
				if (is_int($pIndex)) $this->index = $pIndex;
				else $this->index = intval($pIndex);
			}
			
		}*/
		
		public function getName() {
			return $this->name;
		}
		
		public function getImageFond() {
			return $this->image_fond;
		}
		
		public function getDecoStyle() {
			return $this->deco_style;
		}
		
		public function getDecoStyleParams() {
			return $this->deco_style_params;
		}
		
		public function getXsize() {
			return $this->size->getX();
		}
		
		public function getYsize() {
			return $this->size->getY();
		}
		
		public function getDescription() {
			return $this->description;
		}
		
		public function getGameName() {
			return $this->gameName;
		}
		
		public function setPoints($pPts) {
			
			$this->pts = array();
			$i = 0;
			
			foreach($pPts as $pt) {
				if(is_a($pt, 'point')) {
					
					$this->pts[$i] = $pt;
					++$i;
					
				}
			}
			
		}
		
		public function addPoints ($pPts) {
			
			foreach($pPts as $pt) {
				if(is_a($pt, 'point')) {
					
					$this->pts[] = $pt;
					
				}
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

			$SVGcontent .= $this->size->getX();

			$SVGcontent .= '" height="';

			$SVGcontent .= $this->size->getY();

			$SVGcontent .= '" id="';

			$SVGcontent .= $this->index;

			$SVGcontent .= '"
			version="1.1">';
			
			return $SVGcontent;
			
		}
		
		private function endSVG () {

			return "</svg>";
			
		}
		
		private function beginCardDraw() {
			
			//on génère l'image
			$SVGcontent = '<image y="0" x="0" id="'.self::DELFAUTBACKGROUNDID.'" xlink:href="'.$this->image_fond.'" height="'.$this->size->getY().'" width="'.$this->size->getX().'" viewbox="0 0 '.$this->size->getX().' '.$this->size->getY().'" preserveAspectRatio="xMidYMid Slice" />';

			//puis on la protège
			$SVGcontent .= '<foreignobject x="0" y="0" width="'.$this->size->getX().'" height="'.$this->size->getY().'"><body xmlns="http://www.w3.org/1999/xhtml"><div></div></body></foreignobject>';

			return $SVGcontent;
			
		}
		
		public function drawCardWithoutPoints () {
			
			$page = new pageBuilder();
			
			$page->addToHead('<script type="text/javascript" > useAjax = true; </script>');
			$page->addToHead('<script type="text/javascript" src="js/carte.js"></script>');
			
			$page->addToBody($this->initSVG());
			$page->addToBody($this->beginCardDraw());
			
			foreach($this->pts as $pt) {
			
				$page->addToBody($pt->drawPoint());
				
			}
				
			$page->addToBody($this->endSVG());
		
			$page->drawPage();
			
		}
		
		public function drawCardWithPoints () {
			
			$page = new pageBuilder();
			
			$page->addToHead('<script> useAjax = false; </script>');
			$page->addToHead('<script type="text/javascript" src="js/carte.js"></script>');
			
			$page->addToBody($this->initSVG());
			$page->addToBody($this->beginCardDraw());
			
			foreach($this->pts as $pt) {
			
				$page->addToBody($pt->drawPoint());
				
			}
			
			foreach($this->pts as $pt) {
			
				$page->addToBody($pt->drawPointInfos($this->size));
				
			}
			
			$page->addToBody($this->endSVG());
		
			$page->drawPage();
			
		}
		
		/* Cette fonction sert à charger la carte en tenant compte du maximum de point chargeable en une fois et décidant s'il y a lieux d'utiliser Ajax ou non.*/
		public function drawCardWithPointsCare() {
			
			if (isset($_SESSION['configuration']) AND is_a($_SESSION['configuration'], 'config')) {
			
				$maxN = null;
			
				try {
					
					$maxN = $_SESSION['configuration']->getParam('maxPointSize');
					
				} catch (Exception $e) {
					
					$maxN = 0;
					
				}
				
				if (count($this->pts) < $maxN) { // si le nombre de point est plus petit que le nombre de point maximal que l'on peut charger à la fois
					
					$this->drawCardWithPoints(); //on charge directement tout les points
					
				} else { //sinon on utilisera ajax pour charger les points à la demande.
					
					$this->drawCardWithoutPoints();
					
				}
				
			} else {
				
				$this->drawCardWithPoints();
				
			}
			
		}
		
		/* cette fonction sert à obtenir un lien vers la carte*/
		public function drawLinkTo() {
		
			echo '<table>
				<tr><td><img src="'.$this->image_fond.'" alt = "image non trouvée" width="200px" heigth="150px"/></td><td><a class="linkTitle" href="carte.php?map='.$this->name.'">'.$this->name.'</a><br><br>'.$this->description.'</td></tr>
			</table><br><br>';
			
		}
		
		public function drawEditLinkTo(){
		
			echo '<table id="'.$this->index.'tableEdit">
				<tr><td><img src="'.$this->image_fond.'" alt = "image non trouvée" width="200px" heigth="150px"/></td><td><a class="linkTitle" href="carte.php?map='.$this->name.'" target="_blank">'.$this->name.'</a><br><br>'.
				'<div class="editlinks"><a href="admin.php?tool=maps&map='.$this->index.'">Infos</a> | <a href="mapEditor.php?map='.$this->index.'" target="_blank">editor</a> | <button onclick="del(\''.$this->index.'\')" >delete</button></div></td></tr>
			</table><br><br>';
			
		}
		
		public function drawCardEditable(){
			
			if(isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights()) {
			
				$page = new pageBuilder();
				
				$page->addToHead('<script> useAjax = false; </script>');
				$page->addToHead('<script type="text/javascript" src="js/functions.js"></script>');
				$page->addToHead('<script type="text/javascript" src="js/carte.js"></script>');
				$page->addToHead('<script type="text/javascript" src="js/carteEdit.js"></script>');
				
				$page->addToBody($this->initSVG());
				$page->addToBody($this->beginCardDraw());
				
				foreach($this->pts as $pt) {
				
					$page->addToBody($pt->drawPointEditable());
					
				}
				
				$page->addToBody($this->endSVG());
			
				$page->drawPage();
			
			}
			
		}
		
		public function drawCardInfosEditable(mapLoader &$loader){
			
			$html = "\n<iframe src=\"ajax/saveMap.php?id=".$this->index."\" width=\"100%\" height=\"40\" name=\"saveFrame\" id=\"saveFrame\" frameborder=\"0\"></iframe><br>\n";
			$html .= "<form method=\"post\"  action=\"ajax/saveMap.php?map=".$this->index."\" target=\"saveFrame\" accept-charset=\"ISO-8859-1\">\n";
			
			$html .= '<fieldset><legend>Informations de base:</legend><br>
						<label for="name">Nom:</label>&nbsp;&nbsp;&nbsp;
						<input id="name" name="name" type="text" width="'.self::FORMLARGNESS.'" value="'.$this->name.'"><br><br>
						<label for="description">Description:</label><br>
						<textarea id="description" name="description" style="height: 150px; width: '.(self::FORMLARGNESS*3).'px ;">'.utf8_encode($this->description).'</textarea><br><br>
						<label for="visibility">Carte publique?&nbsp;&nbsp;&nbsp;</label><input id="visibility" type="checkbox" name="visibility" value="isPublic" ';
						
			if($this->isPublic)
				$html.= 'checked';
						
			$html .= '><br><br>
						<label for="game">Jeu:</label>&nbsp;&nbsp;&nbsp;
						<input id="game" list="'.$this->index.'list" name="game" type="text" width="'.self::FORMLARGNESS.'" value="'.$this->gameName.'">
						<datalist id="'.$this->index.'list">';
						  
			if(!$loader->isPDOConnected())
				$loader->connectPDO();
				
			$tab = $loader->getGameNameList();
			
			if(is_array($tab)){
				
				$i = 0;
				
				foreach($tab as $name){
					
					$html .= '<option value="'.$name.'">';
					
				}
			}
						  
			$html .= '</datalist>
						</fieldset><br><br>
						<fieldset><legend>Décoration:</legend><br>
						<label for="image">Image de fond:</label>&nbsp;&nbsp;&nbsp;
						<input id="image" name="image" type="text" width="'.self::FORMLARGNESS.'" value="'.$this->image_fond.'"><br><br>';
						
			/*$html .= '<label for="deco">Nom de la décoration:</label><br>
						<input id="deco" name="deco" type="text" width="'.self::FORMLARGNESS.'" value="'.$this->deco_style.'"><br><br>
						<label for="name">Paramètres de la décoration:</label><br>
						<input id="name" name="name" type="text" width="'.self::FORMLARGNESS.'" value="'.$this->name.'"><br><br>';*/
						
			$html .= '</fieldset><br><br>
						<fieldset><legend>Taille:</legend><br>
						<label for="x">Largeur:&nbsp;&nbsp;&nbsp;</label><input id="x" name="x" type="text" width="'.self::FORMLARGNESS.'" value="'.$this->size->getX().'">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<label for="y">Hauteur:&nbsp;&nbsp;&nbsp;</label><input id="y" name="y" type="text" width="'.self::FORMLARGNESS.'" value="'.$this->size->getY().'">
						</fieldset><br><br>';

			$html .= "\n\n<div align=\"right\"><input type=\"submit\" name=\"sauver\" value=\"Sauver\"></div>\n";
			
			$html .= "\n</form><br><br>";
			
			$html .= "\n<fieldset><legend>Points:</legend><br>";
			$html .= '<div class="editlinks" align="right"><a href="mapEditor.php?map='.$this->index.'" target="_blank">éditeur de points</a> | <button onclick="newPoint(\'pointList\', '.$this->index.');">nouveau point</button></div><hr><div id="pointList">';
			
			foreach($this->pts as $pt){
			
				$html .= $pt->drawEditLinkTo();
				
			}
			
			$html .= "\n</div></fieldset><br>\n";
			
			return $html;
			
		}
		
		
	}
?>
