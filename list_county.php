<?php
/**
 * @version $Header$
 * Copyright (c) 2004 bitweaver nlpg
 * @package nlpg
 * @subpackage functions
 */

/**
 * required setup
 */
require_once('../kernel/setup_inc.php' );
require_once(NLPG_PKG_PATH.'BitNlpg.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage('nlpg' );

// Now check permissions to access this page
$gBitSystem->verifyPermission('p_nlpg_view' );

$nlpg = new BitNlpg();

$listnlpg = $nlpg->getOsnList( $_REQUEST );

$gBitSmarty->assign_by_ref('listInfo', $_REQUEST['listInfo']);
$gBitSmarty->assign_by_ref('list', $listnlpg);
if ( isset($_REQUEST['listInfo']) ) $gBitSmarty->assign_by_ref('l_id', $_REQUEST['l_id']);
if ( isset($_REQUEST['listInfo']) ) $gBitSmarty->assign_by_ref('c_id', $_REQUEST['c_id']);

// Display the template
if ( $_REQUEST['list'] == 'county' ) {
	$gBitSystem->display('bitpackage:nlpg/list_county.tpl', tra('Counties') );
} else if ( $_REQUEST['list'] == 'local' ) {
	$gBitSystem->display('bitpackage:nlpg/list_local.tpl', tra('Local Authorities') );
} else if ( $_REQUEST['list'] == 'ward' ) {
	$gBitSystem->display('bitpackage:nlpg/list_ward.tpl', tra('Wards') );	
} else if ( $_REQUEST['list'] == 'parish' ) {
	$gBitSystem->display('bitpackage:nlpg/list_parish.tpl', tra('Parishes') );	
} else if ( $_REQUEST['list'] == 'blpu_class' ) {
	$gBitSystem->display('bitpackage:nlpg/list_blpu_class.tpl', tra('Property Classification') );
}
?>
