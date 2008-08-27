{if $gBitSystem->isFeatureActive('feature_sample_comments')}
<div class="navbar comment">
	{if $comments_cant > 0}
		<a href="javascript:document.location='#comments';flip('comzone{if $comments_show eq 'y'}open{/if}');">{if $comments_cant eq 1}{tr}1 comment{/tr}{else}{$comments_cant} {tr}comments{/tr}{/if}</a>
	{else}
		<a href="javascript:document.location='#comments';flip('comzone{if $comments_show eq 'y'}open{/if}');">{tr}comment{/tr}</a>
	{/if}
</div>
{/if}
