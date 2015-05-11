<div id=content>
<?php if(empty($orders)): ?>
	<blockquote>
		<p>还没有享受过哎油的优惠和服务哦。您可以：
	</blockquote>
	<ol>
		<li>去充值<a class="btn btn-primary" title="哎油账户充值" href="<?php echo base_url('order/create/recharge') ?>">获得每月额外返利</a></li>
		<li>去附近<a class="btn btn-default" title="哎油首页" href="<?php echo base_url() ?>">找加油站试一下</a></li>
	</ol>
<?php else: ?>
	<ul id=orders class=list-group>
		<?php foreach ($orders as $order): ?>
		<li class=list-group-item>
			订单号 <?php echo $order['order_id'] ?>
			金额 <?php echo $order['total'] ?>
			创建时间 <?php echo $order['time_create'] ?>
			支付时间 <?php echo $order['time_payed'] ?>
			<a class="btn btn-primary btn-block" href="<?php echo $type == 'consume'? base_url('order/'.$order['order_id']): base_url('order/recharge/'.$order['order_id']) ?>">查看详情</a>
		</li>
		<?php endforeach ?>
	</ul>
<?php endif ?>
</div>