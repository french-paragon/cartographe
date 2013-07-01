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
			
			echo("<svg
			xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
			xmlns:cc=\"http://creativecommons.org/ns#\"
			xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"
			xmlns:svg=\"http://www.w3.org/2000/svg\"
			xmlns:xlink=\"http://www.w3.org/1999/xlink\"
			xmlns:sodipodi=\"http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd\"
			xmlns:inkscape=\"http://www.inkscape.org/namespaces/inkscape\"
			width=\"");

			echo($this->size->getX());

			echo("\"
			height=\"");

			echo($this->size->getY());

			echo("\"
			id=\"");

			echo($this->index);

			echo("\"
			version=\"1.1\"
			inkscape:version=\"0.48.3.1 r9886\"
			sodipodi:docname=\"dessin.svg\">");
			
		}
		
		private function endSVG () {

			echo("</svg>");
			
		}
		
		private function beginCardDraw() {
			
			//on génère l'image
			$SVGcontent = '<image y="0" x="0" id="'.self::DELFAUTBACKGROUNDID.'" xlink:href="'.$this->image_fond.'" height="'.$this->size->getY().'" width="'.$this->size->getX().'" viewbox="0 0 '.$this->size->getX().' '.$this->size->getY().'" preserveAspectRatio="xMidYMid Slice" />';

			//puis on la protège
			$SVGcontent .= '<foreignobject x="0" y="0" width="'.$this->size->getX().'" height="'.$this->size->getY().'"><body xmlns=\"http://www.w3.org/1999/xhtml\"><div></div></body></foreignobject>';

			echo $SVGcontent;
			
		}
		
		public function drawCardWithoutPoints () {
			
			$this->initSVG();
			$this->beginCardDraw();
			$this->endSVG();
			
		}
		
		public function drawCardWithPoints () {
			
			$this->initSVG();
			$this->beginCardDraw();
			
			foreach($this->pts as $pt) {
			
				$pt->drawPoint();
				$pt->drawPointInfos($this->size);
				
			}
			
			$this->endSVG();
			
		}
		
		
	}
?>
