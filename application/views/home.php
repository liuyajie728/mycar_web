<!--<ul id=filter class=horizontal>
	<li id=filter-position>
		<a href=#>位置</a>
	    <ul>
			<li data-sort_type=0>所有</li>
	    </ul>
	</li>
	<li id=filter-brand>
	    <a href=#>品牌</a>
	    <ul>
			<li data-sort_type=0>所有</li>
			<?php foreach($station_brands as $brand): ?>
			<li data-brand_id=<?php echo $brand['brand_id'] ?>><?php echo $brand['name'] ?></li>
			<?php endforeach ?>
	    </ul>
	</li>
	<li id=filter-sorter>
		<a href=#>排序方式</a>
	    <ul>
			<li data-sort_type=0>距离</li>
	    </ul>
	</li>
</ul>
-->
<ul id=stations>
	<?php foreach($stations as $station): ?>
	<li class=station>
		<a title="<?php echo $station['name'] ?>" href="<?php echo base_url('station/'.$station['station_id']); ?>">
			<figure class=station_img>
				<img alt="<?php echo $station['name'] ?>" src="<?php echo $station['image_url'] ?>">
			</figure>
			<div class=station_info>
				<h2><?php echo '#'.$station['station_id'].' '.$station['name'] ?></h2>
				<ul>
					<li>
						<?php
							echo $station['district']. ' '. $station['address'];
							if(isset($station['distance'])):
						?>
						<span class=distance><?php echo ($station['distance'] <= 1500)? $station['distance'].'米': round($station['distance']/1000).'公里'; ?></span>
						<?php endif ?>
					</li>
					<li><?php echo rate2star($station['rate_oil']); ?></li>
				</ul>
			</div>
		</a>
	</li>
	<?php endforeach; ?>
</ul>
<script>
	$(function(){
		$('#filter>li>a').click(function(){
			return false;
		})
	});
</script>