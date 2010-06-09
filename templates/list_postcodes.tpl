{* $Header$ *}

{strip}

<div class="floaticon">{bithelp}</div>

<div class="listing postcodes">

	<div class="header">
		<h1>{tr}Postcode records{/tr} ({$listInfo.total_records})</h1>
	</div>

	<div class="body">
		{minifind sort_mode=$sort_mode list=postcode}

			<input type="hidden" name="offset" value="{$control.offset|escape}" />
			<input type="hidden" name="sort_mode" value="{$control.sort_mode|escape}" />
			<input type="hidden" name="list" value="blpu_class" />

			<table class="data">
				<caption>{tr}List of street records{/tr}</caption>
				<thead>
					<tr>
						<th>{smartlink ititle="Postcode" isort=postcode idefault=1 iorder=desc offset=$control.offset list=postcode}</th>
						<th>{smartlink ititle="Sub-Title" isort=add1 offset=$control.offset list=postcode}</th>
						<th>{smartlink ititle="Title" isort=street_descriptor offset=$control.offset list=postcode}</th>
						<th>{smartlink ititle="Locality" isort=add3 offset=$control.offset list=postcode}</th>
						<th>{smartlink ititle="Area" isort=add4 offset=$control.offset list=postcode}</th>
						<th>{smartlink ititle="Town" isort=town offset=$control.offset list=postcode}</th>
						<th>{smartlink ititle="County" isort=county offset=$control.offset list=postcode}</th>
						<th>{smartlink ititle="Postcode coord" isort=grideast offset=$control.offset list=postcode}</th>
						<th>{smartlink ititle="Description" isort=note offset=$control.offset list=postcode}</th>
					</tr>
				</thead>
				<tbody>
					{section name=county loop=$list}
						<tr class="{cycle values="even,odd"}" title="{$list[county].title|escape}">
							<td>
								{$list[county].postcode}
							</td>
							<td>
								{$list[county].add1}
							</td>
							<td>
								{$list[county].title}
							</td>
							<td>
								{$list[county].add3}
							</td>
							<td>
								{$list[county].add4}
							</td>
							<td>
								{$list[county].town}
							</td>
							<td>
								{$list[county].county}
							</td>
							<td>
								<a href="http://www.openstreetmap.org/index.html?mlat={$list[county].pc_lat}&mlon={$list[county].pc_lng}&zoom=15&layers=BOFT" title="{$list[county].title}">
									{$list[county].grideast},{$list[county].gridnorth}
								</a>&nbsp;&lt;
								<a href="http://www.multimap.com/maps/?map={$list[county].pc_lat},{$list[county].pc_lng}|17|4&loc=GB:{$list[county].pc_lat}:{$list[county].pc_lng}:17" title="{$list[county].title}">
									Multimap
								</a>&gt;&nbsp;&lt;
								<a href="http://www.streetmap.co.uk/newmap.srf?x={$list[county].grideast}&y={$list[county].gridnorth}&z=0" title="{$list[county].title}">
									Streetmap
								</a>&gt;
							</td>
							<td>
								<span class="actionicon">
									{include file="bitpackage:liberty/services_inc.tpl" serviceLocation='list' serviceHash=$listpages[county]}
									{if $gBitUser->hasPermission( 'p_nlpg_edit' )}
										{smartlink ititle="Edit" ifile="edit_ons.php" ibiticon="icons/accessories-text-editor" blpu_id=$list[county].blpu_id}
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

	{pagination list=postcode}
	
</div><!-- end .county -->

{/strip}
