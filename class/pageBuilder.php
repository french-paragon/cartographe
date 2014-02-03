<?php 

	class pageBuilder {
		
		protected $head;
		protected $body;
		
		public function addToHead($textToAdd) {
			$this->head .= $textToAdd;
		}
		
		public function addToBody($textToAdd) {
			$this->body .= $textToAdd;
		}
		
		public function drawPage () {
		
			global $conf_values;
		
			echo '<!DOCTYPE html>
					<html><head>
					<meta http-equiv="content-type" content="text/html; charset=UTF-8">
					<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8">
					<meta http-equiv="content-style-type" content="text/css">
					<link rel="stylesheet" type="text/css" href="'.$conf_values['rootFolder'].'styles/br.css">'.$this->head.'</head><body>'.$this->body.'</body></html>';
		}
		
	}

?>
