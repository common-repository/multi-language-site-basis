<?php
/**
Plugin Name: Multi-Language Site (Helper Framework)
Description: Plugin helps you to operate Multi-Language website. You can use this plugin in single WP installation too, but it's a framework to help your MULTI-SITE WORDPRESS to be more comfortable.  (P.S.  OTHER MUST-HAVE PLUGINS FOR EVERYONE: http://bitly.com/MWPLUGINS  ) 
Version: 2.11
Author: TazoTodua
Author URI: http://www.protectpages.com/profile
Plugin URI: http://www.protectpages.com/
Donate link: http://paypal.me/tazotodua
*/
define('version__MLSS', 2.11);		if (!defined('ABSPATH')) exit; //Exit if accessed directly
define('IS_MULTISITE__MLSS',		is_multisite());
global $wpdb;




 //define essentials
define('domainURL__MLSS',				(((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off') 
											|| $_SERVER['SERVER_PORT']===443) ? 
											'https://':'http://' ).$_SERVER['HTTP_HOST']);

define('wpURL__MLSS',					(IS_MULTISITE__MLSS ? network_home_url() : home_url())  );
define('wpFOLD__MLSS',					str_ireplace(domainURL__MLSS,'',	wpURL__MLSS)); 
										// define('PATH_CURRENT_SITE', '/subdir/');
define('homeURL__MLSS',					home_url());
define('homeFOLD__MLSS',				str_ireplace(domainURL__MLSS,'',	homeURL__MLSS));
define('requestURI__MLSS',				$_SERVER["REQUEST_URI"]);
define('requestURIfromHome__MLSS', 		str_ireplace(homeFOLD__MLSS, '',requestURI__MLSS) );
define('requestURIfromHomeWithoutParameters__MLSS',parse_url(requestURIfromHome__MLSS, PHP_URL_PATH));
define('currentURL__MLSS',				domainURL__MLSS.requestURI__MLSS);
define('THEME_URL_nodomain__MLSS',		str_ireplace(domainURL__MLSS, '', get_template_directory_uri()) ); 
define('PLUGIN_URL_nodomain__MLSS',		str_ireplace(domainURL__MLSS, '', plugin_dir_url(__FILE__)) );
define('THEME_DIR__MLSS',				get_stylesheet_directory() );
define('PLUGIN_DIR__MLSS',				plugin_dir_path(__FILE__) );
define('SITESLUG__MLSS',				str_ireplace('.','_',   str_ireplace('www.','',$_SERVER['HTTP_HOST']))  );
define('PluginName__MLSS',				'Multi-Language-Plugin-Simple');
define('pluginpage__MLSS',				'my-mlss-slug'); 
define('plugin_settings_page__MLSS', 	(IS_MULTISITE__MLSS ? network_admin_url('settings.php') : admin_url( 'options-general.php') ). '?page='.pluginpage__MLSS  ); 
define('STYLESHEETURL__MLSS',			plugin_dir_url(__FILE__).'flags/stylesheet.css');
define('cookienameLngs__MLSS',			SITESLUG__MLSS.'_lang');
define('MyEmailAddress__MLSS',			'tazotodua+wp@gmail.com' );
define('NewsPostTypeName__MLSS',		'news_mlss');
define('CatBaseWpOpt__MLSS',			get_option('category_base') ); 
define('C_CategPrefix__MLSS',			''); //'_'.get_site_option('CategSlugname', 'categories')
define('S_CategPrefix__MLSS',			'');
define('PagePrefix__MLSS',				''); //'_'.get_site_option('PageSlugname', 'pages')
define('IS_ADMIN__MLSS',				IS_ADMIN() ); //'_'.get_site_option('PageSlugname', 'pages')
define('IS_HOME__MLSS',					(requestURIfromHome__MLSS==='' || requestURIfromHome__MLSS==='/') );  
define('IS_NEW_WP__MLSS',				(function_exists('get_sites')) );  
$GLOBALS['NetworkHome__MLSS']=	(IS_MULTISITE__MLSS && is_main_site() ||  (currentURL__MLSS===wpURL__MLSS));	
add_action('init','homeurls_define__MLSS'); function homeurls_define__MLSS(){
	$GLOBALS['NetworkHome__MLSS']=	$GLOBALS['NetworkHome__MLSS'] && is_home();	
}



//|| IS_HOME__MLSS ) ); 
//'_'.get_site_option('PageSlugname', 'pages')
define('old_plugin_url', 				'http://plugins.svn.wordpress.org/multi-language-site-basis/assets/multi-language-site-basis-1.78.zip');


	


//==================================================== ACTIVATION commands ===============================	

	//REDIRECT SETTINGS PAGE (after activation)
	add_action( 'activated_plugin', function($plugin) { if( $plugin === plugin_basename( __FILE__ ) ) { 
		//if not "update"/"re-activate" action, but a clean install
		$g= get_mainsite_options__MLSS();
		exit(wp_redirect( (is_multisite() ? network_admin_url('settings.php') : admin_url('admin.php')) .'?page='.pluginpage__MLSS. ( !empty($g) ? "&update_d=y" :'')) ); 
	} } );

	//ACTIVATION HOOK
register_activation_hook( __FILE__, 'activation__MLSS' ); 
//register_deactivation_hook( __FILE__, 'deactivation__MLSS' ); 

add_action('plugins_loaded', 're_update__MLSS',1); function re_update__MLSS(){ refresh_options__MLSS(); } 	

		
function refresh_options__MLSS(){
	$opts	=get_mainsite_options__MLSS();
	$initial=$opts;
  // Defaults
	$InitialArray = array( 
		'sub_sites'	=> array() ,		
		'manual_lang_sites'	=> array() ,		
		'OnOffMode'	=> 'oon',			'FirstMethod'=> 'dropddd',			'DefForOthers'	=> 'dropdownn' ,
		'DropdHeader'=> 'ddropdown',	'DropdDFixedOrAbs'	=> 'fixed',		'DropdSidePos'=> 'left' ,
		'DropdDistanceTop'	=> '70' ,	'DropdDistanceSide'	=> '50',
		'IncludeNamesDropd'	=>  "full", 'IncludeNamesShortc'=>  "abbrev",		'IncludeFlagsDropd'	=>  1 , 
		'CategSlugname'	=> '' ,			'PageSlugname'=> '' ,
		'DisableTranslateError'=> 0,	'table1installed'	=> 1,			'redirect_from_main_to_lang_sub'=> 1,	'DefaultHome'=> '' ,
		'MS_Targets'=> array(
			'eng'=> array('United States','United Kingdom'),
			'rus'=> array('Russian Federation','Belarus','Ukraine','Kyrgyzstan'),
			),	
		'MS_Target_default'=> 'eng',
		'FixedLang'	=> 'eng' ,
	);
		
		foreach($InitialArray as $name=>$value){if (!array_key_exists($name,$opts)) { $opts[$name]=$value; } }
  // MUST-CHANGED array
	$opts['version']	= version__MLSS;
	//$opts['NeedFlush']	=  'okk';
	if($initial!=$opts) {	update_mainsite_options__MLSS('Opts__MLSS',$opts);	}
	return $opts;
}		


function activation__MLSS() { 	global $wpdb;
	// die if not network (when MULTISITE )
    if ( is_multisite() && ! strpos( $_SERVER['REQUEST_URI'], 'wp-admin/network/plugins.php' ) ) {	die ( __( '<script>alert("Activate this plugin only from the NETWORK DASHBOARD.");</script>') );    }
	
	
	
	$opts = refresh_options__MLSS();
	
	// ============================  IF UPDATING OLD VERSION ===============================
	$old_tablename = $GLOBALS['wpdb']->base_prefix.'_'.Table1slug__MLSS;
	$new_mainSite_tablename= $GLOBALS['wpdb']->base_prefix.Table1slug__MLSS;
  //if OLD table exists, and new table doesnt, then rename
	if ( ($wpdb->query("show tables like '".$old_tablename."'")) > 0 && !($wpdb->query("show tables like '".$new_mainSite_tablename."'") > 0)  )  {  $d = $wpdb->query("RENAME TABLE `" . $old_tablename. "` TO `" .  $new_mainSite_tablename. "`");  } 
	// ============================ ### IF UPDATING OLD VERSION =============================
	
	
  
	//=================================== create tables		===============================
						 $bla55555 = $wpdb->get_results("SELECT SUPPORT FROM INFORMATION_SCHEMA.ENGINES WHERE ENGINE = 'InnoDB'");
						 $engine = ''; //'ENGINE='. ( !empty($bla55555[0]->SUPPORT) ? 'InnoDB' : 'MyISAM'  );
						 //) ".$engine." DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;"
						 $charset = $wpdb->get_charset_collate();
	//1 (for phrazes)
	$x= $wpdb->query("CREATE TABLE IF NOT EXISTS `".Table1__MLSS."` (
		`IDD` int(11) NOT NULL AUTO_INCREMENT,
		`title_indx` varchar(150) NOT NULL,
		`lang` varchar(150) NOT NULL,
		`translation` LONGTEXT  NOT NULL DEFAULT '',
		`mycolumn3` LONGTEXT CHARACTER SET latin1 NOT NULL DEFAULT '',
		PRIMARY KEY (`IDD`),
		UNIQUE KEY `IDD` (`IDD`)
		) ".$charset." AUTO_INCREMENT=1;"
	);
	
	// ============= for Alternative Posts =============
	$LangLines=""; 	foreach(ActiveLangs__MLSS() as $name=>$value){ $LangLines .= "`$name` varchar(255) NOT NULL DEFAULT '', \r\n"; }
					
	$x= $wpdb->query("CREATE TABLE IF NOT EXISTS `".TableGroupIDs__MLSS."` (
		`ID` int(11) NOT NULL AUTO_INCREMENT,
		`groupId` TINYTEXT NOT NULL DEFAULT '',
		".$LangLines."
		`extra1_` MEDIUMTEXT  NOT NULL DEFAULT '',
		`extra2_` MEDIUMTEXT  NOT NULL DEFAULT '',
		`extra3_` MEDIUMTEXT  NOT NULL DEFAULT '',
		PRIMARY KEY (`ID`),
		UNIQUE KEY `ID` (`ID`)
		) ".$charset." AUTO_INCREMENT=1;"
	);
	//If updating, check if some languages dont exist.. if so, insert new column
	UpdateNewLangsColumns__MLSS();
	
	
	
	//flush-update permalinks for CUSTOM POST TYPES 
	GetLanguagesFromBase__MLSS();
	
	//if (!$opts['table1installed']){
		//$r1=UPDATEE_OR_INSERTTT__MLSS(Table1__MLSS, array('translation'=>'Hii user!!!'),	array('title_indx'=>'my_HeadingMessage', 'lang'=>'eng'));
		//$r2=UPDATEE_OR_INSERTTT__MLSS(Table1__MLSS, array('translation'=>'haи иуzer!'),		array('title_indx'=>'my_HeadingMessage', 'lang'=>'rus'));
	//	$opts['table1installed']=true;
	//}
		
	update_mainsite_options__MLSS('Opts__MLSS',$opts);
}
				// WHEN INSERTING a NEW COLUMN in POST_RELATION table
				function UpdateNewLangsColumns__MLSS(){ global $wpdb;
					$all_columns = $wpdb->get_col( "DESC " . TableGroupIDs__MLSS , 0 );
					foreach(ActiveLangs__MLSS(true) as $name=>$value){
						if (!in_array($name, $all_columns )){  $result= $wpdb->query(
							"ALTER     TABLE ".TableGroupIDs__MLSS."     ADD $name     VARCHAR(100)     CHARACTER SET utf8     NOT NULL    AFTER groupId" 
						);}
					}
				}
	
