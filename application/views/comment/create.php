<style>
#content{padding-top:20px;}
#content>p{text-align:center;}
</style>
<div id=content>
	<?php
		$attributes = array('class' => 'form-comment-create', 'role' => 'form');
		echo form_open(base_url('comment/create/'.$order_id), $attributes);
	?>
			<fieldset>
				<label for=rate_oil>能源质量</label>
				<select name=rate_oil required>
					<option value=100>非常满意</a>
					<option value=80>满意</a>
					<option value=60>一般</a>
					<option value=40>不满</a>
					<option value=20>非常不满</a>
				</select>
				<label for=rate_service>服务质量</label>
				<select name=rate_service required>
					<option value=100>非常满意</a>
					<option value=80>满意</a>
					<option value=60>一般</a>
					<option value=40>不满</a>
					<option value=20>非常不满</a>
				</select>
				<label for=content>评论内容</label>
				<textarea name=content rows=5 placeholder="最多100字"></textarea>
				<?php echo form_error('content'); ?>
				<input name=order_id type=hidden value=<?php echo $order_id ?> required>
			</fieldset>
			<button>确定</button>
		</form>
</div>