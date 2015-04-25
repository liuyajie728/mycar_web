<?php
	// 设置导航URL http://developer.baidu.com/map/index.php?title=uri/api/web
	$marker_url = 'http://api.map.baidu.com/marker?location=' . $station['latitude'] . ',' . $station['longitude'] . '&title=' . $station['name'] . '&content=' . $station['address'] . '【哎油】优选商户&output=html&src=哎油'; // 可以在PC、移动设备浏览器上打开打开该链接显示地图上的点
?>
<div id=content>
	<section id=info>
		<figure><img alt="<?php echo $station['name'] ?>" src="<?php echo $station['image_url'] ?>"></figure>
		<h2><?php echo $station['name'] ?></h2>
		<p><?php echo $station['address'] ?></p>
	</section>
	<ul id=action>
		<li><a class="btn btn-default btn-block" href="tel:<?php echo $station['tel'] ?>"><?php echo $station['tel'] ?></a></li>
		<li><a class="btn btn-default btn-block" href="<?php echo $marker_url ?>"><?php echo $station['address'] ?></a></li>
		<li><a class="btn btn-primary btn-block" href="<?php echo base_url('order/create/consume/'.$station['station_id']) ?>">在此加油</a></li>
	</ul>
</div>