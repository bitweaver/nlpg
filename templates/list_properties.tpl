{* $Header$ *}

{strip}

<div class="floaticon">{bithelp}</div>

<div class="listing streets">

	<div class="header">
		<h1>{tr}Property records{/tr} ({$listInfo.total_records})</h1>
	</div>

	<div class="body">
		{form class="minifind" legend="find in entries"}
			<input type="hidden" name="sort_mode" value="{$sort_mode}" />
			{booticon iname="icon-search"  ipackage="icons"  iexplain="Search"} &nbsp;
			<label>{tr}Organisation{/tr}:&nbsp;<input size="20" type="text" name="find_org" value="{$find_org|default:$smarty.request.find_org|escape}" /></label> &nbsp;
			<label>{tr}Building{/tr}:&nbsp;<input size="20" type="text" name="find_xao" value="{$find_xao|default:$smarty.request.find_xao|escape}" /></label> &nbsp;
			<label>{tr}Street{/tr}:&nbsp;<input size="20" type="text" name="find_street" value="{$find_street|default:$smarty.request.find_street|escape}" /></label> &nbsp;
			<label>{tr}Postcode{/tr}:&nbsp;<input size="10" type="text" name="find_postcode" value="{$find_postcode|default:$smarty.request.find_postcode|escape}" /></label> &nbsp;
			<input type="submit" name="search" value="{tr}Find{/tr}" />&nbsp;
			<input type="button" onclick="location.href='{$smarty.server.SCRIPT_NAME}{if $hidden}?{/if}{foreach from=$hidden item=value key=name}{$name}={$value}&amp;{/foreach}'" value="{tr}Reset{/tr}" />
		{/form}

			<input type="hidden" name="offset" value="{$control.offset|escape}" />
			<input type="hidden" name="sort_mode" value="{$control.sort_mode|escape}" />
			<input type="hidden" name="list" value="property" />

			<table class="data">
				<caption>{tr}List of property records{/tr}</caption>
				<thead>
					<tr>
						<th>{smartlink ititle="UPRN" isort=uprn idefault=1 iorder=desc icontrol=$listInfo list=property}</th>
						<th>Property Type</th>
						<th>{smartlink ititle="Organisation" isort=organisation icontrol=$listInfo list=property}</th>
						<th>{smartlink ititle="Sec. Title" isort=soa icontrol=$listInfo list=property}</th>
						<th>{smartlink ititle="Title" isort=title icontrol=$listInfo list=property}</th>
						<th>{smartlink ititle="Street" isort=street_descriptor icontrol=$listInfo list=property}</th>
						<th>{smartlink ititle="Locality" isort=locality_name icontrol=$listInfo list=property}</th>
						<th>{smartlink ititle="Town" isort=town_name icontrol=$listInfo list=property}</th>
						<th>{smartlink ititle="Postcode" isort=postcode icontrol=$listInfo list=property}</th>
						<th>{smartlink ititle="Location" isort=x_coordinate icontrol=$listInfo list=property}</th>
					</tr>
				</thead>
				<tbody>
					{section name=county loop=$list}
						<tr class="{cycle values="even,odd"}" title="{$list[county].title|escape}">
							<td>
								<a href="display_property.php?uprn={$list[county].uprn}" title="uprn_{$list[county].uprn}">
									{$list[county].uprn}
								</a>
							</td>
							<td>
								{$list[county].organisation}
							</td>
							<td>
								{$list[county].sao}
							</td>
							<td>
								{$list[county].title}
							</td>
							<td>
								<a href="{$list[county].display_usrn}" title="uprn_{$list[county].usrn}">
									{$list[county].street_descriptor}
								</a>
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
