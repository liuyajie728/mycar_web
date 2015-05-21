<div id=content>
	<?php if (isset($error)): ?>
	<h2>404</h2>
	<p><?php echo $error ?></p>
	<?php else: ?>
	<h2><?php echo $article['title'] ?></h2>
	<section><?php echo $article['content'] ?></section>
	<?php endif ?>
</div>