<div id=content>
<?php
	$attributes = array('class' => 'form-payment-create', 'role' => 'form');
	echo form_open(base_url('payment/create/'. $order_id), $attributes);
?>
		<fieldset>
			<select name=method class=form-control required>
				<option value=wechat selected>微信支付</option>
			</select>
			<input name=order_id type=hidden value=<?php echo $order_id ?> required>
		</fieldset>
		<button class="btn btn-default btn-block">确定</button>
	</form>
</div>