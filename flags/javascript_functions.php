<?php  if (isset($_GET['jstypee'])) { $JSoutp=true;     header("Content-type: application/x-javascript"); } else {$JSoutp=false;} ?>


<?php if (!$JSoutp) { ?> <script type="text/javascript"> <?php } ?>


//######################## simple POPUP  ############################# https://github.com/tazotodua/useful-javascript/ ###############
function show_my_popup(TEXTorID){
		TEXTorID=TEXTorID.trim(); var FirstChar= TEXTorID.charAt(0); var eName = TEXTorID.substr(1); if ('#'==FirstChar || '.'==FirstChar){	if('#'==FirstChar){var x=document.getElementById(eName);} else{var x=document.getElementsByClassName(eName)[0];}} else { var x=document.createElement('div');x.innerHTML=TEXTorID;} var randm_id=Math.floor((Math.random()*100000000));
	var DivAA = document.createElement('div');    DivAA.id = "blkBackgr_"+randm_id;  DivAA.className = "MyJsBackg";   DivAA.setAttribute("style", 'background:black; height:5000px; left:0px; opacity:0.9; position:fixed; top:0px; width:100%; z-index:9599;'); document.body.appendChild(DivAA);
	var DivBB = document.createElement('div');    DivBB.id = 'popupp_'+randm_id;     DivBB.className = "MyJsPopup";   DivBB.setAttribute("style",'background-color:white; border:6px solid white; border-radius:10px; display:block; min-height:100px; min-width:350px; overflow:auto; max-height:80%; max-width:92%; padding:15px; position:fixed; text-align:center; top:25%; left:50%; transform:translate(-50%, 0); z-index:9599;'); 	DivBB.innerHTML = '<div style="background-color:#C0BCBF; border-radius:55px; padding:5px; font-family:arial; float:right; font-weight:700; margin:-15px -10px 0px 0px;"><a href="javascript:pop_hide('+randm_id+');" style="display:block;margin:-5px 0 0 0;font-size:1.6em;">x</a></div>'; document.body.appendChild(DivBB);z=x.cloneNode(true);DivBB.appendChild(z); if(z.style.display=="none"){z.style.display="block";}
}
function pop_hide(RandomIDD)  { var x=document.getElementById("blkBackgr_"+RandomIDD); x.parentNode.removeChild(x);      var x=document.getElementById('popupp_'+RandomIDD); x.parentNode.removeChild(x); }
//###################################################################################


 






//######################## separate BLACKening background  #################(NOTE: on your over element, use z-index:9600 ) ###############
function SHOW_blackGROUND(){ var AAADIV = document.createElement('div'); AAADIV.id = "my_black_bck_123";  var stl='background:black; height:5000px; left:0px; opacity:0.9; position:fixed; top:0px; width:100%; z-index:9503;';  AAADIV.setAttribute("style", stl ); if (mybodyyy = document.body)  {mybodyyy.insertBefore(AAADIV, mybodyyy.childNodes[0]);}   else                           {document.write('<div style="'+stl+'"></div>');}}
function REMOVE_blackGROUND(){ var AAADIV = document.getElementById('my_black_bck_123'); AAADIV.parentNode.removeChild(AAADIV); }
//###################################################################################




// =================================== hide content if chosen radio box not chosen  ===============================
	function radiobox_onchange_hider(selector,desiredvalue, target_hidding_selector, SHOW_or_hide){
		SHOW_or_hide = SHOW_or_hide || false;
		if( typeof dropdown_objs == 'undefined') { dropdown_objs = {}; } 
		if( typeof dropdown_objs[selector] == 'undefined' ){
			dropdown_objs[selector] = true ; var funcname= arguments.callee.name;
			jQuery(selector).change(function() { window[funcname](selector,desiredvalue, target_hidding_selector, SHOW_or_hide);	});
		}
		var x = jQuery(target_hidding_selector);
		if( jQuery(selector+':checked').val() == desiredvalue)	{ if(SHOW_or_hide)	x.show(); else x.hide(); } 
		else 													{ if(SHOW_or_hide)	x.hide(); else x.show(); }
	}
// ===========================================================================================




//############################### https://github.com/tazotodua/useful-javascript/ ################
function SHOW_waiting(){  var DIIV = document.createElement('div'); DIIV.id = 'my_waiting_box';  DIIV.innerHTML=  '<div style="background-color:black; color:white; height:4000px; left:0px; opacity:0.9; position:fixed; top:0px; width:100%; z-index:1007;" id="ppshadow">' + '<div style="position:absolute; top:200px;left:49%; z-index: 1008;" id="ppload"> ' + '<span style="color:white;font-size:24px;"> LOADING...</span><br/>'+'</div>'+'</div>'; 	var b=document.body;   b.insertBefore(DIIV, b.childNodes[0]);  }
function HIDE_waiting(id){  var DIIV = document.getElementById('my_waiting_box'); DIIV.parentNode.removeChild(DIIV);  }
//###################################################################################


						//instead of "LOADING" word, you can use: '<img alt="" src="data:image/gif;base64,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" />'







