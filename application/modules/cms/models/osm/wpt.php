<?php
class wpt {
	var $id = 0;
	var $lat = 0;
	var $lng = 0;
	var $name = "";
	var $desc = "";
	var $sym = "";
	var $story = NULL;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getLat() {
		return $this->lat;
	}

	public function setLat($lat) {
		if (-90.0 <= $lat && $lat <= 90.0) {
			$this->lat = $lat;
		} else {
			die('latitude value outside of acceptable range (-90.0 <= value <= 90.0)');
		}
	}
	
	public function getLon(){
		return $this->getLng();
	}
	
	public function setLon( $lon ) {
		$this->setLng( $lon );
	}

	public function getLng() {
		return $this->lng;
	}

	public function setLng($lng) {
		if (-180.0 <= $lng && $lng < 180.0) {
			$this->lng = $lng;
		} else {
			die('longitude value outside of acceptable range (-180.0 <= value < 180.0)');
		}
	}

	function __construct($lat, $lng) {
		$this->setLat($lat);
		$this->setLng($lng);
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function setDesc($desc) {
		$this->desc = $desc;
	}

	public function getDesc() {
		return $this->desc;
	}

	public function setSym($sym) {
		$this->sym = $sym;
	}

	public function getSym() {
		return $this->sym;
	}
	
	public function setStory( $story ) {
		$this->story = $story;
	}
	
	public function getStory() {
		return $this->story;
	}
}

?>