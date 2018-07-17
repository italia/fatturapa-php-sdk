<?php

class parser {
	
	public function getData($xml) {

		$xml = new SimpleXMLElement($xml);

		var_dump($xml->FatturaElettronicaHeader);


		die;

	}


}