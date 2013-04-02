<div class="body">
	<div class="content">

						<div class="control-group">
							{formlabel label="Status" for="state"}
							{forminput}
								{$streetInfo.state|escape} {$streetInfo.state_date|bit_long_date}
								{$streetInfo.street_surface|escape} {$streetInfo.street_classification|escape}
							{/forminput}
						</div>
						<div class="control-group">
							{formlabel label="Version" for="version"}
							{forminput}
								{$streetInfo.version|escape}
							{/forminput}
						</div>
						<div class="control-group">
							{formlabel label="Street Created" for="street_start_date"}
							{forminput}
								{$streetInfo.street_start_date|bit_long_date}
							{/forminput}
						</div>
						<div class="control-group">
							{formlabel label="Street Removed" for="street_end_date"}
							{forminput}
								{$streetInfo.street_end_date|bit_long_date}
							{/forminput}
						</div>
						<div class="control-group">
							{formlabel label="Start Coordinates" for="street_start_x"}
							{forminput}
								Easting: {$streetInfo.street_start_x|escape} Northing: {$streetInfo.street_start_y|escape}
								&nbsp;&lt;<a href="http://www.multimap.com/maps/?map={$streetInfo.street_start_lat},{$streetInfo.street_start_lng}|17|4&loc=GB:{$streetInfo.street_start_lat}:{$streetInfo.street_start_lng}:17" title="{$streetInfo.title}">
									Multimap
								</a>&gt;
							{/forminput}
						</div>
						<div class="control-group">
							{formlabel label="End Coordinates" for="street_end_x"}
							{forminput}
								Easting: {$streetInfo.street_end_x|escape} Northing: {$streetInfo.street_end_y|escape}
								&nbsp;&lt;<a href="http://www.multimap.com/maps/?map={$streetInfo.street_end_lat},{$streetInfo.street_end_lng}|17|4&loc=GB:{$streetInfo.street_end_lat}:{$streetInfo.street_end_lng}:17" title="{$streetInfo.title}">
									Multimap
								</a>&gt;
							{/forminput}
						</div>
						<div class="control-group">
							{formlabel label="Coordinate Tolerance" for="street_tolerance"}
							{forminput}
								{$streetInfo.street_tolerance} meters
							{/forminput}
						</div>
						<div class="control-group">
							{formlabel label="English Descriptor" for="descriptor"}
							{forminput}
								Title - {$streetInfo.descriptor.ENG.street_descriptor|escape}<br />
								Locality - {$streetInfo.descriptor.ENG.locality_name|escape}<br />
								Town - {$streetInfo.descriptor.ENG.town_name|escape}<br />
								Administration - {$streetInfo.descriptor.ENG.administrative_area|escape}<br />
							{/forminput}
						</div>
	</div><!-- end .content -->
</div><!-- end .body -->
