{strip}
<ul>
	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_streets.php">{biticon iname="format-justify-fill" iexplain="List Streets" ilocation=menu}</a></li>
{*	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_postcodes.php">{biticon iname="format-justify-fill" iexplain="List Postcodes" ilocation=menu}</a></li>
*}
	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_properties.php">{biticon iname="format-justify-fill" iexplain="List Properties" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_county.php?list=county">{biticon iname="format-justify-fill" iexplain="List of Counties" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_county.php?list=local">{biticon iname="format-justify-fill" iexplain="List of Local Authorities" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_county.php?list=ward">{biticon iname="format-justify-fill" iexplain="List of Wards" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_county.php?list=parish">{biticon iname="format-justify-fill" iexplain="List of Parishes" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}list_county.php?list=blpu_class">{biticon iname="format-justify-fill" iexplain="List of Property Classifications" ilocation=menu}</a></li>
	{if $gBitUser->hasPermission( 'p_nlpg_admin' ) }
		<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}load.php">{biticon iname="appointment-new" iexplain="New extract load" ilocation=menu}</a></li>
		<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}update.php">{biticon iname="appointment-new" iexplain="Process update extract" ilocation=menu}</a></li>
		<li><a class="item" href="{$smarty.const.NLPG_PKG_URL}load_ons.php">{biticon iname="appointment-new" iexplain="ONS Names load" ilocation=menu}</a></li>
	{/if}
</ul>
{/strip}
