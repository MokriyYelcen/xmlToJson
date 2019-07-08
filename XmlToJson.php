<?php
class XmlToJson{
	protected $xml;
	public function __construct(string $xml){
		$this->xml=$xml;
	}
	

	public function getJson(){
		$sml=new SimpleXMLElement($this->xml);
		return '{'.self::SimpleXMLElementToJson($sml).'}';
		
	}

	protected static function SimpleXMLElementToJson(SimpleXMLElement $sml){
		$json=' "'.$sml->getName().'":';
	//part for the attributes from sml
	
		$attr=$sml->attributes();
		$attrCount=$attr->count();
		if($attrCount>0){
			$json.='{';
			foreach($attr as $key=>$value){
				$json.=' "'.$key.'": "'.$value.'",';
			}
			$json=substr($json, 0,-1);

		}
	//part for the child elemrnts from sml
		
	$children=$sml->children();

	if($children->count()==0){

		if(strlen($sml)>0){
			if($attrCount>0){
				$json.=',"#text": '.'"'.$sml.'"}';
			}
			else{
				$json.='"'.$sml.'"';
			}
		}
		if(strlen($sml)==0 && $attrCount==0){
			$json.='null';
		}
		if($attrCount>0){
			$json.='}';
		}
		
	}
	else{
		
		//need "," if children existed
		if($attrCount>0){
			$json.=',';
		}
		else{
			$json.='{';
		}
		foreach($children as $value){
			$json.=self::SimpleXMLElementToJson($value).',';
		}
		$json=substr($json, 0,-1);
		$json.='}';
	}
		
	
	return $json;
	} 

	


}