//========================================= ### END  ACTIVATION ####===============================



//  ============================ DETECTING if  MULTI-SITE or separate utilization =====================
	function get_mainsite_options__MLSS($keyname=false){ 
		if(is_multisite()){
			$x = get_site_option('Opts__MLSS', array());  
			if($keyname && is_array($x) && !empty($x)) { $x= array_key_exists($keyname,$x) ? $x[$keyname] : ''; }
		}
		else{
			$x = get_options__MLSS($keyname);  
		}
		return $x;
	} 

	function get_options__MLSS($keyname=false){ 
		$x = get_option_for_this_site__MLSS('Opts__MLSS', array());  
		if($keyname && is_array($x) && !empty($x)) { $x= array_key_exists($keyname,$x) ? $x[$keyname] : ''; }
		return $x;
	} 

	function update_mainsite_options__MLSS($name,$value){ return (is_multisite() ? update_site_option($name,$value) : update_option($name,$value)); }
	
	
	
	
	function get_optMLSS_for_this_site__MLSS($keyname=false){
		return (This_Site_is_in_MS_LANG_SUBSITES() ? get_mainsite_options__MLSS($keyname) : get_options__MLSS($keyname) );
	}
	
	function get_option_for_this_site__MLSS($name){
		return (This_Site_is_in_MS_LANG_SUBSITES() ? get_site_option($name) : get_option($name) );
	}
	function update_option_for_this_site__MLSS($name,$value){
		return (This_Site_is_in_MS_LANG_SUBSITES() ? update_site_option($name,$value) : update_option($name,$value) );
	}
	
	// check if current blog is part of MultiSite languaged blogs.
	function This_Site_is_in_MS_LANG_SUBSITES(){
		if(is_multisite()){
			return  ( is_main_site() || in_array(get_blog_name__MLSS(),array_keys(ActiveLangs__MLSS())) );
		}
		return false;
	}
	
  //Get Blog slug, i.e. "subdir"  from "http://example.com/subdir/"
	function get_blog_name__MLSS(){
						//if cached
						if (!empty($GLOBALS['this_sitename__MLSS'])) return $GLOBALS['this_sitename__MLSS'];

		if(is_multisite()){
			global $blog_id;
			$current_blog_details = IS_NEW_WP__MLSS ? get_site($blog_id) : get_blog_details( array( 'blog_id' => $blog_id ) );
			$b_slug = basename($current_blog_details->path);
		}
		else{
			$b_slug=SITESLUG__MLSS;
		}
		return $GLOBALS['this_sitename__MLSS']=$b_slug; 
	}
	
	function this_site_lang__MLSS(){
		if (This_Site_is_in_MS_LANG_SUBSITES()) return get_blog_name__MLSS();
		else return false;
	}

