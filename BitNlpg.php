<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_nlpg/BitNlpg.php,v 1.1 2008/08/27 16:26:17 lsces Exp $
 *
 * Class for processing nlpg extract data.
 *
 * @author lsces <lester@lsces.co.uk>
 * @package nlpg
 */

/**
 * required setup
 */
require_once( LIBERTY_PKG_PATH.'LibertyContent.php' );
require_once(NLPG_PKG_PATH.'lib/phpcoord-2.3.php' );

/**
 * This is used to uniquely identify the object
 */
define( 'BITNLPG_CONTENT_TYPE_GUID', 'bitnlpg' );

/**
 * @package nlpg
 */
class BitNlpg extends LibertyContent {
	/**
	* Primary key for street identification
	* @public
	*/
	var $mUSRN;

	/**
	* Primary key for property identification
	* @public
	*/
	var $mUPRN;

	/**
	* During initialisation, be sure to call our base constructors
	**/
	function BitNlpg( $pRecId=NULL, $pContentId=NULL ) {
		LibertyContent::LibertyContent();
		$this->mUSRN = $pRecId;
		$this->mUSRN = $pRecId;
		$this->mContentId = $pContentId;
		$this->mContentTypeGuid = BITNLPG_CONTENT_TYPE_GUID;
		$this->registerContentType( BITNLPG_CONTENT_TYPE_GUID, array(
			'content_type_guid' => BITNLPG_CONTENT_TYPE_GUID,
			'content_description' => 'Nlpg',
			'handler_class' => 'BitNlpg',
			'handler_package' => 'nlpg',
			'handler_file' => 'BitNlpg.php',
			'maintainer_url' => 'http://www.lsces.co.uk/'
		) );

		// Permission setup
		$this->mViewContentPerm  = 'p_nlpg_view';
		$this->mEditContentPerm  = 'p_nlpg_edit';
		$this->mAdminContentPerm = 'p_nlpg_admin';
	}

	/**
	* Load the data from the database
	* @param pParamHash be sure to pass by reference in case we need to make modifcations to the hash
	**/
	function load() {
		global $gBitSystem;
		if( $this->verifyId( $this->mEventsId ) || $this->verifyId( $this->mContentId ) ) {
			// LibertyContent::load()assumes you have joined already, and will not execute any sql!
			// This is a significant performance optimization
			$lookupColumn = $this->verifyId( $this->mEventsId ) ? 'events_id' : 'content_id';
			$bindVars = array(); $selectSql = ''; $joinSql = ''; $whereSql = '';
			array_push( $bindVars, $lookupId = @BitBase::verifyId( $this->mEventsId )? $this->mEventsId : $this->mContentId );
			$this->getServicesSql( 'content_load_sql_function', $selectSql, $joinSql, $whereSql, $bindVars );

			$query = "SELECT e.*, lc.*, " .
				"uue.`login` AS modifier_user, uue.`real_name` AS modifier_real_name, " .
				"uuc.`login` AS creator_user, uuc.`real_name` AS creator_real_name " .
				"$selectSql " .
				"FROM `".BIT_DB_PREFIX."nlpg` n " .
				"INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON( lc.`content_id` = n.`content_id` ) $joinSql" .
				"LEFT JOIN `".BIT_DB_PREFIX."users_users` uue ON( uue.`user_id` = lc.`modifier_user_id` )" .
				"LEFT JOIN `".BIT_DB_PREFIX."users_users` uuc ON( uuc.`user_id` = lc.`user_id` )" .
				"WHERE e.`$lookupColumn`=? $whereSql";
			$result = $this->mDb->query( $query, $bindVars );

			if( $result && $result->numRows() ) {
				$this->mInfo = $result->fields;
				$this->mContentId = $result->fields['content_id'];
				$this->mEventsId = $result->fields['events_id'];

				$this->mInfo['creator'] =( isset( $result->fields['creator_real_name'] )? $result->fields['creator_real_name'] : $result->fields['creator_user'] );
				$this->mInfo['editor'] =( isset( $result->fields['modifier_real_name'] )? $result->fields['modifier_real_name'] : $result->fields['modifier_user'] );
				$this->mInfo['display_url'] = $this->getDisplayUrl();
				$this->mInfo['parsed_data'] = $this->parseData( $this->mInfo['data'], $this->mInfo['format_guid'] );

				$prefChecks = array('show_start_time', 'show_end_time');
				foreach ($prefChecks as $key => $var) {
					if ($this->getPreference($var) == 'on') {
						$this->mInfo[$var] = 1;
					}
					else {
						$this->mInfo[$var] = 0;
					}
				}				

				LibertyAttachable::load();
			}
		}
		return( count( $this->mInfo ) );
	}

	function preview( &$pParamHash ) {
		global $gBitSmarty, $gBitSystem;
		$this->verify( $pParamHash );
		// This is stupid! verify does NOT work how it should.
		// verify should call the super class verify at all levels.
		LibertyContent::verify($pParamHash);

		$this->mInfo = array_merge($pParamHash['events_store'],$pParamHash['content_store'],$pParamHash['events_prefs_store']);
		$this->mInfo['data'] = $pParamHash['edit'];
		$this->mInfo['parsed'] = $this->parseData($pParamHash['edit'], empty($pParamHash['format_guid']) ? $pParamHash['format_guid'] : $gBitSystem->getConfig('default_format'));

		$this->invokeServices( 'content_preview_function' );    

		$gBitSmarty->assign('preview', true);

	}

	/**
	* Any method named Store inherently implies data will be written to the database
	* @param pParamHash be sure to pass by reference in case we need to make modifcations to the hash
	* This is the ONLY method that should be called in order to store( create or update )an events!
	* It is very smart and will figure out what to do for you. It should be considered a black box.
	*
	* @param array pParams hash of values that will be used to store the page
	*
	* @return bool TRUE on success, FALSE if store could not occur. If FALSE, $this->mErrors will have reason why
	*
	* @access public
	**/
	function store( &$pParamHash ) {
		if( $this->verify( $pParamHash )&& LibertyContent::store( $pParamHash ) ) {
			$table = BIT_DB_PREFIX."events";

			$prefChecks = array('show_start_time', 'show_end_time');
			foreach ($prefChecks as $var) {
				if (isset($pParamHash['events_prefs_store'][$var])) {
					$this->storePreference($var, $pParamHash['events_prefs_store'][$var]);
				}
				else {
					$this->storePreference($var);
				}
			}

			$this->mDb->StartTrans();

			if( $this->mEventsId ) {
				$result = $this->mDb->associateUpdate( $table, $pParamHash['events_store'], array( 'events_id' => $pParamHash['events_id'] ) );
			} else {
				$pParamHash['events_store']['content_id'] = $pParamHash['content_id'];
				if( @$this->verifyId( $pParamHash['events_id'] ) ) {
					// if pParamHash['events_id'] is set, some is requesting a particular events_id. Use with caution!
					$pParamHash['events_store']['events_id'] = $pParamHash['events_id'];
				} else {
					$pParamHash['events_store']['events_id'] = $this->mDb->GenID( 'events_events_id_seq' );
				}
				$this->mEventsId = $pParamHash['events_store']['events_id'];

				$result = $this->mDb->associateInsert( $table, $pParamHash['events_store'] );
			}
			$this->mDb->CompleteTrans();
			$this->load();
		}
		return( count( $this->mErrors )== 0 );
	}

