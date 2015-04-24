<div id=content>
<?php
	if(empty($order)):
		echo '未找到该订单。';
	else:
?>
	<ul id=orders>
		<li class=<?php $order['order_id'] ?>>订单ID <?php $order['order_id'] ?></li>
		<li class=<?php $order['time_create'] ?>>订单ID <?php $order['time_create'] ?></li>
	</ul>
<?php
	endif;
?>
</div>