define('DB_PREFIX__MLSS', 			(This_Site_is_in_MS_LANG_SUBSITES() ? $GLOBALS['wpdb']->base_prefix  : $GLOBALS['wpdb']->prefix )) ;
define('Table1slug__MLSS',			'mlss_translatedwords');
define('Table1__MLSS',				DB_PREFIX__MLSS.Table1slug__MLSS);
define('TableGroupIDs__MLSS',		DB_PREFIX__MLSS.'mlss_postgroups');
define('TablePostsRel__MLSS',		DB_PREFIX__MLSS.'mlss_postrelations');
define('OldTablePostsRel__MLSS',	DB_PREFIX__MLSS.'mlss_postrelationsOld');
		

//get OPTS
$opts=$GLOBALS['MLSS_OPTS']=get_mainsite_options__MLSS(); 
			if(empty($opts['version'])){activation__MLSS(); $opts=$GLOBALS['MLSS_OPTS']=get_mainsite_options__MLSS(); } 
define('FullMode__MLSS',	('oon' === $opts['OnOffMode'])   );

	
	function This_SiteNameLanguage(){
		if(This_Site_is_in_MS_LANG_SUBSITES()) return $GLOBALS['this_sitename__MLSS'];
		else{
			//if single install, then at this moment, no support for language detection..
			return '';
		}
	}
	




