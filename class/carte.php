<?php
    class carte
    {
		protected $index;
		protected $name;
		protected $image_fond;
		protected $deco_style;
		protected $deco_style_params;
		protected $size;
		protected $description;
		protected $message;
		protected $isPublic;
		protected $pts;
		
		const DELFAUTBACKGROUNDID = "fondCarte";
		 
		public function __construct($pIndex, $pName, $pImage_fond, $pDeco_style, $pDeco_style_params, $pX_size, $pY_size, $pDecription, $pPublic){
			
			$this->index = $pIndex;
			$this->name = $pName;
			$this->image_fond = $pImage_fond;
			$this->deco_style = $pDeco_style;
			$this->deco_style_params = $pDeco_style_params;
			$this->size = new coordonnee($pX_size.','.$pY_size);
			$this->description = $pDecription;
			$this->isPublic = $pPublic;
			
		}
		
		public function isPrivate() {
				return $this->isPrivate;
		}
		
		public function setPoints($pPts) {
			
			$this->pts = array();
			
			foreach($pPts as $pt) {
				if(is_a($pt, 'point')) {
					
					$this->pts[] = $pt;
					
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
			
			$SVGcontent = "<svg
			xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
			xmlns:cc=\"http://creativecommons.org/ns#\"
			xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"
			xmlns:svg=\"http://www.w3.org/2000/svg\"
			xmlns:xlink=\"http://www.w3.org/1999/xlink\"
			xmlns:sodipodi=\"http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd\"
			xmlns:inkscape=\"http://www.inkscape.org/namespaces/inkscape\"
			width=\"";

			$SVGcontent .= $this->size->getX();

			$SVGcontent .= "\"height=\"";

			$SVGcontent .= $this->size->getY();

			$SVGcontent .= "\"id=\"";

			$SVGcontent .= $this->index;

			$SVGcontent .= "\"
			version=\"1.1\"
			inkscape:version=\"0.48.3.1 r9886\"
			sodipodi:docname=\"dessin.svg\">";
			
			return $SVGcontent;
			
		}
		
		private function endSVG () {

			return "</svg>";
			
		}
		
		private function beginCardDraw() {
			
			//on génère l'image
			$SVGcontent = '<image y="0" x="0" id="'.self::DELFAUTBACKGROUNDID.'" xlink:href="'.$this->image_fond.'" height="'.$this->size->getY().'" width="'.$this->size->getX().'" viewbox="0 0 '.$this->size->getX().' '.$this->size->getY().'" preserveAspectRatio="xMidYMid Slice" />';

			//puis on la protège
			$SVGcontent .= '<foreignobject x="0" y="0" width="'.$this->size->getX().'" height="'.$this->size->getY().'"><body xmlns=\"http://www.w3.org/1999/xhtml\"><div></div></body></foreignobject>';

			return $SVGcontent;
			
		}
		
		public function drawCardWithoutPoints () {
			
			$page->addToHead('<script> useAjax = false; </script>');
			$page->addToHead('<script type="text/javascript" src="js/carte.js"></script>');
			
			$page = new pageBuilder();
			
			$page->addToBody($this->initSVG());
			$page->addToBody($this->beginCardDraw());
			$page->addToBody($this->endSVG());
		
			$page->drawPage();
			
		}
		
		public function drawCardWithPoints () {
			
			$page->addToHead('<script> useAjax = false; </script>');
			$page->addToHead('<script type="text/javascript" src="js/carte.js"></script>');
			
			$page = $this->beginCardDraw();
			
			foreach($this->pts as $pt) {
			
				$page->addToBody($pt->drawPoint());
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
				<tr><td><img src="'.$this->image_fond.'" alt = "image non trouvée" width="200px" heigth="150px"/></td><td><a href="carte.php?map='.$this->name.'">'.$this->name.'</a><br><br>'.$this->description.'</td></tr>
			</table><br><br>';
			
		}
		
		
	}
?>