	/**
	* Make sure the data is safe to store
	* @param pParamHash be sure to pass by reference in case we need to make modifcations to the hash
	* This function is responsible for data integrity and validation before any operations are performed with the $pParamHash
	* NOTE: This is a PRIVATE METHOD!!!! do not call outside this class, under penalty of death!
	*
	* @param array pParams reference to hash of values that will be used to store the page, they will be modified where necessary
	*
	* @return bool TRUE on success, FALSE if verify failed. If FALSE, $this->mErrors will have reason why
	*
	* @access private
	**/
	function verify( &$pParamHash ) {
		global $gBitUser, $gBitSystem;
		// make sure we're all loaded up of we have a mEventsId
		if( $this->verifyId( $this->mEventsId )/* && empty( $this->mInfo )*/ ) {
			$this->load();
		}

		if( @$this->verifyId( $this->mInfo['content_id'] ) ) {
			$pParamHash['content_id'] = $this->mInfo['content_id'];
		}

		// It is possible a derived class set this to something different
		if( @$this->verifyId( $pParamHash['content_type_guid'] ) ) {
			$pParamHash['content_type_guid'] = $this->mContentTypeGuid;
		}

		if( @$this->verifyId( $pParamHash['content_id'] ) ) {
			$pParamHash['events_store']['content_id'] = $pParamHash['content_id'];
		}

		if( !empty( $pParamHash['cost'] ) ) {
		    $pParamHash['events_store']['cost'] = substr( trim($pParamHash['cost']), 0, 160 );
		}

		$prefChecks = array('show_start_time', 'show_end_time');
		foreach ($prefChecks as $var) {
			if (isset($pParamHash[$var])) {
				$pParamHash['events_prefs_store'][$var] = $pParamHash[$var];
			}
		}

		if ( !empty($pParamHash['frequency'] ) ) {
			$pParamHash['events_store']['frequency'] = $pParamHash['frequency'];
		}
		else {
			$pParamHash['events_store']['frequency'] = 0;
		}

		if( !empty( $pParamHash['start_date']) && !empty($pParamHash['start_time']) ) {
			if (isset($pParamHash['start_time']['Meridian'])) {
				$pParamHash['event_time'] = 
					$this->mDate->gmmktime(($pParamHash['start_time']['Meridian'] == 'pm' ?
							      $pParamHash['start_time']['Hour'] + 12 : 
							      $pParamHash['start_time']['Hour']),
							     $pParamHash['start_time']['Minute'],
							     isset($pParamHash['start_time']['Second']) ? 
							     $pParamHash['start_time']['Second'] : 0, 
							     $pParamHash['start_date']['Month'], 
							     $pParamHash['start_date']['Day'],
							     $pParamHash['start_date']['Year']
							     );
			}
			else {
				$pParamHash['event_time'] =
					$this->mDate->gmmktime($pParamHash['start_time']['Hour'],
							     $pParamHash['start_time']['Minute'],
							     isset($pParamHash['start_time']['Second']) ? 
							     $pParamHash['start_time']['Second'] : 0, 
							     $pParamHash['start_date']['Month'], 
							     $pParamHash['start_date']['Day'],
							     $pParamHash['start_date']['Year']
							     );
			}
		}
		
		if( !empty($pParamHash['end_time']) && !empty($pParamHash['event_time']) ) {
			if (empty($pParamHash['start_date'])) {
				$pParamHash['start_date']['Month'] = $this->mDate->strftime("%m", $pParamHash['event_time'], true);
				$pParamHash['start_date']['Day'] = $this->mDate->strftime("%d", $pParamHash['event_time'], true);
				$pParamHash['start_date']['Year'] = $this->mDate->strftime("%Y", $pParamHash['event_time'], true);
			}
			if ((!isset($pParamHash['end_time']['Meridian']) || 
			     ($pParamHash['end_time']['Meridian'] == 'am' ||
			      $pParamHash['end_time']['Meridian'] == 'pm')) &&
			    (isset($pParamHash['end_time']['Hour']) &&
			     is_numeric($pParamHash['end_time']['Hour'])) && 				   
			    (!isset($pParamHash['end_time']['Minute']) || 
			     is_numeric($pParamHash['end_time']['Minute']) && 
			     (!isset($pParamHash['end_time']['Second']) || 
			      is_numeric($pParamHash['end_time']['Second'])))) {
				
				if (isset($pParamHash['end_time']['Meridian'])) {
					$pParamHash['events_store']['end_time'] = 
					  $this->mDate->gmmktime(($pParamHash['end_time']['Meridian'] == 'pm' ?
								      $pParamHash['end_time']['Hour'] + 12 : 
								      $pParamHash['end_time']['Hour']),
								     $pParamHash['end_time']['Minute'],
								     isset($pParamHash['end_time']['Second']) ? 
								     $pParamHash['end_time']['Second'] : 0,
								     $pParamHash['start_date']['Month'], 
								     $pParamHash['start_date']['Day'],
								     $pParamHash['start_date']['Year']
								     );
				}
				else {
					$pParamHash['events_store']['end_time'] =
					  $this->mDate->gmmktime($pParamHash['end_time']['Hour'],
								     $pParamHash['end_time']['Minute'],
								     isset($pParamHash['end_time']['Second']) ? 
								     $pParamHash['end_time']['Second'] : 0,
								     $pParamHash['start_date']['Month'], 
								     $pParamHash['start_date']['Day'],
								     $pParamHash['start_date']['Year']
								     );
				}					       
				$pParamHash['events_store']['end_time'] = $this->mDate->getUTCFromDisplayDate($pParamHash['events_store']['end_time']);
			}
		}

		if( !empty( $pParamHash['event_time'] ) ) {
			$pParamHash['event_time'] = $this->mDate->getUTCFromDisplayDate( $pParamHash['event_time']);
		} else if ( !empty( $this->mInfo['event_time'] ) ) {
			$pParamHash['event_time'] = $this->mDate->getUTCFromDisplayDate( $this->mInfo['event_time']);
		} else {
			$pParamHash['event_time'] = $gBitSystem->getUTCTime();
		}

		// check some lengths, if too long, then truncate
		if( $this->isValid() && !empty( $this->mInfo['description'] ) && empty( $pParamHash['description'] ) ) {
			// someone has deleted the description, we need to null it out
			$pParamHash['events_store']['description'] = '';
		} else if( empty( $pParamHash['description'] ) ) {
			unset( $pParamHash['description'] );
		} else {
			$pParamHash['events_store']['description'] = substr( $pParamHash['description'], 0, 200 );
		}

		if( !empty( $pParamHash['data'] ) ) {
			$pParamHash['edit'] = $pParamHash['data'];
		}

		// check for name issues, first truncate length if too long
		if( !empty( $pParamHash['title'] ) ) {
			if( empty( $this->mEventsId ) ) {
				if( empty( $pParamHash['title'] ) ) {
					$this->mErrors['title'] = 'You must enter a name for this page.';
				} else {
					$pParamHash['content_store']['title'] = substr( $pParamHash['title'], 0, 160 );
				}
			} else {
				$pParamHash['content_store']['title'] =( isset( $pParamHash['title'] ) )? substr( $pParamHash['title'], 0, 160 ): '';
			}
		} else if( empty( $pParamHash['title'] ) ) {
			// no name specified
			$this->mErrors['title'] = 'You must specify a name';
		}

		return( count( $this->mErrors )== 0 );
	}

