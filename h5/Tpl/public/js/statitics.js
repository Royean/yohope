var path="";(function(){var title=document.getElementsByTagName("title")[0].innerHTML;var url=window.location.href;var site=window.location.host;var referrer=document.referrer;var ref="";ref=referrer;var urlpath=path+"/statistics";var p=navigator.platform;var plat=0;if(p.indexOf("Win")==0||p.indexOf("Mac")==0||p=="X11"){plat=0}else{plat=1}jQuery.post(urlpath,{title:title,url:url,ref_val:ref,plat:plat},function(date){})})();function turn_sta(type,location){var p=navigator.platform;var plat=0;if(p.indexOf("Win")==0||p.indexOf("Mac")==0||p=="X11"){plat=0}else{plat=1}var url=window.location.href;var urlpath=path+"/statisticsTurn";jQuery.post(urlpath,{type:type,location:location,url:url,plat:plat},function(date){})};