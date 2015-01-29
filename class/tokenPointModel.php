<?php 

	class tokenPointModel extends pointModel{
	
		const DELFAULTPARAMS = 'points_models/delfaut/delfaut.png';
		
		const IMAGEPOS = 0;
		const TOKENWIDTHPOS = 1;
		const TOKENHEIGHTPOS = 2;
		const NOTOKENDEFPARAMNB = 3;
		const TOKENPARAMNB = 3;
		
		const POINTBRILLANCEIMG = './points_models/delfaut/deco.png';

		const BORDERDISTANCE = 20;
		
		public function drawEditor() {}
		
		public function drawPointModel (&$pPoint){

			global $conf_values;

			$params = $this->initParamList($pPoint);

			$svgText = '<g  id="'.$pPoint->getID().'pt" onclick="changeVisibility(\''.$pPoint->getID().'_tokens\');" onmouseover="document.getElementById(\''.$pPoint->getID().'_deco\').style.visibility = \'visible\';" onmouseout="document.getElementById(\''.$pPoint->getID().'_deco\').style.visibility = \'hidden\';" >';
			$svgText .= '<image id="'.$pPoint->getID().'_deco" style=" visibility : hidden;" '.$pPoint->getXMLPosWD(-8).' xlink:href="'.$conf_values['rootFolder'].self::POINTBRILLANCEIMG.'" height="'.($pPoint->getHeigth() + 16).'" width="'.($pPoint->getWidth() + 16).'" viewbox="'.($pPoint->getX() - 8).' '.($pPoint->getY() - 8).' '.($pPoint->getWidth() + 16).' '.($pPoint->getHeigth() + 16).'" preserveAspectRatio="xMidYMid Slice" />';
			$svgText .= '<image '.$pPoint->getXMLPos().' xlink:href="'.$conf_values['rootFolder'].$params[self::IMAGEPOS].'" '.$pPoint->getXMLSize().' viewbox="'.$pPoint->getX().' '.$pPoint->getY().' '.$pPoint->getWidth().' '.$pPoint->getHeigth().'" preserveAspectRatio="xMidYMid Slice" />';
			
			$svgText .= '<title>'.$pPoint->getDescription().'</title>';

			$svgText .= '<foreignobject '.$pPoint->getXMLPos().' '.$pPoint->getXMLSize().'><body xmlns=\"http://www.w3.org/1999/xhtml\"><div></div></body></foreignobject></g>';

			return $svgText;
			
		}
	
		public function drawPointInfosModel (&$pPoint, $contextSize){

			global $conf_values;

			$params = $this->initParamList($pPoint);
			
			$svgtext = '<g id="'.$pPoint->getID().'_tokens" style=" visibility : hidden;">';
			
			$s = count($params);
			$nb = ($s-self::NOTOKENDEFPARAMNB)/self::TOKENPARAMNB;
			
			$eqr_t = (floatval($params[self::TOKENHEIGHTPOS]) + floatval($params[self::TOKENWIDTHPOS])) /4;
			$eqr_p = ( $pPoint->getWidth() + $pPoint->getHeigth() ) /4;
			$alpha = 2*M_PI / $nb;
			$r = (self::BORDERDISTANCE + 2*$eqr_t)*1.5 / (sqrt(pow(sin($alpha), 2) + pow((1 - cos($alpha)),2))); // calculate the radius so the distance between point is self::BORDERDISTANCE (more or less)
			$r_fact = 1/1.5;
			
			$f = 1; //sens trigonométrique
			
			$spos = M_PI_2;
			$mpos = $spos + 2*M_PI;
			
			$hb = 0;
			if($pPoint->getY() + $r + 2*self::BORDERDISTANCE > $contextSize->getY()) $hb = -1; // un bord en bas
			if($pPoint->getY() < $r + 2*self::BORDERDISTANCE ) $hb = 1; // un bord en haut
			
			$sb = 0;
			if($pPoint->getX() + $r + 2*self::BORDERDISTANCE > $contextSize->getX()) $sb = -1; // un bord à droite
			if($pPoint->getX() < $r + 2*self::BORDERDISTANCE ) $sb = 1; // un bord à gauche
			
			if($hb == 0){ // pas de bornes verticale
				
				if($sb == 1){ // borne à gauche
					$spos = acos(-$pPoint->getX()/($r + 2*self::BORDERDISTANCE));
					$mpos = -$spos;
					$f = -1; // sens antitrigonométrique
				} else if($sb == -1) { // borne à droite
					$spos = acos(($contextSize->getX()-$pPoint->getX())/($r + 2*self::BORDERDISTANCE));
					$mpos = 2*M_PI - $spos;
				}
				
			} else if($hb == 1){ //borne en haut
				
				if($sb == 0){ // pas de bornes latéralle
					$spos = -asin($pPoint->getY()/($r + 2*self::BORDERDISTANCE));
					$mpos = 2*$spos - M_PI;
					$f = -1; // sens antitrigonométrique
				}else if($sb == 1){ // borne à gauche
					$spos = -asin($pPoint->getY()/($r + 2*self::BORDERDISTANCE));
					$mpos = -acos(-$pPoint->getX()/($r + 2*self::BORDERDISTANCE));
					$f = -1; // sens antitrigonométrique
				} else if($sb == -1) { // borne à droite
					$spos = M_PI - asin($pPoint->getY()/($r + 2*self::BORDERDISTANCE));
					$mpos = 2*M_PI - acos(($contextSize->getX()-$pPoint->getX())/($r + 2*self::BORDERDISTANCE));
				}
				
			} else if($hb == -1){ //borne en bas
				
				if($sb == 0){ // pas de bornes latéralle
					$spos = asin(($contextSize->getY()-$pPoint->getY())/($r + 2*self::BORDERDISTANCE));
					$mpos = M_PI - 2*$spos;
				}else if($sb == 1){ // borne à gauche
					$spos = asin(($contextSize->getY()-$pPoint->getY())/($r + 2*self::BORDERDISTANCE));
					$mpos = acos(-$pPoint->getX()/($r + 2*self::BORDERDISTANCE));
				} else if($sb == -1) { // borne à droite
					$spos = acos(($contextSize->getX()-$pPoint->getX())/($r + 2*self::BORDERDISTANCE));
					$mpos = M_PI - asin(($contextSize->getY()-$pPoint->getY())/($r + 2*self::BORDERDISTANCE));
				}
				
			}
			
			$r_fact = min(1/1.5,$r_fact*2*M_PI/abs($spos - $mpos));
			$r *= $r_fact;
			
			if($r < $eqr_p + $eqr_t + self::BORDERDISTANCE) $r = $eqr_p + $eqr_t + self::BORDERDISTANCE;
			
			$dx = ($hb == 0 AND $sb == 0) ? abs($spos - $mpos)/($nb) : abs($spos - $mpos + $pPoint->getWidth()/(2*$r))/($nb-1);
			$dx *= -$f;
			
			$ddx = (floatval($params[self::TOKENWIDTHPOS]) - $pPoint->getWidth())/2;
			$ddy = (floatval($params[self::TOKENHEIGHTPOS]) - $pPoint->getHeigth())/2;
			
			for($i = self::NOTOKENDEFPARAMNB; $i < $s; $i += self::TOKENPARAMNB){
			
				$pos = new coordonnee( ($r*cos($spos) - $ddx) .','. ($r*sin($spos) - $ddy) );
				
				$svgtext .= '<image id="'.$pPoint->getID().$i.'_token" '.$pPoint->getXMLPosWD($pos).' xlink:href="'.$conf_values['rootFolder'].$params[$i].'" height="'.$params[self::TOKENHEIGHTPOS].'" width="'.$params[self::TOKENWIDTHPOS].'" viewbox="'.$pPoint->getX().' '.$pPoint->getY().' '.$params[self::TOKENWIDTHPOS].' '.$params[self::TOKENHEIGHTPOS].'" preserveAspectRatio="xMidYMid Slice" ';
				
				$svgtext .= 'onmousedown="setDragable(\''.$pPoint->getID().$i.'_token\', evt);" 
				onmousemove="moveToken(\''.$pPoint->getID().$i.'_token\', evt);" 
				onmouseup="unsetDragableToken(\''.$pPoint->getID().$i.'_token\');"'; 
				
				if(preg_match("&^(https?:\/\/)?([\da-z\.-]+)\/?([\da-z_-]+\/)*([\da-z_-]+)?(\?([\da-z_-]+=[\da-z_-]+)*)?(#[\da-z_-]*)?$&", $params[$i+2])){
				
					$svgtext .= 'onclick = "if(evt.detail == 2){ window.open(\''.$params[$i+2].'\');}"';
					
				} else if(preg_match("#^pointclick@[\da-zA-Z]+$#", $params[$i+2])){
					
					$svgtext .= 'onclick = "if(evt.detail == 2){ document.getElementById(\''.substr($params[$i+2], 11).'\').onclick();}"';
					
				}
				
				$svgtext .= '><title>'.$params[$i+1].'</title></image>';
				
				
				$spos += $dx;
				
			}
			
			$svgtext .= '</g>';
			
			return $svgtext;
			
		}
		
		public function drawPointEditableModel(&$pPoint, $contextSize){

			global $conf_values;

			$params = $this->initParamList($pPoint);

			$svgText = '<g  id="'.$pPoint->getID().'" onclick="setDraggable(\''.$pPoint->getID().'\', true);" onmousemove="move(\''.$pPoint->getID().'\');" onmouserelease="setDraggable(\''.$pPoint->getID().'\', false);" onmouseover="document.getElementById(\''.$pPoint->getID().'_editP\').style.visibility = \'visible\';" title="'.$pPoint->getDescription().'">';
			$svgText .= '<image '.$pPoint->getXMLPos().' xlink:href="'.$conf_values['rootFolder'].$params[self::IMAGEPOS].'" '.$pPoint->getXMLSize().' viewbox="'.$pPoint->getX().' '.$pPoint->getY().' '.$pPoint->getWidth().' '.$pPoint->getHeigth().'" preserveAspectRatio="xMidYMid Slice" />';

			$svgText .= '<foreignobject '.$pPoint->getXMLPos().$pPoint->getXMLSize().'><body xmlns=\"http://www.w3.org/1999/xhtml\"><div></div></body></foreignobject></g>';

			$svgText .= '<g id="'.$pPoint->getID().'_editP" transform="translate('.($pPoint->getX() + $pPoint->getWidth()/2 - 50).', '.($pPoint->getY() + $pPoint->getHeigth()/2).')><rect width="100" height="50" style="fill:rgb(255,255,255);stroke-width:3;stroke:rgb(0,0,0);visibility:hidden"/>';
			$svgText .= '<foreignobject width="100" height="50"><body xmlns=\"http://www.w3.org/1999/xhtml\"><div align="center"><br><a href="pointEditor.php?point='.$pPoint->getID().'" target="_blank"">Editer le point</a></div></body></foreignobject></g>';

			return $svgText;
			
		}

		public function initModelRelatedParams(&$pPoint){
		
			$params = $this->initParamList($pPoint);
			
			if(isset($params[self::IMAGEPOS])) $pPoint->setShowImage($params[self::IMAGEPOS]);
			
		}
		
		public function drawPointInfosBGModel(&$pPoint, $contextSize){
			return ""; // return nothing by delfaut, point's usually dont write on background
		}
		
		public function getParamForm(&$pPoint){ //delfaut param form
		
			$params = array();

			$params = $this->initParamList($pPoint);
			
			$end_list = '';
			
			$s = count($params);
			
			for($i = 3; $i < $s; $i++){
				
				$end_list .= $params[$i].','.$params[++$i];
				if($i < $s-2) $end_list .= ',';
				
			}
		
			return '<label for="img_tool">Image du Button principal:&nbsp;</label><input id="img_tool" name="img_tool" type="text" width="'.point::FORMLARGNESS.'" value="'.$params[self::IMAGEPOS].'">
			<br><br>
			<label for="tokenWPL">Largeur des tokens:&nbsp;</label><input id="tokenWPL" name="tokenWPL" type="number" width="'.point::FORMLARGNESS.'" value="'.$params[self::TOKENWIDTHPOS].'">&nbsp;&nbsp;&nbsp;<label for="tokenHPL">Hauteur des tokens:&nbsp;</label><input id="tokenHPL" name="tokenHPL" type="number" width="'.point::FORMLARGNESS.'" value="'.$params[self::TOKENHEIGHTPOS].'">
			<br><br>
			<input type="hidden" name="defModelName" value="'.$pPoint->getModelName().'"><label for"modelParam">Liste des tokens:</label><br><textarea id="modelParam" name="modelParam" style="height: 150px; width: '.(point::FORMLARGNESS*3).'px ;">'.$end_list.'</textarea>';
			
		}
		
		public function treatParamForm(&$pPoint){
			
			$retour = '';
			
			if(isset($_POST['img_tool']))
				$retour = prepareSave($_POST['img_tool']);
			else
				$retour = self::DELFAULTPARAMS;
				
			if(isset($_POST['tokenWPL']) AND isset($_POST['tokenHPL']))
				$retour .= ','.intval($_POST['tokenWPL']).','.intval($_POST['tokenHPL']);
			else
				$retour .= ','.$pPoint->getWidth().','.$pPoint->getHeigth();
			
			if(isset($_POST['modelParam']) && isset($_POST['defModelName']) ){
			
				$p = explode(',', $_POST['modelParam']);
				
				foreach ($p as $key => $val){
					$p[$key] = prepareSave($val);
				}
				//if ($pPoint->getModelName() == $_GET['defModelName']) //avoid to set wrong parameter.
				$retour .= ','.implode(',', $p);
				
			}
			
			return $retour;
			
		}
		
	}

?>