	/**
	* This function removes a events entry
	**/
	function expunge() {
		$ret = FALSE;
		if( $this->isValid() ) {
			$this->mDb->StartTrans();
			$query = "DELETE FROM `".BIT_DB_PREFIX."events_on` WHERE `content_id` = ?";
			$result = $this->mDb->query( $query, array( $this->mContentId ) );
			$query = "DELETE FROM `".BIT_DB_PREFIX."events_invites` WHERE `content_id` = ?";
			$result = $this->mDb->query( $query, array( $this->mContentId ) );
			$query = "DELETE FROM `".BIT_DB_PREFIX."events` WHERE `content_id` = ?";
			$result = $this->mDb->query( $query, array( $this->mContentId ) );
			if( LibertyContent::expunge() ) {
				$ret = TRUE;
				$this->mDb->CompleteTrans();
			} else {
				$this->mDb->RollbackTrans();
			}
		}
		return $ret;
	}

	/**
	* Make sure events is loaded and valid
	**/
	function isValid() {
		return( $this->verifyId( $this->mContentId ) );
	}

	/**
	* This function generates a list of records from the liberty_content database for use in a list page
	**/
	function getList( &$pParamHash ) {
		global $gBitSystem, $gBitUser;
		
		if ( empty( $pParamHash['sort_mode'] ) ) {
			if ( empty( $_REQUEST["sort_mode"] ) ) {
				$pParamHash['sort_mode'] = 'uprn_desc';
			} else {
			$pParamHash['sort_mode'] = $_REQUEST['sort_mode'];
			}
		}

		LibertyContent::prepGetList( $pParamHash );

		$selectSql = '';
		$joinSql = '';
		$whereSql = '';
		$bindVars = array();
		array_push( $bindVars, $this->mContentTypeGuid );
		$this->getServicesSql( 'content_list_sql_function', $selectSql, $joinSql, $whereSql, $bindVars );

		// this will set $find, $sort_mode, $max_records and $offset
		extract( $pParamHash );

		if( is_array( $find ) ) {
			// you can use an array of pages
			$whereSql .= " AND lc.`title` IN( ".implode( ',',array_fill( 0,count( $find ),'?' ) )." )";
			$bindVars = array_merge( $bindVars, $find );
		} else if( is_string( $find ) ) {
			// or a string
			$whereSql .= " AND UPPER( lc.`title` )like ? ";
			$bindVars[] = '%' . strtoupper( $find ). '%';
		} else if( @$this->verifyId( $pUserId ) ) {
			// or a string
			$whereSql .= " AND lc.`creator_user_id` = ? ";
			$bindVars[] = array( $pUserId );
		}
		
		$query = "SELECT e.*, lc.`content_id`, lc.`title`, lc.`data`, lc.`modifier_user_id` AS `modifier_user_id`, lc.`user_id` AS`creator_user_id`,
			lc.`last_modified` AS `last_modified`, lc.`event_time` AS `event_time`, lc.`format_guid`, lcps.`pref_value` AS `show_start_time`, lcpe.`pref_value` AS `show_end_time`  $selectSql
			$selectSql
			FROM `".BIT_DB_PREFIX."events` e
			INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON( lc.`content_id` = e.`content_id` ) 
			LEFT JOIN `".BIT_DB_PREFIX."liberty_content_prefs` lcps ON (lc.`content_id` = lcps.`content_id` AND lcps.`pref_name` = 'show_start_time')
			LEFT JOIN `".BIT_DB_PREFIX."liberty_content_prefs` lcpe ON (lc.`content_id` = lcpe.`content_id` AND lcpe.`pref_name` = 'show_end_time')
			$joinSql
			WHERE lc.`content_type_guid` = ? $whereSql
			ORDER BY ".$this->mDb->convertSortmode( $sort_mode );
		$query_cant = "SELECT COUNT( * )
				FROM `".BIT_DB_PREFIX."events` e
				INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON( lc.`content_id` = e.`content_id` ) $joinSql
				WHERE lc.`content_type_guid` = ? $whereSql";
		$result = $this->mDb->query( $query, $bindVars, $max_records, $offset );
		$ret = array();
		while( $res = $result->fetchRow() ) {
			if (!empty($parse_split)) {
				$res = array_merge($this->parseSplit($res), $res);
			}
			$ret[] = $res;
		}
		$pParamHash["data"] = $ret;

		$pParamHash["cant"] = $this->mDb->getOne( $query_cant, $bindVars );

		LibertyContent::postGetList( $pParamHash );
		return $ret;
	}

