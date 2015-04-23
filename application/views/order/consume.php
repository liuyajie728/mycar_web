<div id=content>
<?php
	$attributes = array('class' => 'form-order-consume-create', 'role' => 'form');
	echo form_open(base_url('order/consume/create'), $attributes);
?>
		<fieldset>
			<label for=refuel_amount>加油/加气/充电金额</label>
			<input name=refuel_amount type=number step=0.01 min=0.01 required autofocus>
			<label for=shopping_amount>其它消费金额（洗车、维修、购物等）</label>
			<input name=shopping_amount type=number step=0.01 min=0.01>
			<input name=station_id type=hidden required>
		</fieldset>
		<button>确定</button>
	</form>
</div>