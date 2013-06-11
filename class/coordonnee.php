<?php
     class coordonnee
     { 
		 
		 protected $x;
		 protected $y;
		 
		 public function __construct($dats)
          {
			  
			  if (preg_match("#^\d+.?\d*,\d+.?\d*$#", $dats)) {
			  
				$datas = explode(",", $dats);
			  
				$this->x = floatval($datas[0]);
				$this->y = floatval($datas[1]);
				  
				}
			  else {
			  
				$this->x = 0.0;
				$this->y = 0.0;
				  
				}
			  
			}
          
          public function getX() {
			  
			  return $this->x;
			  
			  }  
          
          public function getY() {
			  
			  return $this->y;
			  
			  } 
          
          public function setX($px) {
			  
			  $this->x = $px;
			  
			  }  
          
          public function setY($py) {
			  
			  $this->y = $py;
			  
			  } 
		 
	 }
?>
