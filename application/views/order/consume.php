<style>
	body.order{background-color:#f0f0f0;}
	button{background-color:#00a1d8;}
</style>
<div id=content>
	<section class="alert alert-warning" role=alert>
		<p>请确定您正在加油站现场。</p>
	</section>
<?php
	$attributes = array('class' => 'form-order-consume-create', 'role' => 'form');
	echo form_open(base_url('order/create/consume/'.$station_id), $attributes);
?>
		<fieldset>
			<label for=refuel_cost>加油/加气/充电金额</label>
			<input class=form-control name=refuel_amount type=number step=0.01 min=1.00 placeholder="最低1元" autofocus required>
			<?php echo form_error('refuel_amount'); ?>
			<label for=shopping_cost>其它消费金额</label>
			<input class=form-control name=shopping_amount type=number step=0.01 min=0.00 placeholder="洗车、维修、购物等" required>
			<?php echo form_error('shopping_amount'); ?>
			<input name=station_id type=hidden value=<?php echo $station_id ?> required>
		</fieldset>
		<button class="btn btn-primary btn-block">确定</button>
	</form>
</div>
<script>
$(function(){
	$('button').click(function(){
		var shopping_amount = $('input[name=shopping_amount]').val();
		if (shopping_amount == ''){
			shopping_amount = '0.00';
		}
		var refuel_amount = $('input[name=refuel_amount]').val();
		// 序列化字段值并提交到RESTful API
	});
});
</script>