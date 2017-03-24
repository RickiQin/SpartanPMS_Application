<?php

set_include_path(implode(PATH_SEPARATOR, array(
    __DIR__,
    get_include_path()
)));

require_once('all.inc');

class SiteBuilder {
	private $pageTitle, $metaArray, $cssImport, $jscriptImport;
	
	function __construct() {
		$this -> pageTitle = "Spartan Property Management";	
		$this -> setCSS();
		$this -> setJscript();
	}
	
	function setMeta($metaArray) {
		$this -> metaArray = $metaArray;
	}
	
	function setPageTitle($pageTitle) {
		$this -> pageTitle = $pageTitle;
	}
	
	function setCSS($cssArray = array(), $withDefaults = true) {
		if($withDefaults) {
		    // This loads the default CSS
			$this -> cssImport = "\t" . '<link rel="stylesheet" type="text/css" href="/css/spartanpms.css" />' . "\n"; 
		}	
			
		for($i = 0; $i < count($cssArray); $i++) {
			$this -> cssImport .= "\t" . '<link rel="stylesheet" type="text/css" href="' . $cssArray[$i] . '" />' . "\n"; 
		}
	}
	
	function setJscript($jscriptArray = array(), $withJquery = true) {
		if($withJquery) {
			$this -> jscriptImport = "\t" . '<script type="text/javascript" src="/js/jquery.js"></script>' . "\n";
            $this -> jscriptImport .= "\t" . '<script type="text/javascript" src="/js/jquery.bpopup.min.js"></script>' . "\n";
		}
		for($i = 0; $i < count($jscriptArray); $i++) {
			$this -> jscriptImport .= "\t" . '<script type="text/javascript" src="' . $jscriptArray[$i] . '"></script>' . "\n";
		}
		
	}
	
	function getHttpHeader() {
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' . "\n" . '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n";	
		$header .= "<head>\n";
		
		if(isset($this -> metaArray['title'])) {
			$header .= "\t" . '<title>' . $this -> metaArray['title'] . '</title>' . "\n";
		} else {
			$header .= "\t" . '<title>' . $this -> pageTitle . '</title>' . "\n";
		}
		$header .= "\t" . '<link rel="shortcut icon" href="/image/LogoIcon.png" type="image/png">' . "\n";
        $header .= "\t" . '<link href="/image/LogoIcon.png" type="image/png" rel="Bookmark" />' . "\n";
		$header .= "\t" . '<meta http-equiv="content-type" content="text/html;charset=utf-8" />' . "\n";
		
		if(isset($this -> metaArray)) {
			$header .= "\t" . '<meta name="description" content="' . $this -> metaArray['description'] . '" />' . "\n";
			$header .= "\t" . '<meta name="keywords" content="' . $this -> metaArray['keywords'] . '" />' . "\n";
			if(isset($this -> metaArray['noIndex']) && $this -> metaArray['noIndex'] == TRUE) {
				$header .= "\t" . '<meta name="robots" content="noindex" />' . "\n";
			} else {
				$header .= "\t" . '<meta name="robots" content="index,follow" />' . "\n";
			}
		}
	
		$header .= $this -> cssImport;
		$header .= $this -> jscriptImport;
		//$header .= file_get_contents('html/template/googleAnalytics.inc', true) . "\n";
		$header .= "</head>\n";
			
		return $header;
	}
	
	function getPageHeader($which = 0) {
		switch($which) {
			case 0: // DEFAULT HEADER
				include("html/template/pageHeader.php");
			break;
		}
	}
	
	function getPageFooter($which = 0) {
		switch($which) {
			case 0:
				include("html/template/pageFooter.php");
			break;
		}
	}
	
	function getNavigation($which = 0) {
		switch($which) {
			case 0:
				include("html/template/navigation.php");
			break;
		}
	}
    
    function getSearchForm($which = 0) {
        switch($which) {
            case 0:
                include("html/template/searchForm.php");
            break;
            case 1:
                include("html/template/searchFormRefine.php");
            break;
        }
    }
}