	/**
	* Generates the URL to the events page
	* @param pExistsHash the hash that was returned by LibertyContent::pageExists
	* @return the link to display the page.
	*/
	function getDisplayUrl( $pEventsId = NULL, $pParamHash = NULL ) {
		$ret = NULL;
		if( @$this->verifyId( $this->mUSRN ) ) {
			$ret = NLPG_PKG_URL."index.php?usrn=".$this->mUSRN;
		} else if ( @$this->verifyId( $this->mUPRN ) ) {
			$ret = NLPG_PKG_URL."index.php?uprn=".$this->mUPRN;
		} else {
			$ret = LibertyContent::getDisplayUrl( NULL, $pParamHash );
		}
		return $ret;
	}

	/* Limits content status types for users who can not enter all status */
	function getAvailableContentStatuses() {
		global $gBitSystem;
		if ($gBitSystem->isFeatureActive('events_moderation')) {
			return LibertyContent::getAvailableContentStatuses(-100,0);
		}
		return parent::getAvailableContentStatuses();
	}

	function getRenderFile() {
		return EVENTS_PKG_PATH."display_events_inc.php";
	}
	
	/**
	 * Process csv records from extract
	 */
	/**
	 * StreetRecordLoad( $data ); 
	 * type 11 csv record 
	 */
	function StreetRecordLoad( &$data ) {
		$table = BIT_DB_PREFIX."nlpg_street";
		
		$pDataHash['data_store']['usrn'] = $data[3];
		$pDataHash['data_store']['record_type'] = $data[4];
		$pDataHash['data_store']['swa_org_ref_naming'] = $data[5];
		$pDataHash['data_store']['state'] = $data[6];
		$pDataHash['data_store']['state_date'] = $data[7];
		$pDataHash['data_store']['street_surface'] = $data[8];
		$pDataHash['data_store']['street_classification'] = $data[9];
		$pDataHash['data_store']['version'] = $data[10];
		$pDataHash['data_store']['record_entry_date'] = $data[11];
		$pDataHash['data_store']['last_update_date'] = $data[12];
		$pDataHash['data_store']['street_start_date'] = $data[13];
		$pDataHash['data_store']['street_end_date'] = $data[14];
		$pDataHash['data_store']['street_start_x'] = $data[15];
		$pDataHash['data_store']['street_start_y'] = $data[16];
		$pDataHash['data_store']['street_end_x'] = $data[17];
		$pDataHash['data_store']['street_end_y'] = $data[18];
		$pDataHash['data_store']['street_tolerance'] = $data[19];
		if ( $data[1] == 'I' ) {
			$result = $this->mDb->associateInsert( $table, $pDataHash['data_store'] );
		} else if ( $data[1] == 'U' ) {
			$result = $this->mDb->associateUpdate( $table, $pDataHash['data_store'], array( 'usrn' => $pDataHash['usrn'] ) );
		}
	}
	/**
	 * StreetRecordXrefLoad( $data );
	 * type 12 csv record 
	 */
	function StreetRecordXrefLoad( &$data ) {
		$table = BIT_DB_PREFIX."nlpg_street_xref";
		
		$pDataHash['data_store']['usrn'] = $data[3];
		$pDataHash['data_store']['xref_type'] = $data[4];
		$pDataHash['data_store']['usrn_version_number'] = $data[5];
		$pDataHash['data_store']['xref_id'] = $data[6];
		$pDataHash['data_store']['xref_version_number'] = $data[7];
		$pDataHash['data_store']['entry_date'] = $data[8];
		if ( $data[1] == 'I' ) {
			$result = $this->mDb->associateInsert( $table, $pDataHash['data_store'] );
		} else if ( $data[1] == 'U' ) {
			$result = $this->mDb->associateUpdate( $table, $pDataHash['data_store'], array( 'usrn' => $pDataHash['usrn'] ) );
		}
	}
	/**
	 * StreetRecordLoad( $data ); 
	 * type 15 csv record 
	 */
	function StreetRecordDescriptorLoad( &$data ) {
		$table = BIT_DB_PREFIX."nlpg_street_descriptor";
		
		$pDataHash['data_store']['usrn'] = $data[3];
		$pDataHash['data_store']['street_descriptor'] = $data[4];
		$pDataHash['data_store']['locality_name'] = $data[5];
		$pDataHash['data_store']['town_name'] = $data[6];
		$pDataHash['data_store']['administrative_area'] = $data[7];
		$pDataHash['data_store']['language'] = $data[8];
		if ( $data[1] == 'I' ) {
			$result = $this->mDb->associateInsert( $table, $pDataHash['data_store'] );
		} else if ( $data[1] == 'U' ) {
			$result = $this->mDb->associateUpdate( $table, $pDataHash['data_store'], array( 'usrn' => $pDataHash['usrn'], 'language' => $pDataHash['language'] ) );
		}
	}
	/**
	 * BlpuRecordLoad( $data ); 
	 * type 21 csv record 
	 */
	function BlpuRecordLoad( &$data ) {
		$table = BIT_DB_PREFIX."nlpg_blpu";

		$pDataHash['data_store']['uprn'] = $data[3];
		$pDataHash['data_store']['logical_status'] = $data[4];
		$pDataHash['data_store']['blpu_state'] = $data[5];
		$pDataHash['data_store']['blpu_state_date'] = $data[6];
		$pDataHash['data_store']['blpu_class'] = $data[7];
		$pDataHash['data_store']['parent_uprn'] = $data[8];
		$pDataHash['data_store']['x_coordinate'] = $data[9];
		$pDataHash['data_store']['y_coordinate'] = $data[10];
		$pDataHash['data_store']['rpa'] = $data[11];
		$pDataHash['data_store']['local_custodian_code'] = $data[12];
		$pDataHash['data_store']['start_date'] = $data[13];
		$pDataHash['data_store']['end_date'] = $data[14];
		$pDataHash['data_store']['last_update_date'] = $data[15];
		$pDataHash['data_store']['entry_date'] = $data[16];
		$pDataHash['data_store']['organisation'] = $data[17];
		$pDataHash['data_store']['ward_code'] = $data[18];
		$pDataHash['data_store']['parish_code'] = $data[19];
		$pDataHash['data_store']['custodian_one'] = $data[20];
		$pDataHash['data_store']['custodian_two'] = $data[21];
		$pDataHash['data_store']['can_key'] = $data[22];
		if ( $data[1] == 'I' ) {
			$result = $this->mDb->associateInsert( $table, $pDataHash['data_store'] );
		} else if ( $data[1] == 'U' ) {
			$result = $this->mDb->associateUpdate( $table, $pDataHash['data_store'], array( 'usrn' => $pDataHash['usrn'] ) );
		}
	}
	/**
	 * BlpuProvenanceRecordLoad( $data ); 
	 * type 23 csv record 
	 */
	function BlpuProvenanceRecordLoad( &$data ) {
		$table = BIT_DB_PREFIX."nlpg_blpu_provenance";

		$pDataHash['data_store']['uprn'] = $data[3];
		$pDataHash['data_store']['prov_key'] = $data[4];
		$pDataHash['data_store']['provenance_code'] = $data[5];
		$pDataHash['data_store']['annotation'] = $data[6];
		$pDataHash['data_store']['entry_date'] = $data[7];
		$pDataHash['data_store']['start_date'] = $data[8];
		$pDataHash['data_store']['end_date'] = $data[9];
		$pDataHash['data_store']['last_update_date'] = $data[10];
		if ( $data[1] == 'I' ) {
			$result = $this->mDb->associateInsert( $table, $pDataHash['data_store'] );
		} else if ( $data[1] == 'U' ) {
			$result = $this->mDb->associateUpdate( $table, $pDataHash['data_store'], array( 'usrn' => $pDataHash['usrn'], 'language' => $pDataHash['language'] ) );
		}
	}
	/**
	 * BlpuXrefRecordLoad( $data ); 
	 * type 23 csv record 
	 */
	function BlpuXrefRecordLoad( &$data ) {
		$table = BIT_DB_PREFIX."nlpg_blpu_xref";
		
		$pDataHash['data_store']['uprn'] = $data[3];
		$pDataHash['data_store']['xref_key'] = $data[4];
		$pDataHash['data_store']['start_date'] = $data[5];
		$pDataHash['data_store']['last_update_date'] = $data[6];
		$pDataHash['data_store']['entry_date'] = $data[7];
		$pDataHash['data_store']['end_date'] = $data[8];
		$pDataHash['data_store']['cross_reference'] = $data[9];
		$pDataHash['data_store']['source'] = $data[10];
		if ( $data[1] == 'I' ) {
			$result = $this->mDb->associateInsert( $table, $pDataHash['data_store'] );
		} else if ( $data[1] == 'U' ) {
			$result = $this->mDb->associateUpdate( $table, $pDataHash['data_store'], array( 'usrn' => $pDataHash['usrn'], 'language' => $pDataHash['language'] ) );
		}
	}
	/**
	 * LpiRecordLoad( $data ); 
	 * type 24 csv record 
	 */
	function LpiRecordLoad( &$data ) {
		$table = BIT_DB_PREFIX."nlpg_lpi";

		$pDataHash['data_store']['uprn'] = $data[3];
		$pDataHash['data_store']['xref_key'] = $data[4];
		$pDataHash['data_store']['language'] = $data[5];
		$pDataHash['data_store']['logical_status'] = $data[6];
		$pDataHash['data_store']['start_date'] = $data[7];
		$pDataHash['data_store']['end_date'] = $data[8];
		$pDataHash['data_store']['entry_date'] = $data[9];
		$pDataHash['data_store']['last_update_date'] = $data[10];
		$pDataHash['data_store']['sao_start_number'] = $data[11];
		$pDataHash['data_store']['sao_start_suffix'] = $data[12];
		$pDataHash['data_store']['sao_end_number'] = $data[13];
		$pDataHash['data_store']['sao_end_suffix'] = $data[14];
		$pDataHash['data_store']['sao_text'] = $data[15];
		$pDataHash['data_store']['pao_start_number'] = $data[16];
		$pDataHash['data_store']['pao_start_suffix'] = $data[17];
		$pDataHash['data_store']['pao_end_number'] = $data[18];
		$pDataHash['data_store']['pao_end_suffix'] = $data[19];
		$pDataHash['data_store']['pao_text'] = $data[20];
		$pDataHash['data_store']['usrn'] = $data[21];
		$pDataHash['data_store']['v_level'] = $data[22];
		$pDataHash['data_store']['postally_addressable'] = $data[23];
		$pDataHash['data_store']['postcode'] = $data[24];
		$pDataHash['data_store']['post_town'] = $data[25];
		$pDataHash['data_store']['official_flag'] = $data[26];
		$pDataHash['data_store']['custodian_one'] = $data[27];
		$pDataHash['data_store']['custodian_two'] = $data[28];
		$pDataHash['data_store']['can_key'] = $data[29];
		if ( $data[1] == 'I' ) {
			$result = $this->mDb->associateInsert( $table, $pDataHash['data_store'] );
		} else if ( $data[1] == 'U' ) {
			$result = $this->mDb->associateUpdate( $table, $pDataHash['data_store'], array( 'usrn' => $pDataHash['usrn'] ) );
		}
	}
	/**
	 * OnsLARecordLoad( $data );
	 * Office of national statistics Local Authority csv record 
	 */
	function OnsLARecordLoad( &$data ) {
		$table = BIT_DB_PREFIX."nlpg_ons_local_authority";
		
		$pDataHash['data_store']['l_id'] = $data[0];
		$pDataHash['data_store']['c_id'] = substr($data[0], 0, 2 );
		$pDataHash['data_store']['title'] = $data[1];
		$result = $this->mDb->associateInsert( $table, $pDataHash['data_store'] );
	}
	/**
	 * OnsWardRecordLoad( $data );
	 * Office of national statistics ward entry csv record 
	 */
	function OnsWardRecordLoad( &$data ) {
		$table = BIT_DB_PREFIX."nlpg_ons_ward";
		
		$pDataHash['data_store']['w_id'] = $data[0];
		$pDataHash['data_store']['l_id'] = substr($data[0], 0, 4 );
		$pDataHash['data_store']['c_id'] = substr($data[0], 0, 2 );
		$pDataHash['data_store']['title'] = $data[1];
		$result = $this->mDb->associateInsert( $table, $pDataHash['data_store'] );
	}
	/**
	 * OnsParishRecordLoad( $data );
	 * Office of national statistics parish entry csv record 
	 */
	function OnsParishRecordLoad( &$data ) {
		$table = BIT_DB_PREFIX."nlpg_ons_parish";
		
		$pDataHash['data_store']['p_id'] = $data[0];
		$pDataHash['data_store']['l_id'] = substr($data[0], 0, 4 );
		$pDataHash['data_store']['c_id'] = substr($data[0], 0, 2 );
		$pDataHash['data_store']['title'] = $data[1];
		$result = $this->mDb->associateInsert( $table, $pDataHash['data_store'] );
	}
	
