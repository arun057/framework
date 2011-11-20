<?php

require_once('wpt.php');

class gpx {
	var $wpts = array();

	public function setCreator($creator) {
		$this->creator = $creator;
	}

	public function __construct() {
	}

	public function addWpt($wpt) {
		if ($wpt instanceof wpt) {
			array_push($this->wpts, $wpt);
		} else {
			die('Parameter passed to gpx::addWpt($wpt) was not of type wpt.');
		}
	}

	public function toXml() {
		$dom = new DOMDocument('1.0', 'utf-8');		

		$root = $dom->createElementNS('http://www.topografix.com/GPX/1/1', 'gpx');

		$metaElem = $dom->createElement('metadata');
		$copyrightElem = $dom->createElement('copyright');
		$copyrightElem->setAttribute('author','OpenStreetMap and Contributors');
		$licenseElem = $dom->createElement('license', htmlspecialchars('http://creativecommons.org/licenses/by-sa/2.0/'));
		$copyrightElem->appendChild($licenseElem);
		$metaElem->appendChild($copyrightElem);
		$root->appendChild($metaElem);

		foreach ($this->wpts as $wpt) {
			$wptElem = $dom->createElement('wpt');
			$wptElem->setAttribute('lat', htmlspecialchars($wpt->getLat()));
			$wptElem->setAttribute('lon', htmlspecialchars($wpt->getLon()));

			$nameElem = $dom->createElement('name', htmlspecialchars($wpt->getName()));
			$wptElem->appendChild($nameElem);

			$descElem = $dom->createElement('desc', htmlspecialchars($wpt->getDesc()));
			$wptElem->appendChild($descElem);

			$symElem = $dom->createElement('sym', htmlspecialchars($wpt->getSym()));
			$wptElem->appendChild($symElem);

			$root->appendChild($wptElem);
		}

		$dom->appendChild($root);
		$dom->formatOutput = true;
		return $dom->saveXML();
	}
}

?>