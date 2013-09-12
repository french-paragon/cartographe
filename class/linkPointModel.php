<?php 

	class linkPointModel extends pointModel{

		const DELFAULTPARAMS = 'points_models/delfaut/delfaut.png'; //['./x';
		
		const IMAGEPOS = 0;
		const TARGETPOS = 1;
		
		const POINTBRILLANCEIMG = 'points_models/delfaut/deco.png';

		const BORDERDISTANCE = 20;
		
		public function drawEditor() {}
		
		public function initModelRelatedParams(&$pPoint){
		
			$params = $this->initParamList($pPoint);
			
			if(isset($params[self::IMAGEPOS])) $pPoint->setShowImage($params[self::IMAGEPOS]);
			$pPoint->setShowHeight(floatval($pPoint->getHeigth()) + floatval(2*self::BORDERDISTANCE) );
			$pPoint->setShowWidth( floatval($pPoint->getWidth()) + floatval(2*self::BORDERDISTANCE));
			
		}
		
		public function drawPointEditableModel(&$pPoint, $contextSize){

			global $conf_values;

			$params = $this->initParamList($pPoint);

			$svgText = '<g  id="'.$pPoint->getID().'" onclick="setDraggable(\''.$pPoint->getID().'\', true);" onmousemove="move(\''.$pPoint->getID().'\');" onmouserelease="setDraggable(\''.$pPoint->getID().'\', false);" onmouseover="document.getElementById(\''.$pPoint->getID().'_editP\').style.visibility = \'visible\';" title="'.$pPoint->getDescription().'">';
			$svgText .= '<image '.$pPoint->getXMLPos().' xlink:href="'.$conf_values['rootFolder'].$params[self::IMAGEPOS].'" height="'.$pPoint->getHeigth().'" width="'.$pPoint->getWidth().'" viewbox="'.$pPoint->getX().' '.$pPoint->getY().' '.$pPoint->getWidth().' '.$pPoint->getHeigth().'" preserveAspectRatio="xMidYMid Slice" />';

			$svgText .= '<foreignobject '.$pPoint->getXMLPos().' width="'.$pPoint->getWidth().'" height="'.$pPoint->getHeigth().'"><body xmlns=\"http://www.w3.org/1999/xhtml\"><div></div></body></foreignobject></g>';

			$svgText .= '<g id="'.$pPoint->getID().'_editP" transform="translate('.($pPoint->getX() + $pPoint->getWidth()/2 - 50).', '.($pPoint->getY() + $pPoint->getHeigth()/2).')><rect width="100" height="50" style="fill:rgb(255,255,255);stroke-width:3;stroke:rgb(0,0,0);visibility:hidden"/>';
			$svgText .= '<foreignobject width="100" height="50"><body xmlns=\"http://www.w3.org/1999/xhtml\"><div align="center"><br><a href="pointEditor.php?point='.$pPoint->getID().'" target="_blank"">Editer le point</a></div></body></foreignobject></g>';

			return $svgText;
			
		}
		
		public function drawPointModel (&$pPoint){

			global $conf_values;

			$params = $this->initParamList($pPoint);
			$svgText = '';

			if( isset($params[self::TARGETPOS]) ){
				$svgText .=  ' <a xlink:href="'.$params[self::TARGETPOS].'">';
			}
			
			$svgText .= '<g  id="'.$pPoint->getID().'" onmouseover="document.getElementById(\''.$pPoint->getID().'_deco\').style.visibility = \'visible\';" onmouseout="document.getElementById(\''.$pPoint->getID().'_deco\').style.visibility = \'hidden\';" title="'.$pPoint->getDescription().'">';
			$svgText .= '<image id="'.$pPoint->getID().'_deco" style=" visibility : hidden;" '.$pPoint->getXMLPosWD(-8).' xlink:href="'.self::POINTBRILLANCEIMG.'" height="'.($pPoint->getHeigth() + 16).'" width="'.($pPoint->getWidth() + 16).'" viewbox="'.($pPoint->getX() - 8).' '.($pPoint->getY() - 8).' '.($pPoint->getWidth() + 16).' '.($pPoint->getHeigth() + 16).'" preserveAspectRatio="xMidYMid Slice" />';
			$svgText .= '<image '.$pPoint->getXMLPos().' xlink:href="'.$conf_values['rootFolder'].$params[self::IMAGEPOS].'" height="'.$pPoint->getHeigth().'" width="'.$pPoint->getWidth().'" viewbox="'.$pPoint->getX().' '.$pPoint->getY().' '.$pPoint->getWidth().' '.$pPoint->getHeigth().'" preserveAspectRatio="xMidYMid Slice" />';

			$svgText .= '<foreignobject '.$pPoint->getXMLPos().' width="'.$pPoint->getWidth().'" height="'.$pPoint->getHeigth().'"><body xmlns=\"http://www.w3.org/1999/xhtml\"><div></div></body></foreignobject></g>';

			if( isset($params[self::TARGETPOS]) ){
				$svgText .=  ' </a>';
			}

			return $svgText;

		}
		
		public function drawPointInfosModel (&$pPoint, $contextSize){
			return ""; //return nothing cause à point has no informations.
		}
		
	}
	
?>