	/**
	 * OnsRecordsFix( $data );
	 * Hard coded fixes to place the unitary authority entries in the right 'county' 
	 * Adds counties for Wales, Scotland and Northern Ireland 
	 */
	function OnsRecordsFix() {
		$fix = "UPDATE `".BIT_DB_PREFIX."nlpg_ons_local_authority` SET C_ID = '01' WHERE L_ID BETWEEN '00AA' AND '00BK'" ;
		$result = $this->mDb->query( $fix );
		$fix = "UPDATE `".BIT_DB_PREFIX."nlpg_ons_local_authority` SET C_ID = '02' WHERE L_ID BETWEEN '00BL' AND '00BW'" ;
		$result = $this->mDb->query( $fix );
		$fix = "UPDATE `".BIT_DB_PREFIX."nlpg_ons_local_authority` SET C_ID = '03' WHERE L_ID BETWEEN '00BX' AND '00CB'" ;
		$result = $this->mDb->query( $fix );
		$fix = "UPDATE `".BIT_DB_PREFIX."nlpg_ons_local_authority` SET C_ID = '04' WHERE L_ID BETWEEN '00CC' AND '00CG'" ;
		$result = $this->mDb->query( $fix );
		$fix = "UPDATE `".BIT_DB_PREFIX."nlpg_ons_local_authority` SET C_ID = '05' WHERE L_ID BETWEEN '00CH' AND '00CM'" ;
		$result = $this->mDb->query( $fix );
		$fix = "UPDATE `".BIT_DB_PREFIX."nlpg_ons_local_authority` SET C_ID = '06' WHERE L_ID BETWEEN '00CN' AND '00CW'" ;
		$result = $this->mDb->query( $fix );
		$fix = "UPDATE `".BIT_DB_PREFIX."nlpg_ons_local_authority` SET C_ID = '07' WHERE L_ID BETWEEN '00CX' AND '00DB'" ;
		$result = $this->mDb->query( $fix );
		$fix = "UPDATE `".BIT_DB_PREFIX."nlpg_ons_local_authority` SET C_ID = '98' WHERE L_ID STARTING '00N' OR WHERE L_ID STARTING '00P'" ;
		$result = $this->mDb->query( $fix );
		$fix = "UPDATE `".BIT_DB_PREFIX."nlpg_ons_local_authority` SET C_ID = '99' WHERE L_ID STARTING '00Q' OR WHERE L_ID STARTING '00R'" ;
		$result = $this->mDb->query( $fix );
		$fix = "UPDATE `".BIT_DB_PREFIX."nlpg_ons_ward` w SET C_ID = ( SELECT `C_ID` FROM `".BIT_DB_PREFIX."nlpg_ons_local_authority` WHERE `L_ID` = w.`L_ID` )" ;
		$result = $this->mDb->query( $fix );
		$fix = "UPDATE `".BIT_DB_PREFIX."nlpg_ons_parish` p SET C_ID = ( SELECT `C_ID` FROM `".BIT_DB_PREFIX."nlpg_ons_local_authority` WHERE `L_ID` = p.`L_ID` )" ;
		$result = $this->mDb->query( $fix );
	}
	
