<?php

	class hiddenDelfautPointModel extends delfautPointModel{
		
		const WARNINGMSG = '<b>Attention, les informations contenues sur ce point peuvent contenir des spoilers. Ne regardez pas si vous êtes un joueur</b>';
		
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
				
				$svgText .= '<foreignobject onclick="unhideSpoiler(\''.$pPoint->getID().'\');" id="'.$pPoint->getID().'Protection" x="'.delfautPointModel::BORDERDISTANCE.'" y="'.delfautPointModel::BORDERDISTANCE.'" width="'.($this->params[delfautPointModel::LEGENDWIDTHPOS] - (2*delfautPointModel::BORDERDISTANCE)).'" height="'.($this->params[delfautPointModel::LEGENDHEIGHTPOS]- 2*delfautPointModel::BORDERDISTANCE).'" >';
				$svgText .= '<html><body  xmlns=\"http://www.w3.org/1999/xhtml\"><div class="'.self::TITLESTYLERULE.'">';
				$svgText .= $this->params[delfautPointModel::TITLEPOS].'<br>-<br>'.self::WARNINGMSG.'<br>-<br> cliquez pour voir les informations';
				$svgText .= '</div></body></html></foreignobject>';
				
				$svgText .= '<g id="'.$pPoint->getID().'Spoiler" style=" visibility : hidden; display : none;" >';
				
				$svgText .= $this->generateInfosContent();
				
				$svgText .= '</g>';
				
				$svgText .= "\n</g>\n";

				return $svgText;

			} else {
				return "";
			}
			
		}
		
	};

?>
