/*
	Simple Ajax Chat > JavaScript
	@ https://wordpress.org/plugins/simple-ajax-chat/
*/

// Fade Anything Technique by Adam Michela
var Fat = { 
	make_hex : function(d,c,a) {
		d = d.toString(16);
		if (d.length == 1) {
			d = '0' + d;
		}
		c = c.toString(16);
		if (c.length == 1) {
			c = '0' + c;
		}
		a = a.toString(16);
		if (a.length == 1) {
			a = '0' + a;
		}
		return '#' + d + c + a;
	},
	fade_all : function() {
		var b = document.getElementsByTagName('*');
		for (var c = 0; c < b.length; c++) {
			var e = b[c];
			var d = /fade-?(\w{3,6})?/.exec(e.className);
			if (d) {
				if (!d[1]) {
					d[1] = '';
				}
				if (e.id) {
					Fat.fade_element(e.id, null, null, '#' + d[1]);
				}
			}
		}
	},
	fade_element : function(m, c, a, o, d) {
		if (!c) {
			c = 30; 
		}
		if (!a) {
			a = 3000;
		}
		if (!o || o == '#') {
			o = '#ffff33';
		}
		if (!d) { 
			d = this.get_bgcolor(m);
		}
		var i = Math.round(c * (a/1000));
		var s = a / i;
		var w = s;
		var j = 0;
		if (o.length < 7) {
			o += o.substr(1, 3);
		}
		if (d.length < 7) {
			d += d.substr(1, 3);
		}
		var n = parseInt(o.substr(1, 2), 16);
		var u = parseInt(o.substr(3, 2), 16);
		var e = parseInt(o.substr(5, 2), 16);
		var f = parseInt(d.substr(1, 2), 16);
		var l = parseInt(d.substr(3, 2), 16);
		var t = parseInt(d.substr(5, 2), 16);
		var k, q, v, p;
		while (j < i) {
			k = Math.floor(n * ((i - j) / i) + f * (j / i));
			q = Math.floor(u * ((i - j) / i) + l * (j / i));
			v = Math.floor(e * ((i - j) / i) + t * (j / i));
			p = this.make_hex(k, q, v);
			setTimeout(Fat.set_bgcolor.bind(null, m, p), w);
			j++;
			w = s * j;
		}
		setTimeout(Fat.set_bgcolor.bind(null, m, d), w);
	}, 
	set_bgcolor : function(d, b) {
		var a = document.getElementById(d);
		a.style.backgroundColor = b;
	},
	get_bgcolor : function(e) {
		var b = document.getElementById(e);
		while(b) {
			var d;
			if (window.getComputedStyle) {
				d = window.getComputedStyle(b, null).getPropertyValue('background-color');
			}
			if (b.currentStyle) {
				d = b.currentStyle.backgroundColor;
			}
			if ((d != '' && d != 'transparent') || b.tagName == 'body') {
				break;
			}
			b = b.parentNode;
		}
		if (d == undefined || d == '' || d == 'transparent') {
			d = '#ffffff';
		}
		var a = d.match(/rgb\s*\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*\)/);
		if (a) {
			d = this.make_hex(parseInt(a[1]), parseInt(a[2]), parseInt(a[3]));
		}
		return d;
	}
};

