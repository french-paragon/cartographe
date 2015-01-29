<?php 

	class delfautPointModel extends pointModel{

		const DELFAULTPARAMS = 'points_models/delfaut/delfaut.png'; //Url du fond, hauteur, largeur, titre, hauteur du titre, image, hauteur de l'image, texte, image background, lien du titre, lien de l'image

		const IMAGEPOS = 0;

		const LEGENDHEIGHTPOS = 1;
		const LEGENDWIDTHPOS = 2;
		const TITLEPOS = 3;
		const LEGENDTITLEHEIGHTPOS = 4;
		const LEGENDIMAGEPOS = 5;
		const LEGENDIMAGEHEIGHTPOS = 6;
		const LEGENDTEXTPOS = 7;
		
		//facultative infos
		const LEGENDBGPOS = 8;
		const TITLELINKPOS = 9;
		const IMAGELINKPOS = 10;
		
		const PARAMLISTSIZE = 11;

		const TITLESTYLERULE = 'delfautModelTitle';
		const TITLESTYLEHEIGHT = 40;

		const TEXTSTYLERULE = 'delfautModelText';

		const BORDERDISTANCE = 20;
		
		const POINTBRILLANCEIMG = './points_models/delfaut/deco.png';
		
		public function drawEditor() {}
		
		public function initModelRelatedParams(&$pPoint){
		
			$this->params = $this->initParamList($pPoint);
			
			if(isset($this->params[self::IMAGEPOS])) $pPoint->setShowImage($this->params[self::IMAGEPOS]);
			if(isset($this->params[self::LEGENDHEIGHTPOS])) $pPoint->setShowHeight(floatval($pPoint->getHeigth()) + floatval($this->params[self::LEGENDHEIGHTPOS]) + floatval(3*self::BORDERDISTANCE) );
			if(isset($this->params[self::LEGENDWIDTHPOS])) $pPoint->setShowWidth(floatval($this->params[self::LEGENDWIDTHPOS]) + floatval(2*self::BORDERDISTANCE));
			
		}
		
		public function drawPointEditableModel(&$pPoint, $contextSize){

			global $conf_values;

			$this->params = $this->initParamList($pPoint);

			$svgText = '<g  id="'.$pPoint->getID().'" onclick="setDraggable(\''.$pPoint->getID().'\', true);" onmousemove="move(\''.$pPoint->getID().'\');" onmouserelease="setDraggable(\''.$pPoint->getID().'\', false);" onmouseover="document.getElementById(\''.$pPoint->getID().'_editP\').style.visibility = \'visible\';" title="'.$pPoint->getDescription().'">';
			$svgText .= '<image '.$pPoint->getXMLPos().' xlink:href="'.$conf_values['rootFolder'].$this->params[self::IMAGEPOS].'" '.$pPoint->getXMLSize().' viewbox="'.$pPoint->getX().' '.$pPoint->getY().' '.$pPoint->getWidth().' '.$pPoint->getHeigth().'" preserveAspectRatio="xMidYMid Slice" />';

			$svgText .= '<foreignobject '.$pPoint->getXMLPos().$pPoint->getXMLSize().'><body xmlns=\"http://www.w3.org/1999/xhtml\"><div></div></body></foreignobject></g>';

			$svgText .= '<g id="'.$pPoint->getID().'_editP" transform="translate('.($pPoint->getX() + $pPoint->getWidth()/2 - 50).', '.($pPoint->getY() + $pPoint->getHeigth()/2).')><rect width="100" height="50" style="fill:rgb(255,255,255);stroke-width:3;stroke:rgb(0,0,0);visibility:hidden"/>';
			$svgText .= '<foreignobject width="100" height="50"><body xmlns=\"http://www.w3.org/1999/xhtml\"><div align="center"><br><a href="pointEditor.php?point='.$pPoint->getID().'" target="_blank"">Editer le point</a></div></body></foreignobject></g>';

			return $svgText;
			
		}
	
		public function drawPointModel (&$pPoint){

			global $conf_values;

			$this->params = $this->initParamList($pPoint);

			$svgText = '<g  id="'.$pPoint->getID().'pt" onclick="viewInfo(\''.$pPoint->getID().'\');" onmouseover="document.getElementById(\''.$pPoint->getID().'_deco\').style.visibility = \'visible\';" onmouseout="document.getElementById(\''.$pPoint->getID().'_deco\').style.visibility = \'hidden\';">';
			$svgText .= '<image id="'.$pPoint->getID().'_deco" style=" visibility : hidden;" '.$pPoint->getXMLPosWD(-8).' xlink:href="'.$conf_values['rootFolder'].self::POINTBRILLANCEIMG.'" height="'.($pPoint->getHeigth() + 16).'" width="'.($pPoint->getWidth() + 16).'" viewbox="'.($pPoint->getX() - 8).' '.($pPoint->getY() - 8).' '.($pPoint->getWidth() + 16).' '.($pPoint->getHeigth() + 16).'" preserveAspectRatio="xMidYMid Slice" />';
			
			if(isset($this->params[self::TITLEPOS]))
				$svgText .= '<title>'.$this->params[self::TITLEPOS].'</title>';
			
			$svgText .= '<image '.$pPoint->getXMLPos().' xlink:href="'.$conf_values['rootFolder'].$this->params[self::IMAGEPOS].'" '.$pPoint->getXMLSize().' viewbox="'.$pPoint->getX().' '.$pPoint->getY().' '.$pPoint->getWidth().' '.$pPoint->getHeigth().'" preserveAspectRatio="xMidYMid Slice" />';

			$svgText .= '<foreignobject '.$pPoint->getXMLPos().' '.$pPoint->getXMLSize().'><body xmlns=\"http://www.w3.org/1999/xhtml\"><div></div></body></foreignobject></g>';

			return $svgText;

		}
		
		protected function generateInfosBackground(){
			
			global $conf_values;
		
			$svgText = '';
		
			if (file_exists($conf_values['rootFolder'].$this->params[self::LEGENDBGPOS]) && is_file($conf_values['rootFolder'].$this->params[self::LEGENDBGPOS])) {
				$svgText .= '<image y="0" x="0" xlink:href="'.$conf_values['rootFolder'].$this->params[self::LEGENDBGPOS].'" height="'.$this->params[self::LEGENDHEIGHTPOS].'" width="'.$this->params[self::LEGENDWIDTHPOS].'" viewbox="0 0 '.$this->params[self::LEGENDWIDTHPOS].' '.$this->params[self::LEGENDHEIGHTPOS].'" preserveAspectRatio="none" />';

				//protection de l'image
				$svgText .= '<foreignobject x="0" y="0" width="'.$this->params[self::LEGENDWIDTHPOS].'" height="'.$this->params[self::LEGENDHEIGHTPOS].'"><body><div></div></body></foreignobject>'; 
			} else {
				$svgText .= '<rect style="fill:#ffffff;fill-opacity:1;fill-rule:nonzero;stroke:#000000;stroke-width:3;stroke-miterlimit:4;stroke-opacity:1;stroke-dasharray:none" width="'.$this->params[self::LEGENDWIDTHPOS].'" height="'.$this->params[self::LEGENDHEIGHTPOS].'" x="0" y="0" />';
			}
			
			return $svgText;
		
		}
		
		protected function configureDefaultParam(){
		
			if(!isset($this->params[self::LEGENDBGPOS]))
				$this->params[self::LEGENDBGPOS] = null;
				
			if(!isset($this->params[self::TITLELINKPOS]))
				$this->params[self::TITLELINKPOS] = null;
				
			if(!isset($this->params[self::IMAGELINKPOS]))
				$this->params[self::IMAGELINKPOS] = null;
				
			if(!isset($this->params[self::LEGENDTITLEHEIGHTPOS]))
				$this->params[self::LEGENDTITLEHEIGHTPOS] = self::TITLESTYLEHEIGHT;
					
		}
		
		protected function calcultateInfosPos(&$pPoint, $contextSize){
		
			$lSize = new coordonnee($this->params[self::LEGENDWIDTHPOS].','.$this->params[self::LEGENDHEIGHTPOS]);
			$pos = $pPoint->getDiff($lSize);

			$pos->setX($pos->getX() + ($this->params[self::LEGENDWIDTHPOS]/2) + ($pPoint->getWidth()/2));
			$pos->setY($pos->getY() - self::BORDERDISTANCE);

			//si la position est au delà du bord droit:
			if($pos->getX() > $contextSize->getX() - $this->params[self::LEGENDWIDTHPOS] - self::BORDERDISTANCE) {

				$pos->setX($pPoint->getX() - $this->params[self::LEGENDWIDTHPOS] - self::BORDERDISTANCE);
				$pos->setY($pPoint->getY() - ($this->params[self::LEGENDHEIGHTPOS]/2));

			} elseif ($pos->getX() < self::BORDERDISTANCE) { //si la position est trop pres du bord gauche:
			
				$pos->setX($pPoint->getX() + $pPoint->getWidth() + self::BORDERDISTANCE);
				$pos->setY($pPoint->getY() - ($this->params[self::LEGENDHEIGHTPOS]/2));

			}

			if ($pos->getY() >  $contextSize->getY() - $this->params[self::LEGENDHEIGHTPOS] - self::BORDERDISTANCE) { // si le cadre est trop près du bas
			
				$pos->setY($pPoint->getY()- $this->params[self::LEGENDHEIGHTPOS] - self::BORDERDISTANCE);
				
			} elseif ($pos->getY() < self::BORDERDISTANCE ){ //si le point est trop prêt du haut

				$pos->setY($pPoint->getY() + $pPoint->getHeigth() + self::BORDERDISTANCE);

			}
			
			return $pos;
			
		}

		protected function generateInfosContent(){
			
			global $conf_values;
					
			$jumps = 0;
			$svgText = '';

			if($this->params[self::TITLEPOS] != null ) {

				$svgText .= '<foreignobject x="'.self::BORDERDISTANCE.'" y="'.self::BORDERDISTANCE.'" width="'.($this->params[self::LEGENDWIDTHPOS] - (2*self::BORDERDISTANCE)).'" height="'.$this->params[self::LEGENDTITLEHEIGHTPOS].'" ><html><body  xmlns=\"http://www.w3.org/1999/xhtml\"><div class="'.self::TITLESTYLERULE.'">';
				
				if(isset($this->params[self::TITLELINKPOS]) && $this->params[self::TITLELINKPOS] != '')
					$svgText .= '<a href="'.$this->params[self::TITLELINKPOS].'">'.$this->params[self::TITLEPOS].'</a></div></body></html></foreignobject>';
				else
					$svgText .=  $this->params[self::TITLEPOS].'</div></body></html></foreignobject>';

				$jumps++;

			}

			if ($this->params[self::LEGENDIMAGEPOS] != null AND file_exists($conf_values['rootFolder'].$this->params[self::LEGENDIMAGEPOS]) ) {

				$h = self::BORDERDISTANCE;
				
				if ($jumps == 1){

					$h += $this->params[self::LEGENDTITLEHEIGHTPOS] + 5;
				}
				
				$this->params[self::LEGENDIMAGEHEIGHTPOS] = ($this->params[self::LEGENDIMAGEHEIGHTPOS] <= $this->params[self::LEGENDHEIGHTPOS] - self::BORDERDISTANCE - $h) ? $this->params[self::LEGENDIMAGEHEIGHTPOS] : $this->params[self::LEGENDHEIGHTPOS] - self::BORDERDISTANCE - $h;

				$svgText .= '<image y="'.$h.'" x="'.self::BORDERDISTANCE.'" xlink:href="'.$conf_values['rootFolder'].$this->params[self::LEGENDIMAGEPOS].'" height="'.$this->params[self::LEGENDIMAGEHEIGHTPOS].'" width="'.($this->params[self::LEGENDWIDTHPOS] - (2*self::BORDERDISTANCE)).'" viewbox="0 0 '.($this->params[self::LEGENDWIDTHPOS] - (2*self::BORDERDISTANCE)).' '.$this->params[self::LEGENDIMAGEHEIGHTPOS].'" preserveAspectRatio="xMidYMid" />';

				$svgText .= '<foreignobject x="'.self::BORDERDISTANCE.'" y="'.$h.'" width="'.($this->params[self::LEGENDWIDTHPOS] - (2*self::BORDERDISTANCE)).'" height="'.$this->params[self::LEGENDIMAGEHEIGHTPOS].'"><body><div></div></body></foreignobject>';

				$jumps += 2;

			}else if ($this->params[self::LEGENDIMAGEPOS] != null AND url_exists($this->params[self::LEGENDIMAGEPOS]) ) {

				$h = self::BORDERDISTANCE;
				
				if ($jumps == 1){

					$h += $this->params[self::LEGENDTITLEHEIGHTPOS] + 5;
				}
				
				$this->params[self::LEGENDIMAGEHEIGHTPOS] = ($this->params[self::LEGENDIMAGEHEIGHTPOS] <= $this->params[self::LEGENDHEIGHTPOS] - self::BORDERDISTANCE - $h) ? $this->params[self::LEGENDIMAGEHEIGHTPOS] : $this->params[self::LEGENDHEIGHTPOS] - self::BORDERDISTANCE - $h;

				$svgText .= '<image y="'.$h.'" x="'.self::BORDERDISTANCE.'" xlink:href="'.$this->params[self::LEGENDIMAGEPOS].'" height="'.$this->params[self::LEGENDIMAGEHEIGHTPOS].'" width="'.($this->params[self::LEGENDWIDTHPOS] - (2*self::BORDERDISTANCE)).'" viewbox="0 0 '.($this->params[self::LEGENDWIDTHPOS] - (2*self::BORDERDISTANCE)).' '.$this->params[self::LEGENDIMAGEHEIGHTPOS].'" preserveAspectRatio="xMidYMid" />';

				$svgText .= '<foreignobject x="'.self::BORDERDISTANCE.'" y="'.$h.'" width="'.($this->params[self::LEGENDWIDTHPOS] - (2*self::BORDERDISTANCE)).'" height="'.$this->params[self::LEGENDIMAGEHEIGHTPOS].'"><body><div></div></body></foreignobject>';

				$jumps += 2;

			}

			if ($this->params[self::LEGENDTEXTPOS] != null ) {

				$h = self::BORDERDISTANCE;

				if ($jumps == 1) {
					$h += $this->params[self::LEGENDTITLEHEIGHTPOS] + 5;
				} elseif ($jumps == 2) {
					$h += $this->params[self::LEGENDIMAGEHEIGHTPOS] + 5;
				} elseif ($jumps == 3) {
					$h += $this->params[self::LEGENDTITLEHEIGHTPOS] + $this->params[self::LEGENDIMAGEHEIGHTPOS] + 10;
				}

				$hh = $this->params[self::LEGENDHEIGHTPOS] - $h; //la place qui reste.

				if ( $hh > (20 + self::BORDERDISTANCE) ){ //si on a de la place pour écrire.
					
					$svgText .= '<foreignobject x="'.self::BORDERDISTANCE.'" y="'.$h.'" width="'.($this->params[self::LEGENDWIDTHPOS] - (2*self::BORDERDISTANCE)).'" height="'.($hh-self::BORDERDISTANCE).'" ><html><body  xmlns=\"http://www.w3.org/1999/xhtml\"><div class="'.self::TEXTSTYLERULE.'">'.$this->params[self::LEGENDTEXTPOS].'</div></body></html></foreignobject>';

				}

			}
			
			return $svgText;	
		}
		
		public function drawPointInfosModel (&$pPoint, $contextSize){

			global $conf_values;

			$this->params = $this->initParamList($pPoint);

			if(isset($this->params[self::TITLEPOS]) || isset($this->params[self::LEGENDIMAGEPOS]) || isset($this->params[self::LEGENDTEXTPOS]) ) {
				
				//calculer la position

				$pos = $this->calcultateInfosPos($pPoint, $contextSize);

				$svgText = "\n<g  id=\"".$pPoint->getID()."Infos\" style=\" visibility : hidden; display : none;\" transform=\"translate(".$pos.")\">\n\t";
				
				//paramètres par défaut

				$this->configureDefaultParam();

				//génération du fond
					
				$svgText .= $this->generateInfosBackground();
				
				//génération du contenus
				
				$svgText .= $this->generateInfosContent();
				
				$svgText .= "\n</g>\n";

				return $svgText;

			} else {
				return "";
			}
			
		}
		
		public function getParamForm(&$pPoint){ //delfaut param form
		
			$this->params = array();

			$this->params = $this->initParamList($pPoint);
			
			for($i = 0; $i < self::PARAMLISTSIZE; ++$i){
			
				if (!isset($this->params[$i])) $this->params[$i] = '';
				
			}
			
			$html = '<script>
			
			function disableTwoElem(id1, id2, id){
			
					document.getElementById(id1).disabled = document.getElementById(id2).disabled = (!document.getElementById(id).checked);
				
			}
			
			function disableOneElem(id1, id){
			
					document.getElementById(id1).disabled = (!document.getElementById(id).checked);
				
			}
			
			function disableElements(){
				
				document.getElementById(\'lP\').disabled = document.getElementById(\'hP\').disabled = document.getElementById(\'titrePL\').disabled = document.getElementById(\'titreHPL\').disabled = document.getElementById(\'titreHPLC\').disabled = document.getElementById(\'imagePL\').disabled = document.getElementById(\'imageHPL\').disabled = document.getElementById(\'imageHPLC\').disabled = document.getElementById(\'textPL\').disabled = document.getElementById(\'textHPLC\').disabled = document.getElementById(\'lPBG\').disabled = document.getElementById(\'lPBGC\').disabled = document.getElementById(\'lPT\').disabled = document.getElementById(\'lPTC\').disabled = document.getElementById(\'lPI\').disabled = document.getElementById(\'lPIC\').disabled = (!document.getElementById(\'legendP\').checked);
				
				if(document.getElementById(\'legendP\').checked){
					
					disableTwoElem(\'titrePL\', \'titreHPL\', \'titreHPLC\');
					disableTwoElem(\'imagePL\', \'imageHPL\', \'imageHPLC\');
				
					disableOneElem(\'textPL\', \'textHPLC\');
					disableOneElem(\'lPBG\', \'lPBGC\');
					disableOneElem(\'lPT\', \'lPTC\');
					disableOneElem(\'lPI\', \'lPIC\');
				
				}
				
			}
			
			</script>';
			
			$html .= '<input type="hidden" name="defModelName" value="'.$pPoint->getModelName().'"><label for="imageFP">Image de fond du point:</label> 
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="imageFP" name="imageFP" type="text" value="'.$this->params[self::IMAGEPOS].'" width="'.point::FORMLARGNESS.'"><br><hr><br>
				
				<label for="legendP">Paramètres de la légende:&nbsp;&nbsp;&nbsp; (activer la légende)</label><input type="checkbox" name="actived[]" id="legendP" value="SetLegend" onclick="disableElements()" checked><br><br>
				
				<label for="lP">Largeur:&nbsp;&nbsp;&nbsp;</label><input id="lP" name="lP" type="text" width="'.point::FORMLARGNESS.'" value="'.$this->params[self::LEGENDWIDTHPOS].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label for="hP">Hauteur:&nbsp;&nbsp;&nbsp;</label><input id="hP" name="hP" type="text" width="'.point::FORMLARGNESS.'" value="'.$this->params[self::LEGENDHEIGHTPOS].'"><br><br>
				
				<label for="titrePL">Titre:&nbsp;</label><input id="titrePL" name="titrePL" type="text" width="'.point::FORMLARGNESS.'" value="'.$this->params[self::TITLEPOS].'">&nbsp;&nbsp;&nbsp;<label for="titreHPL">Hauteur du titre:&nbsp;</label><input id="titreHPL" name="titreHPL" type="text" width="'.point::FORMLARGNESS.'" value="'.$this->params[self::LEGENDTITLEHEIGHTPOS].'">&nbsp;&nbsp;&nbsp; <input id="titreHPLC" type="checkbox" name="actived[]" value="SetTitre" onclick="disableTwoElem(\'titrePL\', \'titreHPL\', \'titreHPLC\')" checked><br><br>
				
				<label for="imagePL">Image:&nbsp;</label><input id="imagePL" name="imagePL" type="text" width="'.point::FORMLARGNESS.'" value="'.$this->params[self::LEGENDIMAGEPOS].'">&nbsp;&nbsp;&nbsp;<label for="imageHPL">Hauteur du image:&nbsp;</label><input id="imageHPL" name="imageHPL" type="text" width="'.point::FORMLARGNESS.'" value="'.$this->params[self::LEGENDIMAGEHEIGHTPOS].'">&nbsp;&nbsp;&nbsp;<input type="checkbox" name="actived[]" id="imageHPLC" value="SetImage"  
				onclick="disableTwoElem(\'imagePL\', \'imageHPL\', \'imageHPLC\')" checked><br><br>
				
				<label for="textPL">Texte:</label>&nbsp;&nbsp;&nbsp;<label for="textHPLC">(désactiver le texte)</label><input type="checkbox" name="actived[]" id="textHPLC" value="SetText" onclick="disableOneElem(\'textPL\', \'textHPLC\')" checked><br><textarea id="textPL" name="textPL" style="height: 150px; width: '.(point::FORMLARGNESS*3).'px ;">'.$this->params[self::LEGENDTEXTPOS].'</textarea><br><br><br>
				
				<label for="lPBG">Image de fonds de la légende:&nbsp;&nbsp;&nbsp;</label><input id="lPBG" name="lPBG" type="text" width="'.point::FORMLARGNESS.'" value="'.$this->params[self::LEGENDBGPOS].'">&nbsp;&nbsp;&nbsp;<input type="checkbox" name="actived[]" id="lPBGC" value="SetBGImage" onclick="disableOneElem(\'lPBG\', \'lPBGC\')" checked><br><br>
				
				<label for="lPT">Lien du titre:&nbsp;&nbsp;&nbsp;</label><input id="lPT" name="lPT" type="text" width="'.point::FORMLARGNESS.'" value="'.$this->params[self::TITLELINKPOS].'">&nbsp;&nbsp;&nbsp;<input type="checkbox" name="actived[]" id="lPTC" value="SetLinkTitle" onclick="disableOneElem(\'lPT\', \'lPTC\')" checked><br><br>
				
				<label for="lPI">Lien de l\'image:&nbsp;&nbsp;&nbsp;</label><input id="lPI" name="lPI" type="text" width="'.point::FORMLARGNESS.'" value="'.$this->params[self::IMAGELINKPOS].'">&nbsp;&nbsp;&nbsp;<input type="checkbox" name="actived[]" id="lPIC" value="SetLinkImage" onclick="disableOneElem(\'lPI\', \'lPIC\')" checked><br><br>
				
				
				';
				
			return $html;
			
		}
		
		public function treatParamForm(&$pPoint){
			
			$retour = '';
			
			if(isset($_POST['imageFP'])){
			
				$retour .= prepareSave($_POST['imageFP']);
				
				$act = array();
				
				foreach($_POST['actived'] as $key){
					$act[$key] = true;
				}
				
				if(isset($act['SetLegend'])){
					
					if(isset($_POST['hP']))
						$retour .= ','.prepareSave($_POST['hP']);
					else return $retour;
					
					if(isset($_POST['lP']))
						$retour .= ','.prepareSave($_POST['lP']);
					else return $retour;
					
					if(isset($act['SetTitre'])){
						
						if( isset($_POST['titrePL']) && isset($_POST['titreHPL']) )
							$retour .= ','.prepareSave($_POST['titrePL']).','.prepareSave($_POST['titreHPL']);
						else return $retour;
						
					} else $retour .= ',,';
					
					if(isset($act['SetImage'])){
						
						if( isset($_POST['imagePL']) && isset($_POST['imageHPL']) )
							$retour .= ','.prepareSave($_POST['imagePL']).','.prepareSave($_POST['imageHPL']);
						else return $retour;
						
					} else $retour .= ',,';
					
					if(isset($act['SetText'])){
						
						if( isset($_POST['textPL']) )
							$retour .= ','.prepareSave($_POST['textPL']);
						else return $retour;
						
					} else $retour .= ',';
					
					if(isset($act['SetBGImage'])){
						
						if( isset($_POST['lPBG']) )
							$retour .= ','.prepareSave($_POST['lPBG']);
						else return $retour;
						
					} else $retour .= ',';
					
					if(isset($act['SetLinkTitle'])){
						
						if( isset($_POST['lPT']) )
							$retour .= ','.prepareSave($_POST['lPT']);
						else return $retour;
						
					} else $retour .= ',';
					
					if(isset($act['SetLinkImage'])){
						
						if( isset($_POST['lPI']) )
							$retour .= ','.prepareSave($_POST['lPI']);
						else return $retour;
						
					} else $retour .= ',';
					
				} else return $retour;
				
			} else return $pPoint->getModelParam();
		
			return $retour;
			
		}
		
	}

?>
