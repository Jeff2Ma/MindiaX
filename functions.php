<?php
//mindiax- a child theme of Mindia
if ( ! defined( 'ABSPATH' ) ) exit;

// define constants
define('CHILDPATH', dirname( get_bloginfo('stylesheet_url') ));


/***___________________________________________________________________________________________**/

//add extra nav menu
register_nav_menus(array(
      'mindiax-top-menu' => 'MindiaX-右上导航菜单',
      'mindiax-right-menu' => 'MindiaX-右侧边栏导航菜单',
    ));

//nav fallback
function mindiax_right_menu_fallback(){
	echo '<ul><li><a href="/">首页</a></li><li><a href="/wp-admin/nav-menus.php">设置菜单</a></li><li><a href="/wp-admin/nav-menus.php">设置菜单</a></li><li><a href="/wp-admin/nav-menus.php">设置菜单</a></li><li><a href="/wp-admin/nav-menus.php">设置菜单</a></li></ul>';
}

//nav fallback2
function mindiax_top_menu_fallback(){
	echo '<ul><li><a href="/wp-admin/nav-menus.php">关于</a></li><li><a href="/wp-admin/nav-menus.php">联系</a></li><li><a href="/wp-admin/">管理</a></li><li><a href="#menu" class="menu-link"></li></ul>';
}

// add menu icon after mindiax top nav
add_filter('wp_nav_menu_items','mindiax_menu_item', 10, 2);
function mindiax_menu_item( $items, $args ) {
    if( $args->theme_location == 'mindiax-top-menu' ){
    	if (current_user_can( 'manage_options' )) {
    		$items .= '<li><a href="/wp-admin/">管理</a></li>';
    	}
        return $items.'<li><a href="#menu" class="menu-link"><i class="icon-menu"></i></a></li>';
    }
    return $items;
}

/***___________________________________________________________________________________________**/

//add option for mindiaX
add_filter( 'of_options', function( $options ) {
	
	$options[] = array(
		'name' => __('MindiaX设置', 'options_framework_theme'),
		'type' => 'heading');

	$options[] = array(
		'desc' => '<div id="message2" class="updated below-h2"><p>以下是MindiaX子主题的首页设置</p></div>',
		'type' => 'info');

	$options[] = array(
		'name' => __('MindiaX首页全屏图片展现方式', 'options_framework_theme'),
		'desc' => __('选择你的MindiaX首页全屏图片展现方式，有固定背景或定时自动背景', 'options_framework_theme'),
		'id' => 'mindiax_bg_mod',
		'std' => 'mindiax_cronbg_mod',
		'type' => 'radio',
		'options' => array(
			'mindiax_cronbg_mod' => '定时自动背景模式',
			'mindiax_fixbg_mod' => '固定背景模式',
		));

	$options[] = array(
		'name' => __('固定背景模式背景图上传', 'options_framework_theme'),
		'desc' => __('在这里上传固定背景模式背景图，建议为jpg格式', 'options_framework_theme'),
		'id' => 'mindiax_fixbg_mod_url',
		'std'=>  CHILDPATH.'/images/default.jpg',
		//'class' => 'hide',
		'type' => 'upload');


	$options[] = array(
		'name' => __('定时自动背景模式时间设置', 'options_framework_theme'),
		'desc' => __('设置定时自动背景模式的时间间隔（即多久更换一次背景图片）', 'options_framework_theme'),
		'id' => 'mindiax_cronbg_mod_time',
		'std' => '24h',
		'class' => 'mini',
		'type' => 'select',
		'options' => array(
			//dev
			//'dev' => '10s，测试模式',
			'1h' => '1小时',
			'6h' => '6小时',
			'12h' => '12小时',
			'24h' => '24小时',
			'48h' => '48小时'
		));
	
	      return $options;
	  });

/***___________________________________________________________________________________________**/