	/**
	 * OnsExpunge();
	 * Clear office of national statistics entries 
	 */
	function OnsExpunge() {
		$query = "DELETE FROM `".BIT_DB_PREFIX."nlpg_ons_local_authority`";
		$result = $this->mDb->query( $query );
		$query = "DELETE FROM `".BIT_DB_PREFIX."nlpg_ons_ward`";
		$result = $this->mDb->query( $query );
		$query = "DELETE FROM `".BIT_DB_PREFIX."nlpg_ons_parish`";
		$result = $this->mDb->query( $query );
	}

	/**
	* Generates the URL to a usrn record reference
	* @param usrn
	* @return the link to display the page.
	*/
	function getUsrnEntryUrl( $usrn = NULL ) {
		$ret = NULL;
		if ( is_numeric( $usrn ) ) {
			$ret = NLPG_PKG_URL."index.php?uprn=".$this->mUPRN;
		} else {
			$ret = NLPG_PKG_URL."index.php";
		}
		return $ret;
	}

	/**
	* Generates the URL to a uprn record reference
	* @param usrn
	* @return the link to display the page.
	*/
	function getUprnEntryUrl( $uprn = NULL ) {
		$ret = NULL;
		if ( is_numeric( $uprn ) ) {
			$ret = NLPG_PKG_URL."index.php?uprn=".$uprn;
		} else {
			$ret = NLPG_PKG_URL."index.php";
		}
		return $ret;
	}

	/**
	* Generates the URL to a uprn record reference
	* @param usrn
	* @return the link to display the page.
	*/
	function getGridEntryUrl( $gridref = NULL ) {
		$ret = NULL;
		if ( is_numeric( $uprn ) ) {
			$ret = "http://www.geograph.org.uk/gridref/".$gridref;
		} else {
			$ret = NLPG_PKG_URL."index.php";
		}
		return $ret;
	}

