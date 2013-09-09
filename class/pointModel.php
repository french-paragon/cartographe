<?php 

	abstract class pointModel{
	
		function __construct () {
			
		}
		
		abstract protected function drawEditor();
	
		abstract protected function drawPointModel (&$pPoint);
		
		abstract protected function drawPointInfosModel (&$pPoint, $contextSize);
		
		abstract protected function drawPointEditableModel(&$pPoint, $contextSize);

		protected function initParamList (&$pPoint) {

			$params = $pPoint->getModelParam();

			if (is_string($params)) {

				$params = explode(',', $params);
				$pPoint->setModelParam($params);

			} elseif (!is_array($params)) {

				$params = explode(',', self::DELFAULTPARAMS);
				$pPoint->setModelParam($params);

			}

			return $params;
		}
		
		public function getParamForm(&$pPoint){ //delfaut param form
		
			return '<input type="hidden" name="defModelName" value="'.$pPoint->getModelName().'"><label for"modelParam">Paramètre du modèle:</label><br><textarea id="modelParam" name="modelParam" style="height: 150px; width: '.(point::FORMLARGNESS*3).'px ;">'.$pPoint->getStringModelParam().'</textarea>';
			
		}
		
		public function treatParamForm(&$pPoint){
			
			if(isset($_POST['modelParam']) && isset($_POST['defModelName']) ){
			
				//if ($pPoint->getModelName() == $_GET['defModelName']) //avoid to set wrong parameter.
				return $_POST['modelParam'];
				
			}
			
		}
		
	}

?>
