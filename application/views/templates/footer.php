		</div>
		<footer id=footer>
			<div class=container>
				<p>&copy;<?php echo date('Y'); ?> <a title="<?php echo $title; ?>" href="<?php echo base_url(); ?>"><?php echo $title; ?></a></p>
			</div>
		</footer>
		<script>
			// 隐藏微信底部导航栏
			document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
				WeixinJSBridge.call('hideToolbar');
			});
			
			$(function(){
				//表格可排序
				$('.sortable').tablesorter();

				// 回到页首按钮
				$('a#tostations').click(function(){
					$('body,html').stop(false, false).animate({
						scrollTop: $('#stations').offset().top
					}, 800);
					return false;
				});
			});
		</script>
	</body>
<!-- 内容结束 -->
</html>