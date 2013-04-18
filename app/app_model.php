<?php
class AppModel extends Model {

	function getUrlPart($title, $fix=false) {
		$title = trim($title);

		if ( $fix!==false && isset($this->url_fix_map[$title]) ) $title = $this->url_fix_map[$title];

		$aSearch 	= array(" ", '"', "'", '#', ',', ';', '&'   , ':', '!', '?', '/', '*', '%', '$', '(', ')', '+', '=', '<', '>', '`', 'է', '[', ']', '{', '}', '@');
		$aReplace 	= array('-', '' ,  "",  '',  '',  '',  'and', '' , '' , '' , '' , '' , '' , '' , '' , '' , '' , '' , '' , '' , '' , '' , '' , '' , '' , '' , '');

		$title = str_replace($aSearch, $aReplace, $title);
		return urlencode(strtolower($title));
	}

	function getSlug($name,$id){
		return $this->getUrlPart($name.'-'.$id);
	}


}
?>
