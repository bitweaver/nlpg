<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_nlpg/display_street.php,v 1.5 2010/02/08 21:27:24 wjames5 Exp $
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
require_once( '../kernel/setup_inc.php' );

include_once( NLPG_PKG_PATH.'BitNlpg.php' );
include_once( NLPG_PKG_PATH.'NlpgStreet.php' );

$gBitSystem->isPackageActive('nlpg', TRUE);

// Now check permissions to access this page
$gBitSystem->verifyPermission('p_nlpg_view' );

if( !empty( $_REQUEST['usrn'] ) ) {
	$gStreet = new NlpgStreet($_REQUEST['usrn']);
	$gStreet->load();
} else {
	$gStreet = new NlpgStreet();
}

$gBitSmarty->assign_by_ref( 'streetInfo', $gStreet->mInfo );
if ( $gStreet->isValid() ) {
	$gBitSystem->setBrowserTitle("National Street Gazetteer Item");
	$gBitSystem->display( 'bitpackage:nlpg/show_street.tpl');
} else {
	header ("location: ".NLPG_PKG_URL."index.php");
	die;
}
?>
