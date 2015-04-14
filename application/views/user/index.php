<ul id=content>
	<?php var_dump($me) ?>
	<?php if(empty($me['nickname'])): ?>
	<p>Hi, <?php echo $me['mobile'] ?></p>
	<?php else: ?>
	<li><?php echo $me['nickname'] ?></li>
	<li><?php echo $me['mobile'] ?></li>
	<?php endif; ?>
</ul>