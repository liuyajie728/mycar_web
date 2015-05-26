<style>
strong{color:#00a1d8;font-weight:bold;}
ul.list_info{background-color:#fff;margin:20px 0;border-top:1px solid #e8e8e8;border-bottom:1px solid #e8e8e8;}
	ul.list_info li{width:90%;margin:0 auto;height:40px;line-height:40px;border-bottom:1px solid #e8e8e8;}
		ul.list_info li:last-child{border-bottom:0;}
	ul.list_info li span{float:right;}
a.button{color:#fff;font-size:18px;background-color:#00a1d8;display:block;width:90%;margin:0 auto;height:40px;line-height:40px;text-align:center;}
</style>
<div id=content>
	<p>“哎油”目前处于测试阶段，所有订单均为测试订单，不可作为消费或预付款凭证，敬请安心测试。</p>
<?php
	if(empty($order)):
		echo '未找到该订单。';
	else:
?>
	<ul id=order_info class=list_info>
		<li>订单编号 <span><?php echo $order['order_id'] ?></span></li>
		<li>创建时间 <span><?php echo $order['time_create'] ?></span></li>
		<li>订单状态 <span><strong><?php echo show_order_status($order['status']) ?></strong></span></li>
		<?php if ($order['status'] >= 3): ?>
		<li>支付方式 <span><?php echo show_payment_type($order['payment_type']) ?></span></li>
		<li>支付时间 <span><?php echo $order['time_payed'] ?></span></li>
		<?php endif ?>
		<?php if (isset($order['refuel_amount'])): // 如果是消费订单?>
		<li>消费地点 <span><?php echo $order['station_name'] ?></span></li>
		<li>加油口令 <span><strong><?php echo $order['order_code'] ?></strong></span></li>
		<li>加油/加气/充电金额 <span><strong><?php echo $order['refuel_amount'] ?> 元</strong></span></li>
		<li>其它消费金额 <span><strong><?php echo $order['shopping_amount'] ?>  元</strong></span></li>
		<li>小计 <span><?php echo $order['amount'] ?> 元</span></li>
		<li>抵扣 <span>- <?php echo $order['deduction'] ?> 元</span></li>
		<?php else: ?>
		<li>充值金额 <span><strong><?php echo $order['amount'] ?> 元</strong></span></li>
		<?php endif ?>
		<li>支付金额 <span><?php echo $order['total'] ?> 元</span></li>
	</ul>
<?php endif ?>

<?php if(!empty($comment)): ?>
	<ul id=comment class=list_info>
		<li>服务评分 <?php echo $comment['rate_service'] ?></li>
		<li>质量评分 <?php echo $comment['rate_oil'] ?></li>
		<li>评价内容 <?php echo isset($comment['content'])? $comment['content']: '该用户只进行了评分，未写评价。'; ?></li>
		<?php if (!empty($comment['append'])): ?>
		<li>追加评价 <?php echo $comment['append'] ?></li>
		<?php endif ?>
	</ul>
<?php endif ?>

<?php
	if ($order['status'] == 0):
		$type = isset($order['refuel_amount'])? 'consume': 'recharge';
		$name = isset($order['refuel_amount'])? '消费订单': '余额充值';
		$payment_url = wepay_url('js_api_call.php?showwxpaytitle=1&type='. $type. '&total_fee='. $order['total']. '&order_id='. $order['order_id']. '&order_name=哎油-'.$name);
?>
<a class=button href="<?php echo $payment_url ?>">付款</a>
<?php elseif ($order['status'] == 3 && isset($order['refuel_amount'])): ?>
<a class=button href="<?php echo base_url('comment/create/'.$order['order_id']) ?>">评价</a>
<?php elseif ($order['status'] == 4 && isset($order['refuel_amount'])): ?>
<a class=button href="<?php echo base_url('comment/append/'.$comment['comment_id']) ?>">追加评价</a>
<?php endif ?>
</div>