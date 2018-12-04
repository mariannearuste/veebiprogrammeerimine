<?php
class Test
{
	//omadused e muutujad
	private $secretNumber;
	public $publicNumber;
	//eriline funktsioon e konstruktor on see, mis käivitatakse kohe, klassi kasutuselevõtmisel e objekti loomisel
	function __construct($sentNumber){
		$this->secretNumber=5;
		$this->publicNumber=$this->secretNumber*$sentNumber;
		$this->tellSecret();
	}
	//eriline funktsioon, mida kasutatakse, kui klass suletakse/object eemaldatakse
	function __destruct(){
		echo "lõpetame";
	}
	
	private function tellSecret(){
		echo $this->secretNumber;
	}
	
	public function tellInfo(){
		echo "\n saladusi ei paljasta";
	}
	
}//class lõppeb
?>