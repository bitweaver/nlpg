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
$_REQUEST['list'] = 'postcode';

$listnlpg = $nlpg->getOsnList( $_REQUEST );

$gBitSmarty->assign_by_ref('listInfo', $_REQUEST['listInfo']);
$gBitSmarty->assign_by_ref('list', $listnlpg);

// Display the template
$gBitSystem->display('bitpackage:nlpg/list_postcodes.tpl', tra('Postcode record list') );

?>
