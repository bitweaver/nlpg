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
$gBitSystem->verifyPackage( 'nlpg' );

// Now check permissions to access this page
$gBitSystem->verifyPermission( 'p_nlpg_view' );

$nlpg = new BitNlpg();
$_REQUEST['list'] = 'street';
$listHash = $_REQUEST;

$listnlpg = $nlpg->getOsnList( $listHash );

if ( isset( $listHash['listInfo']['find'] ) ) {
	$listHash['listInfo']['ihash']['find_objects'] = $listHash['listInfo']['find'];
}

$gBitSmarty->assign_by_ref('listInfo', $listHash['listInfo']);
$gBitSmarty->assign_by_ref('list', $listnlpg);

// Display the template
$gBitSystem->display('bitpackage:nlpg/list_streets.tpl', tra('Street record detail') );

?>
