<div id=content>
	<section class="alert alert-warning" role=alert>
		<p>请确定您正在加油站现场进行加油。</p>
	</section>
<?php
	$attributes = array('class' => 'form-order-consume-create', 'role' => 'form');
	echo form_open(base_url('order/create/consume'), $attributes);
?>
		<fieldset>
			<label for=refuel_cost>加油/加气/充电金额</label>
			<input class=form-control name=refuel_cost type=number step=0.01 min=0.01 autofocus required>
			<?php echo form_error('refuel_cost'); ?>
			<label for=shopping_cost>其它消费金额</label>
			<input class=form-control name=shopping_cost type=number step=0.01 min=0.00 value=0.00 placeholder="洗车、维修、购物等" required>
			<?php echo form_error('shopping_cost'); ?>
			<input name=station_id type=hidden value=<?php echo $station_id ?> required>
		</fieldset>
		<button class="btn btn-primary btn-block">确定</button>
	</form>
</div>