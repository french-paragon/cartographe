<?php 

	abstract class pointModel{
	
		function __construct () {
			
		}
	
		abstract protected function drawPointModel ($pPoint);
		
		abstract protected function drawPointInfosModel ($pPoint, $contextSize);
		
	}

?>