//========================================= SEVERAL USEFUL FUNCTIONS ===============================
//CHECK IF USER IS ADMIN
	function iss_admiiiiiin__MLSS()   	{require_once(ABSPATH.'wp-includes/pluggable.php'); return (current_user_can('manage_options')? true:false);}
	function iss_editorrr__MLSS()   	{require_once(ABSPATH.'wp-includes/pluggable.php'); return (current_user_can('manage_categories')? true:false);}
	function iss_admiiiiiin_network__MLSS()	{require_once(ABSPATH.'wp-includes/pluggable.php'); return (current_user_can('manage_network')? true:false);}
	function die_if_not_admin__MLSS()	{if(!iss_admiiiiiin__MLSS()) {die('not adminn_error_755 '.$_SERVER["SCRIPT_FILENAME"]);}	}
//CHECK IF USER CAN MODIFY OPTIONS PAGE
	function NonceCheck__MLSS($value, $action_name){if ( !isset($value) || !wp_verify_nonce($value, $action_name) ) { die("error_5151, Refresh the page");}}	
//add_action( 'wp_head', 'noindex_pagesss__MLSS' );	  //IT'S BETTER, THAT USELESS PAGES WERE NOT INDETEX BY GOOGLE
	function noindex_pagesss__MLSS() {
		if ( !is_404() && !is_page() && !is_single() && !is_search() && !is_archive() && !is_admin() && !is_attachment() && !is_author() && !is_category() && !is_front_page() && !is_home() && !is_preview() && !is_tag())  { echo '<meta name="robots" content="noindex, nofollow"><!-- by MLSS -->'; }
	}	
//function to replace double-slashes with one slashes
	function remove_double_slashes__MLSS($input){$x=$input; $x=str_replace('//','/', $x);  $x=str_replace('\\\\','\\', $x);  return str_replace(':/','://',$x);}
//return plain string
	function PlainString__MLSS(&$text1=false,&$text2=false,&$text3=false,&$text4=false,&$text5=false,&$text6=false,&$text7=false,&$text8=false){
		for($i=1; $i<=8; $i++){    if(${'text'.$i}) {${'text'.$i} = preg_replace('/\W/si','',${'text'.$i});} 	}
		return $text1;
	}
	
	define('ALLOW_COOKIE_LANG_ON_MAINPAGE__MLSS', true);
	
//function to check, if language detection is in Automatic mode
	function if_allowed_autoLang__MLSS(){$opts =get_optMLSS_for_this_site__MLSS(); 	return (!in_array($opts['FirstMethod'], array('nothing','fixeddd')));	}
	
//REDIRECT function (301,303,307 or 404)
	function  REDIRECTTT__MLSS($url, $RedirCodee=false){
		if (defined('MLSS_cstRedirect')) {return;}
		header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); header("Pragma: no-cache"); header("Expires: Thu, 01 Jan 1970 00:00:00 GMT"); 
		header("location:" . $url, true, ($RedirCodee ? $RedirCodee : 301) ); exit; 
	} //FIX for WP BUG,, w hile site loaded in: Appearence>customize.php:
		if (stripos(currentURL__MLSS, admin_url('customize.php')) !== false)	{define('MLSS_cstRedirect',true);} 
	//Children of above
	function MAYBE_REDIRECTTT__MLSS($url,$RedirCodee=false, $force=false){ if (FullMode__MLSS ||  $force) {REDIRECTTT__MLSS($url,$RedirCodee);} }



