<?php

/* NLPG Data transfer format DTF7.3 is used as the basis for these tables
 * CSV extracts are loaded into the relevent tables.
 * nlpg_street					- type 11
 * nlpg_street_xref				- type 12
 * nlpg_street_descriptor		- type 15
 * nlpg_blpu					- type 21
 * nlpg_blpu_provenance			- type 22
 * nlpg_blpu_xref				- type 23
 * nlpg_lpi						- type 24
 * nlpg_blpu_extent				- type 25 - Not handled yet
 * nlpg_blpu_extent_poly		- type 26 - Not handled yet
 * nlpg_blpu_extent_vert		- type 27 - Not handled yet
 * nlpg_metadata				- type 10, 29, 98
 */

$tables = array(
	'nlpg_ons_county' => "
		c_id	C(2) NOTNULL,
		title	C(64) 	PRIMARY
	",
	'nlpg_ons_local_authority' => "
		l_id	C(4) PRIMARY,
		c_id	C(2) NOTNULL,
		title	C(64) NOTNULL
	",
	'nlpg_ons_ward' => "
		w_id	C(6) PRIMARY,
		l_id	C(4) NOTNULL,
		c_id	C(2) NOTNULL,
		title	C(64) NOTNULL
	",
	'nlpg_ons_parish' => "
		p_id	C(7) PRIMARY,
		l_id	C(4) NOTNULL,
		c_id	C(2) NOTNULL,
		title	C(80) NOTNULL
	",
	'nlpg_street' => "
		usrn I8 PRIMARY,
		record_type I4 NOTNULL,
		swa_org_ref_naming I4 NOTNULL,
		state I2,
		state_date D,
		street_surface I2,
		street_classification I2,
		version I2 NOTNULL,
		record_entry_date D NOTNULL,
		last_update_date D NOTNULL,
		street_start_date D NOTNULL,
		street_end_date D,
		street_start_x F NOTNULL,
		street_start_y F NOTNULL,
		street_end_x F NOTNULL,
		street_end_y F NOTNULL,
		street_tolerance I2
	",		
	'nlpg_street_xref' => "
		usrn I8 NOTNULL,
		xref_type I4 NOTNULL,
		usrn_version_number I2 NOTNULL,
		xref_id C(16) NOTNULL,
		xref_version_number I2 NOTNULL,
		entry_date D NOTNULL
	",		
	'nlpg_street_descriptor' => "
		usrn I8 PRIMARY,
		language C(4) PRIMARY,
		street_descriptor C(100) NOTNULL,
		locality_name C(35),
		town_name C(30) NOTNULL,
		administrative_area C(30) NOTNULL
	",		
	'nlpg_blpu' => "
		uprn I8 PRIMARY,
		logical_status I2 PRIMARY,
		blpu_state I2,
		blpu_state_date D,
		blpu_class C(4) NOTNULL,
		parent_uprn I8,
		x_coordinate F NOTNULL,
		y_coordinate F NOTNULL,
		rpa	I2 NOTNULL,
		local_custodian_code I2 NOTNULL,
		start_date D NOTNULL,
		end_date D,
		last_update_date D NOTNULL,
		entry_date D NOTNULL,
		organisation C(100),
		ward_code C(6),
		parish_code C(7),
		custodian_one I2,
		custodian_two I2,
		can_key	C(14)
	",		
	'nlpg_blpu_provenance' => "
		uprn I8 NOTNULL,
		prov_key C(14) PRIMARY,
		provenance_code C(1),
		annotation C(30),
		entry_date D NOTNULL,
		start_date D NOTNULL,
		end_date D,
		last_update_date D NOTNULL
	",		
	'nlpg_blpu_xref' => "
		uprn I8 NOTNULL,
		xref_key C(14) PRIMARY,
		start_date D NOTNULL,
		last_update_date D NOTNULL,
		entry_date D NOTNULL,
		end_date D,
		cross_reference C(20),
		source C(6)
	",		
	'nlpg_lpi' => "
		uprn I8 NOTNULL,
		xref_key C(14) PRIMARY,
		language C(4) PRIMARY,
		logical_status I2,
		start_date D NOTNULL,
		end_date D,
		entry_date D NOTNULL,
		last_update_date D NOTNULL,
		sao_start_number I2,
		sao_start_suffix C(1),
		sao_end_number I2,
		sao_end_suffix C(1),
		sao_text C(90),
		pao_start_number I2,
		pao_start_suffix C(1),
		pao_end_number I2,
		pao_end_suffix C(1),
		pao_text C(90),
		usrn I8 NOTNULL,
		v_level C(30),
		postally_addressable C(1) NOTNULL,
		postcode C(8),
		post_town C(30),
		official_flag C(1),
		custodian_one I2,
		custodian_two I2,
		can_key	C(14),
		sao C(110),
		pao C(110)
	",		
	'nlpg_metadata' => "
		content_id I8 PRIMARY,
		custodian_name C(40) NOTNULL,
		custodian_uprn I8 NOTNULL,
		custodian_code C(4) NOTNULL,
		process_date T NOTNULL DEFAULT 'NOW',
		volume_number I2 NOTNULL,
		entry_date D NOTNULL,
		time_stamp D NOTNULL,
		dtf_version F NOTNULL,
		file_type C(1) NOTNULL,
		gaz_name C(60) NOTNULL,
		gaz_scope C(60) NOTNULL,
		ter_of_use C(60) NOTNULL,
		linked_data C(100),
		gaz_owner C(60) NOTNULL,
		ngaz_freq C(1),
		co_ord_system C(40),
		co_ord_unit C(10),
		meta_date D,
		class_scheme C(40),
		gaz_date D,
		language C(3),
		character_set C(30),
		last_lpi_key C(14),
		last_prov_key C(14),
		last_xref_key C(14),
		last_update_date D,
		last_time_stamp T
	",		
	'nlpg_record_types' => "
		r_id	I2	PRIMARY,
		id	C(4) 	PRIMARY,
		title	C(64)	NOTNULL
		
	",
	'nlpg_blpu_class' => "
		blpu_id C(4)	PRIMARY,
		pc	C(1)	NOTNULL,
		pd	C(32)	NOTNULL,
		sc	C(1)	NOTNULL,
		sd	C(64)	NOTNULL,
		tid	C(2)	NOTNULL,
		td	C(64)	NOTNULL,
		notes	X	
	",
);

