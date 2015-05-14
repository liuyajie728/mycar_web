<style>
body{background-color:#00a1d8;}
#content{color:#fff;text-align:center;padding-top:90px;}
#content h2{margin-bottom:10px;}
#content>p{margin-bottom:10px;}
form p{font-size:smaller;text-align:center;margin-top:10px;}
	form p>a{color:#8ce2db;}
		form p>a:hover{color:#fff;}
.input-group{border-bottom:1px solid #c7c7c7;}
#sms_send{color:#fff;background-color:#47dac0;text-align:center;}
button{background-color:#47dac0;}
</style>
<div id=content>
	<h2>您的手机号是？</h2>
	<p>填写手机号，成为哎油会员</p>
<?php
	if(isset($error)){echo $error;}
	$attributes = array('class' => 'form-login', 'role' => 'form');
	echo form_open(base_url('login'), $attributes);
?>
		<fieldset>
			<div class=input-group>
				<input class=form-control name=mobile type=tel placeholder="*手机号码" required autofocus>
				<a id=sms_send class="input-group-addon button" href="#">获取验证码</a>
			</div>
			<input name=captcha type=number step=1 placeholder="*验证码" required disabled>
		</fieldset>
		<p>点击“开始”，即表示您同意<a title="查看青岛我的车信息技术有限公司《哎油服务条款》详细内容" href="#myModal" data-toggle=modal data-target="#myModal">《哎油服务条款》</a>。</p>
		<button id=login class="btn btn-primary btn-block" disabled>开始</button>
	</form>
	<script>
		$(function(){
			// 清空cookie中的sms_id记录
			$.cookie('sms_id', '', {expires:-1});
			
			/**
			* @param int Whether should check length of string
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
					else if (mobile.length == 11)
					{
						$('a#sms_send').removeAttr('disabled');
					}
				}
			}
			
			$('[name=mobile]').keyup(function(){
				var mobile = $('[name=mobile]').val();
				check_mobile(mobile, 0);
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
				$.getJSON('sms/send', params, function(data){
					if (data.status == 200) // 若成功，激活并将焦点移到captcha字段，激活确认按钮
					{
						$.cookie('sms_id', data.content.sms_id);
						$('[name=captcha],button#login').removeAttr('disabled');
						$('[name=captcha]').focus();
					}
					else // 若失败，激活sms_send按钮
					{
						$('#sms_send').text('验证').removeAttr('disabled');
					}
				});
				return false;
			});

			$('button#login').click(function(){
				// 验证captcha字段是否已被输入4位数字
				var captcha = $('[name=captcha]').val();
				//if (check_captcha(captcha, 1) == false)
				//{
				//	return false;
				//}
				// 将表单提交按钮设置为不可用状态
				$('button#login').attr('disabled');

				// 将captcha字段值和存储在cookie中的sms_id发送到服务器进行验证
				var mobile = $('[name=mobile]').val();
				var sms_id = $.cookie('sms_id');
				var params = {'captcha':captcha, 'mobile':mobile, 'sms_id':sms_id};
				$.getJSON('login', params, function(data){
					if (data.status == 200) //若成功，删除cookie中的短信ID，跳转到json文件中target_url
					{
						$.cookie('sms_id', '', {expires:-1});
						location.href = data.content.target_url;
					}
					else // 若失败，进行提示并将焦点移入captcha字段
					{
						alert('登录失败，请重试验证码。');
						$('button#login').removeAttr('disabled');
						$('[name=captcha]').val('').focus();
					}
				});
				return false;
			});
		});
	</script>
</div>

<!-- 用户条款模态窗口，bootstrap插件 -->
<!--
<div class="modal fade" id=myModal tabindex="-1" role=dialog aria-labelledby=myModalLabel aria-hidden=true>
  <div class=modal-dialog>
    <div class=modal-content>
      <div class=modal-header>
        <button class=close data-dismiss=modal aria-label=Close><span aria-hidden=true>&times;</span></button>
        <h4 class=modal-title id=myModalLabel><?php echo $article['title'] ?></h4>
      </div>
      <div class=modal-body><?php echo $article['content'] ?></div>
      <div class=modal-footer>
        <button data-dismiss=modal>好的</button>
      </div>
    </div>
  </div>
</div>
-->