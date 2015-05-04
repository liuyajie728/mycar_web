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
		<li class=list-group-item>创建时间 <?php echo $order['time_create'] ?></li>
		<li class=list-group-item>支付时间 <?php echo $order['time_payed'] ?></li>
	</ul>
	<?php if ($order['status'] == 0): ?><a class="btn btn-primary btn-block" href="<?php echo base_url('payment/create/'. $order['order_id']) ?>">付款</a><?php endif ?>
<?php
	endif;
?>
</div>