<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_nlpg/display_property.php,v 1.4 2009/10/01 14:17:02 wjames5 Exp $
 *
 * Copyright (c) 2006 bitweaver.org
 * All Rights Reserved. See below for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details.
 *
 * @package nlpg
 * @subpackage functions
 */

/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );

include_once( NLPG_PKG_PATH.'BitNlpg.php' );
include_once( NLPG_PKG_PATH.'NlpgProperty.php' );

$gBitSystem->isPackageActive('nlpg', TRUE);

// Now check permissions to access this page
$gBitSystem->verifyPermission('p_nlpg_view' );

if( !empty( $_REQUEST['uprn'] ) ) {
	$gProperty = new NlpgProperty($_REQUEST['uprn']);
	$gProperty->load();
} else {
	$gProperty = new NlpgProperty();
}

$gBitSmarty->assign_by_ref( 'propertyInfo', $gProperty->mInfo );
if ( $gProperty->isValid() ) {
	$gBitSystem->setBrowserTitle("National Land and Property Gazetteer Item");
	$gBitSystem->display( 'bitpackage:nlpg/show_property.tpl');
} else {
//	header ("location: ".NLPG_PKG_URL."index.php");
//	die;
}
?>
