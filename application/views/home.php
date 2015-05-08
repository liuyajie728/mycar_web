<nav id=filter class="btn-group btn-group-justified" role=group>
	<div id=filter-position class=btn-group role=group>
		<button type=button class="btn btn-default dropdown-toggle" data-toggle=dropdown aria-expanded=false>位置<span class=caret></span></button>
	</div>
	<div id=filter-brand class=btn-group role=group>
	    <button type=button class="btn btn-default dropdown-toggle" data-toggle=dropdown aria-expanded=false>品牌<span class=caret></span></button>
	    <ul class=dropdown-menu role=menu>
		<?php foreach($station_brands as $brand): ?>
			<li data-brand_id=<?php echo $brand['brand_id'] ?>><?php echo $brand['name'] ?></li>
		<?php endforeach; ?>
	    </ul>
	</div>
	<div id=filter-sorter class=btn-group role=group>
		<button type=button class="btn btn-default dropdown-toggle" data-toggle=dropdown aria-expanded=false>排序方式<span class=caret></span></button>
	    <ul class=dropdown-menu role=menu>
			<li data-sort_type=0>默认</li>
	    </ul>
	</div>
</nav>
<ul id=stations class=list-group>
	<?php foreach($stations as $station): ?>
	<li class=list-group-item>
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
				scrollTop: $('#filter').offset().top
			}, 600);
			return false;
		});
	});
</script>