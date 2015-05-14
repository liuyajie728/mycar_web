<div id=content>
	<?php if ($me['nickname'] === NULL): ?>
	<p>Hi, <?php echo $me['mobile'] ?></p>
	<?php else: ?>
	<ul>
		<li><?php echo $me['nickname'] ?></li>
		<li><?php echo $me['mobile'] ?></li>
	</ul>
	<?php endif; ?>
	<ul class=orders class=list-group>
		<li class=list-group-item><a title="余额 &amp; 充值记录" href="<?php echo base_url('order/recharge') ?>">余额 &amp; 充值记录 <i class="fa fa-chevron-right"></i></a></li>
		<li class=list-group-item><a title="消费订单" href="<?php echo base_url('order') ?>">消费订单 <i class="fa fa-chevron-right"></i></a></li>
	</ul>
</div>
<a class="btn btn-block btn-danger" title="退出账户" href="<?php echo base_url('logout') ?>">退出账户</a>