//add extra js/css files
//@rewrite functions
function mindia_script() {
   wp_enqueue_style('style', DWPATH . '/style.css',array(), THEMEVER, 'screen');
   wp_enqueue_style('fontello', DWPATH . '/lib/css/fontello/css/fontello.css',array(),THEMEVER, 'screen');
    //js 文件
   switch (mindia_option('md_jquery_select')) {
        case 'qiniu':$jquery_url = 'http://cdn.staticfile.org/jquery/1.9.1/jquery.min.js';break;
        case 'google':$jquery_url = 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js';break;
        case 'baidu':$jquery_url = 'http://libs.baidu.com/jquery/1.9.1/jquery.min.js';break;
        case 'sae':$jquery_url = 'http://lib.sinaapp.com/js/jquery/1.9.0/jquery.min.js';break;
        case 'upyun':$jquery_url = 'http://upcdn.b0.upaiyun.com/libs/jquery/jquery-1.9.1.min.js';break;    
    }

      wp_enqueue_script( 'jquery1.9.1', $jquery_url, array(), '1.9.1', true);
      wp_enqueue_script( 'modernizr', DWPATH . '/lib/js/modernizr.custom.js', array(), THEMEVER, true);
      wp_enqueue_script( 'main', DWPATH . '/lib/js/mindia.js', array(), THEMEVER, true);
     
  
     //singular page 
    if ( is_singular() || is_page()){     
        global $post;
        $postid = $post->ID;
        $ajaxurl = home_url("/");
              
        wp_enqueue_script( 'comment', DWPATH . '/lib/js/comments.js', array(), THEMEVER, true);
        
        wp_localize_script( 'comment', 'mindia', 
          array(
            "postid" => $postid,
            "ajaxurl" => $ajaxurl,
            //"fixed" => $fixed
        ));
          }

   //mindiax       
   wp_enqueue_style('mindiaxstyle', CHILDPATH . '/mindiax.css',array(), THEMEVER, 'screen');
   //mindiax
   wp_enqueue_script( 'mindiaxjs', CHILDPATH . '/js/mindiax.js', array(),THEMEVER, true);
         
}

// add mindiax class in function body_class
add_filter( 'body_class', 'body_class_mindiax' );
function body_class_mindiax( $classes ) {
if( is_home() ) {
    $classes[] = 'mindiax';
}
return $classes;
}

/***___________________________________________________________________________________________**/


// get remote img date from json	
function mindiax_remote_img() {

	$json_api_src ='http://dreamafar.qiniudn.com/destination.json';
	$json = file_get_contents($json_api_src);
   	$obj = json_decode($json);

   	foreach ($obj as $destinations => $value) {
   		foreach ($value as $date) {
   			$curren_id = date("d");//获取当前日期
   			if($date->id == $curren_id){
				$file_pre = $date->alias;
   				$count = $date->photoCount;
   				$file_id = rand(1,$count);
        		$url= 'http://mindiax.qiniudn.com/'.$file_pre.'_'.$file_id.'.jpg';
        		return $url; 
        		break;
   			}
   			
        	
    	}
   	}
}

//cache the img url in wp using transient
function mindiax_cache_img(){
	if (false === get_transient( 'mindiax_cache_img_url') || '' == get_transient( 'mindiax_cache_img_url')){
		
	//读取设置面板中设置的缓存时间
	switch (mindia_option('mindiax_cronbg_mod_time')) {
			//测试模式
			//case 'dev':$mindiax_cache_img_time = 10;break;
        	case '1h':$mindiax_cache_img_time = 1*3600;break;
        	case '6h':$mindiax_cache_img_time = 6*3600;break;
        	case '12h':$mindiax_cache_img_time = 12*3600;break;
        	case '24h':$mindiax_cache_img_time = 24*3600;break;
        	case '48h':$mindiax_cache_img_time = 48*3600;break;  
    }

		$mindiax_cache_img_key = mindiax_remote_img();
		//set_transient('mindiax_cache_img_url', $mindiax_cache_img_key,2);	//debug mod
		set_transient('mindiax_cache_img_url', $mindiax_cache_img_key,$mindiax_cache_img_time);		

	}
		$cache_url = get_transient( 'mindiax_cache_img_url');
		return $cache_url;
}

//option bg mod
function mindiax_real_img(){
	if(mindia_option('mindiax_bg_mod') == 'mindiax_cronbg_mod'){
		$real_url = mindiax_cache_img();
	}else{
		$real_url = mindia_option('mindiax_fixbg_mod_url');
	}
	return $real_url;
}

/***___________________________________________________________________________________________**/

	
?>