// smilies
var smilies = [
	[':\\)',      'icon_smile.gif'], 
	[':\\-\\)',   'icon_smile.gif'], 
	[':D',        'icon_biggrin.gif'], 
	[':\\-D',     'icon_biggrin.gif'], 
	[':grin:',    'icon_biggrin.gif'], 
	[':smile:',   'icon_smile.gif'], 
	[':\\(',      'icon_sad.gif'], 
	[':\\-\\(',   'icon_sad.gif'], 
	[':sad:',     'icon_sad.gif'], 
	[':o',        'icon_surprised.gif'], 
	[':\\-o',     'icon_surprised.gif'], 
	['8o',        'icon_eek.gif'], 
	['8\\-o',     'icon_eek.gif'], 
	['8\\-0',     'icon_eek.gif'], 
	[':eek:',     'icon_surprised.gif'], 
	[':s',        'icon_confused.gif'], 
	[':\\-s',     'icon_confused.gif'], 
	[':lol:',     'icon_lol.gif'], 
	[':cool:',    'icon_cool.gif'], 
	['8\\)',      'icon_cool.gif'], 
	['8\\-\\)',   'icon_cool.gif'], 
	[':x',        'icon_mad.gif'], 
	[':-x',       'icon_mad.gif'], 
	[':mad:',     'icon_mad.gif'], 
	[':p',        'icon_razz.gif'], 
	[':\\-p',     'icon_razz.gif'], 
	[':razz:',    'icon_razz.gif'], 
	[':\\$',      'icon_redface.gif'], 
	[':\\-\\$',   'icon_redface.gif'], 
	[":'\\(",     'icon_cry.gif'], 
	[':evil:',    'icon_evil.gif'], 
	[':twisted:', 'icon_twisted.gif'], 
	[':cry:',     'icon_cry.gif'], 
	[':roll:',    'icon_rolleyes.gif'], 
	[':wink:',    'icon_wink.gif'], 
	[';\\)',      'icon_wink.gif'], 
	[';\\-\\)',   'icon_wink.gif'], 
	[':!:',       'icon_exclaim.gif'], 
	[':\\?',      'icon_question.gif'], 
	[':\\-\\?',   'icon_question.gif'], 
	[':idea:',    'icon_idea.gif'], 
	[':arrow:',   'icon_arrow.gif'], 
	[':\\|',      'icon_neutral.gif'], 
	[':neutral:', 'icon_neutral.gif'], 
	[':\\-\\|',   'icon_neutral.gif'], 
	[':mrgreen:', 'icon_mrgreen.gif']
];

// apply filters
function sac_apply_filters(s) { 
	return filter_smilies(make_links((s))); 
};

// filter smilies
function filter_smilies(s) {
	for (var i = 0; i < smilies.length; i++) {
		var search = smilies[i][0];
		var imgalt = smilies[i][0].replace(/\\/g, '');
		var imgsrc = 'https://infinitum236.space/wp-includes/images/smilies/' + smilies[i][1];
		var replace = '<img src="' + imgsrc + '" class="wp-smiley" border="0" style="border:none;" alt="' + imgalt + '" />';
		re = new RegExp(search, 'gi');
		s = s.replace(re, replace);
	}
	return s;
};

// links
function make_links(s) {
	var re = /((http|https|ftp):\/\/[^ ]*)/gi; 
	text = s.replace(re, '<a rel="external nofollow" href="$1" class="sac-chat-link">&laquo;link&raquo;</a>');
	return text;
};

// sound alerts
var myBox = new Object();
myBox.onInit = function(){};

// Generic onload @ https://www.brothercake.com/site/resources/scripts/onload/
if (typeof window.addEventListener != 'undefined') {
	window.addEventListener('load', initJavaScript, false);
} else {
	if (typeof document.addEventListener != 'undefined') {
		document.addEventListener('load', initJavaScript, false);
	} else {
		if (typeof window.attachEvent != 'undefined') {
			window.attachEvent('onload', initJavaScript);
		}
	}
};

// scroll to position
function scroll_to_position() {
		
	// reverse display disabled
		
};

// get timeout
function get_timeout() {
	
	return 3000;
	
};

// XHTML live Chat by Alexander Kohlhofer

var sac_loadtimes;
var httpReceiveChat;
var httpSendChat;

var get_timeout = get_timeout();
var sac_timeout = get_timeout;
var GetChaturl  = 'https://infinitum236.space/wp-content/plugins/simple-ajax-chat/simple-ajax-chat-core.php?sacGetChat=yes';
var SendChaturl = 'https://infinitum236.space/wp-content/plugins/simple-ajax-chat/simple-ajax-chat-core.php?sacSendChat=yes';

function initJavaScript() {
	
	if (!document.getElementById('sac_chat')) return;
	
	document.forms['sac-form'].elements.sac_chat.setAttribute('autocomplete', 'off');
	
	checkStatus('');
	checkName();
	checkUrl();
	
	sac_loadtimes   = 1;
	httpReceiveChat = getHTTPObject();
	httpSendChat    = getHTTPObject();
	
	setTimeout(receiveChatText, sac_timeout);
	
	var sacUrl = document.getElementById('sac_url');
	if (sacUrl != null) sacUrl.onblur = checkUrl;
	
	document.getElementById('sac_name').onblur        = checkName;
	document.getElementById('sac_chat').onfocus       = function(){ checkStatus('active'); };
	document.getElementById('sac_chat').onblur        = function(){ checkStatus(''); };
	document.getElementById('sac-form').onsubmit      = function(){ return false; };
	document.getElementById('submitchat').onclick     = sendComment;
	document.getElementById('sac-output').onmouseover = function(){
		
		if (sac_loadtimes > 9){
			sac_loadtimes = 1;
			receiveChatText();
		}
		
		sac_timeout = get_timeout;
		
	}
	
	scroll_to_position();
	
};

