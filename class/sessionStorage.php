<?php

class sessionStorage implements Serializable
{
	
	const MAXLOGTRY = 5;
	
	protected $user;
	protected $getPSW;
	
	private $tryC;
	
	protected $ul;

	public function __construct($pUserName, $pPSW, userLoader &$pUL){
		
		$this->ul = $pUL;
		$this->getPSW = sha1($pPSW);
		$this->user = $this->ul->getUser($pUserName);
		
	}
	
	public function setUserLoader(userLoader &$pUL) {
		
		$this->ul = $pUL;
		
	}
	
	public function isUserLoaderSet() {
		return isset($this->ul);
	}

    public function serialize()
    {
        $vars = get_object_vars($this);
        unset($vars['ul']);
        return serialize($vars);
    }

    public function unserialize($data)
    {
        $vars = unserialize($data);
        
        foreach ($vars as $var => $value) {
            $this->$var = $value;
        }
    }
	
	public function reInitUserDatas($pUserName, $pPSW) {
		
		$addTry = false;
		$pas = sha1($pPSW);
		
		if($this->getPSW != $pas) {
			$this->getPSW = $pas;
			$addTry = true;
		}
		
		if($this->user->getName() != $pUserName) {
			$this->user = $this->ul->getUser($pUserName);
			$addTry = true;
		}
		
		if ($addTry){
				$this->addTry();
		}
		
	}
	
	public function hasTooMuchLog() {
		return $this->tryC > self::MAXLOGTRY;
	}
	
	private function addTry() {
		$this->tryC += 1;
	}
	
	public function isUserRegistred(){ //renvoie vrai si l'utilisateur est enregistré, faux autrement
		
		if (isset($this->user)){
		
			if (is_a($this->user, 'user')){
				return true;
			} else {
				return false;
			}
			
		} else {
			return false;
		}
		
	}
	
	public function isUserIdentyfied(){
	
		if (is_a($this->user, 'user') && $this->tryC <= self::MAXLOGTRY) {
			
			$this->tryC = 0;
			
			return ($this->user->getPSW() == $this->getPSW);
			
		} else {
			return false;
		}
		
	}
		
	public function getSessionOpenMessage(){ //renvoie le code html à afficher à l'ouverture de session
		
		return 'Vous êtes loggué!';
		
	}
	
}

?>
