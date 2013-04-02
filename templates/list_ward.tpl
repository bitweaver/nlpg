{* $Header$ *}

{strip}

<div class="floaticon">{bithelp}</div>

<div class="listing nlpg county">

	<div class="header">
		<h1>{tr}Wards{/tr} ({$listInfo.total_records})</h1>
	</div>

	<div class="body">
		{minifind sort_mode=$sort_mode list=ward l_id=$l_id}

			<input type="hidden" name="offset" value="{$control.offset|escape}" />
			<input type="hidden" name="sort_mode" value="{$control.sort_mode|escape}" />
			<input type="hidden" name="list" value="ward" />

			<table class="data">
				<caption>{tr}List of Ward Titles{/tr}</caption>
				<thead>
					<tr>
						<th>{smartlink ititle="Ward ID" isort=c_id idefault=1 iorder=desc offset=$control.offset list=ward}</th>
						<th>{smartlink ititle="Title" isort=title offset=$control.offset list=ward}</th>
						<th>{smartlink ititle="Local Authority" isort=local_authority offset=$control.offset list=ward}</th>
						<th>{smartlink ititle="County" isort=county offset=$control.offset list=ward}</th>
						<th>{smartlink ititle="Description" isort=description offset=$control.offset list=ward}</th>
					</tr>
				</thead>
				<tbody>
					{section name=county loop=$list}
						<tr class="{cycle values="even,odd"}" title="{$list[county].title|escape}">
							<td>
								{$list[county].w_id}
							</td>
							<td>
									{$list[county].title}
							</td>
							<td>
								<a href="{$smarty.const.NLPG_PKG_URL}index.php?l_id={$list[county].l_id|escape:"url"}" title="{$list[county].title}">
									{$list[county].local_authority}
								</a>
							</td>
							<td>
								<a href="{$smarty.const.NLPG_PKG_URL}index.php?c_id={$list[county].c_id|escape:"url"}" title="{$list[county].county}">
									{$list[county].county}
								</a>
							</td>
							<td>
								<span class="actionicon">
									{include file="bitpackage:liberty/services_inc.tpl" serviceLocation='list' serviceHash=$listpages[county]}
									{if $gBitUser->hasPermission( 'p_nlpg_edit' )}
										{smartlink ititle="Edit" ifile="edit_ons.php" booticon="icon-edit" w_id=$list[county].w_id}
									{/if}
								</span>
								<label for="ev_{$list[county].w_id}">	
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

	{pagination list=ward l_id=$l_id}
	
</div><!-- end .county -->

{/strip}
