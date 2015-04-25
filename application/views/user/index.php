<ul id=content>
	<?php if ($me['nickname'] === NULL): ?>
	<p>Hi, <?php echo $me['mobile'] ?></p>
	<?php else: ?>
	<li><?php echo $me['nickname'] ?></li>
	<li><?php echo $me['mobile'] ?></li>
	<?php endif; ?>
</ul>