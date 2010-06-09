{* $Header$ *}

{strip}

<div class="floaticon">{bithelp}</div>

<div class="listing nlpg county">

	<div class="header">
		<h1>{tr}Local Authorities{/tr} ({$listInfo.total_records})</h1>
	</div>

	<div class="body">
		{minifind sort_mode=$sort_mode list=local c_id=$c_id}

			<input type="hidden" name="offset" value="{$control.offset|escape}" />
			<input type="hidden" name="sort_mode" value="{$control.sort_mode|escape}" />
			<input type="hidden" name="list" value="local" />

			<table class="data">
				<caption>{tr}List of Local Authorities{/tr}</caption>
				<thead>
					<tr>
						<th>{smartlink ititle="Local Authority ID" isort=l_id idefault=1 iorder=desc offset=$control.offset list=local}</th>
						<th>{smartlink ititle="Title" isort=title offset=$control.offset list=local}</th>
						<th>Wards and Parishes</th>
						<th>{smartlink ititle="County" isort=county offset=$control.offset list=local}</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
					{section name=county loop=$list}
						<tr class="{cycle values="even,odd"}" title="{$list[county].title|escape}">
							<td>
								{$list[county].l_id}
							</td>
							<td>
								{$list[county].title}
							</td>
							<td>
								&lt;<a href="{$smarty.const.NLPG_PKG_URL}list_county.php?sort_mode=l_id_asc&list=ward&l_id={$list[county].l_id|escape:"url"}" title="{$list[county].title}">
									Wards
								</a>&gt;&nbsp;&lt;
								<a href="{$smarty.const.NLPG_PKG_URL}list_county.php?sort_mode=l_id_asc&list=ward&l_id={$list[county].l_id|escape:"url"}" title="{$list[county].title}">
									Parishes
								</a>&gt;
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
										{smartlink ititle="Edit" ifile="edit_ons.php" ibiticon="icons/accessories-text-editor" l_id=$list[county].l_id}
									{/if}
								</span>
								<label for="ev_{$list[county].l_id}">	
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

	{pagination list=local c_id=$c_id}
	
</div><!-- end .county -->

{/strip}
