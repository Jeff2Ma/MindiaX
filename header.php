<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php  
    $logo = mindia_option('md_logo', '' );
    $title = mindia_option('md_title', '' );
    $sub_title = mindia_option('md_sub_title', '' );
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" /> <!--禁止转码 -->
    <?php $minilogo = mindia_option('md_minilogo', '' );if ( empty( $minilogo ) ) { ?>
    <link rel="shortcut icon" href="<?php echo home_url(); ?>/favicon.ico" type="image/x-icon" />
    <?php  } else{  ?>
    <link rel="shortcut icon" href="<?php echo $minilogo; ?>" type="image/x-icon" />
    <?php } ?>
    <title><?php mindia_title(); ?></title>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    
<?php if(is_home()){//仅在首页展示如下
    ?>
<nav id="menu" class="panel" role="navigation">
    <div class="header-content">
                <a class="header-logo" href="/">
                    <img class="avatar" src="<?php echo $logo; ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>"/>                 
                </a>
            </div>
                    <?php wp_nav_menu( array( //右侧边栏菜单
                         'theme_location' => 'mindiax-right-menu',
                         'container'       => '',
                         'container_id'       => '',
                         'depth'           => 1,
                         'fallback_cb' => 'mindiax_right_menu_fallback'
                          ) ); ?>
</nav>

<div class="loading loading-home"></div>

<header id="header" class="wrap push" style="background-image: url(<?php echo mindiax_real_img(); ?>);">
        <div id="nav-right" class="right">
            <nav class="" id="topMenu">
                    <?php wp_nav_menu( array( //顶部菜单
                         'theme_location' => 'mindiax-top-menu',
                         'container'       => '',
                         'container_id'       => '',
                         'depth'           => 1,
                         'fallback_cb' => 'mindiax_top_menu_fallback'
                          ) ); ?>
         
            </nav>
        </div>

    <div class="container">
        <div class="main-content">
            <h1 class="title title-font-h1"><a href="/"><?php echo $title; ?></a></h1>
            <h2 class="sub-title sub-title-font"><?php echo $sub_title; ?></h2>
        </div>
        
    </div><!-- .container -->

<div class="go-down">
    <a href="#container" class="pulsate-opacity"><i class="icon-up"></i></a>
</div>

</header>
    <div id="container"  class="wrap push">
        <section id="content" class="<?php mindia_section_class(); ?>">

<?php } else {//其他页面保持不变?>
<?php mindia_top_left_nav();?>

<?php if (mindia_option('md_right_button')){ ?>
     <?php if (!current_user_can( 'manage_options' )) {?>
        <nav class="post-menu"><a href="/wp-login.php" class="button2 admin dwtip-bottom" data-tooltip="登录后台">登录</a></nav>
     <?php }
     else {?>
     <nav class="post-menu">
     <?php if(is_home()){?>
              <a href="/wp-admin/post-new.php" class="button2 edit dwtip-bottom" data-tooltip="写文章">新建</a>
              <a href="/wp-admin/" class="button2 admin dwtip-bottom" data-tooltip="后台管理">管理</a>
        <?php } else{?>
            <?php edit_post_link(); ?>
            <a href="/wp-admin/post-new.php" class="button2 new dwtip-bottom" data-tooltip="写文章">新建</a>
        <?php } ?>
     </nav>
     <?php  } } ?>

     <!--首页的头部文件-start-->
      <?php mindia_header_bg_setting(); ?>
    <!--文章页的头部文件-end-->

    <div id="container">
        <section id="content" class="<?php mindia_section_class(); ?>">

<?php }?>