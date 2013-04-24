{* $Header$ *}

{strip}

<div class="floaticon">{bithelp}</div>

<div class="listing streets">

	<div class="header">
		<h1>{tr}Street records{/tr} ({$listInfo.total_records})</h1>
	</div>

	<div class="body">
		{minifind sort_mode=$sort_mode list=street}

			<input type="hidden" name="offset" value="{$control.offset|escape}" />
			<input type="hidden" name="sort_mode" value="{$control.sort_mode|escape}" />
			<input type="hidden" name="list" value="blpu_class" />

			<table class="table data">
				<caption>{tr}List of street records{/tr}</caption>
				<thead>
					<tr>
						<th>{smartlink ititle="USRN" isort=usrn idefault=1 iorder=desc offset=$control.offset list=street}</th>
						<th>{smartlink ititle="Title" isort=title offset=$control.offset list=street}</th>
						<th>{smartlink ititle="Locality" isort=locality_name offset=$control.offset list=street}</th>
						<th>{smartlink ititle="Town" isort=town_name offset=$control.offset list=street}</th>
						<th>{smartlink ititle="Street start coord" isort=street_start_x offset=$control.offset list=street}</th>
						<th>{smartlink ititle="Street end coord" isort=street_start_x offset=$control.offset list=street}</th>
						<th>{smartlink ititle="State" isort=state offset=$control.offset list=street}</th>
						<th>{smartlink ititle="State Date" isort=state_date offset=$control.offset list=street}</th>
						<th>{smartlink ititle="Street surface" isort=street_surface offset=$control.offset list=street}</th>
						<th>{smartlink ititle="Description" isort=note offset=$control.offset list=street}</th>
					</tr>
				</thead>
				<tbody>
					{section name=county loop=$list}
						<tr class="{cycle values="even,odd"}" title="{$list[county].title|escape}">
							<td>
								<a href="display_street.php?usrn={$list[county].usrn}" title="{$list[county].title}">
									{$list[county].usrn}
								</a>
							</td>
							<td>
								{$list[county].title}
							</td>
							<td>
								{$list[county].locality_name}
							</td>
							<td>
								{$list[county].town_name}
							</td>
							<td>
								<a href="http://www.openstreetmap.org/index.html?mlat={$list[county].street_start_lat}&mlon={$list[county].street_start_lng}&zoom=15&layers=BOFT" title="{$list[county].title}">
									{$list[county].street_start_x},{$list[county].street_start_y}
								</a>&nbsp;&lt;
								<a href="http://www.multimap.com/maps/?map={$list[county].street_start_lat},{$list[county].street_start_lng}|17|4&loc=GB:{$list[county].street_start_lat}:{$list[county].street_start_lng}:17" title="{$list[county].title}">
									Multimap
								</a>&gt;
							</td>
							<td>
								<a href="http://www.openstreetmap.org/index.html?mlat={$list[county].street_end_lat}&mlon={$list[county].street_end_lng}&zoom=15&layers=BOFT" title="{$list[county].title}">
									{$list[county].street_end_x},{$list[county].street_end_y}
								</a>&nbsp;&lt;
								<a href="http://www.multimap.com/maps/?map={$list[county].street_end_lat},{$list[county].street_end_lng}|17|4&loc=GB:{$list[county].street_end_lat}:{$list[county].street_end_lng}:17" title="{$list[county].title}">
									Multimap
								</a>&gt;
							</td>
							<td>
								{$list[county].state}
							</td>
							<td>
								{$list[county].state_date}
							</td>
							<td>
								{$list[county].street_surface}
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

	{pagination list=street}
	
</div><!-- end .county -->

{/strip}
