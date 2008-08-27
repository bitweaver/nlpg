<div class="floaticon">
  {if $lock}
    {biticon ipackage="icons" iname="locked" iexplain="locked"}{$info.editor|userlink}
  {/if}
  {if $print_page ne 'y'}
    {if !$lock}
      {if $gBitUser->hasPermission('p_nlpg_edit')}
		<a href="edit_street.php?usrn={$propertyInfo.usrn}" {if $beingEdited eq 'y'}{popup_init src="`$gBitLoc.THEMES_PKG_URL`overlib.js"}{popup text="$semUser" width="-1"}{/if}>{biticon ipackage="icons" iname="accessories-text-editor" iexplain="edit"}</a>
      {/if}
    {/if}
    <a title="{tr}print{/tr}" href="print.php?usrn={$propertyInfo.usrn}">{biticon ipackage="icons" iname="document-print" iexplain="print"}</a>
      {if $gBitUser->hasPermission('p_nlpg_remove')}
        <a title="{tr}remove this street{/tr}" href="remove_street.php?usrn={$propertyInfo.usrn}">{biticon ipackage="icons" iname="edit-delete" iexplain="delete"}</a>
      {/if}
  {/if} {* end print_page *}
</div> {*end .floaticon *}
<div class="date">
	{tr}Created by{/tr} {displayname user=$propertyInfo.local_custodian_code user_id=$propertyInfo.local_custodian_code real_name=$propertyInfo.local_custodian_code} on {$propertyInfo.entry_date|bit_long_date}, {tr}Last modification on{/tr} {$propertyInfo.last_update_date|bit_long_date}
</div>
