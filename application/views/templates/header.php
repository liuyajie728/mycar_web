<!doctype html>
<html lang=zh-cn>
	<head>
		<meta charset=utf-8>
		<meta http-equiv=x-dns-prefetch-control content=on>
		<link rel=dns-prefetch href="http://cdn.key2all.com">
		<link rel=dns-prefetch href="http://images.key2all.com">
		<title><?php echo ($class != 'home')?$title :'哎油'; ?></title>
		<meta name=description content="<?php echo $title ?>">
		<meta name=keywords content="<?php echo $title ?>">
		<meta name=version content="revision20150513">
		<meta name=author content="刘亚杰">
		<meta name=copyright content="刘亚杰, 森思壮SenseStrong, 青岛我的车信息技术有限公司, 哎油">
		<meta name=contact content="liuyaji@sensestrong.com, http://weibo.com/sensestrong">
		<meta name=viewport content="width=device-width, user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!--[if (lt IE 9) & (!IEMobile)]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
			<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<![endif]-->
		<script src="http://cdn.key2all.com/js/jquery/new.js"></script>
		<script src="http://cdn.key2all.com/js/jquery/jquery.cookie.js"></script>
		<!--<script src="http://cdn.key2all.com/js/jquery/jquery.validate.js"></script>-->
		<!--<script src="http://cdn.key2all.com/js/jquery/jquery.uploadify.js"></script>-->
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

		<link rel=stylesheet media=all href="http://cdn.key2all.com/css/reset.css">
		<!-- Latest compiled and minified CSS -->
		<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">-->
		<link rel=stylesheet href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel=stylesheet media=all href="<?php echo base_url('css/style.css'); ?>">

		<link rel="shortcut icon" href="http://images.key2all.com/logo/brand/6_32.png">
		<link rel="apple-touch-icon" href="http://images.key2all.com/logo/brand/6_120.png">

		<link rel=canonical href="<?php echo current_url() ?>">

		<meta name=format-detection content="telephone=yes, email=no, address=no">

		<!-- 苹果设备优化 -->
		<meta name=apple-mobile-web-app-capable content=yes>
		<meta name=apple-mobile-web-app-status-bar-style content=black-translucent>
		<link rel="apple-touch-startup-image" media="device-width: 320px" href="<?php echo base_url('images/launch_960.png'); ?>">
		<link rel="apple-touch-startup-image" media="(device-width: 320px) and (-webkit-device-pixel-ratio: 2)" href="<?php echo base_url('images/launch_1136.png'); ?>">
	</head>
<?php
	//将head内容立即输出，让用户浏览器立即开始请求head中各项资源，提高页面加载速度
	ob_flush();flush();
?>
<!-- 内容开始 -->
	<body<?php echo (isset($class))? ' class="'.$class.'"': NULL; ?>>
	<?php if(strpos($this->input->user_agent(), 'MicroMessenger') === FALSE && strpos($this->input->user_agent(), 'Windows Phone') === FALSE): ?>
		<header id=header>
			<nav id=nav-header class=container>
				<h1><a title="<?php echo $title; ?>" href="<?php echo base_url() ?>"><?php echo $title; ?></a></h1>
				<?php
					// 拆分载入视图时传入的$class变量为数组，并检查数组中内容决定是否需要显示“返回”按钮
					$class_array = explode(' ', $class);
					$no_toback = array('home', 'user-index', 'order-recharge', 'user-login');
					if (empty(array_intersect($class_array, $no_toback))):
				?>
				<a id=toback title="返回" href="#" onclick="javascript:history.go(-1);"><i class="fa fa-chevron-left"></i> 返回</a>
				<?php endif; ?>
			</nav>
		</header>
	<?php endif ?>
		<div id=maincontainer class=container>