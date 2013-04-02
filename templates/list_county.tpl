{* $Header$ *}

{strip}

<div class="floaticon">{bithelp}</div>

<div class="listing nlpg county">

	<div class="header">
		<h1>{tr}Counties{/tr} ({$listInfo.total_records})</h1>
	</div>

	<div class="body">
		{minifind sort_mode=$sort_mode list=county}

			<input type="hidden" name="offset" value="{$control.offset|escape}" />
			<input type="hidden" name="sort_mode" value="{$control.sort_mode|escape}" />
			<input type="hidden" name="list" value="county" />

			<table class="data">
				<caption>{tr}List of County Titles{/tr}</caption>
				<thead>
					<tr>
						<th>{smartlink ititle="County ID" isort=c_id idefault=1 iorder=desc offset=$control.offset list=county}</th>
						<th>{smartlink ititle="Title" isort=title offset=$control.offset list=county}</th>
						<th>{smartlink ititle="Description" isort=description offset=$control.offset list=county}</th>
					</tr>
				</thead>
				<tbody>
					{section name=county loop=$list}
						<tr class="{cycle values="even,odd"}" title="{$list[county].title|escape}">
							<td>
								{$list[county].c_id}
							</td>
							<td>
								<a href="{$smarty.const.NLPG_PKG_URL}index.php?c_id={$list[county].c_id|escape:"url"}" title="{$list[county].title}">
									{$list[county].title}
								</a>
							</td>
							<td>
								<span class="actionicon">
									{include file="bitpackage:liberty/services_inc.tpl" serviceLocation='list' serviceHash=$listpages[county]}
									{if $gBitUser->hasPermission( 'p_nlpg_edit' )}
										{smartlink ititle="Edit" ifile="edit_ons.php" booticon="icon-edit" c_id=$list[county].c_id}
									{/if}
								</span>
								<label for="ev_{$list[county].c_id}">	
									{$list[county].description}
								</label>
							</td>
						</tr>
					{sectionelse}
						<tr class="norecords">
							<td colspan="3">
								{tr}No records found{/tr}
							</td>
						</tr>
					{/section}
				</tbody>
			</table>

	</div><!-- end .body -->

	{pagination list=county}
	
</div><!-- end .county -->

{/strip}
