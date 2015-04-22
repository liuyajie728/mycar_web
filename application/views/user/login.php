<div id=content>
	<h2>您的手机号是？</h2>
	<p>填写手机号，成为哎油会员</p>
<?php
	if(isset($error)){echo $error;}
	$attributes = array('class' => 'form-login form-horizontal', 'role' => 'form');
	echo form_open(base_url('login'), $attributes);
?>
		<fieldset>
			<input class=form-control name=mobile type=tel value="" placeholder="手机号" required autofocus>
			<a id=sms_send class="btn btn-primary" href="#">验证</a>
			<input class=form-control name=captcha type=number step=1 value="" placeholder="验证码" required disabled>
		</fieldset>
		<p>点击“开始”，即代表您同意<a title="查看青岛我的车信息技术有限公司《哎油服务条款》详细内容" href="<?php echo base_url('article/1') ?>">《哎油服务条款》</a>。</p>
		<button id=login class="btn btn-primary" disabled>开始</button>
	</form>
	<script>
		$(function(){
			// 清空cookie中的sms_id记录
			$.cookie('sms_id', '', {expires:-1});
			
			/**
			* @param int stage whether should check length of string
			*/
			function check_mobile(mobile, check_length)
			{
				if (isNaN(mobile))
				{
					alert('请输入有效手机号码');
					$('[name=mobile]').val('').focus();
				}
				if (check_length == 1)
				{
					if (mobile.length != 11)
					{
						alert('请输入有效手机号码');
						return false;
					}
					else if(mobile.length == 11)
					{
						$('a#sms_send').removeAttr('disabled');
					}
				}
			}
			function check_captcha(captcha)
			{
				if (isNaN(captcha))
				{
					alert('请输入有效验证码');
					$('[name=captcha]').val('').focus();
				}
				if (check_length == 1)
				{
					if (mobile.length != 4)
					{
						alert('请输入有效验证码');
						return false;
					}
					else if (captcha.length == 4)
					{
						$('button#login').removeAttr('disabled');
					}
				}
			}
			
			$('[name=mobile]').keyup(function(){
				var mobile = $('[name=mobile]').val();
				check_mobile(mobile);
			});
			
			$('a#sms_send').click(function(){
				// 获取mobile字段值，验证该字段是否已被输入11位数字，设置sms_send按钮为不可用状态
				var mobile = $('[name=mobile]').val();
				if (check_mobile(mobile, 1) == false)
				{
					return false;
				}
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
				check_captcha(captcha);
			});

			$('button#login').click(function(){
				// 验证captcha字段是否已被输入4位数字
				var captcha = $('[name=captcha]').val();
				if (check_captcha(captcha, 1) == false)
				{
					return false;
				}
				// 将captcha字段值和存储在cookie中的sms_id发送到服务器进行验证
				var mobile = $('[name=mobile]').val();
				var sms_id = $.cookie('sms_id');
				var params = {'captcha':captcha, 'mobile':mobile, 'sms_id':sms_id};
				$.getJSON('/login', params, function(data){
					if (data.status == 200) //若成功，保存用户信息信息到session/cookie, 并跳转到首页
					{
						// 清除储存在cookie中的sms_id，将data.content里所含数组全部转存为cookie，并跳转到首页
						$.cookie('sms_id', '', {expires:-1});
						$.each(
							data.content,
							function(key,value){
								$('fieldset>p').before(key+':'+value+'<br>');
								//$.cookie(key, value);
							}
						);
						//alert('登陆成功');
						location.href = '/home';
					}
					else // 若失败，进行提示并将焦点移入captcha字段
					{
						alert('验证码错误，请确认');
						$('[name=captcha]').val('').focus();
					}
				});
				return false;
			});
		});
	</script>
</div>