//DETECT PLATFORM ===(check Updates:::: https://github.com/tazotodua/useful-php-scripts/ )
function get_OperatingSystem__MLSS() { 
	$user_agent=$_SERVER['HTTP_USER_AGENT']; $final =array(); $final['os_namee']="_Unknown_OS_";  $final['os_typee']="_Unknown_OS_";
	$os_array=array(
		'MOUSED'	=> array('/windows nt 6.3/i'=>'Windows 8.1', '/windows nt 6.2/i'=>'Windows 8', '/windows nt 6.1/i'=>'Windows 7',	'/windows nt 6.0/i'=>'Windows Vista','/windows nt 5.2/i'=>'Windows Server 2003/XP x64', '/windows nt 5.1/i'=>'Windows XP', '/windows xp/i'=>'Windows XP','/windows nt 5.0/i'=>'Windows 2000','/windows me/i'=>'Windows ME','/win98/i'=>'Windows 98','/win95/i'=>'Windows 95','/win16/i'=>'Windows 3.11',
			'/macintosh|mac os x/i' =>'Mac OS X','/mac_powerpc/i'=>'Mac OS 9', '/linux/i'=>'Linux','/ubuntu/i'=>'Ubuntu',	),
		'NOMOUSED'	=> array('/iphone/i'=>'iPhone','/ipod/i'=>'iPod','/ipad/i'=>'iPad','/android/i'=>'Android','/blackberry/i'=>'BlackBerry', '/webos/i'=>'Mobile'	)
	);
	foreach($os_array as $namee=>$valuee) { foreach ($valuee as $regex => $value1) {	if(preg_match($regex, $user_agent)){$final['os_namee']=$value1;  $final['os_typee'] = $namee;}		} } 	return $final;
}  $zz = get_OperatingSystem__MLSS();
$GLOBALS['MLSS_VARS']['isMobile'] = ( $zz['os_typee'] != 'MOUSED' ?    true : false );

//Redirect from NOTFOUND WP pages, but currently not used, because 404 redirection inside "add_action" may cause problems in custom pages (i.e. where include(..'/wp-load.php');). So, it's better,that this function was in header.php
	function errorrrr_404__MLSS(){if (is_404() && WP_USE_THEMES === true )	{REDIRECTTT__MLSS(homURL,404);}}
	add_action( 'init', 'add_some_supportss__MLSS', 1); function add_some_supportss__MLSS() {  add_theme_support('post-thumbnails');  }
	
//die if not plain string
	function DieIfNotPlainPhrase__MLSS($text){if ($text!=PlainString__MLSS($text)) {die();}}
//DETECT ROOT CATEGORY slug for current 'post'
	function PostRootCatDetect__MLSS($postid=false, $catid=false) { $catParent='';
		if (!$postid){ $p=$GLOBALS['post'];	$postid= is_array($p) ? $p['ID'] : $p->ID; }
		if (!$catid) {$x=get_the_category($postid);    if (!empty($x[0])) {$catid=$x[0]->term_id;} }
		// continue, untill a parent $catid will be null
		
		while ($catid) 	{ $cat = get_category($catid);	$catid = $cat->category_parent;  $catParent=$cat->slug; }
		return $catParent;
	}
//DETECT ROOT PAGE slug for current 'page'
	function PageRootDetect__MLSS($postid=false, $pageid=false) { $catParent=''; $pslug='';
		if (!$postid){ $p=$GLOBALS['post'];	$postid=is_array($p) ? $p['ID'] : $p->ID;	}
		if (!$pageid) {$x=get_post($postid);  if (!empty($x)) {$pageid=$x->post_parent;}		}
		// continue, untill a parent $pageid will be null
		while ($pageid != 0) 	{ $pg = get_post($pageid);   $pageid = $pg->post_parent;   $pslug=$pg->post_name; }
		return $pslug;
	}

//	decedant checker
if ( !function_exists( 'post_is_in_descendant_category' ) ) { function post_is_in_descendant_category( $cats, $_post = null ) {
		foreach ( (array) $cats as $cat ) {	$descendants = get_term_children( (int) $cat, 'category' );
			if ( $descendants && in_category( $descendants, $_post ) ) {return true;}				
		} return false;
	}
}	

//CSS CLASSES for BODY
add_filter('body_class', 'my_body_class__MLSS'); function my_body_class__MLSS($classes){
	if (defined('LNG')) {$classes[]='MLSS-'.LNG; } 
	return $classes;
}

//INSERT VALUE IN DATABASE  ===(check Updates:::: https://github.com/tazotodua/useful-php-scripts/blob/master/mysql-commands%20%28%2BWordpress%29.php )
	function UPDATEE_OR_INSERTTT__MLSS($tablename, $NewArray, $WhereArray){	global $wpdb; $arrayNames= array_keys($WhereArray);
		//convert array to STRING
		$o=''; $i=1; foreach ($WhereArray as $key=>$value){ $value= is_numeric($value) ? $value : "'".addslashes($value)."'"; $o .= $key . " = $value"; if ($i != count($WhereArray)) { $o .=' AND '; $i++;}  }
		//check if already exist
		$CheckIfExists = $wpdb->get_var("SELECT ".$arrayNames[0]." FROM $tablename WHERE $o");
		if (!empty($CheckIfExists))	{	return $wpdb->update($tablename,	$NewArray,	$WhereArray	);}
		else						{	return $wpdb->insert($tablename, 	array_merge($NewArray, $WhereArray)	);	}
	}
