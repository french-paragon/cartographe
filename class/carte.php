<?php
    class carte
    {
		protected $index;
		protected $name;
		protected $image_fond;
		protected $deco_style;
		protected $deco_style_params;
		protected $x_size;
		protected $y_size;
		protected $description;
		protected $message;
		protected $isPublic;
		 
		public function __construct($pIndex, $pName, $pImage_fond, $pDeco_style, $pDeco_style_params, $pX_size, $pY_size, $pDecription, $pPublic){
			
			$this->index = $pIndex;
			$this->name = $pName;
			$this->image_fond = $pImage_fond;
			$this->deco_style = $pDeco_style;
			$this->deco_style_params = $pDeco_style_params;
			$this->x_size = $pX_size;
			$this->y_size = $pY_size;
			$this->description = $pDecription;
			$this->isPublic = $pPublic;
			
		}
		
		public function isPrivate() {
				return $this->isPrivate;
		}
		
		
		
	}
?>
