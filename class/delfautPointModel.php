<?php 

	class delfautPointModel extends pointModel{

		const DELFAULTPARAMS = './points_models/delfaut/delfaut.png'; //['./points_models/delfaut/delfaut.png', '41px', '41px', null, null, null, null, null, null, null, null, null]

		const IMAGEPOS = 0;

		const TITLEPOS = 1;
		const LEGENDIMAGEPOS = 2;
		const LEGENDTEXTPOS = 3;
		const LEGENDHEIGHTPOS = 4;
		const LEGENDWIDTHPOS = 5;
		const LEGENDIMAGEHEIGHTPOS = 6;
		
		//facultative infos
		const TOOLTIPPOS = 7;
		const LEGENDBGPOS = 8;
		const TITLELINKPOS = 9;
		const IMAGELINKPOS = 10;

		const TITLESTYLERULE = 'delfautModelTitle';
		const TITLESTYLEHEIGHT = 40;

		const TEXTSTYLERULE = 'delfautModelText';

		const BORDERDISTANCE = 20;
		
		const POINTBRILLANCEIMG = './points_models/delfaut/deco.png';
		
		public function drawEditor() {}
		
		public function drawPointEditableModel(&$pPoint, $contextSize){

			$params = $this->initParamList($pPoint);

			$svgText = '<g  id="'.$pPoint->getID().'" onclick="setDraggable(\''.$pPoint->getID().'\', true);" onmousemove="move(\''.$pPoint->getID().'\');" onmouserelease="setDraggable(\''.$pPoint->getID().'\', false);" onmouseover="document.getElementById(\''.$pPoint->getID().'_editP\').style.visibility = \'visible\';" title="'.$params[self::TOOLTIPPOS].'">';
			$svgText .= '<image '.$pPoint->getXMLPos().' xlink:href="'.$params[self::IMAGEPOS].'" '.$pPoint->getXMLSize().' viewbox="'.$pPoint->getX().' '.$pPoint->getY().' '.$pPoint->getWidth().' '.$pPoint->getHeigth().'" preserveAspectRatio="xMidYMid Slice" />';

			$svgText .= '<foreignobject '.$pPoint->getXMLPos().$pPoint->getXMLSize().'><body xmlns=\"http://www.w3.org/1999/xhtml\"><div></div></body></foreignobject></g>';

			$svgText .= '<g id="'.$pPoint->getID().'_editP" transform="translate('.($pPoint->getX() + $pPoint->getWidth()/2 - 50).', '.($pPoint->getY() + $pPoint->getHeigth()/2).')><rect width="100" height="50" style="fill:rgb(255,255,255);stroke-width:3;stroke:rgb(0,0,0);visibility:hidden"/>';
			$svgText .= '<foreignobject width="100" height="50"><body xmlns=\"http://www.w3.org/1999/xhtml\"><div align="center"><br><a href="pointEditor.php?point='.$pPoint->getID().'" target="_blank"">Editer le point</a></div></body></foreignobject></g>';

			return $svgText;
			
		}
	
		public function drawPointModel (&$pPoint){

			$params = $this->initParamList($pPoint);

			$svgText = '<g  id="'.$pPoint->getID().'" onclick="viewInfo(\''.$pPoint->getID().'\');" onmouseover="document.getElementById(\''.$pPoint->getID().'_deco\').style.visibility = \'visible\';" onmouseout="document.getElementById(\''.$pPoint->getID().'_deco\').style.visibility = \'hidden\';" title="'.$params[self::TOOLTIPPOS].'">';
			$svgText .= '<image id="'.$pPoint->getID().'_deco" style=" visibility : hidden;" '.$pPoint->getXMLPosWD(-8).' xlink:href="'.self::POINTBRILLANCEIMG.'" height="'.($pPoint->getHeigth() + 16).'" width="'.($pPoint->getWidth() + 16).'" viewbox="'.($pPoint->getX() - 8).' '.($pPoint->getY() - 8).' '.($pPoint->getWidth() + 16).' '.($pPoint->getHeigth() + 16).'" preserveAspectRatio="xMidYMid Slice" />';
			$svgText .= '<image '.$pPoint->getXMLPos().' xlink:href="'.$params[self::IMAGEPOS].'" '.$pPoint->getXMLSize().' viewbox="'.$pPoint->getX().' '.$pPoint->getY().' '.$pPoint->getWidth().' '.$pPoint->getHeigth().'" preserveAspectRatio="xMidYMid Slice" />';

			$svgText .= '<foreignobject '.$pPoint->getXMLPos().$pPoint->getXMLSize().'><body xmlns=\"http://www.w3.org/1999/xhtml\"><div></div></body></foreignobject></g>';

			return $svgText;

		}
		
		public function drawPointInfosModel (&$pPoint, $contextSize){

			$params = $this->initParamList($pPoint);

			if($params[self::TITLEPOS] != null || $params[self::LEGENDIMAGEPOS] != null || $params[self::LEGENDTEXTPOS] != null ) {

				$lSize = new coordonnee($params[self::LEGENDWIDTHPOS].','.$params[self::LEGENDHEIGHTPOS]);
				$pos = $pPoint->getDiff($lSize);

				$pos->setX($pos->getX() + ($params[self::LEGENDWIDTHPOS]/2) + ($pPoint->getWidth()/2));
				$pos->setY($pos->getY() - self::BORDERDISTANCE);

				//si la position est au delà du bord droit:
				if($pos->getX() > $contextSize->getX() - $params[self::LEGENDWIDTHPOS] - self::BORDERDISTANCE) {

					$pos->setX($pPoint->getX() - $params[self::LEGENDWIDTHPOS] - self::BORDERDISTANCE);
					$pos->setY($pPoint->getY() - ($params[self::LEGENDIMAGEHEIGHTPOS]/2));

				} elseif ($pos->getX() < self::BORDERDISTANCE) { //si la position est trop pres du bord gauche:
				
					$pos->setX($pPoint->getX() + $pPoint->getWidth() + self::BORDERDISTANCE);
					$pos->setY($pPoint->getY() - ($params[self::LEGENDIMAGEHEIGHTPOS]/2));

				}

				if ($pos->getY() < self::BORDERDISTANCE && $pos->getY() >  $contextSize->getY() - $params[self::LEGENDIMAGEHEIGHTPOS] - self::BORDERDISTANCE) { } elseif ($pos->getY() < self::BORDERDISTANCE ){

					$pos->setY($pPoint->getY() + self::BORDERDISTANCE);

				}

				$svgText = "\n<g  id=\"".$pPoint->getID()."Infos\" style=\" visibility : hidden;\" transform=\"translate(".$pos.")\">\n\t";
				$jumps = 0;
				
				//paramètres par défaut
				
				if(!isset($params[self::LEGENDBGPOS]))
					$params[self::LEGENDBGPOS] = null;
					
				if(!isset($params[self::TITLELINKPOS]))
					$params[self::TITLELINKPOS] = null;
					
				if(!isset($params[self::IMAGELINKPOS]))
					$params[self::IMAGELINKPOS] = null;

				//génération du fond
					
				if (file_exists($params[self::LEGENDBGPOS])) {
					$svgText .= '<image y="0" x="0" xlink:href="'.$params[self::LEGENDBGPOS].'" height="'.$params[self::LEGENDHEIGHTPOS].'" width="'.$params[self::LEGENDWIDTHPOS].'" viewbox="0 0 '.$params[self::LEGENDWIDTHPOS].' '.$params[self::LEGENDHEIGHTPOS].'" preserveAspectRatio="none" />';

					//protection de l'image
					$svgText .= '<foreignobject x="0" y="0" width="'.$params[self::LEGENDWIDTHPOS].'" height="'.$params[self::LEGENDHEIGHTPOS].'"><body><div></div></body></foreignobject>'; 
				} else {
					$svgText .= '<rect style="fill:#ffffff;fill-opacity:1;fill-rule:nonzero;stroke:#000000;stroke-width:3;stroke-miterlimit:4;stroke-opacity:1;stroke-dasharray:none" width="'.$params[self::LEGENDWIDTHPOS].'" height="'.$params[self::LEGENDHEIGHTPOS].'" x="0" y="0" />';
				}

				if($params[self::TITLEPOS] != null ) {

					$svgText .= '<foreignobject x="'.self::BORDERDISTANCE.'" y="'.self::BORDERDISTANCE.'" width="'.($params[self::LEGENDWIDTHPOS] - (2*self::BORDERDISTANCE)).'" height="'.self::TITLESTYLEHEIGHT.'" ><html><body  xmlns=\"http://www.w3.org/1999/xhtml\"><div class="'.self::TITLESTYLERULE.'">';
					
					if(isset($params[self::TITLELINKPOS]))
						$svgText .= '<a href="'.$params[self::TITLELINKPOS].'">'.$params[self::TITLEPOS].'</a></div></body></html></foreignobject>';
					else
						$svgText .=  $params[self::TITLEPOS].'</div></body></html></foreignobject>';

					$jumps++;

				}

				if ($params[self::LEGENDIMAGEPOS] != null AND file_exists($params[self::LEGENDIMAGEPOS]) ) {

					$h = self::BORDERDISTANCE;
					
					if ($jumps == 1){

						$h += self::TITLESTYLEHEIGHT + 5;
					}
					
					$params[self::LEGENDIMAGEHEIGHTPOS] = ($params[self::LEGENDIMAGEHEIGHTPOS] <= $params[self::LEGENDHEIGHTPOS] - self::BORDERDISTANCE - $h) ? $params[self::LEGENDIMAGEHEIGHTPOS] : $params[self::LEGENDHEIGHTPOS] - self::BORDERDISTANCE - $h;

					$svgText .= '<image y="'.$h.'" x="'.self::BORDERDISTANCE.'" xlink:href="'.$params[self::LEGENDIMAGEPOS].'" height="'.$params[self::LEGENDIMAGEHEIGHTPOS].'" width="'.($params[self::LEGENDWIDTHPOS] - (2*self::BORDERDISTANCE)).'" viewbox="0 0 '.($params[self::LEGENDWIDTHPOS] - (2*self::BORDERDISTANCE)).' '.$params[self::LEGENDIMAGEHEIGHTPOS].'" preserveAspectRatio="xMidYMid" />';

					$svgText .= '<foreignobject x="'.self::BORDERDISTANCE.'" y="'.$h.'" width="'.($params[self::LEGENDWIDTHPOS] - (2*self::BORDERDISTANCE)).'" height="'.$params[self::LEGENDIMAGEHEIGHTPOS].'"><body><div></div></body></foreignobject>';

					$jumps += 2;

				}

				if ($params[self::LEGENDTEXTPOS] != null ) {

					$h = self::BORDERDISTANCE;

					if ($jumps == 1) {
						$h += self::TITLESTYLEHEIGHT + 5;
					} elseif ($jumps == 2) {
						$h += $params[self::LEGENDIMAGEHEIGHTPOS] + 5;
					} elseif ($jumps == 3) {
						$h += self::TITLESTYLEHEIGHT + $params[self::LEGENDIMAGEHEIGHTPOS] + 10;
					}

					$hh = $params[self::LEGENDHEIGHTPOS] - $h; //la place qui reste.

					if ( $hh > (20 + self::BORDERDISTANCE) ){ //si on a de la place pour écrire.
						
						$svgText .= '<foreignobject x="'.self::BORDERDISTANCE.'" y="'.$h.'" width="'.($params[self::LEGENDWIDTHPOS] - (2*self::BORDERDISTANCE)).'" height="'.($hh-self::BORDERDISTANCE).'" ><html><body  xmlns=\"http://www.w3.org/1999/xhtml\"><div class="'.self::TEXTSTYLERULE.'">'.$params[self::LEGENDTEXTPOS].'</div></body></html></foreignobject>';

					}

				}
				
				$svgText .= "\n</g>\n";

				return $svgText;

			} else {
				return "";
			}

			

		}
		
	}

?>
