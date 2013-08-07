<?php 

	class linkPointModel extends pointModel{

		const DELFAULTPARAMS = './points_models/delfaut/delfaut.png, 41px, 41px'; //['./x';
		
		const IMAGEPOS = 0;
		const HEIGHTPOS = 1;
		const WIDTHPOS = 2;
		
		const TARGETPOS = 3;
		
		const POINTBRILLANCEIMG = './points_models/delfaut/deco.png';
		
		public function drawPointModel (&$pPoint){

			$params = $this->initParamList($pPoint);
			$svgText = '';

			if( isset($params[self::TARGETPOS]) ){
				$svgText .=  ' <a xlink:href="'.$params[self::TARGETPOS].'">';
			}
			
			$svgText .= '<g  id="'.$pPoint->getID().'" onmouseover="document.getElementById(\''.$pPoint->getID().'_deco\').style.visibility = \'visible\';" onmouseout="document.getElementById(\''.$pPoint->getID().'_deco\').style.visibility = \'hidden\';" >';
			$svgText .= '<image id="'.$pPoint->getID().'_deco" style=" visibility : hidden;" '.$pPoint->getXMLPosWD(-8).' xlink:href="'.self::POINTBRILLANCEIMG.'" height="'.($params[self::HEIGHTPOS] + 16).'" width="'.($params[self::WIDTHPOS] + 16).'" viewbox="'.($pPoint->getX() - 8).' '.($pPoint->getY() - 8).' '.($params[self::WIDTHPOS] + 16).' '.($params[self::HEIGHTPOS] + 16).'" preserveAspectRatio="xMidYMid Slice" />';
			$svgText .= '<image '.$pPoint->getXMLPos().' xlink:href="'.$params[self::IMAGEPOS].'" height="'.$params[self::HEIGHTPOS].'" width="'.$params[self::WIDTHPOS].'" viewbox="'.$pPoint->getX().' '.$pPoint->getY().' '.$params[self::WIDTHPOS].' '.$params[self::HEIGHTPOS].'" preserveAspectRatio="xMidYMid Slice" />';

			$svgText .= '<foreignobject '.$pPoint->getXMLPos().' width="'.$params[self::WIDTHPOS].'" height="'.$params[self::HEIGHTPOS].'"><body xmlns=\"http://www.w3.org/1999/xhtml\"><div></div></body></foreignobject></g>';

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
