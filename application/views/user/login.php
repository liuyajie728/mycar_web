<div id=content>
	<h2>您的手机号是？</h2>
	<p>填写手机号，成为哎油会员</p>
<?php
	if(isset($error)){echo $error;}
	$attributes = array('class' => 'form-login form-horizontal', 'role' => 'form');
	echo form_open(base_url('login'), $attributes);
?>
		<fieldset>
			<div class="form-group">
				<div class="col-sm-10">
					<input class=form-control name=mobile type=tel value="<?php echo set_value('mobile'); ?>" placeholder="手机号" required autofocus>
					<a id=sms_send class="btn btn-primary" href="#">验证</a>
					<?php echo form_error('mobile'); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-10">
					<input class=form-control name=captcha type=number step=1 value="<?php echo set_value('captcha'); ?>" placeholder="验证码" required disabled>
					<?php echo form_error('captcha'); ?>
				</div>
			</div>
		</fieldset>
		<button id=login class="btn btn-primary" disabled>开始</button>
	</form>
	<script>
		$(function(){
			$('#sms_send').click(function(){
				// 获取mobile字段值，验证该字段是否已被输入11位数字，设置sms_send按钮为不可用状态
				var mobile = $('[name=mobile]').val();
				var type = 1; // 注册/登陆短信类型为1
				var params = {'mobile':mobile, 'type':type};
				$('a#sms_send').text('重新发送').attr('disabled');

				// 尝试发送短信并获取发送状态
				$.getJSON('/sms/send', params, function(data){
					if (data.status == 200) // 若成功，激活并将焦点移到captcha字段
					{
						$('[name=captcha]').removeAttr('disabled').focus();
						$.cookie('sms_id', data.sms_id);
					}
					else // 若失败，激活sms_send按钮
					{
						$('#sms_send').text('验证').removeAttr('disabled');
					}
				});
				return false;
			});
			
			$('[name=captcha]').keyup(function(){
				var captcha = $('[name=captcha]').val();
				if (captcha.length == 4)
				{
					$('button#login').removeAttr('disabled');
				}
			});

			$('button#login').click(function(){
				// 验证captcha字段是否已被输入4位数字
				var captcha = $('[name=captcha]').val();
				// 将captcha字段值和存储在cookie中的sms_id发送到服务器进行验证
				var mobile = $('[name=mobile]').val();
				var sms_id = $.cookie('sms_id');
				var params = {'captcha':captcha, 'mobile':mobile, 'sms_id':sms_id};
				$.getJSON('/login', params, function(data){
					if (data.status == 200) //若成功，保存用户信息信息到session, 并跳转到首页
					{
						// 未完成，将data.content里所含数组全部转存为session
						location.href = '/home';
					}
					else // 若失败，进行提示并将焦点移入captcha字段
					{
						$('[name=captcha]').val('').focus();
					}
				});
				return false;
			});
		});
	</script>
</div>