function receiveChatText() {
	
	sac_lastID = parseInt(document.getElementById('sac_lastID').value) - 1;
	
	if (httpReceiveChat.readyState == 4 || httpReceiveChat.readyState == 0) {
		
		var id    = '&sac_lastID=' + sac_lastID;
		var rand  = '&rand=' + Math.floor(Math.random() * 1000000);
		var nonce = '&sac_nonce_receive=661536f513';
		var query = GetChaturl + id + nonce + rand;
		
		httpReceiveChat.open('GET', query, true);
		httpReceiveChat.onreadystatechange = handlehHttpReceiveChat;
		httpReceiveChat.send(null);
		
		sac_loadtimes++;
		if (sac_loadtimes > 9) {
			sac_timeout = sac_timeout * 1.25;
		}
		
	}
	
	// console.log('sac_loadtimes: '+ sac_loadtimes + ', Timeout: ' + sac_timeout);
	
	setTimeout(receiveChatText, sac_timeout);
	
};

// http receive chat
function handlehHttpReceiveChat() {
	if (httpReceiveChat.readyState == 4) { 
		results = httpReceiveChat.responseText.split('---');
		if (results.length > 4) {
			for (i = 0; i < (results.length - 1); i = i + 5) {
				insertNewContent(results[i + 1], results[i + 2], results[i + 3], results[i + 4], results[i]);
				document.getElementById('sac_lastID').value = parseInt(results[i]) + 1;
			}
			sac_timeout = get_timeout;
			sac_loadtimes = 1;
		}
	}
};

// send chat
function sendComment() {
	currentChatText = document.forms['sac-form'].elements.sac_chat.value;
	if (httpSendChat.readyState == 4 || httpSendChat.readyState == 0) {
		if(currentChatText == '' || currentChatText.trim().length === 0) {
			return;
		}
		currentName = document.getElementById('sac_name').value;
		
		var currentUrl = document.getElementById('sac_url');
		if (currentUrl != null) currentUrl = currentUrl.value;
		
		currentNonce   = document.getElementById('sac_nonce').value;
		currentJSNonce = document.getElementById('sac_js_nonce').value;
		
		var n = 'n='  + encodeURIComponent(currentName);
		var c = '&c=' + encodeURIComponent(currentChatText);
		var u = '&u=' + encodeURIComponent(currentUrl);
		var nonce = '&sac_nonce=' + encodeURIComponent(currentNonce);
		var jsnonce = '&sac_js_nonce=' + encodeURIComponent(currentJSNonce);
		
		param = n + c + u + nonce + jsnonce;
		httpSendChat.open('POST', SendChaturl, true);
		httpSendChat.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		httpSendChat.onreadystatechange = receiveChatText;
		httpSendChat.send(param);
		document.forms['sac-form'].elements.sac_chat.value = '';
	}
};

