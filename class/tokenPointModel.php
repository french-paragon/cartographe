<?php 

	class tokenPointModel extends pointModel{
	
		const DELFAULTPARAMS = 'points_models/delfaut/delfaut.png';
		
		const IMAGEPOS = 0;
		
		const POINTBRILLANCEIMG = './points_models/delfaut/deco.png';

		const BORDERDISTANCE = 20;
		
		public function drawEditor() {}
		
		public function drawPointModel (&$pPoint){

			global $conf_values;

			$params = $this->initParamList($pPoint);

			$svgText = '<g  id="'.$pPoint->getID().'pt" onclick="changeVisibility(\''.$pPoint->getID().'_tokens\');" onmouseover="document.getElementById(\''.$pPoint->getID().'_deco\').style.visibility = \'visible\';" onmouseout="document.getElementById(\''.$pPoint->getID().'_deco\').style.visibility = \'hidden\';" title="'.$pPoint->getDescription().'">';
			$svgText .= '<image id="'.$pPoint->getID().'_deco" style=" visibility : hidden;" '.$pPoint->getXMLPosWD(-8).' xlink:href="'.$conf_values['rootFolder'].self::POINTBRILLANCEIMG.'" height="'.($pPoint->getHeigth() + 16).'" width="'.($pPoint->getWidth() + 16).'" viewbox="'.($pPoint->getX() - 8).' '.($pPoint->getY() - 8).' '.($pPoint->getWidth() + 16).' '.($pPoint->getHeigth() + 16).'" preserveAspectRatio="xMidYMid Slice" />';
			$svgText .= '<image '.$pPoint->getXMLPos().' xlink:href="'.$conf_values['rootFolder'].$params[self::IMAGEPOS].'" '.$pPoint->getXMLSize().' viewbox="'.$pPoint->getX().' '.$pPoint->getY().' '.$pPoint->getWidth().' '.$pPoint->getHeigth().'" preserveAspectRatio="xMidYMid Slice" />';

			$svgText .= '<foreignobject '.$pPoint->getXMLPos().' '.$pPoint->getXMLSize().'><body xmlns=\"http://www.w3.org/1999/xhtml\"><div></div></body></foreignobject></g>';

			return $svgText;
			
		}
	
		public function drawPointInfosModel (&$pPoint, $contextSize){

			global $conf_values;

			$params = $this->initParamList($pPoint);
			
			$svgtext = '<g id="'.$pPoint->getID().'_tokens" style=" visibility : hidden;">';
			
			$s = count($params);
			
			$dx = $pPoint->getWidth() + self::BORDERDISTANCE;
			$f = ($pPoint->getX() + ($s-1)*$dx + 2*self::BORDERDISTANCE > $contextSize->getX() && $pPoint->getX() > ($s-1)*$dx - 2*self::BORDERDISTANCE) ? -1 : 1;
			
			$dx *= $f;
			
			$pos = new coordonnee( $f*2*self::BORDERDISTANCE .',0');
			
			
			for($i = 1; $i < $s; $i++){
				
				$svgtext .= '<image id="'.$pPoint->getID().$i.'_token" '.$pPoint->getXMLPosWD($pos).' xlink:href="'.$conf_values['rootFolder'].$params[$i].'" height="'.$pPoint->getHeigth().'" width="'.$pPoint->getWidth().'" viewbox="'.$pPoint->getX().' '.$pPoint->getY().' '.$pPoint->getWidth().' '.$pPoint->getHeigth().'" preserveAspectRatio="xMidYMid Slice" onmousedown="setDragable(\''.$pPoint->getID().$i.'_token\', evt);" onmousemove="moveToken(\''.$pPoint->getID().$i.'_token\', evt);" onmouseup="unsetDragableToken(\''.$pPoint->getID().$i.'_token\');"/>';
				
				$pos->setX($pos->getX() + $dx);
				
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
		
			return '<input type="hidden" name="defModelName" value="'.$pPoint->getModelName().'"><label for"modelParam">Paramètre du modèle:</label><br><textarea id="modelParam" name="modelParam" style="height: 150px; width: '.(point::FORMLARGNESS*3).'px ;">'.$pPoint->getStringModelParam().'</textarea>';
			
		}
		
		public function treatParamForm(&$pPoint){
			
			if(isset($_POST['modelParam']) && isset($_POST['defModelName']) ){
			
				$p = explode(',', $_POST['modelParam']);
				
				foreach ($p as $key => $val){
					$p[$key] = prepareSave($val);
				}
				//if ($pPoint->getModelName() == $_GET['defModelName']) //avoid to set wrong parameter.
				return implode(',', $p);
				
			}
			
		}
		
	}

?>
