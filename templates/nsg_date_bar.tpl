<div class="floaticon">
  {if $lock}
    {biticon ipackage="icons" iname="locked" iexplain="locked"}{$info.editor|userlink}
  {/if}
  {if $print_page ne 'y'}
    {if !$lock}
      {if $gBitUser->hasPermission('p_nlpg_edit')}
		<a href="edit_street.php?usrn={$streetInfo.usrn}" {if $beingEdited eq 'y'}{popup_init src="`$gBitLoc.THEMES_PKG_URL`overlib.js"}{popup text="$semUser" width="-1"}{/if}>{booticon iname="icon-edit" ipackage="icons" iexplain="edit"}</a>
      {/if}
    {/if}
    <a title="{tr}print{/tr}" href="print.php?usrn={$streetInfo.usrn}">{booticon iname="icon-print"  ipackage="icons"  iexplain="print"}</a>
      {if $gBitUser->hasPermission('p_nlpg_remove')}
        <a title="{tr}remove this street{/tr}" href="remove_street.php?usrn={$streetInfo.usrn}">{booticon iname="icon-trash" ipackage="icons" iexplain="delete"}</a>
      {/if}
  {/if} {* end print_page *}
</div> {*end .floaticon *}
<div class="date">
	{tr}Created by{/tr} {displayname user=$streetInfo.swa_org_ref_naming user_id=$streetInfo.swa_org_ref_naming real_name=$streetInfo.swa_org_ref_naming} on {$streetInfo.record_entry_date|bit_long_date}, {tr}Last modification on{/tr} {$streetInfo.last_update_date|bit_long_date}
</div>
