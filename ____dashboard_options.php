<?php
if (!defined('ABSPATH')) exit;

 
 
// START, if admin url
if ( IS_ADMIN__MLSS ){
	add_action( is_multisite() ? 'network_admin_menu' : 'admin_menu' , 'exec_pages__MLSS'); 
		function exec_pages__MLSS() {
			add_menu_page('MultiLang (MLSS)', 'MultiLang (MLSS)', 'manage_options', pluginpage__MLSS , 'my_subfunc1__MLSS',  PLUGIN_URL_nodomain__MLSS.'/flags/a_main.png', "29.4342423" );
			add_submenu_page(pluginpage__MLSS, 'MLSS Settings',	'MLSS Settings',	'manage_options', 	pluginpage__MLSS,  'my_subfunc1__MLSS');
			add_submenu_page(pluginpage__MLSS, 'Translated Words','Translated Words',	'manage_options', pluginpage__MLSS.'2', 'my_subfunc2__MLSS');
		}  //NonceCheck__MLSS()  is in main file
	
	//====================================  FIRST SUBMENU (settings)   ===============================//
					
					//update optionsss
					add_action('init','update353__MLSS',1);function update353__MLSS(){
					  if (isset($_POST['inp_SecureNonce1']) && is_admin() && iss_admiiiiiin__MLSS()){
						NonceCheck__MLSS($_POST['inp_SecureNonce1'],'fupd_mlss');
						$opts=get_option_for_this_site__MLSS('Opts__MLSS') ;
						
						//Langs(sub-sites)
						$opts['sub_sites']=array();
						if(isset($_POST['bloglist'])){
							foreach ($_POST['bloglist'] as $key=>$value){
								$opts['sub_sites'][$key]['enabled']	= !empty($_POST['bloglist'][$key]['enabled']) ? 1 : 0;
								$opts['sub_sites'][$key]['title']	= $_POST['bloglist'][$key]['title'];
							}
						}
						//Langs(manually added)
						$opts['manual_lang_sites']=array();
						if(isset($_POST['custom_lngs'])){
							foreach ($_POST['custom_lngs'] as $key=>$value){
								$lng = $value['abbrev'];
								$opts['manual_lang_sites'][$lng]['enabled']	= !empty($value['enabled']) ? 1 : 0;
								$opts['manual_lang_sites'][$lng]['title']	= $value['title'];
							}
						}
						
						$opts['FirstMethod']		= $_POST['inp_FirstMethod']	; 
						$opts['FixedLang']			= $_POST['inp_FirsttimeFixed'];
						$opts['DefForOthers']		= $_POST['other_defaulter'];
						$x=ActiveLangs__MLSS();
						if(!empty($x)) { foreach ($x as $name=>$value){ $opts['MS_Targets'][$name]= explode(',', $_POST['Lcountries'][$name]); } }
						$opts['MS_Target_default']= sanitize_text_field($_POST['MS_Target_default']);
						//$opts['HidenEntriesIdSlug']= $_POST['SlugofHidenEntriesId'];
						$opts['DropdHeader']		= $_POST['drp_in_header'];
						$opts['DropdSidePos']		= $_POST['drdn_aside'];
						$opts['DropdDistanceTop']	= $_POST['fromtop'];
						$opts['DisableTranslateError']= !empty($_POST['disable_phraze_error']) ? 1 : 0;
						$opts['DropdDistanceSide']	= $_POST['fromside'];
						$opts['DropdDFixedOrAbs']	= $_POST['drd_fixed_rel'];
						$opts['DefaultHome']		= $_POST['DefaultHome'];
						$opts['IncludeNamesDropd']	= sanitize_key($_POST['drd_includeName']);
						$opts['IncludeNamesShortc']	= sanitize_key($_POST['strc_includeName']);
						$opts['IncludeFlagsDropd']	= !empty($_POST['drd_includeFlag']) ? 1 : 0;
						
						//$opts['CategSlugname']	= $_POST['category_slugname']);
						//$opts['PageSlugname']		= $_POST['page_slugname']);
						
						//update priority fields...
								//if reflush is needed
								//if (isset($_POST['mlss_FRRULES_AGAIN'])){ MyFlush__MLSS(false); }
						$opts['OnOffMode']= $_POST['iOnOffMode'];			if(get_optMLSS_for_this_site__MLSS('OnOffMode') != $_POST['iOnOffMode']){ $NEEDS_FLUSH_REDIRECT=true;}
						//if (isset($NEEDS_FLUSH_REDIRECT)) {  MyFlush__MLSS(true); }
						update_option_for_this_site__MLSS('Opts__MLSS', $opts) ;
						UpdateNewLangsColumns__MLSS();
					  }
					}
					 
	function my_subfunc1__MLSS() { 
		$opts= get_option_for_this_site__MLSS('Opts__MLSS');
		if (isset($_GET['update_d'])) {
			// if (version__MLSS< 1.63) {echo '<script type="text/javascript">alert("Added New Features:\r\n1) Post Alternatives! ( you will see it on post editor page) \r\n2)Pretty Categorized Permalinks (see the 4th paragraph on this page) ");</script>'; }
			// die('<script type="text/javascript">window.location="'.admin_url('plugins.php').'";</script>');
		
		}
		if (isset($_GET['dont_show_mlss_versionalert'])){ update_option('optMLSS__version',false); }
		
		
		
		//update options are in separate function,because they needed flush inside INIT
		$ChosenSelectorType = get_optMLSS_for_this_site__MLSS('FirstMethod');
		$PluginOnOffMode = get_optMLSS_for_this_site__MLSS('OnOffMode');
		?> 
		<style>	body{font-family:arial;}input.langs{width:100%;} input.hiddenlangs{width:100%;}	span.codee{background-color:#D2CFCF; padding:1px 3px; border:1px solid;} .eachColumn22{border:1px solid;margin:2px 0 0 90px;} .delete22{padding:3px; background-color:#759C83; float:right; display:inline-block;}	.lng_NAME22{width:25px; display:inline-block;padding:0px 2px;} input.inpVALUES22{width:70%;} .title{display: inline-block;} .addNEWlnBLOCK22{position:relative;background-color:#B9B9B9;width:90%; padding:2px; margin: 30px 0 0 100px;} span.save_div_lng22{display:block; position:fixed; bottom:25px; width:300px; left:45%; z-index:101;} a.lng_SUBMIT22{background-color:red; border-radius:5px; padding:5px; color:white; font-size:2em;} span.crnt_keyn{display:inline-block;  color:red; background-color:black; padding:2px;font-weight:bold;}	.hiddenlngs{margin: 10px 0 0 140px;background-color:#DBDBDB;} .dividerrr{background-color:black;height:2px; clear:both; margin:20px 0;} .fakeH22{font-size:2em;font-weight:bold;} .eachBlock{margin: 30px 0px 0px; border: 3px solid; padding: 10px; border-radius: 5px;} a.readpopp{color:#56CC18;} span.smallnotic{font-size: 10px; float: right; right: 5%; position: relative;} .MyJsPopup {text-align:left!important; width:60%!important;top:60px!important; } .MyJsBackg{opacity:0.6!important;}</style> 
		<?php if (empty($GLOBALS['JS_SCRIPT__MLSS'])) {echo $GLOBALS['JS_SCRIPT__MLSS']='<script type="text/javascript"  src="'.PLUGIN_URL_nodomain__MLSS.'/flags/javascript_functions.php?jstypee"></script>';}?>
		
		<div class="multiLangSimpPage">
		
				<form action="" method="post" enctype="multipart/form-data" target="_blank" id="addflagimage" style="display:none;">
					Most of flags are not added. Because, at first, you'd better to download <a href="https://ps.w.org/multi-language-site-basis/assets/unused_flags.zip" target="_blank">flags</a>, then name your desired image the <b>3 official letters</b> (as mentioned previously).  For example: <b>spa</b>.png,<b>rus</b>.png... (The image dimensions could be approximately 128px+.)
					<br/><br/>Select image to upload (if you've currently made any changes in this page, at first SAVE it and return back here):
					<div style="background-color:pink;">						
						<br/><input type="file" name="ImgFile__mlss" /><input type="hidden" name="ImgUploadForm__mlss" value="OK" /> <input type="submit" value="Upload Image" name="submit"> <br/><i>(Will be stored in <?php echo dirname( PLUGIN_URL_nodomain__MLSS) .FlagFolder__MLSS;?>)</i>
					</div>
				</form>
				
				
																<form action="" method="POST">
		<center><h1><b>MLSS</b> (MultiLanguage Site framework) </h1></center>
		<center><span class="fakeH22" style="font-size:19px; color:red;">(Please, read this page before you start)</span></center> 
		<?php if( (get_option('optMLSS__version') && delete_option('optMLSS__version') ) || !This_Site_is_in_MS_LANG_SUBSITES()) {echo '<center><span class="fakeH22" style="color:red;padding:70px;border:1px solid; display: block; line-height: 2em; margin: 10px 0px; ">THIS PLUGIN is not intended to be used in single WP installation. You\'d better setup a MULTI-SITE WORDPRESS (<a href="http://codesphpjs.blogspot.com/2016/05/migrating-normal-wp-site-as-multisite.html" target="_blank"> instruction to convert single WP site into MULTI-SITE</a>).</span> </center>';}?>
		
					<br/><span class="smallnotic">(Visit <a href="http://codesphpjs.blogspot.com/2015/04/wordpress-multi-language-plugin-list.html" target="_blank">other MultiLang plugins</a>...)</span>
					<br/><span class="smallnotic">(Visit <a href="http://j.mp/wpluginstt#mlss" target="_blank">other useful plugins</a>...)</span>
		
		<div class="eachBlock"><span class="fakeH22"></span> 
			<div class="pluginStatus">
				Status: 
				<input type="radio" name="iOnOffMode" value="oon" <?php echo ($PluginOnOffMode==='oon' ? 'checked="checked"':'');?> />ON (fully)   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="iOnOffMode" value="onlycodes" <?php echo ($PluginOnOffMode==='onlycodes' ? 'checked="checked"':'');?> /><b style="color:red;">Only functionalities</b> (<a href="javascript:show_my_popup('#pluginonoff');" class="readpopp">Read popup</a>!)
					<div id="pluginonoff" style="display:none;">
					"ONLY functionalities" means: This option can be very useful for DEVELOPMENT - Plugin wont do anything or wont trigger any actions itself. Just its functionalies  can be used/integrated silently into your theme/plugins, so it will help you.
					
					<!-- (<a href="javascript:show_my_popup('#pluginsparameters');" class="readpopp">See those parameters</a>!). -->
					
						<div id="pluginsparameters" style="zdisplay:none;">
							<br/>Those parameters are (At first, review this page fully, after that you will better understand the below terminology...):
							<br/>- <span class="codee">LANGS__MLSS()</span>[Returns array of all used languages;]
							<br/>- <span class="codee">LNG</span> (CONSTANT) [Returns visitor's detected language's name, i.e. "<b>eng</b>" (can be modified,<a href="javascript:alert('this LNG parameter is detected according to sub-site prefix... \r\n However, in case you wish to pre-set that value with your own logic&function (i dont know, maybe you are programmer, and have your own functions to find out the language parameter yourself, on any page of your site), then you can pre-set the constant,named LNG_PASSED (in functions.php or elsewhere), with  add_action(\u0027init\u0027,\u0027your_func\u0027,3);  \r\nBUT READ the 6th paragraph about initialization time.');">read more!</a>)]
							<br/>- <span class="codee">echo apply_filters('MLSS','<span style="color:red;">my_HeadingMessage</span>', LNG);</span> [<span style="color:red;">useful!!</span> Returns translation of any "TRANSLATION_PHRASE" (you will set them in the left sidebar menu). <b>LNG</b> is auto detected by plugin, but you can pass straightly, for example: <b>"eng"</b>, instead of LNG]... p.s. also, you can add 4th parameter too:  <span class="codee">array('eng'=&gt;'Hello World',  'spa'=&gt; '')</span> (this option is good to manually insert the translation values into database)
							<br/><span class="codee">[MLSS_phrase name="<span style="color:red;">my_HeadingMessage</span>"]</span> [Shortcode, to return that translation phrase.. can be used in widgets and posts]
							<br/><span class="codee">[post_translations_MLSS]</span> [Shortcode, to display flags for translations within post/page]
							<br/>- <span class="codee">LastCookiedLanguage__MLSS</span> [Returns the last Language, cought using COOKIE. This is only  usable in other custom PHP pages, to detect the last-used language. ]
							<br/>- <span class="codee">ReturnLangsWithFlags__MLSS()</span> [Returns array of All Languages,with their flags and URLs]
							<br/>- <span class="codee">OutputFirstTimePopup__MLSS()</span> [Returns styled output of "Select FirstTime Language" popup's list]
							<br/>- <span class="codee">OutputDropdown__MLSS()</span> [Returns styled output of "Select Language DROPDOWN"]
							<br/>&nbsp;&nbsp;&nbsp;&nbsp;- <span class="codee">[MLSS_navigation name="<span style="color:red;">your_menu_slug</span>"]</span> [read the 6th paragraph on this page]
						</div>
					</div>
			</div>
		</div>



		
		<div class="eachBlock"><span class="fakeH22"> 1) Languages</span> (<a href="javascript:show_my_popup('#enabledlanguages');" class="readpopp">Read popup!</a>)
						<div id="enabledlanguages" style="display:none;">
						<br/>For example, if you want to add <b>Spanish</b> sub-site, create a sub-site <b><?php echo homeURL__MLSS;?>/spa</b> (Needs to be latin 3 characters,i.e. "<b>spa</b>"....   &nbsp;&nbsp;View countries' official <a href="http://www-01.sil.org/iso639-3/codes.asp?order=reference_name&letter=%25" target="_blank">3 symbols</a><a href="http://en.wikipedia.org/wiki/List_of_countries_by_spoken_languages#Spanish)" target="_blank">.</a>)
						<br/><br/><br/>p.s. if you ever change the language symbol, then <a href="javascript:alert('If you want to change the 3-letter letter symbol of already created language (and while using that language symbol, you have filled \u0022ALTERNATIVE POST ID\u0022 fields, then you might have to rename the column-name in database to, otherwise, you will have to re-set the \u0022ALTERNATIVE POST ID\u0022s for the new 3-letter language. ) ');">read this popup!</a>.
						</div>
						
			<div class="enabled_langs">		<style> .enabled_langs td{border:1px solid black; border-width:0 1 1px 0;} </style>
				Sub-sites ready "TO BE LANGUAGED":
				<table class=""><tbody>
				<tr><td><b>sub-site:</b></td><td>Language title</td><td>Enabled</td></tr>
				<?php
				foreach ($GLOBALS['MLSS_BLOG_LIST'] as $key=>$site) {
					if( $site->blog_id =='1'){continue;}		//if main network site
					$blogname= basename($site->path);
					echo '<tr><td><span style="font-size:0.85em">'.dirname($site->path).'/</span><b style="color:rgb(200, 132, 9);">'. basename($site->path).'</b></td><td><input type="text" value="'. (!empty($opts['sub_sites'][$blogname]['title']) ? $opts['sub_sites'][$blogname]['title'] : '') .'" name="bloglist['.$blogname.'][title]" placeholder="i.e. Spanish" /> </td><td><input type="checkbox" name="bloglist['.$blogname.'][enabled]" value="y" '.(!empty($opts['sub_sites'][$blogname]['enabled']) && $opts['sub_sites'][$blogname]['enabled'] ? 'checked="checked"' : '') .'/></td></tr>';	
					$at_least_one_found=true;
				}
				if(!isset($at_least_one_found)) { echo "<tr><td><h1>No SUB-SITES found. Please, create a sub-site. </td></tr>";}
				?>
				</tbody></table>

				<div style="font-style:italic;font-size:1em;">(or <a href="javascript:document.getElementById('manuall_Langs').style.display='block';void(0);" class="readpopp">manually add langs</a>)</div>
				<div id="manuall_Langs" style="display:none;">
				<table class=""><tbody>
				<tr><td><b>manual-langs:</b></td><td>Language title</td><td>Enabled</td></tr>
				<?php
				$custom_langs= array_merge($opts['manual_lang_sites'], array(''=>array('enabled'=>0, 'title'=>'') ));
				$i=0;
				foreach ($custom_langs as $key=>$value) {
					$i++;
					echo '<tr><td><span style="font-size:0.85em"><input type="text" value="'. $key .'" name="custom_lngs['.$i.'][abbrev]" placeholder="i.e. eng" /></span></td><td><input type="text" value="'. (!empty($value['title']) ? $value['title'] : '') .'" name="custom_lngs['.$i.'][title]" placeholder="i.e. Spanish" /> </td><td><input type="checkbox" name="custom_lngs['.$i.'][enabled]" value="y" '.checked($value['enabled'],1, $echo=false) .'/></td></tr>';
				}
				?>
				</tbody></table>				
				</div>
				<br/><div style="float:right;">(p.s. You may need too add your flag image - <a href="javascript:show_my_popup('#addflagimage');" class="readpopp">Read popup!</a>)  </div><div style="clear:both;"></div>
			</div>
			
			
			<br/><br/>
					<span class="fakeH22"> Choose Language for visitors</span>  (<a href="javascript:show_my_popup('#firsttimmm');" class="readpopp">Read popup!</a>) 
											<div id="firsttimmm" style="display:none;">
											Whoever enters your site BASE URL:<br/><b><?php echo homeURL__MLSS;?>/</b> (and if it's FIRST TIME visit),  you can set language to be redirected to that  HomePage,i.e:<br/> <b><?php echo homeURL__MLSS;?>/<b>eng</b>/
											</div>
			<br/><input type="radio" name="inp_FirstMethod" value="nothing" <?php echo (($ChosenSelectorType==='nothing')? 'checked="checked"':'');?> /><b>A)</b> Do nothing
			
			<br/><input type="radio" name="inp_FirstMethod" value="dropddd" <?php echo (($ChosenSelectorType==='dropddd')? 'checked="checked"':'');?> /><b>B)</b> Let user choose the desired language from dropdown (<a href="javascript:previewww();">See preview</a>) <script type="text/javascript">	function previewww(){ document.cookie="<?php echo cookienameLngs__MLSS;?>=; expires=Thu, 01 Jan 1970 00:00:01 GMT;"; window.open("<?php echo homeURL__MLSS;?>?previewDropd__MLSS","_blank");	}	</script>
				(<i><a href="javascript:alert('(To modify/design the output, read the last paragraph on this page.)');" class="readpopp">Read popup!</a></i>)
			
			<br/> <input type="radio" name="inp_FirstMethod" value="ip_detectt" <?php echo (($ChosenSelectorType==='ip_detectt')? 'checked="checked"':'');?> /><b>C)</b> Autodetect COUNTRY (<a href="javascript:show_my_popup('#autodetectcountry');" class="readpopp">Read popup!</a>)
						
							<div id="autodetectcountry" style="display:none;">
							The plugin contains a detector, to detect visitor's country [using IP]. Fill the table of languages accurately (to input county names correctly, see <a href="<?php echo PLUGIN_URL_nodomain__MLSS;?>flags/ip_country_detect/GeoIP_V2/country_names.txt" target="_blank">this page</a>)
							</div>
			
					<div id="langset_flds">	<?php global $wpdb;
					//$country_lang_sets = $wpdb->get_results("SELECT * from `".$wpdb->options."` WHERE `option_name` LIKE '".'MS_Targets'."%'"); 	//foreach ($country_lang_sets as $each_group){	
					//$abbrev = str_ireplace('MS_Target_','',$each_group->option_name);	 $ItsValue = $each_group->option_value;
					$langs= ActiveLangs__MLSS(true);
					if (!empty($langs)) {
						foreach ($langs as $name=>$value) {
							//$ItsValues=$wpdb->get_results("SELECT * from `".$wpdb->options."` WHERE `option_name` = '".'MS_Targets['.$name."]'");	//$OptValue=$ItsValue[0]->option_value;
							echo 
							'<div class="eachColumn22" id="coulang_'.$name.'"> 
								<div class="delete22" style="display:none;"><a href="javascript:deleteThisBlock22(\'coulang_'.$name.'\');">DELETE</a></div>
								<div class="eachLngWORD22">
									<span class="lng_NAME22">'.$name.'</span>  <span class="lng_VALUE22"><input class="inpVALUES22" type="text" name="Lcountries['.$name.']" value="'.htmlentities(  (!empty($opts['MS_Targets'][$name]) ? implode(",",$opts['MS_Targets'][$name]) : '')  ).'" /></span>
							</div></div>';
						}
					}
					?>		<div class="eachColumn22" id="coulang_default" style="background-color:pink;"> 
								<div class="eachLngWORD22">
									<span class="lng_NAME22"  style="width:auto;color:green;">default lang for all other countries:</span><br/>
									<input type="radio" name="other_defaulter" value="dropdownn" <?php if("dropdownn"===get_optMLSS_for_this_site__MLSS('DefForOthers')){echo 'checked="checked"';}?> /> a) display them "CHOOSE LANGUAGE" Screen 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="other_defaulter" value="fixedd" <?php if("fixedd"===get_optMLSS_for_this_site__MLSS('DefForOthers')){echo 'checked="checked"';}?> />b) force language: <span class="lng_VALUE22"><input class="inpVALUES22"  style="width:50px;" type="text" name="MS_Target_default" value="<?php echo $opts['MS_Target_default'];?>" placeholder="eng" /></span>
								</div>
							</div>
					</div>
					<script type="text/javascript">	
					 function deleteThisBlock22(IDD){ 	if (confirm("Are you sure?")){var x=document.getElementById(IDD); x.parentNode.removeChild(x);}   }
					</script>
					
			<br/><input type="radio" name="inp_FirstMethod" value="fixeddd" <?php echo (($ChosenSelectorType==='fixeddd')? 'checked="checked"':'');?> />
			<b>D)</b> redirect all visitors to this fixed language <input style="width:50px;" type="text" name="inp_FirsttimeFixed" value="<?php echo get_optMLSS_for_this_site__MLSS('FixedLang');?>" placeholder="eng" />
			
			<script>
			radiobox_onchange_hider('input[name=inp_FirstMethod]',  'ip_detectt',  '#langset_flds',  true);
			</script>
			<br/> 
			<br/> 
			<br/>			
			<span class="fakeH22">Choose default dashboard after login</span>   (<a href="javascript:alert('If you want to be redirected to i.e. \n<?php echo network_home_url();?>eng/wp-admin after logging into mainsite \n<?php echo network_home_url();?>/wp-admin, then type in this field:\neng ');void(0);" class="readpopp"><i>Read popup</i></a>) 
			<br/><input type="text" name="DefaultHome" value="<?php echo get_optMLSS_for_this_site__MLSS('DefaultHome');?>" />
			
		</div>
		
		
		<div class="eachBlock">
			<span class="fakeH22"> 2) Design </span>(<a href="javascript:document.getElementById('deisgnmlss').style.display='block';void(0);" class="readpopp"><i>Read popup</i></a>) 
			<div id="deisgnmlss" style="display:none;">
				 You will see "LANGUAGE SELECTOR" dropdown in the upper corner of your site... To modify & design it, you can modify Style.css or use these ooptions:
				<div style="border:1px solid green; margin:20px 0 0 0;">
					*<B>LANGUAGE SELECTOR dropdown style </B>:
						&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="drp_in_header" value="hhide" <?php if ('hhide'===get_optMLSS_for_this_site__MLSS('DropdHeader')) {echo 'checked="checked"';}?> />HIDE 
						&nbsp;&nbsp;&nbsp; <input type="radio" name="drp_in_header" value="hhorizontal" <?php if ('hhorizontal'===get_optMLSS_for_this_site__MLSS('DropdHeader')) {echo 'checked="checked"';}?> />Horizontal
						&nbsp;&nbsp;&nbsp; <input type="radio" name="drp_in_header" value="vvertical" <?php if ('vvertical'===get_optMLSS_for_this_site__MLSS('DropdHeader')) {echo 'checked="checked"';}?> />Vertical
						&nbsp;&nbsp;&nbsp; <input type="radio" name="drp_in_header" value="ddropdown" <?php if ('ddropdown'===get_optMLSS_for_this_site__MLSS('DropdHeader')) {echo 'checked="checked"';}?> />Dropdown
					<div id="dropdownstyless">
						<br/>*<B>Dropdown Position</B>:&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="drdn_aside" value="left" <?php if ('left'===get_optMLSS_for_this_site__MLSS('DropdSidePos')) {echo 'checked="checked"';}?> />LEFT side &nbsp;&nbsp; <input type="radio" name="drdn_aside" value="right" <?php if ('right'===get_optMLSS_for_this_site__MLSS('DropdSidePos')) {echo 'checked="checked"';}?> />RIGHT side
						<br/>*<B>Dropdown Distance from</B>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOP:<input type="text" style="width:40px;" name="fromtop" value="<?php echo get_optMLSS_for_this_site__MLSS('DropdDistanceTop');?>" />px &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Side:<input type="text" style="width:40px;" name="fromside" value="<?php echo get_optMLSS_for_this_site__MLSS('DropdDistanceSide');?>" />px 
						<br/>*<B>Fixed Position Or Absolute?</B>(<a href="javascript:alert('Stay it in FIXED position while you scrolling your site(beware on small resolution screens!)  or stay it as default, not fixed.');" class="readpopp">Read popup!</a>) :  
							<input type="radio" name="drd_fixed_rel" value="absolute" <?php if ('absolute'===get_optMLSS_for_this_site__MLSS('DropdDFixedOrAbs')) {echo 'checked="checked"';}?> />Absolute &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="drd_fixed_rel" value="fixed" <?php if ('fixed'===get_optMLSS_for_this_site__MLSS('DropdDFixedOrAbs')) {echo 'checked="checked"';}?> />Fixed
						<br/>*<B>display Flag (image) : <input type="checkbox" name="drd_includeFlag" value="y" <?php if (get_optMLSS_for_this_site__MLSS('IncludeFlagsDropd')) {echo 'checked="checked"';} ?> /> 
					<br/>*<B>display LANGUAGE NAME (in site main language selector ):  <input type="radio" name="drd_includeName" value="no" <?php if (get_optMLSS_for_this_site__MLSS('IncludeNamesDropd') =='no' || get_optMLSS_for_this_site__MLSS('IncludeNamesDropd') ==0 ) {echo 'checked="checked"';} ?> />[NO]   <input type="radio" name="drd_includeName" value="abbrev" <?php if (get_optMLSS_for_this_site__MLSS('IncludeNamesDropd') =='abbrev') {echo 'checked="checked"';} ?> />[ONLY ABBREVIATION]    <input type="radio" name="drd_includeName" value="full" <?php if (get_optMLSS_for_this_site__MLSS('IncludeNamesDropd') =='full' || get_optMLSS_for_this_site__MLSS('IncludeNamesDropd') ==1) {echo 'checked="checked"';} ?> /> [Full NAME]
					<br/>*<B>display LANGUAGE NAME (when utilized in shortcodes):  <input type="radio" name="strc_includeName" value="no" <?php if (get_optMLSS_for_this_site__MLSS('IncludeNamesShortc') =='no') {echo 'checked="checked"';} ?> />[NO]    <input type="radio" name="strc_includeName" value="abbrev" <?php if (get_optMLSS_for_this_site__MLSS('IncludeNamesShortc') =='abbrev') {echo 'checked="checked"';} ?> />[ONLY ABBREVIATION]   <input type="radio" name="strc_includeName" value="full" <?php if (get_optMLSS_for_this_site__MLSS('IncludeNamesShortc') =='full') {echo 'checked="checked"';} ?> />  [Full NAME]
										
					</div>
					
					
					
					<script>
					radiobox_onchange_hider('input[name=drp_in_header]', 'hhide', '#dropdownstyless');
					</script>
				</div>
				<br/>* <b>How to style/modify LANGUAGE Dropdowns,SELECTERS and etc.. output of this plugin? </b> -   <a href="javascript:show_my_popup('#StyleFlagsOutput');" class="readpopp">Read popup!</a>
					<div id="StyleFlagsOutput" style="display:none;">
						1) To modify a <b>Design</b> of LANGUAGE SELECTORs: First Time Popup Selector[<a href="javascript:previewww();">see preview</a>] OR default Language Selector[in the top corner of your site], then you can easily style it from your default stylesheet/css file. Just target the element names.
						<br/>2) To modify the </b>CODES</b>(OUTPUT) of the LANGUAGE SELECTORs, then you need (i.e. from your theme's FUNCTIONS.PHP or etc..) to hook your function into <b>MLSS__firsttimeselector</b>(or <b>MLSS__dropdownselector</b>). See Example:
						<br/><span class="codee">add_filter('MLSS__dropdownselector','yourFuncNameeeee');
						<br/>function yourFuncNameeeee($passer){
						<br/>&nbsp;&nbsp;&nbsp;return $passer."blablabla";
						<br/>}</span>
					</div>
					
					
			</div>
			 
			 
			
		</div>
		
		
		<div class="eachBlock">
			<span class="fakeH22">3) Additional ... </span>
			<br/><span style="font-size:1.4em;color:red;">* Translation of Phrases for TEMPLATES FILES</span> - <i><a href="javascript:alert('This plugin has a functionality to create auto-translated PHRASES, which can be used in theme PHP files. On the left sidebar, enter \u0022MLSS\u0022 - \u0022TRANSLATED WORDS\u0022, where you will see the examples..');" class="readpopp">Read popup</a>!</i>
			<br/>* Disable Error when translating phrazes (<a href="javascript:alert('when using MLSS filter to translate words, if it is called too early, and if it cant find user\u0027s LNG parameter,then it cant translate the phraze... and should it output warning?');" class="readpopp">Read popup</a>): <input type="checkbox" name="disable_phraze_error" value="y" <?php if (get_optMLSS_for_this_site__MLSS('DisableTranslateError')) {echo 'checked="checked"';} ?> />
			<br/>* <b>How to access the language variables(+functions) from my other php files? </b> -  Read first popup in the top.
			<br/>* <b>Attention to PERMALINKS</b> - <i><a href="javascript:show_my_popup('#AttentionPermalinks');" class="readpopp">Read popup!</a></i>
				<div id="AttentionPermalinks" style="display:none;">
					in PERMALINKS, youd better use PRETTY PERMALINKS ("PRETTY" means i.e. <b>/%postname%</b>,  /%category%/%postname% or etc). 
					<br/>p.s. sometimes you may need to click <b>"SAVE PERMALINKS"</b> in <b> OPTIONS&gt;Permalinks</b> , to refresh the website structure.
				</div>			
			<br/>* <b>REDIRECTIONS</b> - <i><a href="javascript:alert('please note, if your website has already been established some time ago, and your pages are already indexed in google, and want to use this plugin, then redirect old pages to new pages (using \u0022301 redirect plugin\u0022 or etc..)');" class="readpopp">Read popup!</a></i>
			

				
		</div>
		
		<br/><br/><br/><br/>*<b>If you find bugs or etc, <a href="http://j.mp/contactmett" target="_blank">CONTACT ME</b></a>! Also, from time to time, check that your plugin is UPDATEd!!
		
		<br/>================================
			<br/><span class="save_div_lng22"><a class="lng_SUBMIT22" href="javascript:document.forms[1].submit();">SAVE</a></span>
				<input type="submit" value="SAVE" style="display:none;" /> <input type="hidden" name="inp_SecureNonce1" value="<?php echo wp_create_nonce('fupd_mlss');?>" />
		
	</form>
		</div>
		<?php
	}





	//====================================== SECOND SUBMENU(translated words) ==============================
	function my_subfunc2__MLSS() {
		?>
		
		<style>	span.codee{background-color: #D2CFCF;padding: 3px;font-family: Consolas;} .eachColumn{border:1px solid;margin:2px;} .delete{padding:3px; background-color:#759C83; float:right; display:inline-block;} .lng_NAME{width:80px; display:inline-block;} input.inpVALUES{width:70%;padding: 0px 5px;} .title{display: inline-block; margin:0 0 0 20%;} .lexic_SUBMIT{background-color:red; border-radius:5px; padding:5px; color:white; font-size:2em;}   
		.addNEWlnBLOCK{position:relative;background-color:#B9B9B9;width:90%; padding:5px; margin: 10px;} .save_div_lexic{position:fixed; bottom:15px; width:300px; margin:0 0 0 30%; z-index:101;} span.crnt_keyn{display:inline-block;  color:red; background-color:black; padding:2px 4px; font-size:1.2em; font-weight:bold;} span.idd_n{font-size:14px; position:relative; color:red; border:1px solid; display:inline-block; font-style:italic; left:-3px; top:-2px; padding:0px 2px; margin:0px 15px 0px 2px;} </style>
		<script type="text/javascript"  src="<?php echo PLUGIN_URL_nodomain__MLSS;?>/flags/javascript_functions.php?jstypee"></script>
			<script>function UpdateSaveAjax()	{var data=serialize(document.getElementById("lexiconnn"));   myyAjaxRequest(data, "","POST", "alert(responseee);",true ); }	</script>
		
		<form action="" method="POST" class="fmr_lxcn" id="lexiconnn">
			<br/>Below are listed variable INDEXNAMES with their suitable translations. To output any phrase in your theme, use code (like this): 
			<br/><b><span class="codee">echo apply_filters('MLSS','<span style="color:red;">my_HeadingMessage</span>');</span></b> 			&nbsp;&nbsp;&nbsp;<i>(<a href="javascript:alert('1)Even more, you can make this command more shorter -  in your functions.php, create function i.e. function Z($var){return apply_filters...}\r\n\r\n\r\n2) You can use shortcodes too -in widgets,posts or etc...  For that, insert anywhere: [MLSS_phrase name=\u0022my_HeadingMessage\u0022]')">Read popup</a>!)</i>
			
			<!--(<a href="javascript:show_my_popup('#mlsNotice')"> Read popup!</a>) <div id="mlsNotice">You can use this function anywhere (only after initialization of hooks). However,in case you deactivate this plugin, to avoid errors, you must insert this code in the top of your functions.php: <b><span class="codee">if(!function_exists('MLSS')) {function MLSS(){return 'PLUGIN NOT INSTALLED';}}</span></b></div> -->
			<br/><br/>
			<?php 
			
			function TranslationBlock__MLSS($name,$transl_ID='-', $execute_translation=false, $ALL_WORDS= false){
				global $wpdb;
				$output =''; 
				$output .= '<div class="eachColumn defTRcol" id="trID_'.$name.'" class="trID_'.$name.'">'.'<span class="idd_n">'.$transl_ID.'</span>'.
					'<div class="title">identifier: <span class="crnt_keyn">'.$name.'</span></div> 
					<div class="delete"><a href="javascript:deleteThisBlock(\'trID_'.$name.'\');">DELETE</a></div>';
											foreach (ActiveLangs__MLSS() as $key=>$value){ 
						//$trnsl= $wpdb->get_results("SELECT * from `".Table1__MLSS."` WHERE `title_indx` = '$name' and `lang` = '$key' ");
						$phrase='';
						if ($execute_translation) {
							//$trnsl= $wpdb->get_results("SELECT * from `".Table1__MLSS."` WHERE `title_indx` = '$name' and `lang` = '$key' ");
							//$phrase=htmlentities(stripslashes($trnsl[0]->translation));
							foreach($ALL_WORDS as $key4=>$value4) {
								if($value4->title_indx==$name && $value4->lang == $key){
									$phrase=$value4->translation;
								}								
							}
							
						}
						$output .= 
						'<div class="eachLngWORD">
									<span class="lng_NAME">'.$key.'</span>
									<span class="lng_VALUE"><input class="inpVALUES" type="text" placeholder=" - - - - - - - - - - - - " name="titlee['.$name.']['.$key.']" value="'.$phrase.'" /></span>
						</div>';
											}
					$output .= '
				</div>'; 
				return $output;
			}
			
			
			global $wpdb;
			$ALL_WORDS = $wpdb->get_results("SELECT * from `".Table1__MLSS."`"); $final_groups=array();
			//group them based on title_indx
			foreach ($ALL_WORDS as $eachBlockInd => $EachBlockContent)	{  $final_groups[$EachBlockContent->title_indx][]=$EachBlockContent;  }
			foreach ($final_groups as $name=>$each_group){ 	echo TranslationBlock__MLSS($name, $each_group[0]->IDD, true, $ALL_WORDS);	}
			?>
		<input name="mlss_update1" value="x" type="hidden" /><input type="hidden" name="inp_SecureNonce2" value="<?php echo wp_create_nonce('fupd_mlss');?>" />
		</form>	
			<br/><span class="save_div_lexic" style=""><a href="javascript:UpdateSaveAjax();" class="lexic_SUBMIT" >SAVE CHANGES!!</a></span> 
			<!-- <span style="float: right; background-color: #D7D7D7; padding: 5px; bottom: 30px; position: fixed; right: 30px; border: 1px solid;"><a href="<?php echo currentURL__MLSS;?>&mlss_export_translations" target="_blank">EXPORT BACKUP!</a></span> -->
			<div class="addNEWlnBLOCK">
				<span style="color:blue;text-decoration:none;">ADD NEW block (with unique INDEXNAME. for example: <b style="color:red;">MyFooterHello</b>):</span> 
				<input type="text" id="newBlockTitle" value="" /> <a style="background-color:#00D8E0;" href="javascript:add_new_Block(document.getElementById('newBlockTitle').value);void(0);"> Add </a>
			</div>
			<br/><br/>
			<!-- <div style="float:right;font-style:italic;">(p.s you can use shortcodes too, for example,in widgets or posts. for example: <b><span class="codee" style="font-style:normal;">[MLSS_phrase name="<span style="color:red;">my_HeadingMessage</span>"]</span></b></div>-->

			<div style="display:none;" id="sampleJS_block"><?php echo TranslationBlock__MLSS("phraze23864161");?></div>
			<script type="text/javascript">
			var SampleJS_BLOCKK= (x=document.getElementById("sampleJS_block")).innerHTML;  x.parentNode.removeChild(x);
			
			function add_new_Block(New_Keyname)	{
				if (document.getElementById("trID_"+New_Keyname)) {alert("this keyname already exists!"); return false;}
				if(New_Keyname=='') { alert("field is empty ! ! ! "); return false;}
				else{
					alert("ADDED!    now fill it"); 
					document.getElementById("lexiconnn").insertAdjacentHTML('beforeend', SampleJS_BLOCKK.replace(/phraze23864161/g, New_Keyname));
					document.getElementById('newBlockTitle').value='';
				}
			}
			
			function deleteThisBlock(IDD){ 	if (confirm("Are you sure?")){var x=document.getElementById(IDD); x.parentNode.removeChild(x);}   }
			
			//var MLSS_Langs_ARRAYY= {<?php //foreach (ActiveLangs__MLSS() as $k=>$v) { echo "'".$k."':'".$v."',"; } ?>};
			</script>
			
		<?php 
	}
	
	
	
	
	

	
	
	

//===================================== OTHER FUNCTIONS FOR DASHBOARD


	//SAVE TRANSLATION WORDS from AJAX request
	add_action('init','verify_saved_words__MLSS',1); function verify_saved_words__MLSS(){
		if (isset($_POST['mlss_update1']) && iss_admiiiiiin__MLSS()){		
			NonceCheck__MLSS($_POST['inp_SecureNonce2'],'fupd_mlss');
			
			global $wpdb; 
			$wpdb->query("DELETE FROM `".Table1__MLSS."` WHERE 1 = 1;");

			if(!empty($_POST['titlee'])){
				foreach($_POST['titlee'] as $name1=>$Value1){
					foreach($Value1 as $name2=>$Value2){
						UPDATEE_OR_INSERTTT__MLSS(Table1__MLSS, 
													array('translation'=>$Value2),
													array('title_indx'=>$name1, 'lang'=> $name2) );
					}
				}
			}
			die("successfully updated");
		}
	}
	// Export Translation Words
	add_action('init','export_translation_words__MLSS'); function export_translation_words__MLSS(){
		if (isset($_GET['mlss_export_translations']) && is_admin() && iss_admiiiiiin__MLSS()){
			//https://github.com/tazotodua/useful-php-scripts
			function EXPORT_TABLES__MLSS($host,$user,$pass,$name,  $tables=false, $backup_name=false ){$mysqli = new mysqli($host,$user,$pass,$name); $mysqli->select_db($name); $mysqli->query("SET NAMES 'utf8'");$queryTables = $mysqli->query('SHOW TABLES'); while($row = $queryTables->fetch_row()) { $target_tables[] = $row[0]; }   if($tables !== false) { $target_tables = array_intersect( $target_tables, $tables); }	foreach($target_tables as $table){$result = $mysqli->query('SELECT * FROM '.$table);  $fields_amount=$result->field_count;  $rows_num=$mysqli->affected_rows;     $res = $mysqli->query('SHOW CREATE TABLE '.$table); $TableMLine=$res->fetch_row();$content = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";	for ($i = 0; $i < $fields_amount;   $i++, $st_counter=0) {	while($row = $result->fetch_row())  {if ($st_counter%100 === 0 || $st_counter === 0 )  {$content .= "\nINSERT INTO ".$table." VALUES";}$content .= "\n(";	for($j=0; $j<$fields_amount; $j++)  { $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); if (isset($row[$j])){$content .= '"'.$row[$j].'"' ; }else {$content .= '""';}     if ($j<($fields_amount-1)){$content.= ',';} }	$content .=")";	if ( (($st_counter+1)%100===0 && $st_counter!=0) || $st_counter+1===$rows_num) {$content .= ";";} else {$content .= ",";} $st_counter=$st_counter+1;}	} $content .="\n\n\n";}	$backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";header('Content-Type: application/octet-stream');   header("Content-Transfer-Encoding: Binary"); header("Content-disposition: attachment; filename=\"".$backup_name."\"");  echo $content; exit;}
			
			EXPORT_TABLES__MLSS(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME, array(Table1__MLSS,) );   exit;
		}
	};


	
	//WHEN FLAG IMAGE IS UPLOADED
	add_action('init','DetectFlagIsUploaded__MLSS');function DetectFlagIsUploaded__MLSS(){
		if (!empty($_POST['ImgUploadForm__mlss'])){
			if (iss_admiiiiiin__MLSS()){
				//if directory doesnt exists
				if (!file_exists(dirname(PLUGIN_DIR__MLSS).FlagFolder__MLSS)) {  mkdir(dirname(PLUGIN_DIR__MLSS).FlagFolder__MLSS, 0755, true); }
				$filename	 = basename($_FILES["ImgFile__mlss"]["name"]);
				$tmpname	 = $_FILES["ImgFile__mlss"]["tmp_name"];
				$target_file = dirname(PLUGIN_DIR__MLSS).FlagFolder__MLSS.'/'.$filename;
				$imgType = pathinfo($target_file,PATHINFO_EXTENSION);
				if(getimagesize($tmpname)===false){die("File is not an image.");}								//==fake image
				if($imgType != "png")			{die("Sorry,only PNG files are allowed, and not:".$imgType);} 	//==not PNG
				//if(file_exists($target_file)) {die("Sorry, file already exists.");} 							//==already exists
				//if ($_FILES["ImgFile__mlss"]["size"] > 500000) {die("Sorry, your file is too large.");}		//==upload Size
				if (move_uploaded_file($_FILES["ImgFile__mlss"]["tmp_name"], $target_file)) {echo "<b>".$filename. "</b> uploaded. close this window.";}
				else {echo "Sorry, there was an error uploading your file.";  } 				exit;
	}}}



	
}
















	
//======================================= SHOW FLAGS SELECTOR  ============================ //
//========================================================================================= //	
//register style for default front-page	
if (FullMode__MLSS){
	add_action( 'wp_enqueue_scripts', 'stylesht__MLSS',1,98 ); function stylesht__MLSS() {
		wp_enqueue_style( 'custom_styles__MLSS', STYLESHEETURL__MLSS, array(), 1.91 );
	}
}

//POPUP TO CHOOSE LANGUAGE -  ONLY FOR FIRST TIME VISITOR!
add_filter("MLSS__firsttimeselector","OutputFirstTimePopup__MLSS",9,1); function OutputFirstTimePopup__MLSS($cont=''){   $out = 
				//$smth = . '<title></title>';do_action("wp_head");echo '<title></title>';  
		'<!-- To add your styles, read the MLSS_SETTINGS page -->
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" id="mlsss_css"  href="'.STYLESHEETURL__MLSS.'" type="text/css" media="all" />'. //'<script type="text/javascript"  src="'.PLUGIN_URL_nodomain__MLSS.'flags/javascript_functions.php?jstypee"></script>
		  '<div id="my_black_bck_24141"></div>'.
		  '<div id="FirstTimeLanguage1__MLSS"  class="css_reset__MLSS">'.
			 '<div id="popup_CHOOSER2__MLSS"><div class="lnmenu__MLSS">';
			foreach (ActiveLangs__MLSS() as $keyname => $value){	
				$out .= '<div class="LineHolder2__MLSS '.$keyname.'">'.
								'<a class="ImgHolder2__MLSS"  href="'.SetHomeUrlInNavigation__MLSS().$keyname.'">'.
									'<img class="FlagImg2__MLSS" src="'. GetFlagUrl__MLSS($keyname).'" alt="'. $value['title'] .'" />'.
									'<span class="lnmenuSpn2__MLSS">'. $value['title'].'</span>'.
								'</a>'.
						'</div>';
			}
			$out .= '</div></div></div>';	return $cont.$out;	
}
	//output
	if ( (FullMode__MLSS && This_Site_is_in_MS_LANG_SUBSITES()) || isset($_GET['previewDropd__MLSS']) ){ 
		add_action('wp','fnc134__MLSS'); function fnc134__MLSS(){ if (defined('SHOW_FT_POPUP_MLSS')) {echo apply_filters('MLSS__firsttimeselector',''); exit; }} 
	}
	


//DEFAULT LANGUAGE SELECTOR, WHICH IS SEEN ON THE TOP OF PAGE	
add_filter("MLSS__dropdownselector","OutputDropdown__MLSS",9,1); function OutputDropdown__MLSS($cont=''){  global $wpdb,$post;

	$out = 
	'<!-- LanguageSelector__MLSS_start --><style type="text/css">#LanguageSelector__MLSS {top:'.get_optMLSS_for_this_site__MLSS('DropdDistanceTop').'px; '.get_optMLSS_for_this_site__MLSS('DropdSidePos').':'.get_optMLSS_for_this_site__MLSS('DropdDistanceSide').'px; position:'.get_optMLSS_for_this_site__MLSS('DropdDFixedOrAbs').';}</style>'.
		'<div id="LanguageSelector__MLSS" class="css_reset__MLSS">'.
		 '<div class="'.Dtype__MLSS.'_LSTYPE__MLSS">';
			//note:large php codes should not be inside <script...> tags, because NOTEPAD++ misunderstoods the scripting colors
			$SITE_LANGUAGES=ActiveLangs__MLSS(); 
			//If language is set, then sort languages, as the first language FLAG should be the current language
			if (defined('LNG')) {		
			  //remove current language
				$CurrLang_array =$SITE_LANGUAGES[LNG];
				unset($SITE_LANGUAGES[LNG]);
			  //now, re-insert current language in first place
				$SITE_LANGUAGES = array( LNG => $CurrLang_array ) + $SITE_LANGUAGES;	
			}	$out.=
		  '<div id="LangDropMenu1__MLSS">'.
		   '<div id="AllLines1__MLSS"> <a href="javascript:MyMobileFunc__MLSS();" id="RevealButton__MLSS">&#8897;</a>';
		    $out .= get_langs_flaged_urls__MLSS($SITE_LANGUAGES,false,   get_optMLSS_for_this_site__MLSS('IncludeNamesDropd'), false, $include_flags=get_optMLSS_for_this_site__MLSS('IncludeFlagsDropd') );
			$out.=  
		'</div>'. '</div>'. '</div>'.'</div>';
		
		
		include_once(dirname(__file__) ."/flags/detect_platform.php");
		$out.= '<!-- ###LanguageSelector__MLSS_END ### -->
	<script type="text/javascript">
		var langMenu__MLSS = document.getElementById("LanguageSelector__MLSS"); document.body.insertBefore(langMenu__MLSS, document.body.childNodes[0]);
		var langmnSelcr__MLSS=document.getElementById("RevealButton__MLSS"); 
		var ALines__MLSS=document.getElementById("AllLines1__MLSS");
		var ALines_startHEIGHT__MLSS= ALines__MLSS.clientHeight; //overflow maybe  hidden white started
		//For mobile devices, instead of hover, we need "onclick" action to be triggered (already injected into that button)
			var isMobile__MLSS='.( $GLOBALS['MLSS_VARS']['isMobile'] ? "true":"false" ).';
			function MyMobileFunc__MLSS(){	if (isMobile__MLSS){ HideShowAllLines1__MLSS(); }  }	//langmnSelcr__MLSS.addEventListener("click", .....
			Shown__MLSS=false;	function HideShowAllLines1__MLSS()	{
				if (Shown__MLSS===true)	{ Shown__MLSS=false; ALines__MLSS.style.overflow="hidden";   ALines__MLSS.style.height=ALines_startHEIGHT__MLSS + "px";}
				else					{ Shown__MLSS=true;  ALines__MLSS.style.overflow="visible";  ALines__MLSS.style.height="auto";}
			}
	</script>';	return $cont.$out;
} 

	//output
	if (FullMode__MLSS && This_Site_is_in_MS_LANG_SUBSITES()){  
		add_action('wp_footer','fnc138__MLSS'); function fnc138__MLSS(){ define('Dtype__MLSS', get_optMLSS_for_this_site__MLSS('DropdHeader') ); if ( Dtype__MLSS != 'hhide') { echo apply_filters('MLSS__dropdownselector',''); }  }
	}
	
	
		
	function get_langs_flaged_urls__MLSS($SITE_LANGUAGES=false, $postID=false, $include_titles =false , $is_shortcode=false, $include_flags=true){  $SITE_LANGUAGES = $SITE_LANGUAGES ?:  ActiveLangs__MLSS();
		$out='';
		$postID =  $postID ?: $GLOBALS['post']->ID;
		if (empty($GLOBALS['disable_post_langs']) && is_singular()) {  $groupArray= GetGroupByPostID__MLSS($postID);	 }
		foreach ($SITE_LANGUAGES as $name => $key_value){  	    
			//not included in "HIDDEN LANGS"
			$target_url = SetHomeUrlInNavigation__MLSS().$name;
			//If Group ID is found
			if (!empty($groupArray)){   $PostIdOfTargetLang = $groupArray->$name;
				//If Alternative Post Id is found
				if (!empty($PostIdOfTargetLang)){ 
					// this_site_lang__MLSS()
					switch_to_blog(get_id_from_blogname($name));
					$url = get_permalink($PostIdOfTargetLang); if (!empty($url)) { $target_url = $url;}
					//restore_current_blog();
				}
			}

			if ( $include_titles==1 || $include_titles=="full")		{ $title_block =  '<span class="Flag1_lname__MLSS">'.$key_value['title'].'</span>'; }
			elseif (  $include_titles=="abbrev") 					{ $title_block =  '<span class="Flag1_lname__MLSS">'.strtoupper($name).'</span>'; }
			elseif ( $include_titles==0 || $include_titles=="no")	{ $title_block =  ''; }
			
			$out .= 
			'<div class="LineHolder1__MLSS '.$name.'" '.( $is_shortcode ? '' : 'id="lnh_'.$name. '"').' >'.
				'<a class="ImgHolder1__MLSS" href="'.$target_url.'">'.
					($include_flags ? '<img class="FlagImg1__MLSS '.$name.'_flagg1__MLSS" src="'. GetFlagUrl__MLSS($name). '" />' : '') . $title_block .
				'</a>'.
			'</div>'.( $is_shortcode ? '' : '<span class="clerboth2__MLSS"></span>');
		}
		Restore_Original_Blog__MLSS();
		return $out;
	}
	
	add_shortcode('post_translations_MLSS', 'shortcode_langs_flaged_urls__MLSS'); 
	add_shortcode('post_translations', 'shortcode_langs_flaged_urls__MLSS'); 
	function shortcode_langs_flaged_urls__MLSS() {	return 
		'<div class="flaglines_mlss">'.			get_langs_flaged_urls__MLSS(false,false,  get_optMLSS_for_this_site__MLSS('IncludeNamesShortc'), true, get_optMLSS_for_this_site__MLSS('IncludeFlagsDropd')) .   		'</div><div class="clerboth2__MLSS"></div>';
	}
//================================= ##### SHOW FLAGS SELECTOR  ============================ //
//========================================================================================= //	























// ======================= "POST ALTERNATIVE TRANSLATION"  MetaBoxes  ============================//
	// post-relations between different languages
	add_action('add_meta_boxes', 'posts_relations__MLSS'); function posts_relations__MLSS(){
		if(This_Site_is_in_MS_LANG_SUBSITES()){
			add_meta_box('posts-relation-mlss', 'Connect post to other language posts','metabx44__MLSS', get_post_types(),'normal'); 
		}
	}
	function metabx44__MLSS($post){ 
		echo '<style type="text/css"></style> <img src="'.PLUGIN_URL_nodomain__MLSS.'flags/-banner_s.png" style="height:50px;opacity:0.6;" /> <br/>Include this post into GROUP ID: ';
		$group_array = GetGroupByPostID__MLSS($post->ID);
		?> <input type="text" name="mlss_group_id" value="<?php echo (is_object($group_array) ? $group_array->groupId : '' );?>"  placeholder="example: <?php echo Last_GroupId__MLSS();?>"/> (<a href="javascript:alert('In this field, you should insert the unique GROUP ID number.. for example, when you open several different language posts as alternatives of each other, then use the same GROUP ID for them. So, for example, when visitor is viewing Japan post, and clicks English flag in the top dropdown, then visitor will be redirected NOT to ENGLISH HOMEPAGE, but to English translation for this post.  So, it is a good thing to connect the translation posts to each other with same GROUP ID. \r\n\r\n\r\np.s. If this is a completely new post or the field is empty, then you will see the recommended GROUP ID inside, and you can type that directly. ');">Read This Popup!</a>) 
		<div style="background:rgb(242, 205, 205); margin:10px 0 0 0;"> (p.s. to show flags for translations for this post, then insert shortcode <span style="font-weight:bold; font-size:1.3em;">[post_translations_MLSS]</span> in the start of post.)</div>
		<?php 
	}
	
	add_action( 'save_post', 'savpst44__MLSS',95);	
	function savpst44__MLSS( $post_id ){  global $wpdb; 
		if(isset($_POST['mlss_group_id']) ) {
			$langName = this_site_lang__MLSS();
			//at first, remove thihs post id from all existing rows  (we are removing the post from table, only when it existed already (because on first post PUBLISH, it GROUP_ID is empty by default , and in that case, we dont need to take any action)
			if (!empty($wpdb->get_var('SELECT * from '.TableGroupIDs__MLSS." WHERE ". $langName ."='$post_id'"))) { 	
				UPDATEE_OR_INSERTTT__MLSS(TableGroupIDs__MLSS,   array( $langName => '' ), array( $langName => $post_id ) ); 
			}
			//insert again, if it's groupId is set.
			if (!empty($_POST['mlss_group_id'])){
				$res=UPDATEE_OR_INSERTTT__MLSS(TableGroupIDs__MLSS,   array( $langName => $post_id), array('groupId'=> $_POST['mlss_group_id']) );
			}
		}
	}


	// redirecting to chosen language dashboard 
	add_filter( 'login_redirect', 'admin_redirect__MLSS', 10, 3 );	//
	function admin_redirect__MLSS( $redirect_to, $request, $user ) {
		if(isset($_POST['redirect_to']) && $_POST['redirect_to']==network_home_url().'wp-admin/') {
			//is there a user to check?
			if ( isset( $user->roles ) && is_array( $user->roles ) ) {
				$chosen_dashboard = get_optMLSS_for_this_site__MLSS('DefaultHome');
				//check for admins
				if (!empty($chosen_dashboard)){	return network_home_url().$chosen_dashboard.'/wp-admin';	} 
				else { return home_url(); }
			}
		}
		else { return $redirect_to; }
	}




	// GET GROUP ID by POST_ID
	function GetGroupByPostID__MLSS($pID, $lang=false){ 
		if (!$lang) { $lang=get_blog_name__MLSS(); }
		$found_group_ids= $GLOBALS['wpdb']->get_results("SELECT * from `".TableGroupIDs__MLSS."` WHERE `".$lang."` = '".$pID."'");
		return (!empty($found_group_ids) ? $found_group_ids[$LastIdx=count($found_group_ids)-1] : false );
	}
	
	function Last_GroupId__MLSS(){ 
		$opts=get_options__MLSS();
		if(empty($opts['last_g_id'])){
			$results= $GLOBALS['wpdb']->get_results("SELECT * from `".TableGroupIDs__MLSS."`");
			$LastIdx=count($results)+1;
		}
		else {
			$LastIdx =  $opts['last_g_id'] + 1;
		}
		$opts['last_g_id']= $LastIdx ;
		update_mainsite_options__MLSS('Opts__MLSS',$opts);
		return $LastIdx;
	}

	
	
								
									
								//===========  links in Plugins list ==========//
								add_filter( "plugin_action_links_".plugin_basename( __FILE__ ), function ( $links ) {   $links[] = '<a href="'.plugin_settings_page__MLSS.'">Settings</a>'; $links[] = '<a href="http://paypal.me/tazotodua">Donate</a>';  return $links; } );
								//REDIRECT SETTINGS PAGE (after activation)
								add_action( 'activated_plugin', function($plugin ) { if( $plugin == plugin_basename( __FILE__ ) ) { exit( wp_redirect( plugin_settings_page__MLSS.'&isactivation'  ) ); } } );
								
//===================================================================================//
//===================================== END# DASHBOARD ============================= //
?>