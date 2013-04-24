{* $Header$ *}

{strip}

<div class="floaticon">{bithelp}</div>

<div class="listing nlpg county">

	<div class="header">
		<h1>{tr}Property Classification{/tr} ({$listInfo.total_records})</h1>
	</div>

	<div class="body">
		{minifind sort_mode=$sort_mode list=blpu_class}

			<input type="hidden" name="offset" value="{$control.offset|escape}" />
			<input type="hidden" name="sort_mode" value="{$control.sort_mode|escape}" />
			<input type="hidden" name="list" value="blpu_class" />

			<table class="table data">
				<caption>{tr}List of Property Classifications{/tr}</caption>
				<thead>
					<tr>
						<th>{smartlink ititle="BLPU Classification" isort=blpu_id idefault=1 iorder=desc offset=$control.offset list=blpu_class}</th>
						<th>{smartlink ititle="Primary Title" isort=pd offset=$control.offset list=blpu_class}</th>
						<th>{smartlink ititle="Secondary Title" isort=sd offset=$control.offset list=blpu_class}</th>
						<th>{smartlink ititle="Tertiary Title" isort=title offset=$control.offset list=blpu_class}</th>
						<th>{smartlink ititle="Description" isort=note offset=$control.offset list=blpu_class}</th>
					</tr>
				</thead>
				<tbody>
					{section name=county loop=$list}
						<tr class="{cycle values="even,odd"}" title="{$list[county].title|escape}">
							<td>
								{$list[county].blpu_id}
							</td>
							<td>
								{$list[county].pd}
							</td>
							<td>
								{$list[county].sd}
							</td>
							<td>
								{$list[county].title}
							</td>
							<td>
								<span class="actionicon">
									{include file="bitpackage:liberty/services_inc.tpl" serviceLocation='list' serviceHash=$listpages[county]}
									{if $gBitUser->hasPermission( 'p_nlpg_edit' )}
										{smartlink ititle="Edit" ifile="edit_ons.php" booticon="icon-edit" blpu_id=$list[county].blpu_id}
									{/if}
								</span>
								<label for="ev_{$list[county].blpu_id}">	
									{$list[county].note}
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

	{pagination list=blpu_class}
	
</div><!-- end .county -->

{/strip}
