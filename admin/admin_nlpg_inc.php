<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_nlpg/admin/admin_nlpg_inc.php,v 1.1 2008/08/27 16:26:17 lsces Exp $
 *
 * @author lsces
 * @package nlpg
 * @subpackage functions
 */

/**
 * required setup
 */
$formNlpgDisplayOptions = array(
  // This should pobably be a generic setting in kernel or something that is
  // site wide for all html_select_times and such.
	"events_use_24" => array(
		'label' => 'Use 24 Hour',
		'note' => 'Time display uses 24 hour format.',
		'type' => 'toggle',
	),
	"events_end_year" => array(
		'label' => 'Events End Year',
		'note' => 'End year in events date set. Can be a specific year or +# (i.e. +1) to allow events a certain number of years in the future.',
		'type' => 'input',
	),
);
$gBitSmarty->assign( 'formNlpgDisplayOptions', $formNlpgDisplayOptions );

$formNlpgFeatureOptions = array(
	"events_moderation" => array(
		'label' => 'Events Moderation',
		'note' => 'Use content status to moderate events.',
		'type' => 'toggle',
	),
);
$gBitSmarty->assign( 'formNlpgFeatureOptions', $formNlpgFeatureOptions );

if( !empty( $_REQUEST['nlpg_preferences'] ) ) {
  	$events = array_merge( $formNlpgDisplayOptions, $formNlpgFeatureOptions  );
	foreach( $events as $item => $data ) {
		if( $data['type'] == 'numeric' ) {
			simple_set_int( $item, NLPG_PKG_NAME );
		} elseif( $data['type'] == 'toggle' ) {
			simple_set_toggle( $item, NLPG_PKG_NAME );
		} elseif( $data['type'] == 'input' ) {
			simple_set_value( $item, NLPG_PKG_NAME );
		}
	}
}

?>