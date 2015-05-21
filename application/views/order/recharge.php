<style>
#content{padding-top:20px;}
#content>p{text-align:center;}
</style>
<div id=content>
	<p>“哎油”目前处于测试阶段，所有订单均为测试订单，实际支付的金额都将原路退款，敬请安心测试。</p>
<?php
	$attributes = array('class' => 'form-order-recharge-create', 'role' => 'form');
	echo form_open(base_url('order/create/recharge'), $attributes);
?>
		<fieldset>
			<label for=amount>充值金额（元）</label>
			<input name=amount type=number step=100 min=1 required>
			<?php echo form_error('amount'); ?>
		</fieldset>
		<p id=balance_change>充值后最多获得 <span></span> 元余额。</p>
		<button>确定</button>
	</form>
</div>
<script>
$(function(){
	$('[name=amount]').keyup(function(){
		var amount = $(this).val();
		$('#balance_change>span').html(amount * 1.1);
	});
});
</script>