<div id=content>
<?php
	$attributes = array('class' => 'form-order-recharge-create', 'role' => 'form');
	echo form_open(base_url('order/create/recharge'), $attributes);
?>
		<fieldset>
			<label for=amount>充值金额（元）</label>
			<input class=form-control name=amount type=number step=200 min=200 required>
		</fieldset>
		<p id=balance_change>充值后余额增加 <span></span> 元</p>
		<button class="btn btn-default">确定</button>
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