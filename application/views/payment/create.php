<div id=content>
<?php
	$attributes = array('class' => 'form-payment-create', 'role' => 'form');
	echo form_open(base_url('payment/create/'. $order_id), $attributes);
?>
		<fieldset>
			<select name=method class=form-control required>
				<option value=wechat selected>微信支付</option>
				<option value=balance>余额支付</option>
			</select>
			<input name=order_id type=hidden value=<?php echo $order_id ?> required>
		</fieldset>
		<button id=pay class="btn btn-default btn-block">确定</button>
	</form>
</div>
<script>
$(function(){
	$('button#pay').click(function(){
		var method = $('[name=method]').val();
		if (method == 'wechat')
		{
			location.href = '<?php echo base_url('wechat/demo/js_api_call.php?total_fee='. $order_id) ?>';
		}
		else
		{
			alert(method);
		}
		return false;
	});
});
</script>