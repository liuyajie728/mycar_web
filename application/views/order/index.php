<style>
#content>p{text-align:center;margin:20px auto;}
strong{color:#00a1d8;font-weight:bold;}
ul#order_info{background-color:#fff;margin:20px 0;border-top:1px solid #e8e8e8;border-bottom:1px solid #e8e8e8;}
	ul#order_info li{width:90%;margin:0 auto;height:80px;line-height:40px;border-bottom:1px solid #e8e8e8;}
		ul#order_info li:last-child{border-bottom:0;}
	ul#order_info li a{display:block;width:100%;height:100%;overflow:hidden;}
	ul#order_info li i{float:right;}
a.button{color:#fff;font-size:18px;background-color:#00a1d8;display:block;width:90%;margin:0 auto 20px;height:40px;line-height:40px;text-align:center;}
</style>
<div id=content>
<?php if(empty($orders)): ?>
	<p>还没有享受过哎油的优惠和服务哦。您可以：</p>
	<ol>
		<li><a class=button title="哎油账户充值" href="<?php echo base_url('order/create/recharge') ?>">去充值获得额外返利</a></li>
		<li><a class=button title="哎油首页" href="<?php echo base_url() ?>">去找附近加油站试一下</a></li>
	</ol>
<?php else: ?>
	<ul id=order_info class=list_info>
		<?php foreach ($orders as $order): ?>
		<li>
			<a href="<?php echo base_url('order/'.$type.'/'.$order['order_id']) ?>">
			订单号 <?php echo $order['order_id'] ?>
			<?php echo show_order_status($order['status']) ?>
			<br>
			金额 <?php echo $order['total'] ?>
			时间 <?php echo $order['time_create'] ?>
			</a>
		</li>
		<?php endforeach ?>
	</ul>
<?php endif ?>
</div>