	/**
	 * getOsnList( &$pParamHash );
	 * Get county list 
	 */
	function getOsnList( &$pParamHash ) {
		global $gBitSystem, $gBitUser;
		
		if ( empty( $pParamHash['sort_mode'] ) ) {
			if ( empty( $_REQUEST["sort_mode"] ) ) {
				$pParamHash['sort_mode'] = 'title_asc';
			} else {
			$pParamHash['sort_mode'] = $_REQUEST['sort_mode'];
			}
		}
		
		LibertyContent::prepGetList( $pParamHash );

		$findSql = '';
		$selectSql = '';
		$joinSql = '';
		$whereSql = '';
		$bindVars = array();
//		array_push( $bindVars, $this->mContentTypeGuid );
//		$this->getServicesSql( 'content_list_sql_function', $selectSql, $joinSql, $whereSql, $bindVars );

		// this will set $find, $sort_mode, $max_records and $offset
		extract( $pParamHash );

		if ( $pParamHash['list'] == 'street' ) {
			if( is_array( $find ) ) {
				// you can use an array of pages
				$findSql .= " AND `d.street_descriptor` IN( ".implode( ',',array_fill( 0,count( $find ),'?' ) )." )";
				$bindVars = array_merge( $bindVars, $find );
			} else if( is_string( $find ) ) {
				// or a string
				$findSql .= " AND UPPER( `d.street_descriptor` )like ? ";
				$bindVars[] = '%' . strtoupper( $find ). '%';
			}
		} else if ( $pParamHash['list'] == 'postcode' ) {
			if( is_array( $find ) ) {
				// you can use an array of pages
				$whereSql .= " WHERE p.`add2` IN( ".implode( ',',array_fill( 0,count( $find ),'?' ) )." )";
				$bindVars = array_merge( $bindVars, $find );
			} else if( is_string( $find ) ) {
				// or a string
				$whereSql .= " WHERE UPPER( p.`add2` )like ? ";
				$bindVars[] = '%' . strtoupper( $find ). '%';
			}
		} else if ( $pParamHash['list'] == 'local' ) {
			if( is_string( $find ) and $find <> '' ) {
				// or a string
				$whereSql .= " WHERE UPPER( l.`title` ) like ? ";
				$bindVars[] = '%' . strtoupper( $find ). '%';
			}
			else if ( isset( $c_id ) and is_string( $c_id ) and $c_id <> '' ) {
				$whereSql .= " WHERE UPPER( l.`c_id` ) = ? ";
				$bindVars[] = strtoupper( $c_id );
			}
		} else if ( $pParamHash['list'] == 'ward' ) {
			if ( is_string( $find ) and $find <> '' ) {
				// or a string
				$whereSql .= " WHERE UPPER( w.`title` ) like ? ";
				$bindVars[] = '%' . strtoupper( $find ). '%';
			}
			else if ( isset( $l_id ) and is_string( $l_id ) and $l_id <> '' ) {
				$whereSql .= " WHERE UPPER( w.`l_id` ) = ? ";
				$bindVars[] = strtoupper( $l_id );
			}
		} else if ( $pParamHash['list'] == 'parish' ) {
			if( is_string( $find ) and $find <> '' ) {
				// or a string
				$whereSql .= " WHERE UPPER( p.`title` ) like ? ";
				$bindVars[] = '%' . strtoupper( $find ). '%';
			}
		} else if ( $pParamHash['list'] == 'blpu_class' ) {
			if( is_string( $find ) and $find <> '' ) {
				// or a string
				$whereSql .= " WHERE ( UPPER( c.`pd` ) like ? OR UPPER( c.`sd` ) like ?  OR UPPER( c.`td` ) like ? )";
				$bindVars[] = '%' . strtoupper( $find ). '%';
				$bindVars[] = '%' . strtoupper( $find ). '%';
				$bindVars[] = '%' . strtoupper( $find ). '%';
			}
		} else {
			if( is_string( $find ) and $find <> '' ) {
				// or a string
				$whereSql .= " WHERE UPPER( `title` )like ? ";
				$bindVars[] = '%' . strtoupper( $find ). '%';
			}
		} 
/*		} else if( @$this->verifyId( $pUserId ) ) {
			// or a string
			$whereSql .= " AND lc.`creator_user_id` = ? ";
			$bindVars[] = array( $pUserId );
		}
*/		
		if ( $pParamHash['list'] == 'county' ) {
			$query = "SELECT c.* $selectSql 
				FROM `".BIT_DB_PREFIX."nlpg_ons_county` c
				$joinSql $whereSql ORDER BY ".$this->mDb->convertSortmode( $sort_mode );
			$query_cant = "SELECT COUNT( * )
				FROM `".BIT_DB_PREFIX."nlpg_ons_county` c $joinSql $whereSql";
		} else if ( $pParamHash['list'] == 'local' ) {
			$query = "SELECT l.*, c.title AS county $selectSql 
				FROM `".BIT_DB_PREFIX."nlpg_ons_local_authority` l 
				LEFT JOIN `".BIT_DB_PREFIX."nlpg_ons_county` c ON l.c_id = c.c_id AND l.c_id > 0
				$joinSql $whereSql ORDER BY ".$this->mDb->convertSortmode( $sort_mode );
			$query_cant = "SELECT COUNT( * )
				FROM `".BIT_DB_PREFIX."nlpg_ons_local_authority` l $joinSql $whereSql";
		} else if ( $pParamHash['list'] == 'ward' ) {
			$query = "SELECT w.*, l.title AS local_authority, c.title AS county $selectSql 
				FROM `".BIT_DB_PREFIX."nlpg_ons_ward` w 
				INNER JOIN `".BIT_DB_PREFIX."nlpg_ons_local_authority` l ON w.l_id = l.l_id
				LEFT JOIN `".BIT_DB_PREFIX."nlpg_ons_county` c ON l.c_id = c.c_id AND l.c_id > 0
				$joinSql $whereSql ORDER BY ".$this->mDb->convertSortmode( $sort_mode );
			$query_cant = "SELECT COUNT( * )
				FROM `".BIT_DB_PREFIX."nlpg_ons_ward` w $joinSql $whereSql";
		} else if ( $pParamHash['list'] == 'parish' ) {
			$query = "SELECT p.*, l.title AS local_authority, c.title AS county $selectSql 
				FROM `".BIT_DB_PREFIX."nlpg_ons_parish` p 
				INNER JOIN `".BIT_DB_PREFIX."nlpg_ons_local_authority` l ON p.l_id = l.l_id
				LEFT JOIN `".BIT_DB_PREFIX."nlpg_ons_county` c ON l.c_id = c.c_id AND l.c_id > 0
				$joinSql $whereSql ORDER BY ".$this->mDb->convertSortmode( $sort_mode );
			$query_cant = "SELECT COUNT( * )
				FROM `".BIT_DB_PREFIX."nlpg_ons_parish` p $joinSql $whereSql";
		} else if ( $pParamHash['list'] == 'blpu_class' ) {
			$query = "SELECT c.blpu_id, c.pd, c.sd, c.td AS title $selectSql 
				FROM `".BIT_DB_PREFIX."nlpg_blpu_class` c 
				$joinSql $whereSql ORDER BY ".$this->mDb->convertSortmode( $sort_mode );
			$query_cant = "SELECT COUNT( * )
				FROM `".BIT_DB_PREFIX."nlpg_blpu_class` c $joinSql $whereSql";
		} else if ( $pParamHash['list'] == 'street' ) {
			$query = "SELECT s.*, d.street_descriptor AS title, d.locality_name, d.town_name $selectSql 
				FROM `".BIT_DB_PREFIX."nlpg_street` s 
				INNER JOIN `".BIT_DB_PREFIX."nlpg_street_descriptor` d ON s.usrn = d.usrn AND d.language = 'ENG' $findSql 
				$joinSql $whereSql ORDER BY ".$this->mDb->convertSortmode( $sort_mode );
			$query_cant = "SELECT COUNT( * )
				FROM `".BIT_DB_PREFIX."nlpg_street` s
				INNER JOIN `".BIT_DB_PREFIX."nlpg_street_descriptor` d ON s.usrn = d.usrn AND d.language = 'ENG' $findSql 
				$joinSql $whereSql";
		} else if ( $pParamHash['list'] == 'postcode' ) {
			$query = "SELECT p.postcode, p.add1, p.add2 AS title, p.add3, p.add4, p.town, p.county, p.grideast, p.gridnorth $selectSql 
				FROM `".BIT_DB_PREFIX."nlpg_postcode` p 
				$joinSql $whereSql ORDER BY ".$this->mDb->convertSortmode( $sort_mode );
			$query_cant = "SELECT COUNT( * )
				FROM `".BIT_DB_PREFIX."nlpg_postcode` p $joinSql $whereSql";
		}
		$result = $this->mDb->query( $query, $bindVars, $max_records, $offset );
		$ret = array();
		while( $res = $result->fetchRow() ) {
			if (!empty($parse_split)) {
				$res = array_merge($this->parseSplit($res), $res);
			}
			if ( $pParamHash['list'] == 'street' ) {
				$os1 = new OSRef($res['street_start_x'], $res['street_start_y']);
				$ll1 = $os1->toLatLng();
				$res['street_start_lat'] = $ll1->lat;
				$res['street_start_lng'] = $ll1->lng;
				$os1->easting = $res['street_end_x'];
				$os1->northing = $res['street_end_y'];
				$ll1 = $os1->toLatLng();
				$res['street_end_lat'] = $ll1->lat;
				$res['street_end_lng'] = $ll1->lng;
				$res['display_usrn'] = $this->getUsrnEntryUrl( $res['usrn'] );
			} else if ( $pParamHash['list'] == 'postcode' ) {
				$os1 = new OSRef($res['grideast'], $res['gridnorth']);
				$ll1 = $os1->toLatLng();
				$res['pc_lat'] = $ll1->lat;
				$res['pc_lng'] = $ll1->lng;
			}
			$ret[] = $res;
		}

		$pParamHash["data"] = $ret;

		$pParamHash["cant"] = $this->mDb->getOne( $query_cant, $bindVars );

		LibertyContent::postGetList( $pParamHash );
		return $ret;
	}
	
