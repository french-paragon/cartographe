<?php 

	class linkPointModel extends pointModel{

		const DELFAULTPARAMS = './points_models/delfaut/delfaut.png, 41px, 41px'; //['./x';
		
		const IMAGEPOS = 0;
		const HEIGHTPOS = 1;
		const WIDTHPOS = 2;
		
		const TARGETPOS = 3;
		
		const POINTBRILLANCEIMG = './points_models/delfaut/deco.png';
		
		public function drawEditor() {}
		
		public function drawPointEditableModel(&$pPoint, $contextSize){

			$params = $this->initParamList($pPoint);

			$svgText = '<g  id="'.$pPoint->getID().'" onclick="setDraggable(\''.$pPoint->getID().'\', true);" onmousemove="move(\''.$pPoint->getID().'\');" onmouserelease="setDraggable(\''.$pPoint->getID().'\', false);" onmouseover="document.getElementById(\''.$pPoint->getID().'_editP\').style.visibility = \'visible\';">';
			$svgText .= '<image '.$pPoint->getXMLPos().' xlink:href="'.$params[self::IMAGEPOS].'" height="'.$params[self::HEIGHTPOS].'" width="'.$params[self::WIDTHPOS].'" viewbox="'.$pPoint->getX().' '.$pPoint->getY().' '.$params[self::WIDTHPOS].' '.$params[self::HEIGHTPOS].'" preserveAspectRatio="xMidYMid Slice" />';

			$svgText .= '<foreignobject '.$pPoint->getXMLPos().' width="'.$params[self::WIDTHPOS].'" height="'.$params[self::HEIGHTPOS].'"><body xmlns=\"http://www.w3.org/1999/xhtml\"><div></div></body></foreignobject></g>';

			$svgText .= '<g id="'.$pPoint->getID().'_editP" transform="translate('.($pPoint->getX() + $pPoint->getWidth()/2 - 50).', '.($pPoint->getY() + $pPoint->getHeigth()/2).')><rect width="100" height="50" style="fill:rgb(255,255,255);stroke-width:3;stroke:rgb(0,0,0);visibility:hidden"/>';
			$svgText .= '<foreignobject width="100" height="50"><body xmlns=\"http://www.w3.org/1999/xhtml\"><div align="center"><br><a href="pointEditor.php?point='.$pPoint->getID().'" target="_blank"">Editer le point</a></div></body></foreignobject></g>';

			return $svgText;
			
		}
		
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
