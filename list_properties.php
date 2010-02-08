<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_nlpg/list_properties.php,v 1.3 2010/02/08 21:27:24 wjames5 Exp $
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
$listHash = $_REQUEST;

$listnlpg = $nlpg->getPropertyList( $listHash );

// we will probably need a better way to do this
$listHash['listInfo']['ihash']['find_org'] = !empty( $listHash['find_org'] ) ? $listHash['find_org'] : '';
$listHash['listInfo']['ihash']['find_xao'] = !empty( $listHash['find_xao'] ) ? $listHash['find_xao'] : '';
$listHash['listInfo']['ihash']['find_street'] = !empty( $listHash['find_street'] ) ? $listHash['find_street'] : '';
$listHash['listInfo']['ihash']['find_postcode'] = !empty( $listHash['find_postcode'] ) ? $listHash['find_postcode'] : '';

$gBitSmarty->assign_by_ref('listInfo', $listHash['listInfo']);
$gBitSmarty->assign_by_ref('list', $listnlpg);

// Display the template
$gBitSystem->display('bitpackage:nlpg/list_properties.tpl', tra('Property record list') );

?>
