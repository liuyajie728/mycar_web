<div id=content>
<?php
	if(empty($order)):
		echo '未找到该订单。';
	else:
?>
	<ul id=detail>
		<li>订单编号 <?php echo $order['order_id'] ?></li>
		<li>订单状态 <?php echo $order['status'] ?></li>
		<!--订单状态；0待支付1已过期2已取消3已支付4已评论5已追加评论-->
		<?php if (isset($order['refuel_amount'])): // 如果是消费订单?>
		<li>消费站点 <?php echo $station['name'] ?></li>
		<li>加油口令 <?php echo $order['order_code'] ?></li>
		<li>加油/加气/充电金额 <?php echo $order['refuel_amount'] ?></li>
		<li>其它消费金额 <?php echo $order['shopping_amount'] ?></li>
		<li>小计 <?php echo $order['amount'] ?></li>
		<li>抵扣 <?php echo $order['deduction'] ?></li>
		<li>支付金额 <?php echo $order['total'] ?></li>
		<?php else: ?>
		<li>充值金额 <?php echo $order['amount'] ?></li>
		<li>支付金额 <?php echo $order['total'] ?></li>
		<?php endif ?>
		<li>创建时间 <?php echo $order['time_create'] ?></li>
		<?php if ($order['status'] >= 3): ?>
		<li>支付时间 <?php echo $order['time_payed'] ?></li>
		<?php endif ?>
	</ul>
	<?php
		if ($order['status'] == 0):
			$type = isset($order['refuel_amount'])? 'consume': 'recharge';
			$name = isset($order['refuel_amount'])? '消费订单': '余额充值';
			$payment_url = wepay_url('js_api_call.php?showwxpaytitle=1&type='. $type. '&total_fee='. $order['total']. '&order_id='. $order['order_id']. '&order_name=哎油-'.$name);
	?>
	<a href="<?php echo $payment_url ?>">付款</a>
	<?php elseif ($order['status'] == 3 && isset($order['refuel_amount'])): ?>
	<a href="<?php echo base_url('comment/create/'.$order['order_id']) ?>">去评价</a>
	<?php elseif ($order['status'] == 4 && isset($order['refuel_amount'])): ?>
	<a href="<?php echo base_url('comment/append/'.$order['order_id']) ?>">追加评价</a>
	<?php endif ?>
<?php endif ?>
</div>