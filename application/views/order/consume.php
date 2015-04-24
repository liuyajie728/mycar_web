<div id=content>
<?php
	$attributes = array('class' => 'form-order-consume-create', 'role' => 'form');
	echo form_open(base_url('order/create/consume'), $attributes);
?>
		<fieldset>
			<label for=refuel_amount>加油/加气/充电金额</label>
			<input class=form-control name=refuel_amount type=number step=0.01 min=0.01 autofocus required>
			<label for=shopping_amount>其它消费金额</label>
			<input class=form-control name=shopping_amount type=number step=0.01 min=0.00 value=0.00 placeholder="洗车、维修、购物等" required>
			<input name=station_id type=hidden value=<?php echo $station_id ?> required>
		</fieldset>
		<button class="btn btn-default">确定</button>
	</form>
</div>