<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_nlpg/display_property.php,v 1.1 2008/08/27 16:26:17 lsces Exp $
 *
 * Copyright (c) 2006 bitweaver.org
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
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
$gBitSystem->verifyPermission('p_nlpg_edit' );

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
