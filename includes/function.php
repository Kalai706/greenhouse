<?php


/**
 * to print array
 *
 * @access	public
 * @param	array
 * @return	
 */
function pr($arr){
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}


/**
 * to get the url based on htaccess setting
 *
 * @access	public
 * @param	string	file_name url
 * @param  type htaccess or normal
 * @return	string
 */
function getUrl($file_name, $normal = '', $htaccess = '', $type=null)
	{
		global $CFG;
		$normal = $CFG['homePath'].$CFG['page_url'][$file_name]['normal'].$normal;
		$htaccess = $CFG['homePath'].$CFG['page_url'][$file_name]['htaccess'].$htaccess;
		return (!empty($type)) ? (($type == 'htaccess') ? $htaccess : $normal) : (($CFG['rewrite_mode']=='htaccess') ? $htaccess : $normal);  
		 	  
	}
	
/**
 * getCurrentUrl()
 * To get current url of the site
 *
 * @param mixed $with_query_string
 * @return
 */
function getCurrentUrl($with_query_string = true)
	{
		global $CFG;
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		if(!$with_query_string)
			{
				if(strpos($url, '?'))
					$url = substr($url, 0, strpos($url, '?'));
				if(strpos($url, '.php'))
					$url = substr($url, 0, strpos($url, '.php')+4);				
			}
		return $url;
	}	

/**
 * getMetaTags()
 * To get meta tags for the pages
 *
 * @param metatitle, metadescription, metakeyword
 * @return metatag
 */
function getMetaTags($metaType,$metaValue)
	{
		global $CFG;		
		$CFG['metatag'][$metaType] = $metaValue;
	}

		 ?>
		 
		