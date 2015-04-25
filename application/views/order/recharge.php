<div id=content>
<?php
	$attributes = array('class' => 'form-order-recharge-create', 'role' => 'form');
	echo form_open(base_url('order/create/recharge'), $attributes);
?>
		<fieldset>
			<label for=amount>充值金额（元）</label>
			<input class=form-control name=amount type=number step=100 min=100 required>
			<?php echo form_error('amount'); ?>
		</fieldset>
		<p id=balance_change>充值后最多获得 <span></span> 元余额。</p>
		<button class="btn btn-primary btn-block">确定</button>
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