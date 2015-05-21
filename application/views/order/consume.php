<style>
#content{padding-top:20px;}
#content>p{text-align:center;}
</style>
<div id=content>
	<p>“哎油”目前处于测试阶段，所有订单均为测试订单，实际支付的金额都将原路退款，敬请安心测试。</p>
	<p>请确定您正在加油站现场。</p>
<?php
	$attributes = array('class' => 'form-order-consume', 'role' => 'form');
	echo form_open(base_url('order/create/consume/'.$station_id), $attributes);
?>
		<fieldset>
			<label for=refuel_cost>加油/加气/充电金额</label>
			<input name=refuel_amount type=number step=0.01 min=1.00 placeholder="最低1元" autofocus required>
			<?php echo form_error('refuel_amount'); ?>
			<label for=shopping_cost>其它消费金额</label>
			<input name=shopping_amount type=number step=0.01 min=0.00 placeholder="洗车、维修、购物等">
			<?php echo form_error('shopping_amount'); ?>
			<input name=station_id type=hidden value=<?php echo $station_id ?> required>
		</fieldset>
		<button>确定</button>
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
		// 未完成 序列化字段值并提交到RESTful API
	});
});
</script>