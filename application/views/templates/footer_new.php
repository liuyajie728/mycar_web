		</div>
		<?php
			// 拆分载入视图时传入的$class变量为数组，并检查数组中内容决定是否需要显示页面尾部导航
			$class_array = explode(' ', $class);
			$has_footer = array('home', 'user-index', 'order-recharge');
			if (!empty(array_intersect($class_array, $has_footer))):
		?>
		<footer id=footer>
			<nav id=nav-footer class=container>
				<ul>
					<li><a title="哎油首页" href="<?php echo base_url() ?>" class="col-xs-4 text-center">首页</a></li>
					<li><a title="哎油账户充值" href="<?php echo base_url('order/create/recharge') ?>" class="col-xs-4 text-center">充值</a></li>
					<li><a title="我的哎油账户" href="<?php echo base_url('user') ?>" class="col-xs-4 text-center">我</a></li>
				</ul>
			</nav>
			<!--<p>&copy;<?php echo date('Y'); ?> <a title="<?php echo $title; ?>" href="<?php echo base_url(); ?>"><?php echo $title; ?></a> 鲁ICP备15013080号</p>-->
		</footer>
		<?php endif; ?>
		<script>
			// 隐藏微信底部导航栏
			document.addEventListener('WeixinJSBridgeReady', function onBridgeReady(){
				WeixinJSBridge.call('hideToolbar');
			});
			
			$(function(){
			});
		</script>
	</body>
<!-- 内容结束 -->
</html>