<div id=content>
	<figure><img alt="<?php echo $station['name'] ?>" src="<?php echo $station['image_url'] ?>"></figure>
	<h2><?php echo $station['name'] ?></h2>
	<p><?php echo $station['address'] ?></p>
	<a class=tel href="tel:<?php echo $station['tel'] ?>"><?php echo $station['tel'] ?></a>
	<a class=route href="#"><?php echo $station['address'] ?></a>
</div>