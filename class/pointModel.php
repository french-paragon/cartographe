<?php 

	abstract class pointModel{
	
		function __construct () {
			
		}
	
		abstract protected function drawPointModel (&$pPoint);
		
		abstract protected function drawPointInfosModel (&$pPoint, $contextSize);

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
		
	}

?>
