<nav id=quick>
	<li>
		<a id=tostations title="寻找加油站" href="#stations">
			<figure><img alt="寻找加油站" src=""></figure>
			<p>找油站</p>
		</a>
	</li>
	<li>
		<a title="显示付款码" href="/payment/code">
			<figure><img alt="显示付款码" src=""></figure>
			<p>付款码</p>
		</a>
	</li>
</nav>
<nav id=filter>
	<ul id=filter-position>
		位置筛选器
	</ul>
	<ul id=filter-brand>
		<?php foreach($station_brands as $brand): ?>
			<li data-brand_id=<?php echo $brand['brand_id'] ?>><?php echo $brand['name'] ?></li>
		<?php endforeach; ?>
	</ul>
	<ul id=filter-sorter>
		排序方式
	</ul>
</nav>
<ul id=stations>
	<?php foreach($stations as $station): ?>
	<li class=single>
		<a title="<?php echo $station['name'] ?>" href="<?php echo base_url('station/'.$station['station_id']); ?>">
			<figure><img alt="<?php echo $station['name'] ?>" src="<?php echo $station['image_url'] ?>"></figure>
			<h2><?php echo $station['name'] ?></h2>
		</a>
	</li>
	<?php endforeach; ?>
</ul>
<script>
	$(function(){
		// 滑动到油站列表
		$('a#tostations').click(function(){
			$('body,html').stop(false, false).animate({
				scrollTop: $('#stations').offset().top
			}, 800);
			return false;
		});
	});
</script>