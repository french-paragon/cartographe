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
				echo '<html><head>'.$this->head.'</head><body>'.$this->body.'</body></html>';
		}
		
	}

?>
