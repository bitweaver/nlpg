<div class="body">
	<div class="content">

		<div class="control-group">
			{formlabel label="Status" for="state"}
			{forminput}
				{$propertyInfo.logical_status|escape}
				{$propertyInfo.blpu_state|escape} {$propertyInfo.blpu_state|bit_long_date}
			{/forminput}
		</div>
		<div class="control-group">
			{formlabel label="Propert Class" for="version"}
			{forminput}
				{$propertyInfo.blpu_class|escape} 
			{/forminput}
		</div>
		<div class="control-group">
			{formlabel label="Property Created" for="street_start_date"}
			{forminput}
				{$propertyInfo.start_date|bit_long_date}
			{/forminput}
		</div>
		<div class="control-group">
			{formlabel label="Property Removed" for="street_end_date"}
			{forminput}
				{$propertyInfo.end_date|bit_long_date}
			{/forminput}
		</div>
		<div class="control-group">
			{formlabel label="Visual Centre Coordinates" for="street_start_x"}
			{forminput}
				Easting: {$propertyInfo.x_coordinate|escape} Northing: {$propertyInfo.y_coordinate|escape}
				&nbsp;&lt;<a href="http://www.openstreetmap.org/index.html?mlat={$propertyInfo.prop_lat}&mlon={$propertyInfo.prop_lng}&zoom=16&layers=BOFT" title="{$propertyInfo.title}">
					OpenStreetMap
				</a>&gt;&nbsp;&lt;<a href="http://www.multimap.com/maps/?map={$propertyInfo.prop_lat},{$propertyInfo.prop_lng}|17|4&loc=GB:{$propertyInfo.prop_lat}:{$propertyInfo.prop_lng}:17" title="{$propertyInfo.title}">
					Multimap
				</a>&gt;<br />
				{$propertyInfo.rpa|escape}
			{/forminput}
		</div>
		<div class="control-group">
			{formlabel label="Ward" for="ward_code"}
			{forminput}
				{$propertyInfo.ward_code} - {$propertyInfo.ward}
			{/forminput}
		</div>
		<div class="control-group">
			{formlabel label="Parish" for="parish_code"}
			{forminput}
				{$propertyInfo.parish_code} - {$propertyInfo.parish}
			{/forminput}
		</div>
		<div class="control-group">
			{formlabel label="English Descriptor" for="lpi"}
			{forminput}
				Primary Addressabe Object - {$propertyInfo.lpi.ENG.pao|escape}<br />
				Secondary Addressabe Object - {$propertyInfo.lpi.ENG.sao|escape}<br />
				Post Town - {$propertyInfo.lpi.ENG.post_town|escape}<br />
				Postcode - {$propertyInfo.lpi.ENG.postcode|escape}<br />
			{/forminput}
		</div>
	</div>
	<div class="content">
		<div class="control-group">
			{formlabel label="Cross reference" for="xref"}
			{forminput}
			<table>
				<caption>{tr}List of linked references{/tr}</caption>
				<thead>
					<tr>
						<th>Key</th>
						<th>Application</th>
						<th>Reference</th>
					</tr>
				</thead>
				<tbody>
					{section name=xref loop=$propertyInfo.xref}
						<tr class="{cycle values="even,odd"}" title="{$list[county].title|escape}">
							<td>
								{$propertyInfo.xref[xref].xref_key|escape}
							</td>
							<td>
								{$propertyInfo.xref[xref].source|escape}
							</td>
							<td>
								<span class="actionicon">
									{smartlink ititle="View" ifile="view_xref.php" ibiticon="icons/accessories-text-editor" 
									source=$propertyInfo.xref[xref].source xref=$propertyInfo.xref[xref].cross_reference}
								</span>
								<label for="ev_{$propertyInfo.xref[xref].cross_reference}">	
									{$propertyInfo.xref[xref].cross_reference}
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
			{/forminput}
		</div>
	</div>
	<div class="content">
		<div class="control-group">
			{formlabel label="Cross reference" for="ci"}
			{forminput}
			<table>
				<caption>{tr}List of linked citizen index records{/tr}</caption>
				<thead>
					<tr>
						<th>USN</th>
						<th>Name</th>
						<th>Date of Birth</th>
					</tr>
				</thead>
				<tbody>
					{section name=ci loop=$propertyInfo.ci}
						<tr class="{cycle values="even,odd"}" title="{$list[county].title|escape}">
							<td>
								<span class="actionicon">
									{smartlink ititle="View" ifile="../../..`$smarty.const.CITIZEN_PKG_URL`display_citizen.php" ibiticon="icons/accessories-text-editor" 
									content_id=$propertyInfo.ci[ci].content_id}
								</span>
								{$propertyInfo.ci[ci].usn|escape}
							</td>
							<td>
								{$propertyInfo.ci[ci].surname|escape},{$propertyInfo.ci[ci].forename|escape}
							</td>
							<td>
								{$propertyInfo.ci[ci].dob|bit_long_date}
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
			{/forminput}
		</div>
	</div><!-- end .content -->
</div><!-- end .body -->
