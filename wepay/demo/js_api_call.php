<?php
/**
 * JS_API支付demo
 * ====================================================
 * 在微信浏览器里面打开H5网页中执行JS调起支付。接口输入输出数据格式为JSON。
 * 成功调起支付需要三个步骤：
 * 步骤1：网页授权获取用户openid
 * 步骤2：使用统一支付接口，获取prepay_id
 * 步骤3：使用jsapi调起支付
*/
	$total_fee = $_GET['total_fee'];
	include_once('../WxPayPubHelper/WxPayPubHelper.php');

	//使用jsapi接口
	$jsApi = new JsApi_pub();

	//=========步骤1：网页授权获取用户openid============
	//通过code获得openid
	if (!isset($_GET['code']))
	{
		//触发微信返回code码
		$url = $jsApi->createOauthUrlForCode(WxPayConf_pub::JS_API_CALL_URL. '?total_fee='. $total_fee);
		//$url = $jsApi->createOauthUrlForCode(WxPayConf_pub::JS_API_CALL_URL. '?order_id='. $order_id);
		Header("Location: $url"); 
	}
	else
	{
		//获取code码，以获取openid
	    $code = $_GET['code'];
		$jsApi->setCode($code);
		$openid = $jsApi->getOpenId();
	}

	//=========步骤2：使用统一支付接口，获取prepay_id============
	//使用统一支付接口
	$unifiedOrder = new UnifiedOrder_pub();
	//设置统一支付接口参数
	//设置必填参数
	//appid、mch_id、noncestr、spbill_create_ip、sign已填,商户无需重复填写
	$unifiedOrder->setParameter('openid', $openid); // 步骤1中获取到的openid
	$unifiedOrder->setParameter('body', '贡献一分钱'); //商品描述
	//自定义订单号，此处仅作举例
	$out_trade_no = WxPayConf_pub::APPID.time();
	$unifiedOrder->setParameter('out_trade_no', $out_trade_no); //商户订单号
	$unifiedOrder->setParameter('total_fee', $total_fee * 100); //总金额，数字单位为分
	$unifiedOrder->setParameter('notify_url', WxPayConf_pub::NOTIFY_URL); //通知地址
	$unifiedOrder->setParameter('trade_type', 'JSAPI'); //交易类型
	//非必填参数，商户可根据实际情况选填
	//$unifiedOrder->setParameter("attach","XXXX");//附加数据
	//$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
	//$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间

	$prepay_id = $unifiedOrder->getPrepayId();

	//=========步骤3：使用jsapi调起支付============
	$jsApi->setPrepayId($prepay_id);
	$jsApiParameters = $jsApi->getParameters();
?>
<!doctype html>
<html lang=zh-cn>
	<head>
		<meta charset=utf-8>
		<meta http-equiv=x-dns-prefetch-control content=on>
		<link rel=dns-prefetch href="http://cdn.key2all.com">
		<link rel=dns-prefetch href="http://images.key2all.com">
	    <title>哎油 - 微信安全支付</title>
		<meta name=robots content="noindex, nofollow">
		<meta name=description content="哎油">
		<meta name=keywords content="哎油">
		<meta name=version content="revision20150506">
		<meta name=author content="刘亚杰">
		<meta name=copyright content="刘亚杰, 森思壮SenseStrong, 青岛我的车信息技术有限公司, 哎油">
		<meta name=contact content="liuyaji@sensestrong.com, http://weibo.com/sensestrong">
		<meta name=viewport content="width=device-width">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!--[if (lt IE 9) & (!IEMobile)]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
			<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<![endif]-->
		
		<link rel=stylesheet media=all href="http://cdn.key2all.com/css/reset.css">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<!--<link rel=stylesheet media=all href="http://www.jiayoucar.com/web/css/style.css">-->
		
		<link rel="shortcut icon" href="http://images.key2all.com/logo/brand/6_32.png">
		<link rel="apple-touch-icon" href="http://images.key2all.com/logo/brand/6_120.png">

		<meta name=format-detection content="telephone=yes, email=no, address=no">

		<!-- 苹果设备优化 -->
		<meta name=apple-mobile-web-app-capable content=yes>
		<meta name=apple-mobile-web-app-status-bar-style content=black-translucent>
		<script>
			//调用微信JS api 支付
			function jsApiCall()
			{
				WeixinJSBridge.invoke(
					'getBrandWCPayRequest',
					<?php echo $jsApiParameters ?>,
					function(res)
					{
						if (res.err_msg == "get_brand_wcpay_request:ok"){
							alert('支付成功！');
							//location.href = 'http://www.jiayoucar.com/web/order/comment/<?php //echo $order_id ?>';
						}
						else if (res.err_msg == "get_brand_wcpay_request:cancel")
						{
							alert('用户取消支付！');
							//location.href = 'http://www.jiayoucar.com/web/payment/process/<?php //echo $order_id ?>';
						}
						else
						{
							alert('支付失败！');
							//location.href = 'http://www.jiayoucar.com/web/payment/process/<?php //echo $order_id ?>';
						}
					}
				);
			}

			function callpay()
			{
				if (typeof WeixinJSBridge == 'undefined'){
				    if( document.addEventListener ){
				        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
				    }else if (document.attachEvent){
				        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
				        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
				    }
				}else{
				    jsApiCall();
				}
			}
		</script>
	</head>
<?php
	//将head内容立即输出，让用户浏览器立即开始请求head中各项资源，提高页面加载速度
	ob_flush();flush();
?>
	<body class=payment>
		<div id=maincontainer class=container-fluid>
			<p>订单号 <?php echo $order_id ?></p>
			<p>自动订单号 <?php echo $out_trade_no ?></p>
			<p>支付金额 <?php echo $total_fee ?></p>
			<button class="btn" onclick="callpay()">确定</button>
		</div>
		<footer id=footer class="navbar navbar-default navbar-fixed-bottom">
			<div class=container-fluid>
				<nav id=nav-footer class="nav navbar-nav">
					<?php $base_url = 'http://www.jiayoucar.com/web/' ?>
					<a title="哎油首页" href="<?php echo $base_url ?>">首页</a>
					<a title="哎油账户充值" href="<?php echo $base_url.'order/create/recharge' ?>">充值</a>
					<a title="我的哎油账户" href="<?php echo $base_url.'user' ?>">我</a>
				</nav>
				<!--<p>&copy;<?php echo date('Y'); ?> <a title="<?php echo $title; ?>" href="<?php echo base_url(); ?>"><?php echo $title; ?></a> 鲁ICP备15013080号</p>-->
			</div>
		</footer>
	</body>
<!-- 内容结束 -->
</html>
<?php //include_once('../../application/views/templates/footer.php') ?>