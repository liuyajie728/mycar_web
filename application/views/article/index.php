<div id=content>
<?php if (isset($error)): ?>
	<h2>404</h2>
	<p><?php echo $error ?></p>
<?php else: ?>
	<h2>文章列表</h2>
	<ul>
	<?php foreach($articles as $article): ?>
	<li><a title="<?php echo $article['title'] ?>" href="<?php echo base_url('article'.$article['article_id']) ?>"><?php echo $article['title'] ?></a></li>
	<?php endforeach ?>
	</ul>
<?php endif ?>
</div>