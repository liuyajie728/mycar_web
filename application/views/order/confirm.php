<?php var_dump('order') ?>
<div id=content>
	<h2>订单号 <?php echo $order['order_id'] ?></h2>
	<p>用户ID <?php echo $order['user_id'] ?></p>
	<p>状态 <?php echo $order['status']; ?></p>
	<p>创建时间 <?php echo $order['time_create']; ?></p>
</div>