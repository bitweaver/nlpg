{strip}
<ul>
	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_streets.php">{booticon iname="icon-list" iexplain="List Streets" ilocation=menu}</a></li>
{*	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_postcodes.php">{booticon iname="icon-list" iexplain="List Postcodes" ilocation=menu}</a></li>
*}
	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_properties.php">{booticon iname="icon-list" iexplain="List Properties" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_county.php?list=county">{booticon iname="icon-list" iexplain="List of Counties" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_county.php?list=local">{booticon iname="icon-list" iexplain="List of Local Authorities" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_county.php?list=ward">{booticon iname="icon-list" iexplain="List of Wards" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_county.php?list=parish">{booticon iname="icon-list" iexplain="List of Parishes" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_county.php?list=blpu_class">{booticon iname="icon-list" iexplain="List of Property Classifications" ilocation=menu}</a></li>
	{if $gBitUser->hasPermission( 'p_nlpg_admin' ) }
		<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}load.php">{booticon iname="icon-time" iexplain="New extract load" ilocation=menu}</a></li>
		<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}update.php">{booticon iname="icon-time" iexplain="Process update extract" ilocation=menu}</a></li>
		<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}load_ons.php">{booticon iname="icon-time" iexplain="ONS Names load" ilocation=menu}</a></li>
	{/if}
</ul>
{/strip}
