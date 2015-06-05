<?php
	// 设置导航URL http://developer.baidu.com/map/index.php?title=uri/api/web
	$marker_url = 'http://api.map.baidu.com/marker?location=' . $station['latitude'] . ',' . $station['longitude'] . '&title=' . $station['name'] . '&content=【哎油优选】' . $station['address'] . '&output=html&src=哎油'; // 可以在PC、移动设备浏览器上打开打开该链接显示地图上的点
?>
<style>
#station_info{position:relative;}
	#station_info div{color:#fff;background-color:#000;background-color:rgba(0,0,0,0.65);padding:0.18rem 0.5rem;width:100%;position:absolute;left:0;bottom:0;}
		#station_info div h2{font-size:larger;}

#actions{}
	#actions li{background-color:#fff;width:30%;}
		#actions li a{height:3rem;line-height:3rem;}
		#actions li i{color:#c7c7c7;}
	#actions li.refuel{background-color:#0ab1ff;width:40%;}
		#actions li.refuel a,#actions li.refuel i{color:#fff;}

#rates{background-color:#fff;margin:0 auto 10px;}

#comments{background-color:#fff;margin-top:30px;}
	#comments h2{font-size:14px;font-weight:normal;border-bottom:1px solid #e8e8e8;height:40px;line-height:40px;margin:0 auto;width:90%;}
	#comment_list{margin:0 auto;width:90%;}
		.comment_item{padding:5px 0;border-bottom:1px solid #e8e8e8;line-height:20px;overflow:hidden;}
			.comment_user{width:20%;min-width:60px;float:left;display:inline;}
				.comment_user img{width:60px;height:60px;}
			.comment_content{width:76%;float:right;display:inline;}
	
	#flirting{text-align:center;height:40px;line-height:40px;}
		#flirting span{font-size:smaller;}
</style>
<div id=content>
	<section id=station_info>
		<img alt="<?php echo $station['name'] ?>" src="<?php echo $station['image_url'] ?>">
		<div>
			<h2><?php echo $station['name'] ?></h2>
			<p><?php echo $station['district']. ' '. $station['address'] ?></p>
		</div>
	</section>
	<ul id=rates class=list_info>
		<li>质量评价<span><?php echo rate2star($station['rate_oil']) ?></span></li>
		<li>服务评价<span><?php echo rate2star($station['rate_service']) ?></span></li>
	</ul>
	<ul id=actions class=horizontal>
		<li><a href="tel:<?php echo $station['tel'] ?>"><i class="fa fa-phone"></i> 服务电话</a></li>
		<li><a href="<?php echo $marker_url ?>"><i class="fa fa-map-marker"></i> 地图导航</a></li>
		<li class=refuel><a href="<?php echo base_url('order/create/consume/'.$station['station_id']) ?>"><i class="fa fa-crosshairs"></i> 在此加油</a></li>
	</ul>
	<div id=comments>
		<h2>车友点评</h2>
		<?php if (empty($comments)): ?>
		<p id=flirting>人家的第一次<span> 评论 </span>等你哦！</p>
		<?php else: ?>
		<ul id=comment_list>
			<?php foreach($comments as $comment_item): ?>
			<li class=comment_item>
				<figure class=comment_user>
					<img alt="<?php echo $comment_item['user_nickname'] ?>" src="<?php echo !empty($comment_item['user_logo_url'])? $comment_item['user_logo_url']: base_url('images/default_user.png'); ?>">
				</figure>
				<div class=comment_content>
					<p><?php echo rate2star($comment_item['rate_oil']) ?></p>
					<p><?php echo !empty($comment_item['content'])? $comment_item['content']: '该用户只进行了评分，未写评价。'; ?></p>
					<?php if (!empty($comment_item['append'])): ?>
					<p>追加评价：<?php echo $comment_item['append'] ?></p>
					<?php endif ?>
				</div>
			</li>
			<?php endforeach ?>
		</ul>
		<?php endif ?>
	</div>
</div>