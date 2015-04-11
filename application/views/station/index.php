<div id=content>
	<ul id=list_station>
	<?php foreach ($stations as $station){ ?>
		<li class=item_station>
			<figure><img alt="<?php echo $station['name'] ?>" src="<?php echo $station['image_url'] ?>"></figure>
			<h2><?php echo $station['name'] ?></h2>
			<p><?php echo $station['address'] ?></p>
		</li>
	<?php } ?>
	</ul>
</div>