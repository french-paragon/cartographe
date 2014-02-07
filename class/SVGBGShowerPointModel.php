<?php 

	class SVGBGShowerPointModel extends pointModel{

		const DELFAULTPARAMS = 'points_models/delfaut/delfaut.png';
		
		const IMAGEPOS = 0;
		const SVGBGPOS = 1;
		const SVGFGPOS = 2;
		
		const POINTBRILLANCEIMG = 'points_models/delfaut/deco.png';

		const BORDERDISTANCE = 20;
		
		/*
		 * @override 
		 */
		protected function initParamList (&$pPoint) {

			$params = $pPoint->getModelParam();

			if (is_string($params)) {

				$params = explode('@', $params); // @ is less use in svg code than ,
				$pPoint->setModelParam($params);

			} elseif (!is_array($params)) {

				$params = explode('@', self::DELFAULTPARAMS);
				$pPoint->setModelParam($params);

			}

			return $params;
		}
		
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

			return "";
			
		}
	
		public function drawPointModel (&$pPoint){

			global $conf_values;

			$params = $this->initParamList($pPoint);
			
			$svgText = '<script>
				window.onscroll = function (event) {
					// called when the window is scrolled.
					
					document.getElementById(\''.$pPoint->getID().'pt\').setAttribute("transform", "translate(" + window.pageXOffset + ", " + window.pageYOffset + ")");
				}
			</script>';

			$svgText .= '<g  id="'.$pPoint->getID().'pt" onclick="changeVisibility(\''.$pPoint->getID().'SVGBG\'); changeVisibility(\''.$pPoint->getID().'SVGFG\');" onmouseover="document.getElementById(\''.$pPoint->getID().'_deco\').style.visibility = \'visible\';" onmouseout="document.getElementById(\''.$pPoint->getID().'_deco\').style.visibility = \'hidden\';" title="'.$pPoint->getDescription().'" style=" position : fixed; top : 0;">';
			$svgText .= '<image id="'.$pPoint->getID().'_deco" style=" visibility : hidden;" '.$pPoint->getXMLPosWD(-8).' xlink:href="'.$conf_values['rootFolder'].self::POINTBRILLANCEIMG.'" height="'.($pPoint->getHeigth() + 16).'" width="'.($pPoint->getWidth() + 16).'" viewbox="'.($pPoint->getX() - 8).' '.($pPoint->getY() - 8).' '.($pPoint->getWidth() + 16).' '.($pPoint->getHeigth() + 16).'" preserveAspectRatio="xMidYMid Slice" />';
			$svgText .= '<image '.$pPoint->getXMLPos().' xlink:href="'.$conf_values['rootFolder'].$params[self::IMAGEPOS].'" '.$pPoint->getXMLSize().' viewbox="'.$pPoint->getX().' '.$pPoint->getY().' '.$pPoint->getWidth().' '.$pPoint->getHeigth().'" preserveAspectRatio="xMidYMid Slice" />';

			$svgText .= '<foreignobject '.$pPoint->getXMLPos().' '.$pPoint->getXMLSize().'><body xmlns=\"http://www.w3.org/1999/xhtml\"><div></div></body></foreignobject></g>';

			return $svgText;

		}
		
		public function drawPointInfosModel (&$pPoint, $contextSize){

			$params = $this->initParamList($pPoint);
			
			if (isset($params[self::SVGFGPOS])) return '<g  id="'.$pPoint->getID().'SVGFG" style=" visibility : hidden;">'.$params[self::SVGFGPOS].'</g>';
			
			return '<g  id="'.$pPoint->getID().'SVGFG" style=" visibility : hidden;"></g>'; // return nothing if there's nothing to return
			
		}
		
		public function drawPointInfosBGModel(&$pPoint, $contextSize){

			$params = $this->initParamList($pPoint);
			
			if (isset($params[self::SVGBGPOS])) return '<g  id="'.$pPoint->getID().'SVGBG" style=" visibility : hidden;">'.$params[self::SVGBGPOS].'</g>';
			
			return '<g  id="'.$pPoint->getID().'SVGBG" style=" visibility : hidden;"></g>'; // return nothing if there's nothing to return
		}
	}
	
?>
