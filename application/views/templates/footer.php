		</div>
		<?php
			// 拆分载入视图时传入的$class变量为数组，并检查数组中内容决定是否需要显示页面尾部导航
			$class_array = explode(' ', $class);
			$no_footer = array('user-login');
			if (empty(array_intersect($class_array, $no_footer))):
		?>
		<footer id=footer>
			<div class=container>
				<nav id=nav-footer>
					<a title="哎油首页" href="/home">首页</a>
					<a title="哎油充值" href="/product">充值</a>
					<a title="我的哎油账户" href="/user">我</a>
				</nav>
				<!--<p>&copy;<?php echo date('Y'); ?> <a title="<?php echo $title; ?>" href="<?php echo base_url(); ?>"><?php echo $title; ?></a></p>-->
			</div>
		</footer>
		<?php endif; ?>
		<script>
			// 隐藏微信底部导航栏
			document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
				WeixinJSBridge.call('hideToolbar');
			});
			
			$(function(){
				//表格可排序
				$('.sortable').tablesorter();
			});
		</script>
	</body>
<!-- 内容结束 -->
</html>