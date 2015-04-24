<div id=content>
<?php
	$attributes = array('class' => 'form-payment-create', 'role' => 'form');
	echo form_open(base_url('payment/create'), $attributes);
?>
		<fieldset>
			<select name=method required>
				<option value=wechat selected>微信支付</option>
			</select>
		</fieldset>
		<button class="btn btn-default">确定</button>
	</form>
</div>