<style>
#content{padding-top:20px;}
	#content p{text-align:center;}
ul#orders{background-color:#fff;margin:20px 0;border-top:1px solid #e8e8e8;border-bottom:1px solid #e8e8e8;}
	ul#orders li{width:90%;margin:0 auto;height:40px;line-height:40px;border-bottom:1px solid #e8e8e8;}
		ul#orders li:last-child{border-bottom:0;}
	ul#orders li a{display:block;width:100%;height:100%;overflow:hidden;}
	ul#orders li i{text-align:right;}
a.button{color:#fff;font-size:18px;background-color:#00a1d8;display:block;width:90%;margin:0 auto;height:40px;line-height:40px;text-align:center;}
a.button-danger{background-color:firebrick;}
</style>
<div id=content>
	<?php if ($me['nickname'] === NULL): ?>
	<p>Hi, <?php echo $me['mobile'] ?></p>
	<?php else: ?>
	<p>Hi, <?php echo $me['nickname'] ?></p>
	<?php endif ?>
	<ul id=orders>
		<li><a title="余额 &amp; 充值记录" href="<?php echo base_url('order/recharge') ?>">余额 &amp; 充值记录 <i class="fa fa-chevron-right"></i></a></li>
		<li><a title="消费订单" href="<?php echo base_url('order') ?>">消费订单 <i class="fa fa-chevron-right"></i></a></li>
	</ul>
	<a class="button button-danger" title="退出账户" href="<?php echo base_url('logout') ?>">退出账户</a>
</div>