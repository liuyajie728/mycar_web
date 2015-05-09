<style>
	body.order{background-color:#f0f0f0;}
	button{background-color:#00a1d8;}
</style>
<div id=content>
<?php
	if(empty($order)):
		echo '未找到该订单。';
	else:
?>
	<ul id=detail class=list-group>
		<li class=list-group-item>订单ID <?php echo $order['order_id'] ?></li>
		<?php if (isset($order['refuel_amount'])): // 如果是消费订单?>
		<li class=list-group-item>加油站名称 <?php echo $station['name'] ?></li>
		<li class=list-group-item>加油/加气/充电金额 <?php echo $order['refuel_amount'] ?></li>
		<li class=list-group-item>其它消费金额 <?php echo $order['shopping_amount'] ?></li>
		<li class=list-group-item>小计 <?php echo $order['amount'] ?></li>
		<li class=list-group-item>抵扣 <?php echo $order['deduction'] ?></li>
		<li class=list-group-item>支付金额 <?php echo $order['total'] ?></li>
		<?php else: ?>
		<li class=list-group-item>充值金额 <?php echo $order['amount'] ?></li>
		<li class=list-group-item>支付金额 <?php echo $order['total'] ?></li>
		<?php endif ?>
		<li class=list-group-item>创建时间 <?php echo $order['time_create'] ?></li>
		<?php if ($order['status'] == 3): ?>
		<li class=list-group-item>支付时间 <?php echo $order['time_payed'] ?></li>
		<?php endif ?>
		<li class=list-group-item>状态 <?php echo $order['status'] ?></li>
		<!--订单状态；0待支付1已过期2已取消3已支付4已评论5已追加评论-->
	</ul>
	<?php
		if ($order['status'] == 0):
			$type = isset($order['refuel_amount'])? 'consume': 'recharge';
			$name = isset($order['refuel_amount'])? '消费订单': '余额充值';
			$payment_url = wepay_url('js_api_call.php?showwxpaytitle=1&type='. $type. '&total_fee='. $order['total']. '&order_id='. $order['order_id']. '&order_name=哎油-'.$name);
	?>
	<a class="btn btn-primary btn-block" href="<?php echo $payment_url ?>">付款</a>
	<?php endif ?>
<?php endif ?>
</div>