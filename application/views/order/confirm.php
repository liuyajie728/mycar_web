<div id=content>
	<h2>订单号 <?php echo $order['order_id'] ?></h2>
	<p>创建时间 <?php echo $order['time_create'] ?></p>
	<p>付款时间 <?php echo $order['time_payed'] ?></p>
	<p>用户ID <?php echo $order['user_id'] ?></p>
	<p>状态 <?php echo $order['status'] ?></p>
	<?php if ($order['status'] >= 3 && $order['type'] == 'consume'): ?>
	<p>加油口令 <?php echo $order['order_code'] ?></p>
	<?php endif ?>
</div>