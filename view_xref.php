<?php
/*
 * This source code is distributed under the terms as layed out in the
 * GNU General Public License.
 *
 * Purpose: To provide the main entry point in accessing an NLPG repository entry
 *
 * Ported to bitweaver framework by Lester Caine 2006-12-29
 * @version $Id: view_xref.php,v 1.1 2008/08/27 16:26:17 lsces Exp $
 */

// Initialization
require_once( '../bit_setup_inc.php' );

if( !empty( $_REQUEST['xref'] ) ) {
}

$gBitSmarty->assign_by_ref( 'info', $_REQUEST );

$gBitSystem->display( 'bitpackage:nlpg/view_xref.tpl', tra( 'External application link: ' ) );
?>