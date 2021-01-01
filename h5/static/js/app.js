var url=window.location.href;

if(url.indexOf("192.168.1")>-1){
	var baseUrl="/Pc";
}else{
	var baseUrl="/";
}
requirejs.config({
	baseUrl:baseUrl,
	paths:{
		'jquery':['https://cdn.jsdelivr.net/gh/fanliqiangoneall/js/jquery-1.8.3.min','../../Tpl/HJZF2_Z/js/jquery-1.8.3.min'],
		'superSlide':'../../Tpl/HJZF2_Z/js/jquery.SuperSlide',
		'swiper':['https://cdn.jsdelivr.net/gh/fanliqiangoneall/js/swiper.min-4.5.3','../../Tpl/HJZF2_Z/js/swiper.min'],
		'three': '../../Tpl/HJZF2_Z/js/three',
		'lightBox': '../../Tpl/HJZF2_Z/js/jquery.lightbox-0.5.min',
		'jqueryzoom':'../../Tpl/HJZF2_Z/js/jqueryzoom',
		'proDetail': '../../Tpl/HJZF2_Z/js/proDetail',
		'CountUp' :'../../Tpl/HJZF2_Z/js/jquery.countup.min',
		'waypoints':'../../Tpl/HJZF2_Z/js/jquery.waypoints.min',
		'demo':'../../Tpl/HJZF2_Z/js/demo',
		'themepunchR':'../../Tpl/HJZF2_Z/js/jquery.themepunch.revolution.min',
		'themepunchT':'../../Tpl/HJZF2_Z/js/jquery.themepunch.tools.min',
		'slick':'../../Tpl/HJZF2_Z/js/slick.min',
		'countTo':'../../Tpl/HJZF2_Z/js/jquery_mouse_numgd',
		'imgSwitch':'../../Tpl/HJZF2_Z/js/imgSwitch.min',
		'wow':['https://cdn.jsdelivr.net/gh/fanliqiangoneall/js/wow.min','../../Tpl/HJZF2_Z/js/wow'],
		'velocity':'../../Tpl/HJZF2_Z/js/velocity.min',
		'layer': ['../../Tpl/HJZF2_Z/js/layer/layer'],
		'lazyload':['https://cdn.jsdelivr.net/gh/fanliqiangoneall/js/jquery.lazyload','../../Tpl/HJZF2_Z/js/jquery.lazyload'],
		'matchHeight':['../../Tpl/HJZF2_Z/js/jquery.matchHeight'],
		'video':['../../Tpl/HJZF2_Z/js/video'],
		'StickyNavigation':['../../Tpl/HJZF2_Z/js/StickyNavigation'],
		'jquery.validate':['../../Tpl/HJZF2_Z/js/validation/jquery.validate.min'],
		'tn_code':['../../Tpl/HJZF2_Z/js/validation/tn_code'],
		'boomer':['../../Tpl/HJZF2_Z/js/jquery-boomer'],
		'mousewheel':['../../Tpl/HJZF2_Z/js/jquery.mousewheel'],
		'parallax':['../../Tpl/HJZF2_Z/js/jquery.parallax'],
		'move_port':['../../Tpl/HJZF2_Z/js/move_port'],
		
	},
	shim: {
		'layer': {
			deps: ['jquery'],
			exports: "layer"
		},
		'jquery.validate':{
			deps:['jquery'],
			exports: 'jQuery.fn.validate'
		},
		'tn_code':{
			deps:[],
			exports: 'tncode',
		}
		
	},		
	waitSeconds: 20

});


require(['jquery'], function ($) {
	var url=window.location.href;
	if(url.indexOf("192.168.1") !== -1){
		// 替换本地路径不对的图片 例如（http://192.168.1.8:8082/pcuploadfiles/107.151.154.88/webid1078/Mod/202006/...），替换其中的http://192.168.1.8:8082 为http://yun.one-all.com
		$('img').each(function(){
			var error = false;
			if (!this.complete) {
				error = true;
			}
			if (typeof this.naturalWidth != "undefined" && this.naturalWidth == 0) {
				error = true;
			}
			if(error){
				$(this).bind('error.replaceSrc',function(){
					var regResult = this.src.match(/^http:\/\/192\.168\.1\.8\:([0-9]+)/);
					// 判断是否匹配到了http://192.168.1.8:8082的错误图片
					if(regResult){
						var valu = regResult[0];
						var newUrl = this.src.replace(valu, 'http://yun.one-all.com');
						this.src = newUrl;
					}
					$(this).unbind('error.replaceSrc');
				})
			}
		});
	}

});