// insert chat
function insertNewContent(liName,liText,lastResponse, liUrl, liId) {
	
	response = document.getElementById('responseTime');
	response.replaceChild(document.createTextNode(lastResponse), response.firstChild);
	insertO = document.getElementById('sac-messages');

	var audio = document.getElementById('TheBox');
	if (audio) audio.play();

	oLi = document.createElement('li');
	oLi.setAttribute('id', 'comment-new' + liId);
	
	// li date
	Date.prototype.date = function() {
		
		var li_date_1 = this.getFullYear();
		var li_date_2 = (((this.getMonth() + 1) < 10) ? '0' : '');
		var li_date_3 = (this.getMonth() + 1);
		var li_date_4 = ((this.getDate() < 10) ? '0' : '');
		var li_date_5 = this.getDate();
		
		return li_date_1 + '-' + li_date_2 + li_date_3 + '-' + li_date_4 + li_date_5;
		
	};
	
	// li time
	Date.prototype.time = function() {
		
		var li_time_1 = ((this.getHours() < 10) ? '0' : '');
		var li_time_2 = this.getHours();
		var li_time_3 = ((this.getMinutes() < 10) ? '0' : '');
		var li_time_4 = this.getMinutes();
		var li_time_5 = ((this.getSeconds() < 10) ? '0' : '');
		var li_time_6 = this.getSeconds();
		
		return li_time_1 + li_time_2 + ':' + li_time_3 + li_time_4 + ':' + li_time_5 + li_time_6;
		
	};
	
	var newDate = new Date();
	var timestamp = newDate.date() + ',' + newDate.time();
	oLi.setAttribute('data-time', timestamp);
	
	oSpan = document.createElement('span');
	oSpan.setAttribute('class', 'sac-chat-name');
	
	// span date
	Date.prototype.today = function() {
		
		var span_date_1 = this.getFullYear();
		var span_date_2 = (((this.getMonth() + 1) < 10) ? '0' : '');
		var span_date_3 = (this.getMonth() + 1);
		var span_date_4 = ((this.getDate() < 10) ? '0' : '');
		var span_date_5 = this.getDate();
		
		return span_date_1 + '/' + span_date_2 + span_date_3 + '/' + span_date_4 + span_date_5;
		
	};
	
	// span time
	Date.prototype.timeNow = function() {
		
		var span_time_1 = ((this.getHours() < 10) ? '0' : '');
		var span_time_2 = this.getHours();
		var span_time_3 = ((this.getMinutes() < 10) ? '0' : '');
		var span_time_4 = this.getMinutes();
		var span_time_5 = ((this.getSeconds() < 10) ? '0' : '');
		var span_time_6 = this.getSeconds();
		
		return span_time_1 + span_time_2 + ':' + span_time_3 + span_time_4 + ':' + span_time_5 + span_time_6;
		
	};
	
	var datetime = 'Posted: ' + newDate.today() + ' @ ' + newDate.timeNow();
	oSpan.setAttribute('title', datetime);
	oName = document.createTextNode(liName);
	
		
	oURL = oName;
	oSpan.appendChild(oURL);
	
		
	name_class = liName.replace(/[\s\.\#\(\)]+/g,'-');
	
	oLi.className = 'sac-chat-message sac-live sac-user-' + name_class;
	oSpan.appendChild(document.createTextNode(' : '));
	oLi.appendChild(oSpan);
	oLi.innerHTML += sac_apply_filters(liText);
	
		
	if ('Notification' in window) {
		sacCustomNotify('New chat message', liName + ': ' + sac_apply_filters(liText) + "\r\n" + '(' + datetime + ')', "");
	}
	
		
		
	insertO.insertBefore(oLi, insertO.firstChild);
	
		jQuery.post('https://infinitum236.space/wp-content/plugins/simple-ajax-chat/includes/sac-check-user.php', 'sac_user=' + encodeURIComponent(liName), function(response){
		jQuery('.sac-user-' + name_class).addClass('sac-online');
	});
	
		
	var fade_length = 1500;
	var fade_from   = '#ffffcc';
	var fade_to     = '#ffffff';
	
	Fat.fade_element('comment-new' + liId, 30, fade_length, fade_from, fade_to);

};

// textarea enter
function pressedEnter(b,a) {
	var c = a.keyCode ? a.keyCode : a.which ? a.which : a.charCode;
	if (c == 13) { 
		sendComment();
		return false;
	} else { 
		return true;
	}
};

// chat status
function checkStatus(a) {
	currentChatText = document.forms['sac-form'].elements.sac_chat;
	oSubmit = document.forms['sac-form'].elements.submit;
	if (currentChatText.value != '' || a == 'active') {
		oSubmit.disabled = false;
	} else {
		oSubmit.disabled = true;
	}
};

// get cookie
function sac_getCookie(c) {
	var b = document.cookie;
	var e = c + '=';
	var d = b.indexOf('; ' + e);
	if (d == -1) {
		d = b.indexOf(e);
		if (d != 0) {
			return null;
		}
	} else {
		d += 2;
		var a = document.cookie.indexOf(';', d);
		if (a == -1) {
			a = b.length;
		}
		return unescape(b.substring(d + e.length, a));
	}
};

// check name
function checkName() {
	sacCookie = sac_getCookie('sacUserName');
	currentName = document.getElementById('sac_name');
	currentName.value = currentName.value.replace(/[^\p{L}0-9\s_-]/gui, '');
	
		
	chat_name = currentName.value;
		
	if (currentName.value != chat_name) {
		currentName.value = chat_name;
	}
	if (chat_name != sacCookie) {
		document.cookie = 'sacUserName=' + chat_name + '; expires=Sat, 19 Jul 2025 06:35:37 UTC; samesite=strict;';
	}
	if (sacCookie && currentName.value == '') {
		currentName.value = sacCookie;
		return;
	}
	if (currentName.value == '' || currentName.value.trim().length === 0) {
		currentName.value = 'guest_' + Math.floor(Math.random() * 10000);
	}
};

// check url
function checkUrl() {
	var sacCookie = sac_getCookie('sacUrl');
	var sacUrl = document.getElementById('sac_url');
	if (sacUrl != null) {
		sacUrl.value = encodeURI(sacUrl.value);
		if (sacUrl.value == '') {
			return;
		}
		if (sacUrl.value != sacCookie) {
			document.cookie = 'sacUrl=' + sacUrl.value + '; expires=Sat, 19 Jul 2025 06:35:37 UTC; samesite=strict;';
			return;
		}
		if (sacCookie && (sacUrl.value == '' || sacUrl.value == 'http://' || sacUrl.value == 'https://')) {
			sacUrl.value = sacCookie;
			return;
		}
	}
};

// ajax
function getHTTPObject() {
	var xmlhttp;
	/*@cc_on
		@if (@_jscript_version >= 5)
		try {
			xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
		} catch (e) {
			try {
				xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
			} catch (E) {
				xmlhttp = false;
			}
		}
		@else
		xmlhttp = false;
	@end @*/
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
		try { 
			xmlhttp = new XMLHttpRequest();
		} catch (e) {
			xmlhttp = false;
		}
	}
	return xmlhttp;
};

jQuery(document).ready(function($){
	
	// nonce
	var url = 'https://infinitum236.space/wp-content/plugins/simple-ajax-chat/resources/nonce.php';
	$('.sac_js_nonce').load(url);
	
	// blank targets
	jQuery("#sac-messages").on("click", "a[rel*=external]", function(e) {
		e.preventDefault();
		e.stopPropagation();
		window.open(this.href);
	});
	
});

// tooltips
jQuery(document).on({
	mouseenter: function() {
		var item = jQuery(this);
		var link = item.children('a');
		var title = item.attr('title');
		item.data('tip', title).removeAttr('title');
		link.css({ 'cursor' : 'help' });
		item.css({ 'position' : 'relative', 'display' : 'inline-block', 'cursor' : 'help' });
		jQuery('<div class="tooltip"></div>').text(title).appendTo(item);
		jQuery('.tooltip').css({ 
			'position' : 'absolute', 'z-index' : '9999', 'top' : '-2px', 'left' : '105%', 'line-height' : '16px',
			'padding' : '5px 10px', 'font-size' : '12px', 'font-weight' : 'normal', 'white-space' : 'nowrap',
			'color' : '#333', 'background-color' : '#efefef', 'box-shadow' : '0 5px 15px -5px rgba(0,0,0,0.5)'
		});
	}, mouseleave: function() {
		var item = jQuery(this);
		item.attr('title', item.data('tip'));
		jQuery('.tooltip').remove();
	}
}, '.sac-chat-name');

// notifications
function isNewNotificationSupported() {
	if (!window.Notification || !Notification.requestPermission) return false;
	if (Notification.permission == 'granted') throw new Error('Browser notification error for SAC plugin');
	try {
		new Notification('');
	} catch (e) {
		if (e.name == 'TypeError') return false;
	}
	return true;
}

function sacCustomNotify(title, desc, url) {
	if (window.Notification && Notification.permission == 'granted') {
		var notification = new Notification(title, {
			icon: '',
			body: desc,
		});
		if (url) {
			notification.onclick = function() {
				window.open(url);
			};
		}
		notification.onclose = function() {
			// console.log('Notification closed');
		};
	} else if (isNewNotificationSupported()) {
		Notification.requestPermission();
	}
}