//##################### AJAX EXAMPLES  ############## https://github.com/tazotodua/useful-javascript/ ####################
function myyAjaxRequest(parameters, url, method, YOUR_PASSED_CODES, ShowBlackground){ ShowBlackground= ShowBlackground || false;
	method = method || "get";method=method.toLowerCase(); url = (url =='') ? window.location.href : url;  if (method  == "get") { url= url + ( (url.indexOf('?') <= -1) ? '?' : '&') +parameters+'&RandomInLinkToAvoidCache=' + Math.random();}
	if(typeof SHOW_waiting === 'function' && ShowBlackground) {SHOW_waiting();}	try{try{var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");} catch( e ){var xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");}}catch(e){var xmlhttp = new XMLHttpRequest();}
	xmlhttp.onreadystatechange=function(){if (xmlhttp.readyState==4){ if(typeof HIDE_waiting === 'function' && ShowBlackground) {HIDE_waiting();}  responseee = xmlhttp.responseText; //xmlhttp.readyState + xmlhttp.status//
		eval(YOUR_PASSED_CODES); //execute any codes
		}
	}; xmlhttp.open(method,url, true); 
	if (method  == "post"){xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");xmlhttp.send(parameters);}
	else if (method  == "get"){xmlhttp.send(null);}
}
//########################################################################################################################

























// #####################  Form-serialize ###########################  http://github.com/tazotodua/useful-javascript/   #################
function serialize (form) { 'use strict'; // http://kevin.vanzonneveld.net
    var i, j, len, jLen, formElement, q = [];
    function urlencode (str) {
        // Tilde should be allowed unescaped in future versions of PHP (as reflected below), but if you want to reflect current PHP behavior, you would need to add ".replace(/~/g, '%7E');" to the following.
        return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
            replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');
    }
    function addNameValue(name, value) { q.push(urlencode(name) + '=' + urlencode(value)); }
    if (!form || !form.nodeName || form.nodeName.toLowerCase() !== 'form') { throw 'You must supply a form element'; }
    for (i = 0, len = form.elements.length; i < len; i++) { formElement=form.elements[i]; if (formElement.name === '' || formElement.disabled) {continue;}
        switch (formElement.nodeName.toLowerCase()) {
        case 'input':
            switch (formElement.type) {
            case 'text':
            case 'hidden':
            case 'password':
            case 'button': // Not submitted when submitting form manually, though jQuery does serialize this and it can be an HTML4 successful control
            case 'submit':
                addNameValue(formElement.name, formElement.value);
                break;
            case 'checkbox':
            case 'radio':
                if (formElement.checked) {
                    addNameValue(formElement.name, formElement.value);
                }
                break;
            case 'file':
                // addNameValue(formElement.name, formElement.value); // Will work and part of HTML4 "successful controls", but not used in jQuery
                break;
            case 'reset':
                break;
            }
            break;
        case 'textarea':
            addNameValue(formElement.name, formElement.value);
            break;
        case 'select':
            switch (formElement.type) {
            case 'select-one':
                addNameValue(formElement.name, formElement.value);
                break;
            case 'select-multiple':
                for (j = 0, jLen = formElement.options.length; j < jLen; j++) {
                    if (formElement.options[j].selected) {
                        addNameValue(formElement.name, formElement.options[j].value);
                    }
                }
                break;
            }
            break;
        case 'button': // jQuery does not submit these, though it is an HTML4 successful control
            switch (formElement.type) {
            case 'reset':
            case 'submit':
            case 'button':
                addNameValue(formElement.name, formElement.value);
                break;
            }
            break;
}}return q.join('&');
}





// =================================== getElementById from parent_node  =============== http://stackoverflow.com/a/5683184/2377343 ==========
Element.prototype.getElementById_FROM_PARENT = function(req) {
  var elem = this, children = elem.childNodes, i, len, id;
  for (i = 0, len = children.length; i < len; i++) {
	elem = children[i];										// current element
	if (elem.nodeType !== 1 )  continue;					// we only want real elements
	id = elem.id || elem.getAttribute('id');				// get ID
	if (id === req) {  return elem;  }						// If it was found, then return 
	else {id=elem.getElementById_FROM_PARENT(req); if(id) return id;}	// otherwise, search recursively within the child				
  }
  return null;												// if no match found
}
// =========================================================================================================





// ################  get STYLESHEET style of element ################ http://goo.gl/2o6mem ##########
function GETproperty(classOrId,property){ 
	var FirstChar = classOrId.charAt(0);  var Remaining= classOrId.substring(1);
	var elem = (FirstChar =='#') ?  document.getElementById(Remaining) : document.getElementsByClassName(Remaining)[0];
	return window.getComputedStyle(elem,null).getPropertyValue(property);
}





<?php if (!$JSoutp) { ?> </script> <?php } ?>