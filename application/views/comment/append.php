<div id=content>
	<?php
		$attributes = array('class' => 'form-comment-append', 'role' => 'form');
		echo form_open(base_url('comment/append/'.$comment_id), $attributes);
	?>
			<fieldset>
				<label for=append>追加评论内容</label>
				<textarea name=append row=5 required></textarea>
				<?php echo form_error('append'); ?>
				<input name=comment_id type=hidden value=<?php echo $comment_id ?> required>
			</fieldset>
			<button>确定</button>
		</form>
</div>