<nav id=filter class="btn-group btn-group-justified" role=group>
	<div id=filter-position class=btn-group role=group>
		<button type=button class="btn btn-default dropdown-toggle" data-toggle=dropdown aria-expanded=false>位置<span class=caret></span></button>
	    <ul class="dropdown-menu list-group" role=menu>
			<li data-sort_type=0 class=list-group-item>所有</li>
	    </ul>
	</div>
	<div id=filter-brand class=btn-group role=group>
	    <button type=button class="btn btn-default dropdown-toggle" data-toggle=dropdown aria-expanded=false>品牌<span class=caret></span></button>
	    <ul class=dropdown-menu role=menu>
			<li data-sort_type=0 class=list-group-item>所有</li>
			<!--
			<?php foreach($station_brands as $brand): ?>
			<li data-brand_id=<?php echo $brand['brand_id'] ?>><?php echo $brand['name'] ?></li>
			<?php endforeach ?>
			-->
	    </ul>
	</div>
	<div id=filter-sorter class=btn-group role=group>
		<button type=button class="btn btn-default dropdown-toggle" data-toggle=dropdown aria-expanded=false>排序方式<span class=caret></span></button>
	    <ul class=dropdown-menu role=menu>
			<li data-sort_type=0 class=list-group-item>距离</li>
	    </ul>
	</div>
</nav>
<ul id=stations class=list-group>
	<?php foreach($stations as $station): ?>
	<li class=list-group-item>
		<a title="<?php echo $station['name'] ?>" href="<?php echo base_url('station/'.$station['station_id']); ?>">
			<figure class=thumbnail><img alt="<?php echo $station['name'] ?>" src="<?php echo $station['image_url'] ?>"></figure>
			<h2><?php echo '#'.$station['station_id'].' '.$station['name'] ?></h2>
			<ul class=station_info>
				<li><?php echo $station['tel'] ?></li>
				<li><?php echo $station['city']. $station['district']. ' '. $station['address'] ?></li>
				<?php if(isset($station['distance'])): ?>
				<li><?php echo ($station['distance'] <= 1500)? $station['distance'].'米': round($station['distance']/1000).'公里'; ?></li>
				<?php endif ?>
			</ul>
		</a>
	</li>
	<?php endforeach; ?>
</ul>