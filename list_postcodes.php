<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_nlpg/list_postcodes.php,v 1.1 2008/08/27 16:26:17 lsces Exp $
 * Copyright (c) 2004 bitweaver nlpg
 * @package nlpg
 * @subpackage functions
 */

/**
 * required setup
 */
require_once('../bit_setup_inc.php' );
require_once(NLPG_PKG_PATH.'BitNlpg.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage('nlpg' );

// Now check permissions to access this page
$gBitSystem->verifyPermission('p_nlpg_view' );

$nlpg = new BitNlpg();
$_REQUEST['list'] = 'postcode';

$listnlpg = $nlpg->getOsnList( $_REQUEST );

$gBitSmarty->assign_by_ref('listInfo', $_REQUEST['listInfo']);
$gBitSmarty->assign_by_ref('list', $listnlpg);

// Display the template
$gBitSystem->display('bitpackage:nlpg/list_postcodes.tpl', tra('Postcode record list') );

?>
