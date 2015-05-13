<?php
	// 设置导航URL http://developer.baidu.com/map/index.php?title=uri/api/web
	$marker_url = 'http://api.map.baidu.com/marker?location=' . $station['latitude'] . ',' . $station['longitude'] . '&title=' . $station['name'] . '&content=【哎油优选】' . $station['address'] . '&output=html&src=哎油'; // 可以在PC、移动设备浏览器上打开打开该链接显示地图上的点
?>
<style>
#station_info{position:relative;}
	#station_info div{color:#fff;background-color:#000;background-color:rgba(0,0,0,0.65);padding:0.18rem 0.5rem;width:100%;position:absolute;left:0;bottom:0;}
		#station_info div h2{font-size:larger;}
			#station_info div h2 span{font-weight:normal;}

#actions{margin-top:14px;}
	#actions li{background-color:#fff;width:30%;}
		#actions li a{height:3rem;line-height:3rem;}
		#actions li i{color:#c7c7c7;}
	#actions li.refuel{background-color:#0ab1ff;width:40%;}
		#actions li.refuel a,#actions li.refuel i{color:#fff;}
</style>
<div id=content>
	<section id=station_info>
		<img alt="<?php echo $station['name'] ?>" src="<?php echo $station['image_url'] ?>">
		<div>
			<h2><?php echo $station['name'] ?> <span id=rate><?php echo rate2star($station['rate_oil']); ?></span></h2>
			<p><?php echo $station['city']. $station['district']. ' '. $station['address'] ?></p>
		</div>
	</section>
	<ul id=actions class=horizontal>
		<li><a href="tel:<?php echo $station['tel'] ?>"><i class="fa fa-phone"></i> 服务电话</a></li>
		<li><a href="<?php echo $marker_url ?>"><i class="fa fa-map-marker"></i> 地图导航</a></li>
		<li class=refuel><a href="<?php echo base_url('order/create/consume/'.$station['station_id']) ?>"><i class="fa fa-crosshairs"></i> 在此加油</a></li>
	</ul>
</div>