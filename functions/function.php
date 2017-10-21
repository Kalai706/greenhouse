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
 * to check member logged in or not
 *
 * @access	public
 * @param
 * @return	boolean
 */
function isMember()
	{
		if(isset($_SESSION['user']['is_logged_in']) and $_SESSION['user']['is_logged_in'])
			return true;
		return false;
	}


/**
 * return the url
 *
 * @access	public
 * @param	string
 * @return	string
 */
function URL($url)
	{
		return $url;
	}

/**
 * check the current page is ajax request
 *
 * @access	public
 * @param
 * @return	boolean
 */
function isAjaxPage()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		    $_SERVER ['HTTP_X_REQUESTED_WITH']  == 'XMLHttpRequest';
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
		//echo $normal = $CFG['page_url'][$file_name]['normal'].$normal;
		$normal = $CFG['site']['url'] .$CFG['page_url'][$file_name]['normal'].$normal;
		$htaccess = $CFG['site']['url'] .$CFG['page_url'][$file_name]['htaccess'].$htaccess;
		//$htaccess = $CFG['homePath'].$CFG['page_url'][$file_name]['htaccess'].$htaccess;
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
	
/**
 * isloggedIn()
 * Checks if session exists
 *
 * @return
 */
function isloggedIn()
	{
		if(isset($_SESSION['user']['user_id']) and $_SESSION['user']['user_id'])
			return true;
		return false;
	}	

/**
 * to redirection
 *
 * @access	public
 * @param	string
 * @return	static
 */
function Redirect2URL($url)
	{
		global $CFG;
		if(isAjaxpage() or $CFG['admin']['session_redirect_light_window_page'])
			{
				if(!isMember())
					{
						unset($_SESSION['url']);
						$param = '';
						if(isAjaxpage() and $CFG['html']['current_script_name'] != 'shareVideo')
							$param = '?ajax_page=true';
						$url = getUrl('login').$param;
					}
			}

		if (!headers_sent())
		    {
			   header('Location: '.URL($url));
			   //if IIS, then send Refresh header too (as a safe solution)...Location header doesn't seems to work in IIS
			   if (stristr($_SERVER['SERVER_SIGNATURE'], 'IIS'))
			   		header('Refresh: 0;url='.$url);
		    }
		else
			{
				trigger_error('Headers already sent', E_USER_NOTICE);
				echo '<meta http-equiv="refresh" content="0; URL='.URL($url).'" />'."\n";
				echo '<p>Please click this <a href="'.URL($url).'">link</a> to continue...</p>'."\n";
			}
		exit(0);
	}
	
/**
 * to get the url based on htaccess setting
 *
 * @access	public
 * @param	string	file_name url
 * @param	string	normal url
 * @param	string	htaccess url
 * @param	boolean	check url need to change or not(it may be current, root, members, nothing)
 * @return	string
 */
