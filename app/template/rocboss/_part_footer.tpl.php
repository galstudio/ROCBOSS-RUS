<?php die('Access Denied');?>
<div class="footer" id="footer">
	<div class="main-outlet">
		<div class="col">
			<p>Работает на <a href="https://www.rocboss.com" target="_blank">ROCBOSS v2.1.0</a></p>
			<p>Разработчики: admin@rocboss.com</p>
		</div>
		{if isset($hotTags)}
		<div class="col">
			<p class="link">
			Популярные теги:
				{loop $hotTags $tag}
					<a href="{$root}tag/{$tag.tagname}">{$tag.tagname}</a>
				{/loop}
			</p>
		</div>
		{/if}
		{if isset($LinksList)}
		<div class="col">
			<p class="link">
			Ссылки:
				{loop $LinksList $v}
					<a href="{$v.url}" title="{$v.text}" target="_blank">{$v.text}</a>
				{/loop}
			</p>
		</div>
		{/if}
	</div>
	<div class="clear"></div>
</div>
</body>
</html>