// DETECT FLAG'S URLs
	define('FlagFolder__MLSS', "/flags__MLSS");
	function GetFlagUrl__MLSS($lang){  $lang =basename($lang);
		$flg1= dirname(PLUGIN_DIR__MLSS).FlagFolder__MLSS   ."/$lang.png";
		$flg2= 		   PLUGIN_DIR__MLSS 		 		  ."/flags/$lang.png";
		if	  (file_exists($flg1))	{$flag_url= dirname( PLUGIN_URL_nodomain__MLSS) .FlagFolder__MLSS  ."/$lang.png";}
		elseif(file_exists($flg2))	{$flag_url=			 PLUGIN_URL_nodomain__MLSS  			     ."/flags/$lang.png";}
		else						{$flag_url= '';}
		return $flag_url;
	}
// WHEN FLUSH IS NEEDED
	function FINAL_MyFlush__MLSS(){}
	function MyFlush__MLSS($RedirectFlushToo=false){	$GLOBALS['wp_rewrite']->flush_rules(); 
		//DUE TO WORDPRESS BUG ( https://core.trac.wordpress.org/ticket/32023 ) , i use this: (//USE ECHO ONLY! because code maybe executed before other PHP functions.. so, we shouldnt stop&redirect, but  we should redirect from already executed PHP output )
		if($RedirectFlushToo) { echo '<form name="mlss_frForm" method="POST" action="" style="display:none;"><input type="text" name="mlss_FRRULES_AGAIN" value="ok" /> <input type="submit"> </form> <script type="text/javascript">document.forms["mlss_frForm"].submit();</script>'; }
	}

// Function to die (with alert) when LNG is called, but it is not defined.
	function Check_Lng_defined__MLSS(){
		if (defined('LNG') ) {  $res = LNG; }
		elseif (!empty($_COOKIE[cookienameLngs__MLSS])) {  $res = $_COOKIE[cookienameLngs__MLSS]; }
		else { do_action('your_desired_func444');
			$message= '<div class="mlss_5921" style="font-size:0.8em;text-align:center;background-color:red;">(LNG parameter was not defined. So, on this page, there may be problems. (Error_5921 from MLSS plugin))</div>'."<br/>";   //echo '<script type="text/javascript">alert("'.$message.'");</script>';
			if (!$GLOBALS['opts']['DisableTranslateError']) {echo $message;}
			$res = Get_Default_Lang__MLSS();
		}
		return $res;
	}


	function Get_Default_Lang__MLSS(){   $x=  ActiveLangs__MLSS();  return (isset($x[0]) ? $x[0] : '') ; }
	function Restore_Original_Blog__MLSS(){ 
		if(!empty($GLOBALS['_wp_switched_stack'][0])){
			switch_to_blog( $GLOBALS['_wp_switched_stack'][0] );
		}
		$GLOBALS['_wp_switched_stack'] = array();
		$GLOBALS['switched']           = FALSE;
	}

	

	function Is_Home_Probably__MLSS(){
		if(IS_HOME__MLSS) return true;
		if ($GLOBALS['wp_query']->is_main_query()){
			foreach ($GLOBALS['wp_query'] as $key=>$value){
				if(in_array($key,array('is_home','is_front_page'))) {
					if($value){ return true;}
				}
			}
		}
		return false;
	}
	
	function SetHomeUrlInNavigation__MLSS(){
		return $GLOBALS['HomeUrlInNavig__MLSS']=( is_multisite() ?  wpURL__MLSS : homeURL__MLSS);
	}
	
	
	//$GLOBALS['MLSS_VARS'] =array();
	//$GLOBALS['MLSS_CURRENT_SITE'] 			= get_current_site();
	if(!is_multisite()) { $x = array(); } 
	else{
		if(IS_NEW_WP__MLSS){ $x = call_user_func('get_sites', array('network_id'=>null, 'public'=>true) ); }
		else { 
			$x =call_user_func('wp_get_sites', array('network_id'=>null, 'public'=>true) );
			foreach ($x as $name=>$value){
				$x[$name]= (object) $value;
			}
		}
		
	}
	$GLOBALS['MLSS_BLOG_LIST']=$x;
	
	
//================================================= ##### SEVERAL USEFUL FUNCTIONS ===============================















	
//DETERMINE, WHEN PLUGIN SHOULD START LANG_DETERMINATION/TYPE REGISTRATION (default 7, OTHER PLUGINS CAN CHANGE THIS TOO)
define('MLSS_actionstarts', 'plugins_loaded');
define('MLSS_initNumb', 	(defined('MLSS_INIT_POINT') ? MLSS_INIT_POINT : 1));