/*function getUrl($file_name, $normal = '', $htaccess = '', $change = '',$module='')
	{
		global $CFG;
		global $folder_names_arr;
		if ($CFG['feature']['rewrite_mode']=='htaccess' && $module == $CFG['admin']['index']['annals_module'])
			{
				$module = '';
			}
		$relativeUrl='';
		if(!$change)
			{
				$change='current';
			}
		$normal = $CFG['page_url'][$file_name]['normal'].$normal;
		$htaccess = $CFG['page_url'][$file_name]['htaccess'].$htaccess;

		if($CFG['feature']['rewrite_mode']=='clean')
			{
				$restricted_pages = array('addbookmark');
				if(!in_array($file_name, $restricted_pages))
					{
						$normal = getCleanUrl($normal);
					}
			}
		if($CFG['feature']['rewrite_mode']=='htaccess')
			{
				if(strrpos($htaccess, '/')==strlen($htaccess)-1 and ($htaccess!=$CFG['site']['url']) and ($htaccess!=$CFG['site']['url'].'/admin/'))
					{
						$htaccess = substr($htaccess, 0, strrpos($htaccess, '/')).$CFG['feature']['rewrite_mode_endwith'];
					}
				$htaccess = str_replace('/?', '.html?', $htaccess);
				$htaccess = str_replace('/&', '.html&', $htaccess);
			}

		if($module)
			{
				if($CFG['site']['relative_url']==$CFG['site']['url'])
					{
						$relativeUrl=$CFG['site']['url'].$module.'/';
					}
				foreach($folder_names_arr as $folder)
					{
						if($CFG['site']['relative_url']==$CFG['site']['url'].$folder)
							{
								$relativeUrl=$CFG['site']['url'].$module.'/'.$folder;
								break;
							}
					}
				foreach($CFG['site']['modules_arr'] as $mod)
					{
						if($CFG['site']['relative_url']==$CFG['site']['url'].$mod.'/')
							{
								$relativeUrl=$CFG['site']['url'].$module.'/';
								break;
							}
						if($CFG['site']['relative_url']==$CFG['site']['url'].$mod.'/rss/')
							{
								$relativeUrl=$CFG['site']['url'].$module.'/rss/';
								break;
							}
						if($CFG['site']['relative_url']==$CFG['site']['url'].'admin/'.$mod.'/')
							{
								$relativeUrl=$CFG['site']['url'].'admin/'.$module.'/';
								break;
							}

					}
				$siteUrl=$CFG['site']['url'].$module.'/';
			}
		else
			{
				foreach($CFG['site']['modules_arr'] as $mod)
					{
						if($CFG['site']['relative_url']==$CFG['site']['url'].$mod.'/')
							{
								$CFG['site']['relative_url']=$CFG['site']['url'];
							}
						if($CFG['site']['relative_url']==$CFG['site']['url'].$mod.'/rss/')
							{
								$relativeUrl=$CFG['site']['url'].'rss/';
								break;
							}
						if($CFG['site']['relative_url']==$CFG['site']['url'].$mod.'/admin/')
							{
								$relativeUrl=$CFG['site']['url'].'admin/';
								break;
							}
					}
				$siteUrl=$CFG['site']['url'];
			}
		if(!$relativeUrl)
			{
				$relativeUrl=$CFG['site']['relative_url'];
				$siteUrl=$CFG['site']['url'];
			}
		switch($change)
			{
				case 'current':
						if($CFG['feature']['rewrite_mode']=='htaccess')
							return $relativeUrl.$htaccess;
						else
							return $relativeUrl.$normal;
					break;

				case 'root':
						if($CFG['feature']['rewrite_mode']=='htaccess')
							return $siteUrl.$htaccess;
						else
							return $siteUrl.$normal;
					break;

				case 'members':
						if($CFG['feature']['rewrite_mode']=='htaccess')
							return $siteUrl.$htaccess;
						else
							return $siteUrl.$normal;
					break;

				case 'admin':
						if($CFG['feature']['rewrite_mode']=='htaccess')
							return $siteUrl.'admin/'.$htaccess;
						else
							return $siteUrl.'admin/'.$normal;
					break;

				case 'nothing':
						if($CFG['feature']['rewrite_mode']=='htaccess')
							return $htaccess;
						else
							return $normal;
					break;
			}
	}	*/
	
/**
 * getCurrentUrl()
 * To get current url of the site
 *
 * @param mixed $with_query_string
 * @return
 */
/*function getCurrentUrl($with_query_string = true)
	{
		global $CFG;
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		if(!$with_query_string)
			{
				if(strpos($url, '?'))
					$url = substr($url, 0, strpos($url, '?'));
				if(strpos($url, '.php'))
					$url = substr($url, 0, strpos($url, '.php')+4);
				//$url = $CFG['site']['relative_url'].$CFG['site']['script_name'];
			}
		return $url;
	}*/

/**
 * getQueryString()
 * To to get query string for the url
 *
 * @param mixed $url
 * @return
 */
function getQueryString($url)
	{
		if(strpos($url, '?'))
			$url = substr($url, strpos($url, '?'));
		if(strpos($url, '.php'))
			$url = substr($url, strpos($url, '.php')+4);

		return $url;
	}	
	
		 ?>
		 
		