<?php
     class coordonnee
     { 
		 
		 protected $x;
		 protected $y;
		 
		 public function __construct($dats)
          {
			  
			  if (preg_match("#^-?\d+.?\d*,-?\d+.?\d*$#", $dats)) {
			  
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

	public function getDiff (coordonnee $pCord){

		$dx = $this->x - $pCord->getX();
		$dy = $this->y - $pCord->getY();

		return new coordonnee($dx.','.$dy);

	} 

	public function getXMLPos() {
		return 'x="'.$this->x.'" y="'.$this->y.'"';
	}

	public function getXMLPosWD($pD) {
		return 'x="'.($this->x + $pD).'" y="'.($this->y + $pD).'"';
	}

	public function getXMLSize() {
		return 'width="'.$this->x.'" height="'.$this->y.'"';
	}

	public function getXMLSizeWD($pD) {
		return 'width="'.($this->x + $pD).'" height="'.($this->y + $pD).'"';
	}

	public function __toString() {
		return $this->x.','.$this->y;
	}
		 
	 }
?>
