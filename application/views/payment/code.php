<div id=content>
	<p><?php echo $payment_code; ?></p>
	<div id=barcode></div>
	<div id=qrcode></div>
</div>
<script src="http://cdn.key2all.com/js/jquery/jquery.qrcode.js"></script>
<script>
	$(function(){
		// 生成付款码二维码
		$('#qrcode').qrcode('<?php echo $payment_code; ?>');
	});
</script>