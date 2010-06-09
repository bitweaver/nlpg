<?php
/**
 * @version $Header$
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
	"nlpg_maplink" => array(
		'label' => 'Include links to map pages',
		'note' => 'Expand coordinate displays to include links to map packages. The maps packagas available are defined separatly.',
		'type' => 'toggle',
	),
	"nlpg_default_ordering" => array(
		'label' => 'Initial ordering of results',
		'note' => 'Used to supply the initial display ordering.',
		'type' => 'input',
	),
);
$gBitSmarty->assign( 'formNlpgDisplayOptions', $formNlpgDisplayOptions );

$formNlpgFeatureOptions = array(
	"nlpg_edit" => array(
		'label' => 'On-line editing',
		'note' => 'Enable on-line edit pages for NLPG information. Additional to edit permission controls to allow finer management.',
		'type' => 'toggle',
	),
);
$gBitSmarty->assign( 'formNlpgFeatureOptions', $formNlpgFeatureOptions );

if( !empty( $_REQUEST['nlpg_preferences'] ) ) {
  	$nlpg_opt = array_merge( $formNlpgDisplayOptions, $formNlpgFeatureOptions  );
	foreach( $nlpg_opt as $item => $data ) {
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