//==================================================== pre-define languages ===============================
add_action(MLSS_actionstarts,'Defines_MLSS',MLSS_initNumb);
function Defines_MLSS()	{$x=ActiveLangs__MLSS(); if(!empty($x)){ foreach (array_filter($x) as $n=>$v) { define ($n.'__MLSS',$n); define($n.'_title__MLSS',$v['title']);} }  }
function GetLanguagesFromBase__MLSS(){
	// see COUNTRY_NAME abbreviations here (should be 639-3 type https://en.wikipedia.org/wiki/ISO_639-3 ) 
	return $GLOBALS['SiteLangs__MLSS'] = array_merge( 
		get_mainsite_options__MLSS('manual_lang_sites', array() ),       
		get_mainsite_options__MLSS('sub_sites', array())  
	);
}
function ActiveLangs__MLSS($fresh=false){  
	if (!$fresh && isset($GLOBALS['ActiveLangs__MLSS'])){ return $GLOBALS['ActiveLangs__MLSS']; }
	$final =false;
	$x=GetLanguagesFromBase__MLSS();
	if(!empty($x)) {
		foreach($x as $key=>$value){
			if(isset($value['enabled']) && $value['enabled']) { $final[$key]=$value; }
		}
	}
	return $GLOBALS['ActiveLangs__MLSS'] = $final ?: array();
} function LANGS__MLSS()	{ return ActiveLangs__MLSS();} 
	
	//RETURN TRANSLATION FOR ANY KEY_NAME, according to visitor's detected language
	function TRANSLATE_mlss($variable,$lang=false, $desired = array()){$lng=$lang ? $lang : Check_Lng_defined__MLSS();
		PlainString__MLSS($variable,$lng);
		$final= '_____'.$variable.'_____';
		//if already translated in current PageLoad
		if(!empty($GLOBALS['translated__MLSS'][$variable]) ){	$final=$GLOBALS['translated__MLSS'][$variable];	}
		else{
			$res= Translation_Exists_for__MLSS($variable,$lng);
			if(!empty($res))		{ $got_word = $final = stripslashes($res[0]->translation);  }
			if(!empty($desired) && $desired[$lng]!=$final){ 
			  foreach($desired as $eachLang=>$eachValue){
				UPDATEE_OR_INSERTTT__MLSS(Table1__MLSS,  array('translation'=>$eachValue),
														 array('title_indx'=>$variable, 'lang'=> $eachLang) );
			  }
			  $final=$desired[$lng];
			}
		}
		return  $GLOBALS['translated__MLSS'][$variable] = $final;
	} add_filter('MLSS','TRANSLATE_mlss',10,3);  //you can pass additional variables into this filter too.
	
	function Translation_Exists_for__MLSS($variable_name,$lng){
		return $GLOBALS['wpdb']->get_results("SELECT * from `".Table1__MLSS."` WHERE `title_indx`= '$variable_name' AND `lang` = '".$lng."'");
	}
	
	
	
	//to get the last COOKIE-d language value
	DEFINE("LastCookiedLanguage__MLSS", !empty($_COOKIE[cookienameLngs__MLSS]) ? $_COOKIE[cookienameLngs__MLSS] : '' );
	
	
	
	
//============================================================================================= //	
//======================================== SET LANGUAGE for visitor =========================== //	
//============================================================================================= //	

//redirect_from_main_to_lang_sub