global $gBitInstaller;

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( NLPG_PKG_NAME, $tableName, $tables[$tableName] );
}

$gBitInstaller->registerPackageInfo( NLPG_PKG_NAME, array(
	'description' => "National Land and Property Gazetteer package.",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
) );

// ### Indexes

$indices = array(
	'nlpg_lpi_usrn_idx' => array('table' => 'nlpg_lpi', 'cols' => 'usrn', 'opts' => NULL ),
);
$gBitInstaller->registerSchemaIndexes( NLPG_PKG_NAME, $indices );

// ### Sequences

$sequences = array (
	'nlpg_usrn_seq' => array( 'start' => 1 ),
	'nlpg_uprn_seq' => array( 'start' => 1 ),
);
$gBitInstaller->registerSchemaSequences( NLPG_PKG_NAME, $sequences );

$gBitInstaller->registerSchemaDefault( NLPG_PKG_NAME, array(
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 1, 'I', 'Insert')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 1, 'U', 'Update')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 1, 'D', 'Delete')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 2, 1, 'Designated Street Name')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 2, 2, 'Street Description')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 2, 3, 'Street Number')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 2, 4, 'Unofficial Street Name')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 2, 9, 'Feature used for LLPG access')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 3, 1, 'Under construction')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 3, 2, 'Open')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 3, 4, 'Permanently closed')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 3, 5, 'Open with restriction')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 4, 1, 'Metalled')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 4, 2, 'Unmetalled')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 4, 3, 'Mixed')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 5, 4, 'Pedestrian way or footpath')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 5, 6, 'Cycletrack or cycleway')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 5, 8, 'Open to vehicles')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 5, 9, 'Restricted access to vehicles')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 6, 'ENG', 'English')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 6, 'CYM', 'Welsh')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 6, 'COR', 'Cornish')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 6, 'GLE', 'Gaelic (Irish)')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 6, 'GAE', 'Gaelic (Scottish)')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 6, 'ULL', 'Ulster Scots')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 7, 1, 'Approved BLPU')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 7, 5, 'Candidate BLPU')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 7, 6, 'Provisional')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 7, 7, 'Rejected External')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 7, 8, 'Historical')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 7, 9, 'Rejected Internal')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 8, 1, 'Under construction / named or numbered by SN & N')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 8, 2, 'In use / occupied')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 8, 3, 'Unoccupied / vacant / derelict')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 8, 4, 'Demolished')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 8, 5, 'Planning application submitted')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 8, 6, 'Planning permission granted')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 8, 7, 'Planning application refused')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 9, 1, 'Visual centre of BLPU')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 9, 2, 'General internal point')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 9, 3, 'SW corner of 100m grid square')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 9, 4, 'Start of street')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 9, 5, 'General point based on Unit Postcode')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 9, 6, 'Centre of local authority area')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 10, 1, 'Approved / Preferred LPI')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 10, 3, 'Alternate LPI')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 10, 5, 'Candidate LPI')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 10, 6, 'Provisional LPI')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 10, 7, 'Rejected External LPI')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 10, 8, 'Historical LPI')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_record_types` (`r_id`, `id`, `title`) VALUES ( 10, 9, 'Rejected Internal LPI')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CA01', 'C', 'Commercial', 'A', 'Agricultural', '01', 'Farms')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CA02', 'C', 'Commercial', 'A', 'Agricultural', '02', 'Fisheries')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CA03', 'C', 'Commercial', 'A', 'Agricultural', '03', 'Horticulture')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CC01', 'C', 'Commercial', 'C', 'Community Services', '01', 'Fire, Police and Ambulance stations')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CC02', 'C', 'Commercial', 'C', 'Community Services', '02', 'Law courts')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CC03', 'C', 'Commercial', 'C', 'Community Services', '03', 'Prisons')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CC04', 'C', 'Commercial', 'C', 'Community Services', '04', 'Public and village halls')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CC05', 'C', 'Commercial', 'C', 'Community Services', '05', 'Public Conveniences')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CC06', 'C', 'Commercial', 'C', 'Community Services', '06', 'Cemeteries & Crematorium')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CC07', 'C', 'Commercial', 'C', 'Community Services', '07', 'Church halls')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CE01', 'C', 'Commercial', 'E', 'Education', '01', 'Collages')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CE02', 'C', 'Commercial', 'E', 'Education', '02', 'Nursery / Creche')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CE03', 'C', 'Commercial', 'E', 'Education', '03', 'Primary, Junior, Infants or Middle School')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CE04', 'C', 'Commercial', 'E', 'Education', '04', 'Secondary School')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CE05', 'C', 'Commercial', 'E', 'Education', '05', 'University')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CH01', 'C', 'Commercial', 'H', 'Hotels, Boarding and Guest Houses', '01', 'Guest House / B&B')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CH02', 'C', 'Commercial', 'H', 'Hotels, Boarding and Guest Houses', '02', 'Holiday Let')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CH03', 'C', 'Commercial', 'H', 'Hotels, Boarding and Guest Houses', '03', 'Hotel')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CI01', 'C', 'Commercial', 'I', 'Industrial', '01', 'Factories & Manufacturing')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CI02', 'C', 'Commercial', 'I', 'Industrial', '02', 'Mineral workings & Quarries / Mines')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CI03', 'C', 'Commercial', 'I', 'Industrial', '03', 'Workshops')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CI04', 'C', 'Commercial', 'I', 'Industrial', '04', 'Warehouses')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CI05', 'C', 'Commercial', 'I', 'Industrial', '05', 'Wholesale distribution')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CL01', 'C', 'Commercial', 'L', 'Leisure', '01', 'Amusements')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CL02', 'C', 'Commercial', 'L', 'Leisure', '02', 'Holiday / Camp sites')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CL03', 'C', 'Commercial', 'L', 'Leisure', '03', 'Libraries')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CL04', 'C', 'Commercial', 'L', 'Leisure', '04', 'Museums')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CL05', 'C', 'Commercial', 'L', 'Leisure', '05', 'Nightclubs')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CL06', 'C', 'Commercial', 'L', 'Leisure', '06', 'Sporting activities e.g. leisure centre, golf course')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CL07', 'C', 'Commercial', 'L', 'Leisure', '07', 'Theatres / Arenas / Stadium')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CL08', 'C', 'Commercial', 'L', 'Leisure', '08', 'Zoos and theme parks')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CM01', 'C', 'Commercial', 'M', 'Medical', '01', 'Dentist')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CM02', 'C', 'Commercial', 'M', 'Medical', '02', 'GP surgeries and clinics')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CM03', 'C', 'Commercial', 'M', 'Medical', '03', 'Hospitals')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CM04', 'C', 'Commercial', 'M', 'Medical', '04', 'Medical laboratories')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CN01', 'C', 'Commercial', 'N', 'Animal Centre', '01', 'Catteries')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CN02', 'C', 'Commercial', 'N', 'Animal Centre', '02', 'Kennels')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CN03', 'C', 'Commercial', 'N', 'Animal Centre', '03', 'Stables')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CN04', 'C', 'Commercial', 'N', 'Animal Centre', '04', 'Vet')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CN05', 'C', 'Commercial', 'N', 'Animal Centre', '05', 'Animal Sanctuary')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CO01', 'C', 'Commercial', 'O', 'Offices', '01', 'Ofices and work studios')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CO02', 'C', 'Commercial', 'O', 'Offices', '02', 'Broadcasting (TV, Radio)')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CR01', 'C', 'Commercial', 'R', 'Retail', '01', 'Banks / Financial services')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CR02', 'C', 'Commercial', 'R', 'Retail', '02', 'Estate agents')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CR03', 'C', 'Commercial', 'R', 'Retail', '03', 'Hairdressing/beauty salon')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CR04', 'C', 'Commercial', 'R', 'Retail', '04', 'Markets (Indoor & Outdoor)')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CR05', 'C', 'Commercial', 'R', 'Retail', '05', 'Petrol Filling stations')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CR06', 'C', 'Commercial', 'R', 'Retail', '06', 'Public houses and bars')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CR07', 'C', 'Commercial', 'R', 'Retail', '07', 'Restaurants and cafes')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CR08', 'C', 'Commercial', 'R', 'Retail', '08', 'Shops')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CR09', 'C', 'Commercial', 'R', 'Retail', '09', 'Betting offices')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CT01', 'C', 'Commercial', 'T', 'Transport', '01', 'Airports')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CT02', 'C', 'Commercial', 'T', 'Transport', '02', 'Bus shelters')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CT03', 'C', 'Commercial', 'T', 'Transport', '03', 'Car parks')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CT04', 'C', 'Commercial', 'T', 'Transport', '04', 'Goods freight handling')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CT05', 'C', 'Commercial', 'T', 'Transport', '05', 'Marinas, harbours and ports')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CT06', 'C', 'Commercial', 'T', 'Transport', '06', 'Moorings')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CT07', 'C', 'Commercial', 'T', 'Transport', '07', 'Railway assets')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CT08', 'C', 'Commercial', 'T', 'Transport', '08', 'Stations and interchanges')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CT09', 'C', 'Commercial', 'T', 'Transport', '09', 'Transport tracks and ways')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CT10', 'C', 'Commercial', 'T', 'Transport', '10', 'Vehicle storage')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CT11', 'C', 'Commercial', 'T', 'Transport', '11', 'Other waterway infrastructure')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CU01', 'C', 'Commercial', 'U', 'Utilities', '01', 'Electricity sub-stations')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CU02', 'C', 'Commercial', 'U', 'Utilities', '02', 'Landfill')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CU03', 'C', 'Commercial', 'U', 'Utilities', '03', 'Power stations / Energy production')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CU04', 'C', 'Commercial', 'U', 'Utilities', '04', 'Pumping stations / Water towers')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CU05', 'C', 'Commercial', 'U', 'Utilities', '05', 'Recycling sites')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CU06', 'C', 'Commercial', 'U', 'Utilities', '06', 'Telecommunications masts')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CU07', 'C', 'Commercial', 'U', 'Utilities', '07', 'Water / Sewage treatment works')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CZ01', 'C', 'Commercial', 'Z', 'Information', '01', 'Advertising hoardings')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CZ02', 'C', 'Commercial', 'Z', 'Information', '02', 'Tourist Information')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'CZ03', 'C', 'Commercial', 'Z', 'Information', '03', 'Traffic Information')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'LA01', 'L', 'Land', 'A', 'Agricultural', '01', 'Grazing land')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'LA02', 'L', 'Land', 'A', 'Agricultural', '02', 'Permanent crops or crop rotation')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'LC01', 'L', 'Land', 'C', 'Cemeteries', '01', 'Active and disused graveyards')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'LD01', 'L', 'Land', 'D', 'Development', '01', 'Development sites')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'LF01', 'L', 'Land', 'F', 'Forestry', '01', 'Orchards')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'LF02', 'L', 'Land', 'F', 'Forestry', '02', 'Forests (managed * unmanaged)')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'LF03', 'L', 'Land', 'F', 'Forestry', '03', 'Woodlands')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'LF04', 'L', 'Land', 'L', 'Allotments', ' ', 'Allotments')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'LM01', 'L', 'Land', 'M', 'Amenity', '01', 'Roundabouts')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'LM02', 'L', 'Land', 'M', 'Amenity', '02', 'Verges')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'LP01', 'L', 'Land', 'P', 'Parks', '01', 'Public Gardens')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'LP02', 'L', 'Land', 'P', 'Parks', '02', 'Public open spaces, e.g. heaths and parks')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'LP03', 'L', 'Land', 'P', 'Parks', '03', 'Public playgrounds and receation')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'LU01', 'L', 'Land', 'U', 'Unused', '01', 'Vacant or derelict land')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'Lw01', 'L', 'Land', 'W', 'Water', '01', 'Lakes and reservoirs')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'Lw02', 'L', 'Land', 'W', 'Water', '02', 'Ponds')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'Lw03', 'L', 'Land', 'W', 'Water', '03', 'Waterways (canals and rivers)')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'MA  ', 'M', 'Military', 'A', 'Army', 	'  ', 'Army')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'MF  ', 'M', 'Military', 'F', 'Air Force', 	'  ', 'Air Force')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'MG  ', 'M', 'Military', 'G', 'Government', 	'  ', 'Government')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'MN  ', 'M', 'Military', 'N', 'Navy', 	'  ', 'Navy')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'PP  ', 'P', 'Parent Shell', 'P', 'Property Shell', '  ', 'Terrace, block')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'PS  ', 'P', 'Parent Shell', 'S', 'Street BLPU', '  ', 'Street BLPU')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'RD01', 'R', 'Residential', 'D', 'Dwellings', '01', 'Caravans')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'RD02', 'R', 'Residential', 'D', 'Dwellings', '02', 'Detached house')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'RD03', 'R', 'Residential', 'D', 'Dwellings', '03', 'Semi-detached house')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'RD04', 'R', 'Residential', 'D', 'Dwellings', '04', 'Terraced house')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'RD05', 'R', 'Residential', 'D', 'Dwellings', '05', 'Bungalow')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'RD06', 'R', 'Residential', 'D', 'Dwellings', '06', 'Flat')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'RD07', 'R', 'Residential', 'D', 'Dwellings', '07', 'House boats')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'RD08', 'R', 'Residential', 'D', 'Dwellings', '08', 'Sheltered accomodation')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'RD09', 'R', 'Residential', 'D', 'Dwellings', '09', 'HMO')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'RG01', 'R', 'Residential', 'G', 'Garages', '01', 'Allocated parking spaces')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'RG02', 'R', 'Residential', 'G', 'Garages', '02', 'Lock-up garages and garage courts')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'RI01', 'R', 'Residential', 'I', 'Residential Institutions', '01', 'Care Homes')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'RI02', 'R', 'Residential', 'I', 'Residential Institutions', '02', 'Communal residences')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'RI03', 'R', 'Residential', 'I', 'Residential Institutions', '03', 'Residential education (e.g. halls of residence)')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'UC  ', 'U', 'Unclassified', 'C', 'Awaiting Classification', '  ', 'Awaiting Classification')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'UP  ', 'U', 'Unclassified', 'P', 'Pending internal investigation', '  ', 'Pending internal investigation')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'X   ', 'X', 'Mixed', ' ', ' ', '  ', 'Mixed')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'ZA  ', 'Z', 'Features', 'A', 'Archaeological Dig Sites', ' ', 'Archaeological Dig Sites')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'ZM01', 'Z', 'Features', 'M', 'Monuments', '01', 'Obelisks / Milestones / Standing stones')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'ZM02', 'Z', 'Features', 'M', 'Monuments', '02', 'Memorial and market crosses')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'ZM03', 'Z', 'Features', 'M', 'Monuments', '03', 'Statues')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'ZM04', 'Z', 'Features', 'M', 'Monuments', '04', 'Castles and historic ruins')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'ZU01', 'Z', 'Features', 'U', 'Underground Features', '01', 'Caves')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'ZU02', 'Z', 'Features', 'U', 'Underground Features', '02', 'Cellars')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'ZU03', 'Z', 'Features', 'U', 'Underground Features', '03', 'Disused mines')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'ZU04', 'Z', 'Features', 'U', 'Underground Features', '04', 'Potholes')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'ZU05', 'Z', 'Features', 'U', 'Underground Features', '05', 'Wells and springs')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_blpu_class` (`blpu_id` ,`pc`, `pd`, `sc`, `sd`, `tid`, `td`) VALUES ( 'ZW  ', 'Z', 'Features', 'W', 'Places of Worship', '  ', 'Churches, mosques, synagogues, chapels')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '00','Unitary')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '01','Greater London')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '02','Greater Manchester')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '03','Merseyside')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '04','South Yorkshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '05','Tyne and Wear')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '06','West Midlands')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '07','West Yorkshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '09','Bedfordshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '11','Buckinghamshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '12','Cambridgeshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '13','Cheshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '15','Cornwall and Isles of Scilly')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '16','Cumbria')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '17','Derbyshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '18','Devon')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '19','Dorset')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '20','Durham')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '21','East Sussex')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '22','Essex')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '23','Gloucestershire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '24','Hampshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '26','Hertfordshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '29','Kent')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '30','Lancashire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '31','Leicestershire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '32','Lincolnshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '33','Norfolk')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '34','Northamptonshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '35','Northumberland')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '36','North Yorkshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '37','Nottinghamshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '38','Oxfordshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '39','Shropshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '40','Somerset')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '41','Staffordshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '42','Suffolk')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '43','Surrey')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '44','Warwickshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '45','West Sussex')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '46','Wiltshire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '47','Worcestershire')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '95','Northern Ireland')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '98','Wales')",
	"INSERT INTO `".BIT_DB_PREFIX."nlpg_ons_county` (`c_id` ,`title`) VALUES ( '99','Scotland')",
	)
);

// ### Default UserPermissions
$gBitInstaller->registerUserPermissions( NLPG_PKG_NAME, array(
	array( 'p_nlpg_admin', 'Can admin nlpg configuration', 'admin', NLPG_PKG_NAME ),
	array( 'p_nlpg_create', 'Can create nlpg entries', 'editors', NLPG_PKG_NAME ),
	array( 'p_nlpg_update', 'Can update any nlpg entry', 'editors', NLPG_PKG_NAME ),
	array( 'p_nlpg_view', 'Can read nlpg database', 'registered',  NLPG_PKG_NAME ),
	array( 'p_nlpg_expunge', 'Can delete any nlpg entry', 'admin',  NLPG_PKG_NAME ),
) );

// ### Default Preferences
$gBitInstaller->registerPreferences( NLPG_PKG_NAME, array(
	array( NLPG_PKG_NAME, 'nlpg_default_ordering', 'nlpg_usrn_desc' ),
	array( NLPG_PKG_NAME, 'nlpg_version', '7.3'),
	array( NLPG_PKG_NAME, 'nlpg_mapliks', 'y'),
) );
?>
