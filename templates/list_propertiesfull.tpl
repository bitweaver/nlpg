{* $Header$ *}

{strip}

<div class="floaticon">{bithelp}</div>

<div class="listing streets">

	<div class="header">
		<h1>{tr}Property records{/tr} ({$listInfo.total_records})</h1>
	</div>

	<div class="body">
		{minifind sort_mode=$sort_mode list=property}

			<input type="hidden" name="offset" value="{$control.offset|escape}" />
			<input type="hidden" name="sort_mode" value="{$control.sort_mode|escape}" />
			<input type="hidden" name="list" value="property" />

			<table class="table data">
				<caption>{tr}List of property records{/tr}</caption>
				<thead>
					<tr>
						<th>{smartlink ititle="UPRN" isort=uprn idefault=1 iorder=desc offset=$control.offset list=property}</th>
						<th>{smartlink ititle="Sec. Title" isort=soa_text offset=$control.offset list=property}</th>
						<th>{smartlink ititle="Title" isort=title offset=$control.offset list=property}</th>
						<th>{smartlink ititle="Street" isort=street_descriptor offset=$control.offset list=property}</th>
						<th>{smartlink ititle="Locality" isort=locality_name offset=$control.offset list=property}</th>
						<th>{smartlink ititle="Town" isort=town_name offset=$control.offset list=property}</th>
						<th>{smartlink ititle="Postcode" isort=postcode offset=$control.offset list=property}</th>
						<th>{smartlink ititle="Location" isort=x_coordinate offset=$control.offset list=property}</th>
						<th>{smartlink ititle="Ward" isort=ward_code offset=$control.offset list=property}</th>
						<th>{smartlink ititle="Parish" isort=parish_code offset=$control.offset list=property}</th>
						<th>{smartlink ititle="Description" isort=note offset=$control.offset list=property}</th>
					</tr>
				</thead>
				<tbody>
					{section name=county loop=$list}
						<tr class="{cycle values="even,odd"}" title="{$list[county].title|escape}">
							<td>
								{$list[county].uprn}
							</td>
							<td>
								{$list[county].soa}
							</td>
							<td>
								{$list[county].title}
							</td>
							<td>
								{$list[county].street_descriptor}
							</td>
							<td>
								{$list[county].locality_name}
							</td>
							<td>
								{$list[county].town_name}
							</td>
							<td>
								{$list[county].postcode}
							</td>
							<td>
								<a href="http://www.openstreetmap.org/index.html?mlat={$list[county].prop_lat}&mlon={$list[county].prop_lng}&zoom=15&layers=BOFT" title="{$list[county].title}">
									{$list[county].x_coordinate},{$list[county].y_coordinate}
								</a>&nbsp;&lt;
								<a href="http://www.multimap.com/maps/?map={$list[county].prop_lat},{$list[county].prop_lng}|17|4&loc=GB:{$list[county].prop_lat}:{$list[county].prop_lng}:17" title="{$list[county].title}">
									Multimap
								</a>&gt;
							</td>
							<td>
								{$list[county].ward_code}
							</td>
							<td>
								{$list[county].parish_code}
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

	{pagination list=property}
	
</div><!-- end .county -->

{/strip}
