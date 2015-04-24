<div id=content>
<?php
	if(empty($orders)):
		echo '<p>您还没有用哎油加过油，快去<a title="哎油首页" href="'. base_url() .'">最近的加油站</a>试一下吧！</p>';
	else:
		foreach ($orders as $order):
?>
	<ul id=orders>
		<li class=<?php $order['order_id'] ?>>订单ID <?php $order['order_id'] ?></li>
		<li class=<?php $order['time_create'] ?>>订单ID <?php $order['time_create'] ?></li>
	</ul>
<?php
		endforeach;
	endif;
?>
</div>