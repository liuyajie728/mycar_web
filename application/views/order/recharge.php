<div id=content>
<?php
	$attributes = array('class' => 'form-order-recharge-create', 'role' => 'form');
	echo form_open(base_url('order/recharge/create'), $attributes);
?>
		<fieldset>
			<input name=amount type=hidden required>
		</fieldset>
		<button>确定</button>
	</form>
</div>