add_action(MLSS_actionstarts, 'DetectLangUsingUrl__MLSS', 3); 
function DetectLangUsingUrl__MLSS(){ 
		
  //if preview
	if (isset($_GET['previewDropd__MLSS'])) { define('SHOW_FT_POPUP_MLSS', true); return; }			
  //if LNG parameter is already defined by developer (i dont know, maybe with his own logic)
	if (defined('LNG_PASSED'))	{define ('LNG',LNG_PASSED); return; }
	
	// ================================== start detection =======================//	
	$found=false;
	
	//If Multi-site enabled	
	if (is_multisite()){	
		//if this is MAIN SITE
		if(is_main_site()){ 
			//if Cookie-method allowed
			if(if_allowed_autoLang__MLSS() && ALLOW_COOKIE_LANG_ON_MAINPAGE__MLSS){
				if(array_key_exists(LastCookiedLanguage__MLSS, ActiveLangs__MLSS())) {
					$found = LastCookiedLanguage__MLSS;    //if plugin enabled, doesnt matter if admin even want to detect or not the LANG for the site (we just detect lang for any case)
				}
			}
		}
		//if sub-site is enabled for LANGUAGING
		elseif(This_Site_is_in_MS_LANG_SUBSITES())	{
			$found = get_blog_name__MLSS(); 
		} 
		//if not turned on for this site
		else{
			return '';
		}
	}
	// if not multisite, then leave it for future update
	else{
		return '';
	}
				// our variable...
				add_action('init',function(){ define('isLangHomeURI__MLSS',	(empty($_GET) && is_home() && This_Site_is_in_MS_LANG_SUBSITES()) ); }, 1);

	//===================================== INITIALIZE LANGUAGE ============================
	//LANGUAGE detected
	if ($found && array_key_exists($found, ActiveLangs__MLSS()) ){
		define('LNG', $found); setcookie(cookienameLngs__MLSS, $found, time()+10000000, wpFOLD__MLSS);
		X_action_redirect__MLSS();
		
	}
	//LANGUAGE was NOT detected
	else {
		//need inside INIT, because ADMIN_URL's may be hidden by other plugins, we should execute ADMIN_CHECK on init 1000
		X_action_trigger__MLSS();
	}
}

		//IF it not home (i.e.  site.com/eng/?p=123&sea ).. then we dont need redirection (also,when page is unknown (for example, custom page or "wp-login.php" or etc... )
		function Is_Backend__MLSS(){
			$includes=get_included_files();
			$path	= str_replace(array('\\','/'), DIRECTORY_SEPARATOR, ABSPATH);
			return (is_admin() || in_array($path.'wp-login.php', $includes) || in_array($path.'wp-register.php', $includes) );
			//return (!!array_intersect(array($ABSPATH_MY.'wp-login.php',$ABSPATH_MY.'wp-register.php') , get_included_files())) ;
		}
			
		function X_action_redirect__MLSS()	{  add_action('wp_loaded', 'redirect_if_main_homepage__MLSS', 1002);}
		function redirect_if_main_homepage__MLSS(){  
			if(!Is_Backend__MLSS()){
				if(is_main_site()){
					if(Is_Home_Probably__MLSS()) {
						MAYBE_REDIRECTTT__MLSS(homeFOLD__MLSS."/".LNG."/", 303, true);
					}
				}
			}
		}



		function X_action_trigger__MLSS()	{  add_action('wp_loaded', 'Trigger_When_No_Langs_Detected__MLSS', 1002);}
		function Trigger_When_No_Langs_Detected__MLSS(){
			if (!FullMode__MLSS) return;
			if (Is_Backend__MLSS()) return;
				
			$opts =get_optMLSS_for_this_site__MLSS(); 
			//if cookie not set, it maybe first-time visit 
			switch($opts['FirstMethod']){
				case 'nothing':	
					return;
					break;

				case 'dropddd':	
					define('SHOW_FT_POPUP_MLSS', true); return;
					break;
				
				case 'ip_detectt':	
					include( dirname(__file__) .'/flags/ip_country_detect/GeoIP_V2/sample_test.php'); //gets $country_name
					if (!empty($country_name)){
						foreach (ActiveLangs__MLSS() as $name=>$value){ 
							//if (empty($opts['MS_Targets'][$name])) { var_dump($name); echo "not set in langs. error69245 in MLSS plugin"; exit; }
							//elseif(in_array($country_name,$opts['MS_Targets'][$name]) ) {
							if(!empty($opts['MS_Targets'][$name]) && in_array($country_name,$opts['MS_Targets'][$name]) ) {
								define('LNG',$name); 
								setcookie(cookienameLngs__MLSS, LNG, time()+9999999, homeFOLD__MLSS);
								break;
							}
						}
					}
					if (!defined('LNG')) {
						//if default set, then redirect him
						if ($opts['DefForOthers'] === 'fixedd'){ 
							define('LNG',$opts['MS_Target_default']); 
							setcookie(cookienameLngs__MLSS, LNG, time()+9999999, homeFOLD__MLSS); 
						}
						//if "Show Popup" chosen
						else{	
							define('SHOW_FT_POPUP_MLSS', true); return;	
						}
					}
					break;
					
					
				case 'fixeddd':	
					define('LNG',$opts['FixedLang']); //no need to set cookie if temporary FIXED lng
					break;  
			}	
			// ====== fire function	=============
			// if unknown situation happens,  set default lang.   (plus, we'd better to avoid cookie at this time
			if (!defined('LNG')) { 
				ActiveLangs__MLSS();
				define('LNG', ( !empty($opts['MS_Target_default']) ? $opts['MS_Target_default'] : key($GLOBALS['ActiveLangs__MLSS']) ) ) ;
			}
			
			// now, redirect
			MAYBE_REDIRECTTT__MLSS( wpURL__MLSS.'/'.LNG.'/', 303);    //redirect is needed
		}
		function Lang_Defined_act__MLSS(){
			
		}
//============================================================================================= //	
//=================================== ##### SET LANGUAGE for visitor ========================== //	
//============================================================================================= //	

	
	
	
function ReturnLangsWithFlags__MLSS(){   $array=array();
	foreach (ActiveLangs__MLSS() as $keyname => $value){		
		//if (!isHiddenLang__MLSS($value) ) {  //not included in "HIDDEN LANGS"
			$array[$keyname]['url']		= wpURL__MLSS.'/'.$keyname.'/';
			$array[$keyname]['title']	= $value['title'];
			$array[$keyname]['image']	= GetFlagUrl__MLSS($keyname);									
		//}
	}
	return $array; 
}	
	


add_filter( 'widget_text', 'do_shortcode' ); //enable SHORTCODES in widgets
add_shortcode( 'MLSS_phrase', function ($atts){	echo '<span class="mlss__WidgetText">'.apply_filters("MLSS",$atts['name']).'</span>'; });


include(dirname(__file__).'/____dashboard_options.php');
?>