	/**
	 * getPropertyList( &$pParamHash );
	 * Get list of property records 
	 */
	function getPropertyList( &$pParamHash ) {
		global $gBitSystem, $gBitUser;
		
		if ( empty( $pParamHash['sort_mode'] ) ) {
			if ( empty( $_REQUEST["sort_mode"] ) ) {
				$pParamHash['sort_mode'] = 'title_asc';
			} else {
			$pParamHash['sort_mode'] = $_REQUEST['sort_mode'];
			}
		}
		
		LibertyContent::prepGetList( $pParamHash );

		$findSql = '';
		$selectSql = '';
		$joinSql = '';
		$whereSql = '';
		$bindVars = array();

		// this will set $find, $sort_mode, $max_records and $offset
		extract( $pParamHash );

		$where = ' WHERE ';
		if( isset( $find_org ) and is_string( $find_org ) and $find_org <> '' ) {
			$findSql .= $where . "UPPER( p.`organisation` ) like ? ";
			$bindVars[] = '%' . strtoupper( $find_org ). '%';
			$where = ' AND ';
		}
		if( isset( $find_xao ) and is_string( $find_xao ) and $find_xao <> '' ) {
			$findSql .= $where . " ( UPPER( d.`sao` ) like ? OR UPPER( d.`pao` ) like ? ) ";
			$bindVars[] = '%' . strtoupper( $find_xao ). '%';
			$bindVars[] = '%' . strtoupper( $find_xao ). '%';
			$where = ' AND ';
		}
		if( isset( $find_street ) and is_string( $find_street ) and $find_street <> '' ) {
			$findSql .= $where . "UPPER( s.`street_descriptor` ) like ? ";
			$bindVars[] = '%' . strtoupper( $find_street ). '%';
			$where = ' AND ';
		}
		if( isset( $find_postcode ) and is_string( $find_postcode ) and $find_postcode <> '' ) {
			$findSql .= $where . "UPPER( `d.postcode` ) LIKE ? ";
			$bindVars[] = strtoupper( $find_postcode ). '%';
			$where = ' AND ';
		}
		// If no selected filter then reduce result set artificially - use street starting A
		if( $where == ' WHERE ' ) {
			$findSql .= $where . "UPPER( s.`street_descriptor` ) like ? ";
			$bindVars[] = 'A%';
			$pParamHash['find_street'] = 'A';
		}
		$query = "SELECT p.*, d.sao, d.pao AS title, d.postcode, s.* $selectSql 
			FROM `".BIT_DB_PREFIX."nlpg_blpu` p 
			INNER JOIN `".BIT_DB_PREFIX."nlpg_lpi` d ON d.uprn = p.uprn AND d.language = 'ENG' AND d.logical_status = 1 
			INNER JOIN `".BIT_DB_PREFIX."nlpg_street_descriptor` s ON s.usrn = d.usrn AND s.language = 'ENG' $findSql 
			$joinSql $whereSql ORDER BY ".$this->mDb->convertSortmode( $sort_mode );
		$query_cant = "SELECT COUNT( * )
			FROM `".BIT_DB_PREFIX."nlpg_blpu` p
			INNER JOIN `".BIT_DB_PREFIX."nlpg_lpi` d ON p.uprn = d.uprn AND d.language = 'ENG' AND d.logical_status = 1  
			INNER JOIN `".BIT_DB_PREFIX."nlpg_street_descriptor` s ON s.usrn = d.usrn AND s.language = 'ENG' $findSql 
			$joinSql $whereSql";
		$result = $this->mDb->query( $query, $bindVars, $max_records, $offset );
		$ret = array();
		while( $res = $result->fetchRow() ) {
			if (!empty($parse_split)) {
				$res = array_merge($this->parseSplit($res), $res);
			}
			$os1 = new OSRef($res['x_coordinate'], $res['y_coordinate']);
			$ll1 = $os1->toLatLng();
			$res['prop_lat'] = $ll1->lat;
			$res['prop_lng'] = $ll1->lng;
			$res['display_usrn'] = $this->getUsrnEntryUrl( $res['usrn'] );
			$res['display_uprn'] = $this->getUprnEntryUrl( $res['uprn'] );
			$ret[] = $res;
		}

		$pParamHash["cant"] = $this->mDb->getOne( $query_cant, $bindVars );

		LibertyContent::postGetList( $pParamHash );
		return $ret;
	}
	
}
?>
