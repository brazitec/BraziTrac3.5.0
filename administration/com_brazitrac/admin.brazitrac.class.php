<?php
/**
 * @version $Id: admin.brazitec.class.php 193 2009-11-27 13:55:33Z brazitrac $
 * @copyright Copyright (C) James Kennard
 * @license GNU/GPL, see LICENSE.php
 * @package wats
 */

// Don't allow direct linking
defined('_JEXEC') or die('Restricted Access');

/**
 * watsUser
 * @version 1.0
 */
class watsUser extends JUser
{
	var $groupName;
	var $agree;
	var $organisation;
	var $group;
	var $image;
	var $_userRites;

	/**
	 * @version 1.0
	 * @param watsId
	 */
	function watsUser()
	{
	    $this->__construct();
	}
	
	/**
	 *
	 * @param watsId
	 */
	function loadWatsUser( $uid )
	{
		$database = JFactory::getDBO();
		
		$returnValue = false;
		// load user
		$this->load( $uid );
		// load WatsUser
		$database->setQuery( "SELECT  u.*, g.name, g.userrites, g.image, g.name AS groupname FROM #__brazitrac_users AS u LEFT  JOIN #__brazitrac_groups AS g ON g.grpid = u.grpid WHERE u.watsid=".(int)$uid );
		$vars = $database->loadObjectList();
		// set attributes
		if ( isset( $vars[0] ) )
		{
		    $this->groupName = $vars[0]->groupname ;
		    $this->agree = $vars[0]->agree;
		    $this->organisation = $vars[0]->organisation;
			$this->group = $vars[0]->grpid;
			$this->image = $vars[0]->image;
			$this->groupName = $vars[0]->name;
			$this->userRites = $vars[0]->userrites;
			$returnValue = true;
			}
		return $returnValue;
	}
	
	/**
	 *
	 * @param catid
	 * @param rite
	 */
	function checkPermission( $catid, $rite )
	{
		$database = JFactory::getDBO();
	
		// prepare for no rite
		$returnValue = 0;
		// run SQL to find permission
		$database->setQuery( "SELECT type FROM #__brazitrac_permissions WHERE catid=".(int)$catid ." AND grpid=".(int)$this->group);
		$vars = $database->loadObjectList();
		// check for result
		if ( isset( $vars[0] ) ) {
			// find rite in string
			// checks type as well because could return 0
			if ( strpos( $vars[0]->type, strtolower( $rite) ) !== false )
			{
				// check for OWN rite
				$returnValue = 1;
			}
			else if ( strpos( $vars[0]->type, strtoupper( $rite) ) !== false )
			{
				// check for ALL rite
				$returnValue = 2;
			} // end find rite in string
		} // end check for result
		return $returnValue;
	}

	/**
	 *
	 * @param watsId
	 */
	function checkUserPermission( $rite )
	{
		// prepare for no rite
		$returnValue = 0;
		// find rite in string
		// checks type as well because could return 0
		if ( strpos( $this->userRites, strtolower( $rite) ) !== false )
		{
			// check for OWN rite
			$returnValue = 1;
		}
		else if ( strpos( $this->userRites, strtoupper( $rite) ) !== false )
		{
			// check for ALL rite
			$returnValue = 2;
		} // end find rite in string
		return $returnValue;
	}
	
	/**
	 *
	 * @param watsId
	 */
	function makeUser( $watsId, $grpId, $organisation) {
		$database = JFactory::getDBO();
	
		// check doesn't already exist
		$database->setQuery( "SELECT " . WDBHelper::nameQuote("wu.watsid") .
                             "FROM " . WDBHelper::nameQuote("#__brazitrac_users") . " AS " . WDBHelper::nameQuote("wu") . " " .
							 "WHERE " . WDBHelper::nameQuote("watsid") . " = " . intval($watsId) . " /* watsUser::makeUser() */");
		$database->query();
		if ( $database->getNumRows() == 0 )
		{
			// create SQL
			$database->setQuery( "INSERT INTO " . WDBHelper::nameQuote("#__brazitrac_users") . " " .
							     "          ( " . WDBHelper::nameQuote("watsid") . ", " .
												  WDBHelper::nameQuote("organisation") . ", " .
												  WDBHelper::nameQuote("agree") . ", " .
												  WDBHelper::nameQuote("grpid") ." ) " . 
								 "VALUES ( " . intval($watsId) . ", " .
								               $database->Quote($organisation) . ", " .
											   $database->Quote("0000-00-00") . ", " . 
											   intval($grpId) . " ) /* watsUser::makeUser */" );
			// execute
			$database->query();
			return true;
		}
		else
		{
			return false;
		} // end check doesn't already exist
	}
	
	/**
	 *
	 */
	function updateUser()
	{
		$database = JFactory::getDBO();
		
		// check already exists
		$database->setQuery("SELECT " . WDBHelper::nameQuote("wu.watsid") .
					  "FROM " . WDBHelper::nameQuote("#__brazitrac_users") . " AS " . WDBHelper::nameQuote("wu") . " " .
					  "WHERE " . WDBHelper::nameQuote("watsid") . " = " . intval($this->id) . " /* watsUser::updateUser() */ ");
		$database->query();
		if ($database->getNumRows() == 1) {
			// update SQL
			$database->setQuery("UPDATE " . WDBHelper::nameQuote("#__brazitrac_users") . " " .
			                     "SET " . WDBHelper::nameQuote("organisation") . " = " . $database->Quote($this->organisation) . ", " .
								          WDBHelper::nameQuote("agree") . " = " . intval($this->agree) . ", " .
										  WDBHelper::nameQuote("grpid") . " = " . intval($this->group) . " " .
								 "WHERE " . WDBHelper::nameQuote("watsid") . " = " . intval($this->id) . " /* watsUser::updateUser() */" );
			// execute
			return $database->query();	
		}
		else
		{
			return false;
		} // end check doesn't already exist
	}
	
	/**
	 *
	 * @param groupId
	 */
	function setGroup( $groupId ) {
		$database = JFactory::getDBO();
		
		// check group exists and get name
		$database->setQuery("SELECT " . WDBHelper::nameQuote("g.name") .", " .
		                          WDBHelper::nameQuote("g.image") . " " .
					  "FROM " . WDBHelper::nameQuote("#__brazitrac_groups") . " AS " . WDBHelper::nameQuote("g") ." " .
					  "WHERE " . WDBHelper::nameQuote("grpid") . " = " . intval($groupId) . " /* watsUser::setGroup() */");
		$groupDetails = $database->loadObjectList();
		if ( count( $groupDetails ) != 0 )
		{
			// update object
			$this->group = $groupId;
			$this->groupName = $groupDetails[0]->name;
			$this->image = $groupDetails[0]->image;
			// update SQL
			$database->setQuery("UPDATE " . WDBHelper::nameQuote("#__brazitrac_users") . " " .
			              "SET " . WDBHelper::nameQuote("organisation") . " = " . $database->Quote($this->organisation) . ", " .
							       WDBHelper::nameQuote("agree") . " = " . intval($this->agree) . ", " .
								   WDBHelper::nameQuote("grpid") . " = " . intval($this->group) . " " .
						  "WHERE " . WDBHelper::nameQuote("watsid") . " = " . intval($this->id) . " /* watsUser::setGroup() */" );
			// execute
			return $database->query();
		}
		else
		{
			return false;
		} // end check doesn't already exist
	}

	/**
	 *
	 * @param groupId
	 */
	function delete( $remove ) {
		$database = JFactory::getDBO();
	
		switch ( $remove )
		{
			case 'removeposts':
				// remove all posts
				$database->setQuery( "DELETE FROM #__brazitrac_msg WHERE watsid=".intval($this->id));
				$database->query();
			case 'removetickets':
				// find tickets
				$database->setQuery( "SELECT ticketid FROM #__brazitrac_ticket WHERE watsid=".intval($this->id));
				$tickets = $database->loadObjectList();
				$noOfTickets = count( $tickets );
				$i = 0;
				while ( $i < $noOfTickets )
				{
					// remove ticket messages
					$database->setQuery( "DELETE FROM #__brazitrac_msg WHERE ticketid=".intval($tickets[$i]->ticketid));
					$database->query();
					// remove highlights
					$database->setQuery( "DELETE FROM #__brazitrac_highlight WHERE ticketid=".intval($tickets[$i]->ticketid));
					$database->query();
					$i ++;
				}
				// remove tickets
				$database->setQuery( "DELETE FROM #__brazitrac_ticket WHERE watsid=".intval($this->id));
				$database->query();				
				break;
		}
		// delete users highlights
		// $database->setQuery( "DELETE FROM #__brazitrac_highlight WHERE watsid=".$this->id);
		// $database->query();
		// delete user
		$database->setQuery( "DELETE FROM #__brazitrac_users WHERE watsid=".intval($this->id));
		$database->query();
	}
}

/**
 * @version 1.0
 * @created 09-Jan-2006 15:30
 */
class watsUserSet
{
	var $userSet;
	var $noOfUsers;
	var $_db;

	/**
	 * @param database
	 */
	function watsUserSet() {
	}
	
	/**
	 * @param groupId
	 */
	function load( $groupId = null )
	{
		// load all users
	    if ( $groupId === null )
		{
			$database = JFactory::getDBO();
		
			$database->setQuery("SELECT u.*, wu.organisation, g.name AS groupname FROM " . WDBHelper::nameQuote("#__brazitrac_users") . " AS " . WDBHelper::nameQuote("wu") . " " .
                          "JOIN " . WDBHelper::nameQuote("#__users") . " AS " . WDBHelper::nameQuote("u") . " ON " . WDBHelper::nameQuote("u.id") . " = " . WDBHelper::nameQuote("wu.watsid") .
                          "JOIN " . WDBHelper::nameQuote("#__brazitrac_groups") . " AS " . WDBHelper::nameQuote("g") . " ON " . WDBHelper::nameQuote("g.grpid") . " = " . WDBHelper::nameQuote("wu.grpid") .
			              "ORDER BY " . WDBHelper::nameQuote("username") . " /* watsUserSet::load() */" );
			$set = $database->loadObjectList();
			$this->noOfUsers = count( $set );
			$i = 0;
			// create users
			while ( $i < $this->noOfUsers )
			{
				$this->userSet[$i] = new watsUserHTML();
				$this->userSet[$i]->id = $set[$i]->id;
                $this->userSet[$i]->name = $set[$i]->name;
                $this->userSet[$i]->username = $set[$i]->username;
                $this->userSet[$i]->email = $set[$i]->email;
                $this->userSet[$i]->usertype = $set[$i]->usertype;
                $this->userSet[$i]->block = $set[$i]->block;
                $this->userSet[$i]->sendEmail = $set[$i]->sendEmail;
                $this->userSet[$i]->gid = $set[$i]->gid;
                $this->userSet[$i]->registerDate = $set[$i]->registerDate;
                $this->userSet[$i]->lastvisitDate = $set[$i]->lastvisitDate;
                $this->userSet[$i]->activation = $set[$i]->activation;
                $this->userSet[$i]->params = $set[$i]->params;
                $this->userSet[$i]->organisation = $set[$i]->organisation;
                $this->userSet[$i]->groupName = $set[$i]->groupname;
                $this->userSet[$i]->guest = 0;
				$i ++;
			} // end create users
		} // end load all users
	}
}

/**
 * @version 1.0
 * @created 06-Dec-2005 21:42:51
 */
class watsObjectBuilder
{
	/**
	 *
	 * @param database
	 * @param ticketId
	 */
	 function ticket($ticketId ) {
		$database = JFactory::getDBO();
		
		// create query
		$query = "SELECT * FROM " . WDBHelper::nameQuote("#__brazitrac_ticket") . " " .
				 "WHERE " . WDBHelper::nameQuote("ticketid") . " = " . intval($ticketId) . " /* watsObjectBuilder::ticket() */ ";
		// execute query
		$database->setQuery( $query );
		$set = &$database->loadObjectList();
		// check there are results
		if ( $set != null )
		{
			// create ticket object
			return new watsTicketHTML(null, null, $set[0]->ticketname, $set[0]->watsid, null, null, $set[0]->lifecycle, $set[0]->ticketid, null, null, $set[0]->category, $set[0]->assign);
		} // end check there are results
		return null;
	 }
}

/**
 * Individual WATS Ticket Class
 * @version 1.0
 * @created 06-Dec-2005 21:42:32
 */
class watsTicket
{
	var $watsId;
	var $username;
	var $ticketId;
	var $name;
	var $category;
	var $lifeCycle;
	var $datetime;
	var $lastMsg;
	var $lastWatsId;
	var $assignId;
	var $msgNumberOf;
	var $_msgList;
	var $_db;

	/**
	 * 
	 * @param database
	 * @param username
	 * @param lastWatsId
	 * @param name
	 * @param watsId
	 * @param lastMsg
	 * @param datetime
	 * @param lifeCycle
	 * @param ticketId
	 * @param lastView
	 * @param create
	 */
	function watsTicket($username, $lastWatsId, $name, $watsId, $lastMsg, $datetime, $lifeCycle, $ticketId, $lastView, $msgNumberOf, $catId, $assignId = null)
	{
		$this->username = $username;
		$this->lastWatsId = $lastWatsId;
		$this->name = $name;
		$this->watsId = $watsId;
		$this->lastMsg = $lastMsg;
		$this->datetime = $datetime;
		$this->lifeCycle = $lifeCycle;
		$this->ticketId = $ticketId;
		$this->msgNumberOf = $msgNumberOf;
		$this->_msgList = array();
		$this->category = $catId;
		$this->assignId = $assignId;
	}

	/**
	 * returns username of assigned user.
	 */
	function getAssignedUsername()
	{
		// check for assignment
	    if ( $this->assignId != null )
		{
		    $database = JFactory::getDBO();
			// find username
			$database->setQuery("SELECT " . WDBHelper::nameQuote("u.username") . " " .
			                     "FROM " .WDBHelper::nameQuote("#__users") . " AS " . WDBHelper::nameQuote("u") . " " .
								 "WHERE " . WDBHelper::nameQuote("u.id") . " = " . intval($this->assignId) . " /* watsTicket::watsTicket() */ ");
			$user = $database->loadObjectList();
			$returnValue = $user[0]->username;
		}
		else
		{
			// return no assigned user
			$returnValue = "not assigned";
		}
		
		return $returnValue;
	}

	/**
	 * saves ticket to database
	 */
	function save()
	{
		$database =&JFactory::getDBO();
	
		// ticket
		$queryTicket = "INSERT INTO " . WDBHelper::nameQuote("#__brazitrac_ticket") . " " .
					   "SET " . WDBHelper::nameQuote("watsid") . " = " . intval($this->watsId) . ", " .
					            WDBHelper::nameQuote("ticketname") . " = " . $database->Quote($this->name) . ", " .
								WDBHelper::nameQuote("lifecycle") . " = " . intval($this->lifeCycle) . ", " .
								WDBHelper::nameQuote("datetime") . " = " . $database->Quote($this->datetime) . ", " .
								WDBHelper::nameQuote("category") . " = " . intval($this->category) . " /* watsTicket::save() */ ";
		$database->setQuery( $queryTicket );
		$database->query();
		$this->ticketId = $database->insertid();
		// message
		$queryMsg = "INSERT INTO " . WDBHelper::nameQuote("#__brazitrac_msg") . " " .
		            "SET " . WDBHelper::nameQuote("watsid") . " = " . intval($this->watsId) . ", " .
					         WDBHelper::nameQuote("ticketid") . " = " . intval($this->ticketId) . ", " .
							 WDBHelper::nameQuote("msg") . " = " . $database->Quote($this->_msgList[0]->msg) . ", " .
							 WDBHelper::nameQuote("datetime") . " = " . $database->Quote($this->datetime) . " /* watsTicket::save() */";
		$database->setQuery( $queryMsg );
		$database->query();
	}

	/**
	 * decreases view level
	 */
	function deactivate()
	{
		$database = JFactory::getDBO();
	
		// check is not dead
		if ( $this->lifeCycle < 3 )
		{
			// update lifeCycle
			$this->lifeCycle ++;
			$queryDeactivateTicket = "UPDATE " . WDBHelper::nameQuote("#__brazitrac_ticket") . " " . 
			                         "SET " . WDBHelper::nameQuote("lifecycle") . " = " . intval($this->lifeCycle) . " " .
									 "WHERE " . WDBHelper::nameQuote("ticketid") . " = " . intval($this->ticketId) . " /* watsTicket::deactivate() */ "; 
		}
		else
		{
			// remove ticket
			$queryDeactivateTicket = "DELETE FROM " . WDBHelper::nameQuote("#__brazitrac_ticket") . " " .
			                         "WHERE " . WDBHelper::nameQuote("ticketid") . " = " . intval($this->ticketId) . " /* watsTicket::deactivate()*/ ";
			// remove all messages in ticket
			$queryDeactivateMsg = "DELETE FROM " . WDBHelper::nameQuote("#__brazitrac_msg") . " " . 
								  "WHERE " . WDBHelper::nameQuote("ticketid") . " = " . intVal($message->ticketId) . " /* watsTicket::deactivate() */ ";
			$database->setQuery( $queryDeactivateMsg );
			$database->query();
		}
		$database->setQuery( $queryDeactivateTicket );
		$database->query();
	}

	/**
	 * Updates database to reflect viewing of ticket
	 */
	function _highlightUpdate( $watsId )
	{
		$database = JFactory::getDBO();
        $datetime = JFactory::getDate();
        $datetime = $datetime->toMySQL();
	
		// check for existing record
		$queryHighlight = "SELECT " . WDBHelper::nameQuote("datetime") . " " .
		                  "FROM " . WDBHelper::nameQuote("#__brazitrac_highlight") . " " .
						  "WHERE " . WDBHelper::nameQuote("ticketid") . " = " . intval($this->ticketId) . " AND " .
						             WDBHelper::nameQuote("watsid") . " = " . intval($watsId) . " /* watsTicket::_highlightUpdate() */ ";
		$database->setQuery( $queryHighlight );
		$database->query();
		if ( $database->getNumRows() > 0 )
		{
			// update record
			$queryHighlight = "UPDATE " . WDBHelper::nameQuote("#__brazitrac_highlight") . " " .
			                  "SET " . WDBHelper::nameQuote("datetime") . " = " . $database->Quote($datetime) . " " .
							  "WHERE " . WDBHelper::nameQuote("ticketid") . " = " . intval($this->ticketId) . " AND " .
							             WDBHelper::nameQuote("watsid") . " = " . intval($watsId) . " /* watsTicket::_highlightUpdate*/";
		}
		else
		{
			// insert record
			$queryHighlight = "INSERT INTO " . WDBHelper::nameQuote("#__brazitrac_highlight") . " " .
			                  "SET " . WDBHelper::nameQuote("watsid") . " = " . intval($watsId) . ", " . 
							           WDBHelper::nameQuote("ticketid") . " = " . intval($this->ticketId) . ", " .
									   WDBHelper::nameQuote("datetime") . " = " . $database->Quote($datetime) . " /* watsTicket::_highlightUpdate() */";
		}
		// perform query
		$database->setQuery( $queryHighlight );
		$database->query();

	}
	
	/**
	 * Reactivate ticket and updates database
	 */
	function reactivate()
	{
		$database = JFactory::getDBO();
		$this->lifeCycle = 1;
		$queryDeactivateMsg = "UPDATE " . WDBHelper::nameQuote("#__brazitrac_ticket") . " " .
		                      "SET " . WDBHelper::nameQuote("lifecycle") . " = 1 " .
							  "WHERE " . WDBHelper::nameQuote("ticketid") . " = " . intval($this->ticketId) . " /* watsTicket::reactivate() */ ";
		$database->setQuery( $queryDeactivateMsg );
		$database->query();
	}

	/**
	 * Populates _msgList with all related messages
	 */
	function loadMsgList()
	{
		$database = JFactory::getDBO();
		
		// reset number of messages
		$this->msgNumberOf = 0;
		// load categories
		$database->setQuery("SELECT * " .
		              "FROM " . WDBHelper::nameQuote("#__brazitrac_msg") . " AS " . WDBHelper::nameQuote("m") . " " .
					  "WHERE " . WDBHelper::nameQuote("ticketid") . " = " . intval($this->ticketId) . " " .
					  "ORDER BY " . WDBHelper::nameQuote("datetime") . " /* watsTicket::loadMsgList() */ " );
		$messages = $database->loadObjectList();
		// create message objects
		$i = 0;
		foreach( $messages as $message )
		{
			// create object
		    $this->_msgList[$i] = new watsMsg( $message->msgid, $message->msg, $message->watsid, $message->datetime );
			// increment counter
			$i ++;
			$this->msgNumberOf ++;
		}
	}
	
	/**
	 * Add message to _msgList and database
	 */
	function addMsg( $msg, $watsId, $datetime )
	{
		$database = JFactory::getDBO();
	
		// create SQL and execute
		$database->setQuery( "INSERT INTO " . WDBHelper::nameQuote("#__brazitrac_msg") . 
		 			   "    ( " . WDBHelper::nameQuote("ticketid") . ", " .
						          WDBHelper::nameQuote("watsid") . ", " .
						 		  WDBHelper::nameQuote("msg") . ", " .
								  WDBHelper::nameQuote("datetime") . 
					   "    ) " .
					   "VALUES ( " . intval($this->ticketId) . ", " . 
					                 intval($watsId) . ", " . 
									 $database->Quote($msg) . ", " . 
									 $database->Quote($datetime) . 
					   "       ) /* watsTicket::addMsg */ " );
		$database->query();
		$this->_msgList[ count( $this->_msgList ) ] = new watsMsg( $this->ticketId, $msg, $watsId, $datetime );
		$this->msgNumberOf ++;
	}
	
	/**
	 * Add message to _msgList and database
	 */
	function setAssignId( $assignId )
	{
		$database = JFactory::getDBO();
		$this->assignId = $assignId;
		// create SQL and execute
		$database->setQuery("UPDATE " . WDBHelper::nameQuote("#__brazitrac_ticket") . " " .
		              "SET " . WDBHelper::nameQuote("assign") . " = " . intval($this->assignId) . " " .
					  "WHERE " . WDBHelper::nameQuote("ticketid") . " = " . intval($this->ticketId) . " /* watsTicket::setAssignId() */ " );
		$database->query();

        // trigger onTicketAssign event
        JPluginHelper::importPlugin("brazitec");
        $app =& JFactory::getApplication();
        $args = array(&$this);
        $app->triggerEvent("onTicketAssign", $args);
	}
}

/**
 * Individual WATS User Group Category Permission Class
 * @version 1.0
 * @created 01-May-2006 17:42:08
 */
class watsUserGroupCategoryPermissionSet
{
	var $grpid;
	var $catid;
	var $groupname;
	var $categoryname;
	var $rites;
	var $_new;
	var $_db;

	/**
	 * 
	 */
	function watsUserGroupCategoryPermissionSet( $grpid, $catid )
	{
	    $database = JFactory::getDBO();
		
		$this->grpid = $grpid;
		$this->catid = $catid;
		$this->categoryRites = array();
		// load group details
		
		$database->setQuery( "SELECT p.type, g.name as groupname, c.name as categoryname " . 
		                     "FROM #__brazitrac_permissions AS p LEFT JOIN #__brazitrac_groups AS g ON p.grpid = g.grpid LEFT JOIN #__brazitrac_category AS c ON p.catid = c.catid " . 
							 "WHERE p.grpid = " . intval($this->grpid) . " AND p.catid = " . intval($this->catid) );
		$group = $database->loadObjectList();
		// check group exists
		if ( count($group) == 1 )
		{
			$this->groupname = $group[0]->groupname;
			$this->categoryname = $group[0]->categoryname;
			$this->rites = $group[0]->type;
			$this->_new = false;
		}
		else
		{
			$this->groupname = 'unknown group permission set';
			$this->categoryname = 'unknown group permission set';
			$this->_new = true;
		}
	}

	/**
	 *
	 */
	function checkPermission( $rite )
	{
		// prepare for no rite
		$returnValue = 0;
		// find rite in string
		// checks type as well because could return 0
		if ( strpos( $this->rites, strtolower( $rite) ) !== false )
		{
			// check for OWN rite
			$returnValue = 1;
		}
		else if ( strpos( $this->rites, strtoupper( $rite) ) !== false )
		{
			// check for ALL rite
			$returnValue = 2;
		} // end find rite in string
		return $returnValue;
	}
	
	/**
	 *
	 */
	function setPermission( $rite, $level )
	{
		$rites = array( 'V', 'M', 'R', 'C', 'D', 'P', 'A', 'O' );
		// check is valid rite
		$position = array_search( strtoupper( $rite ), $rites );
		if ( $position === false && strlen( $rite ) != 1 )
			return false;
		// check level
		if ( $level > 2 || $level < 0 )
			return false;
		// determine level
		if ( $level == 0 )
		{
			$level = '-';
		}
		elseif ( $level == 1 )
		{
			$level = strtolower( $rite );
		}
		elseif ( $level == 2 )
		{
			$level = strtoupper( $rite );
		}
		// check position
		$checkRite = substr( $this->rites, $position, 1 );
		if ( $checkRite == '-' || $checkRite == strtolower( $rite ) || $checkRite == strtoupper( $rite )  )
		{
			// change rite
			$tempRites = substr( $this->rites, 0, $position );
			$tempRites .= $level;
			$tempRites .= substr( $this->rites, $position + 1, strlen( $this->rites ) - ($position + 1)  );
			$this->rites = $tempRites;
		}
		else
		{
			// rites messed up, append to end (run db maintenance to resolve)
			$this->rites = $level;
		}
		return true;
	}
	
	/**
	 * 
	 */
	function save()
	{
	    $database = JFactory::getDBO();
		
		$database->setQuery( "UPDATE #__brazitrac_permissions SET type=".$database->Quote($this->rites)." WHERE catid=".intval($this->catid)." AND grpid=".intval($this->grpid));
		$database->query();
	}
	
	/**
	 * static
	 */
	function newPermissionSet( $grpId, $catId )
	{
	    $database = JFactory::getDBO();
		// check doesn't already exist
		$database->setQuery( "SELECT type FROM #__brazitrac_permissions WHERE catid=".intval($catId)." AND grpid=".intval($grpId));
		$database->query();
		if ( $database->getNumRows() == 0 )
		{
			// create SQL
			$database->setQuery( "INSERT INTO #__brazitrac_permissions ( catid, grpid, type ) VALUES ( '".intval($catId)."', '".intval($grpId)."', '--------' );" );
			// execute
			$database->query();
			return true;
		}
		else
		{
			// category with that name already exists
			return false;
		} // end check doesn't already exist
	}
}

/**
 * @version 1.0
 * @created 09-Jan-2006 15:30
 */
class watsUserGroupCategoryPermissionSetSet
{
	var $watsUserGroupCategoryPermissionSet;
	var $noOfSets;
	var $groupId;
	var $_db;

	/**
	 * @param database
	 */
	function watsUserGroupCategoryPermissionSetSet() {
	}
	
	/**
	 * @param groupId
	 */
	function load( $groupId )
	{
	    $database = JFactory::getDBO();
		
		$this->groupId = $groupId;
		// load all sets
		$database->setQuery( "SELECT catid FROM #__brazitrac_category ORDER BY catid" );
		$set = $database->loadObjectList();
		$this->noOfSets = count( $set );
		$i = 0;
		// create sets
		while ( $i < $this->noOfSets )
		{
			$this->watsUserGroupCategoryPermissionSet[$i] = new watsUserGroupCategoryPermissionSet( $groupId, $set[$i]->catid );
			//$this->userSet[$i]->loadWatsUser( $set[$i]->watsid  );
			$i ++;
		} // end create sets
		// end load all sets
	}
}

/**
 * Individual WATS User Group Class
 * @version 1.0
 * @created 01-May-2006 15:59:42
 */
class watsUserGroup
{
	var $grpid;
	var $name;
	var $image;
	var $userRites;
	var $categoryRites;
	var $_users;
	var $_new;
	var $_db;

	/**
	 * 
	 */
	function watsUserGroup( $grpid = -1 )
	{
	    $database = JFactory::getDBO();
		
		$this->grpid = $grpid;
		$this->categoryRites = array();
		$this->_users = array();
		// load group details
		$database->setQuery( "SELECT * FROM #__brazitrac_groups WHERE grpid = " . intval($this->grpid) );
		$group = $database->loadObjectList();
		// check group exists
		if ( count($group) == 1 )
		{
			$this->name = $group[0]->name;
			$this->image = $group[0]->image;
			$this->userRites = $group[0]->userrites;
			$this->_new = false;
			$this->categoryRites = new watsUserGroupCategoryPermissionSetSetHTML();
			$this->categoryRites->load( $grpid );
		}
	}
	
	/**
	 * 
	 */
	function newPermissionSet( $catId )
	{
		return watsUserGroupCategoryPermissionSet::newPermissionSet( $this->grpid , $catId );
	}

	/**
	 * Load group rites to categories
	 */
	function loadCategoryRites()
	{
		// reset number of messages
		$this->msgNumberOf = 0;
		// load categories
		$database->setQuery( "SELECT *, UNIX_TIMESTAMP(m.datetime) AS unixDatetime FROM #__brazitrac_msg AS m WHERE ticketid=".intval($this->ticketId)." ORDER BY datetime" );
		$messages = $database->loadObjectList();
		// create message objects
		$i = 0;
		foreach( $messages as $message )
		{
			// create object
		    $this->_msgList[$i] = new watsMsg( $message->msgid, $message->msg, $message->watsid, $message->unixDatetime );
			// increment counter
			$i ++;
			$this->msgNumberOf ++;
		}
	}

	/**
	 * V = view users
	 * M = make users
	 * E = edit users
	 * D = delete users
	 */
	function checkUserPermission( $rite )
	{
		// prepare for no rite
		$returnValue = 0;
		// find rite in string
		// checks type as well because could return 0
		if ( strpos( $this->userRites, strtolower( $rite) ) !== false )
		{
			// check for OWN rite
			$returnValue = 1;
		}
		else if ( strpos( $this->userRites, strtoupper( $rite) ) !== false )
		{
			// check for ALL rite
			$returnValue = 2;
		} // end find rite in string
		return $returnValue;
	}
	
	/**
	 * V = view users
	 * M = make users
	 * E = edit users
	 * D = delete users
	 */
	function setUserPermission( $rite, $level )
	{
		$rites = array( 'V', 'M', 'E', 'D' );
		$rite = strtoupper( $rite );
		// check is valid rite
		$position = array_search( $rite, $rites );
		if ( $position === false && strlen( $rite ) != 1 )
			return false;
		// check level
		if ( ! is_bool( $level ) )
			return false;
		// check position
		$checkRite = substr( $this->userRites, $position, 1 );
		if ( $checkRite == '-' || $checkRite == $rite )
		{
			// change rite
			$tempRites = substr( $this->userRites, 0, $position );
			if ( $level )
			{
				$tempRites .= $rite;
			}
			else
			{
				$tempRites .= '-';
			}
			$tempRites .= substr( $this->userRites, $position + 1, strlen( $this->userRites ) - ($position + 1)  );
			$this->userRites = $tempRites;
		}
		else
		{
			// rites messed up check if is in rites
			$position = strstr( $rite, $this->userRites );
			if ( $position === false )
			{
				// append to end (run db maintenance to resolve)
				if ( $level )
				{
					$tempRites .= $rite;
				}
				else
				{
					$tempRites .= '-';
				}
			}
			else
			{
				// bung in alternate position
				$tempRites = substr( $this->rites, 0, $position );
				if ( $level )
				{
					$tempRites .= $rite;
				}
				else
				{
					$tempRites .= '-';
				}
				$tempRites .= substr( $this->rites, $position + 1, strlen( $this->rites ) - ($position + 1)  );
				$this->userRites = $tempRites;
			}
		}
		return true;
	}
	
	/**
	 * 
	 */
	function save()
	{
	    $database = JFactory::getDBO();
		
		$database->setQuery( "UPDATE #__brazitrac_groups SET name=".$database->Quote($this->name).", image=".$database->Quote($this->image).", userrites=".$database->Quote($this->userRites)." WHERE grpid=".intval($this->grpid).";" );
		$database->query();
	}
	
	/**
	 * 
	 */
	function loadUsers() {
	    $database = JFactory::getDBO();
		
		$this->_users = null;
		$this->_users = array();
		$database->setQuery( "SELECT watsid FROM #__brazitrac_users WHERE grpid=".intval($this->grpid));
		$users = $database->loadObjectList();
		foreach ( $users as $user )
		{
			echo 'a';
			$tempUser = new watsUser();
			echo 'b';
			$tempUser->loadWatsUser( $user->watsid );
			echo 'c';
			$this->_users[] = $tempUser;
			echo 'd';
		}
	}
	
	/**
	 * 
	 */
	function delete( $option )
	{
	    $database = JFactory::getDBO();
		
		$this->loadUsers();
		foreach ( $this->_users as $editUser )
		{
			$editUser->delete( $option );
		}
		// remove permission sets
		$database->setQuery( "DELETE FROM #__brazitrac_permissions WHERE grpid=".intval($this->grpid));
		$database->query();
		// remove group
		$database->setQuery( "DELETE FROM #__brazitrac_groups WHERE grpid=".intval($this->grpid));
		$database->query();
	}
	
	/**
	 * static
	 */
	function makeGroup( $name, $image )
	{
	    $database = JFactory::getDBO();
		// create new category
		$database->setQuery( "INSERT INTO #__brazitrac_groups ( name, image, userrites ) VALUES (".$database->Quote($name).", ".$database->Quote($image).", '----' );" );
		$database->query();
		// create object
		$newGroup = new watsUserGroup( $database->insertid() );
		// create permission sets
		$database->setQuery( "SELECT c.catid FROM #__brazitrac_category AS c;" );		
		$categories = &$database->loadObjectList();
		foreach ( $categories as $category )
		{
			$newGroup->newPermissionSet( $category->catid );
		}
		// return new group
		return $newGroup;
	}
}

/**
 * @version 1.0
 * @created 06-Dec-2005 21:43:47
 */
class watsUserGroupSet
{
	var $noOfGroups = 0;
	var $_userGroupList = array();

	/**
	 * 
	 */
	function loadUserGroupSet() {
		$database = JFactory::getDBO();
	
		// create query
		$query = $sql = "SELECT grpid FROM #__brazitrac_groups ORDER BY name";
		// end create query
		$database->setQuery( $query );
		$set = $database->loadObjectList();
		// check there are results
		if ( $set != null )
		{
			// create user group objects
			foreach( $set as $group )
			{
				// create object
				$this->_userGroupList[$this->noOfGroups] = new watsUserGroupHTML( $group->grpid );
				// increment counter
				$this->noOfGroups ++;
			}// end create user group objects
		} // end check there are results
	}
	
	/**
	 * 
	 */
	function getNamesAndIds()
	{
		$array = array();
		foreach( $this->_userGroupList as $group )
		{
			$array[$group->grpid] = $group->name;
		}
		asort( $array );
		return $array;
	}
}

/**
 * @version 1.0
 * @created 06-Dec-2005 21:43:47
 */
class watsTicketSet
{
	var $ticketNumberOf;
	var $_ticketList;
	var $_ticketListPointer;
	var $_db;

	/**
	 * 
	 * @param database
	 */
	function watsTicketSet()
	{
		$this->ticketNumberOf = 0;
		$this->_ticketListPointer = 0;
	}

	/**
	 * 
	 * @param lifeCycle (-1 = all, 0 = open and closed, 1 = open, 2 = closed, 3 = dead)
	 * @param watsid
	 * @param category (id of category, -1 = all categories)
	 * @param riteAll (true = show all users tickets)
	 * @param assign ( true = assigned tickets only)
	 */
	 //$this->ticketSet->loadTicketSet( 0, $this->watsId, -1, true, true );
	function loadTicketSet( $lifecycle, $category = null )
	{
		$database = JFactory::getDBO();
	
		// create query
		$query = $sql = "SELECT COUNT(*) AS posts, t.ticketid, t.assign, t.watsid AS ownerid, t.ticketname, t.category, t.lifecycle, UNIX_TIMESTAMP(t.datetime) AS firstpost, SUBSTRING(MIN(CONCAT(DATE_FORMAT(m1.datetime, '%Y-%m-%d %H:%i:%s'), m1.msgid)), 20) as firstmsg, SUBSTRING(MAX(CONCAT(DATE_FORMAT(m1.datetime, '%Y-%m-%d %H:%i:%s'), m1.msgid)), 20) as lastpostid, SUBSTRING(MAX(CONCAT(DATE_FORMAT(m1.datetime, '%Y-%m-%d %H:%i:%s'), m1.watsid)), 20) as lastid, UNIX_TIMESTAMP(MAX(m1.datetime)) as lastdate, o.username AS username, SUBSTRING(MAX(CONCAT(DATE_FORMAT(m1.datetime, '%Y-%m-%d %H:%i:%s'), p.username)), 20) AS poster FROM #__brazitrac_ticket AS t LEFT JOIN #__brazitrac_msg AS m1 ON t.ticketid = m1.ticketid LEFT JOIN #__users AS o ON t.watsid = o.id LEFT JOIN #__users AS p ON m1.watsid = p.id ";
		// check lifeCycle
		if( $lifecycle == -1 )
		{
			// do nothing select all
		}
		elseif ( $lifecycle == 0 )
		{
			$query .= "WHERE ( t.lifecycle=1 OR t.lifecycle=2 )";
		}
		else
		{
			$query .= "WHERE t.lifecycle=".$lifecycle;
		}
		if ( $category != null AND $category != -1 )
		{
			// set category
			$query .= " AND category=".intval($category);
		}
		// end create query
		$query .= " GROUP BY t.ticketid, t.watsid, t.ticketname, t.datetime ORDER BY lastdate desc;";
		
		$database->setQuery( $query );
		$set = $database->loadObjectList();
		// check there are results
		if ( $set != null )
		{
			// create ticket objects
			foreach( $set as $ticket )
			{
				// create object
				$this->_ticketList[$this->ticketNumberOf] = new watsTicketHTML( $ticket->username, $ticket->lastid, $ticket->ticketname, $ticket->ownerid, $ticket->lastdate, $ticket->firstpost, $ticket->lifecycle, $ticket->ticketid, $ticket->posts, $ticket->category, $ticket->assign );
				// increment counter
				$this->ticketNumberOf ++;
			}// end create ticket objects
		} // end check there are results
	}
}

/**
 * @version 1.0
 * @created 06-Dec-2005 21:43:13
 */
class watsMsg
{
	var $msgId;
	var $msg;
	var $watsId;
	var $datetime;

	/**
	 * Populates msgId, msg, watsId and datetime with corresponding values
	 *
	 * @param msgId
	 */
	function watsMsg( $msgId, $msg = null, $watsId = null, $datetime = null )
	{
		$this->msgId=$msgId;
		$this->msg=$msg;
		$this->watsId=$watsId;
		$this->datetime=$datetime;
	}
	
}

/**
 * @version 1.0
 * @created 06-Dec-2005 21:44:11
 */
class watsCategory extends JTable
{
    var $catid;
	var $name;
	var $ticketSet;
	var $description;
	var $image;
    var $emails;

	/**
	 * 
	 * @param database
	 */
	function watsCategory() {
        $database = JFactory::getDBO();

	    $this->__construct( '#__brazitrac_category', 'catid', $database);
	}

	/**
	 * Loads this->ticketSet
	 *
	 * @param database
	 * @param lifecycle
	 * @param watsid
	 * @param category
	 */
	function loadTicketSet( $lifecycle, $watsid, $riteAll = false )
	{
		// create new ticketset
		$this->ticketSet = new watsTicketSetHTML();
		// load tickets
		$this->ticketSet->loadTicketSet( $lifecycle, $watsid, $this->catid, $riteAll );
	}

	/**
	 * Purges loaded tickets
	 *
	 */
	function purge()
	{
		$ticketCount = count($this->ticketSet->_ticketList);
		$i = 0;
		while ( $i < $ticketCount )
		{
			$this->ticketSet->_ticketList[$i]->deactivate();
			$i ++;
		}
	}
	
	/**
	 * Returns an array of users who can have tickets assigned to.
	 */
	function getAssignee( $catid = null )
	{
		if ( $catid == null ) {
			$catid = intval($this->catid);
		}
		
		$database = JFactory::getDBO();
		
		$database->setQuery( "SELECT wu.watsid, u.username
								FROM #__brazitrac_permissions AS p
								LEFT  JOIN #__brazitrac_users AS wu ON wu.grpid = p.grpid
								LEFT  JOIN #__users AS u ON wu.watsid = u.id
								WHERE
								p.catid=".intval($catid)." AND (
								p.type LIKE  \"%a%\" OR
								p.type LIKE  \"%A%\" )" );
		$assignees = &$database->loadObjectList( );
		// check for reults
		if ( count( $assignees ) == 0 )
		{
			return null;
		}
		else
		{
			return $assignees;
		} // end check for reults
	}
	
	/**
	 * static
	 */
	function newCategory( $name, $description, $image, $emails ) {
	    $database = JFactory::getDBO();
		// check doesn't already exist
		$database->setQuery( "SELECT name FROM #__brazitrac_category WHERE name=".$database->Quote($name).";");
		$database->query();
		if ( $database->getNumRows() == 0 )
		{
			// create SQL
			$database->setQuery(
                "INSERT INTO #__brazitrac_category ( name, description, image, emails ) ".
                "VALUES (".$database->Quote($name).", ".$database->Quote($description).", ".$database->Quote($image).", ".$database->Quote($emails).")" 
            );
			// execute
			$database->query();
			$newCategoryId = &$database->insertid();
			// iterate through user groups and create rites entries
			$watsUserGroupSet =  new watsUserGroupSet( $database );
			$watsUserGroupSet->loadUserGroupSet();
			foreach ( $watsUserGroupSet->_userGroupList as $watsUserGroup )
			{
				$watsUserGroup->newPermissionSet( $newCategoryId );
			}
			return true;
		}
		else
		{
			// category with that name already exists
			return false;
		} // end check doesn't already exist
	}
	
	/**
	 *
	 */
	function updateCategory()
	{
	    $database = JFactory::getDBO();
		
		// check already exists
		$database->setQuery( "SELECT catid FROM #__brazitrac_category WHERE catid=".intval($this->catid));
		$database->query();
		if ( $database->getNumRows() != 0 )
		{
			// update SQL
			$database->setQuery(
                "UPDATE #__brazitrac_category ".
                "SET name=".$database->Quote($this->name).", description=".$database->Quote($this->description).", image=".$database->Quote($this->image).", emails=".$database->Quote($this->emails)." ".
                "WHERE catid=".intval($this->catid)
            );
			// execute
			$database->query();
			return true;
		}
		else
		{
			return false;
		} // end check doesn't already exist
	}
	
	/**
	 *
	 */
	function delete()
	{
	    $database = JFactory::getDBO();
		
		// remove tickets
		$database->setQuery( "DELETE FROM #__brazitrac_ticket WHERE category=".intval($this->catid).";" );
		$database->query();
		// remove rites matrixes
		$database->setQuery( "DELETE FROM #__brazitrac_permissions WHERE catid=".intval($this->catid).";" );
		$database->query();
		// remove category
		$database->setQuery( "DELETE FROM #__brazitrac_category WHERE catid=".intval($this->catid).";" );
		$database->query();
	}
}

/**
 * @version 1.0
 * @created 12-Dec-2005 13:32:13
 */
class watsAssign
{
	var $ticketSet;
	var $watsId;
	var $_db;
	
	/**
	 * 
	 * @param database
	 */	
	function watsAssign() {
	}

	/**
	 * Loads this->ticketSet
	 *
	 * @param watsid
	 */
	function loadAssignedTicketSet( $watsId )
	{
		// set watsId
		$this->watsId = $watsId;
		// create new ticketset
		$this->ticketSet = new watsTicketSetHTML();
		// load tickets
		$this->ticketSet->loadTicketSet( 0, $this->watsId, -1, true, true );
	}
}

/**
 * @version 1.0
 * @created 06-Dec-2005 21:43:13
 */
class watsCategorySet
{
    var $categorySet;
	var $_db;

	/**
	 * 
	 * @param database
	 */	
	function watsCategorySet()
	{
	    $database = JFactory::getDBO();
		// load categories
		$database->setQuery( "SELECT * FROM #__brazitrac_category ORDER BY name" );
		$vars = $database->loadObjectList();
		// create category objects
		$i = 0;
		foreach( $vars as $var )
		{
			// create object
			$this->categorySet[$i] = new watsCategoryHTML();
			// load object
			$this->categorySet[$i]->load( $var->catid );
			// increment counter
			$i ++;
		} //end  create category object
	}

	/**
	 * 
	 * @param database
	 */	
	function loadTicketSet( $lifecycle, &$watsUser )
	{
		// itterate through categories
		$numberOfCategories = count($this->categorySet);
		$i = 0;
		while ( $i < $numberOfCategories )
		{
			// check view rites
			$rite =  $watsUser->checkPermission( $this->categorySet[$i]->catid, "v" );
			if ( $rite == 2 )
			{
				// allow user to load all tickets
				$this->categorySet[$i]->loadTicketSet( $lifecycle, $watsUser->id, true );
			}
			else if ( $rite = 1 )
			{
				// allow user to load own tickets only
				$this->categorySet[$i]->loadTicketSet( $lifecycle, $watsUser->id );
			}
			// increment counter
			$i ++;
		} // end itterate through categories
	}
}

/**
 * @version 1.0
 * @created 11-Feb-2006 13:23:36
 */
class watsCss
{
	var $path;
	var $cssStyles;
	var $css;

	/**
	 * 
	 */
	function watsCss()
	{
	    $database = JFactory::getDBO();
		$this->cssStyles = array();
		$database->setQuery( "SELECT value FROM #__brazitrac_settings WHERE name=\"css\"" );
		$this->css = &$database->loadObjectList();
		$this->css = $this->css[0]->value;
	}

	/**
	 * opens and parses file
	 */
	function open($pathIn)
	{
		// check path exists
		if ( file_exists ( $pathIn ) )
		{
			// set path
			$this->path = $pathIn;
			// open file
			$cssFile = fopen( $this->path, "r" );
			// read file
			$cssFileContent = fread( $cssFile, filesize( $this->path ) );
			// close file
			fclose( $cssFile );
			// parse file
			{
				// replace unnecessary white spaces with one 
				$cssFileContent = preg_replace( "/[\s]+/", ' ', $cssFileContent );
				// divide into styles
				$cssFileStyles = explode("}", $cssFileContent);
				// loop through styles
				foreach ($cssFileStyles as $cssStyle)
				{
					// get selector
					$cssSelector = trim ( substr( $cssStyle, 0,  strpos( $cssStyle, '{' ) )) ;
					// check is valid selector before continuing
					if ( strlen( $cssSelector ) > 0 )
					{
						// get properties
						$cssProperties = trim ( substr( $cssStyle, strpos( $cssStyle, '{' ) + 1, strlen( $cssStyle ) ) ) ;
						$cssProperties = str_replace("; ", ";\n", $cssProperties);
						// add to styles
						$this->cssStyles[ $cssSelector ] = $cssProperties;
					}
				}
				// end loop through styles
			}
			//end parse file
		}
		// end check path exists
	}
	
	/**
	 * 
	 */
	function save()
	{
		// check can write to file
		if ( is_writable( $this->path ) )
		{
			// write to file
			if ( $cssFile = fopen( $this->path, "wb" ) )
			{
				// prepare file content
				$cssFileContent = '';
				$keys = array_keys( $this->cssStyles );
				// iterate through styles
				foreach( $keys as $key )
				{
					// add style to content
					$cssFileContent .= $key."\r\n{\r\n".$this->cssStyles[$key]."\r\n}\r\n\r\n";
				}
				// end iterate through styles
				// end prepare file content
				if ( fwrite($cssFile, $cssFileContent) === false )
				{
					echo "<p>An error occured when attempting to open the css file for writing.</p>";
				}
				// close file
				fclose( $cssFile );
			}
			else
			{
				echo "<p>An error occured when attempting to open the css file for writing.</p>";
			}
			// end write to file
		}
		else
		{
			echo "<p>Unable to write to css file. Plase change the file rites.</p>";
		}
		// end check can write to file
	}
	
	/**
	 * returns style if exists, else returns false.
	 * @param selector of selector
	 */
	function getStyle( $selector )
	{
		// check for style
		if ( isset( $this->cssStyles[ $selector ] ) )
		{
			// return style
			return $this->cssStyles[ $selector ];
		}
		else
		{
			// return no style
			return false;
		}
	}
	
	/**
	 * sets style properties, adds style if does not exist.
	 * @param selector of style
	 * @param properties of style
	 */
	function setStyle( $selector, $properties )
	{
		// check for style
		if ( isset( $this->cssStyles[ $selector ] ) )
		{
			$this->cssStyles[ $selector ] = $properties;
		}
	}
	
	/**
	 * returns array of styles.
	 */
	function getAllStyles()
	{
		return $this->cssStyles;
	}
	
	/**
	 * restores installation default css.
	 * @param path to restore from.
	 */
	function restore( $restorePath )
	{
		// check retoreFile exists
		if ( is_file( $restorePath ) == false )
			return false;
		// check can read restore file
		if ( is_readable( $restorePath ) == false )
			return false;
		// check can write to file
		if ( is_writable( $this->path ) == false )
			return false;
		// start restore
		{
			{
				// open to read
				$restoreFile = fopen( $restorePath, "r" );
				// read file
				$restoreFileContent = fread( $restoreFile, filesize( $restorePath ) );
				// close file
				fclose( $restoreFile );
			}
			if ( $cssFile = fopen( $this->path, "wb" ) )
			{
				// write
				if ( fwrite($cssFile, $restoreFileContent) === false )
				{
					return false;
				}
				// close file
				fclose( $cssFile );
				// end wite
			}
			else
			{
				return false;
			}
		}
		// end restore
		return true;
	}
	
}

/**
 * @version 1.0
 * @created 07-May-2006 15:44:11
 */
class watsDatabaseMaintenance
{
	var $_db;

	/**
	 * 
	 * @param database
	 */
	function watsDatabaseMaintenance() {
	}
	
	/**
	 * 
	 */
	function performOrphanUsers()
	{
	    $database = JFactory::getDBO();
		// find errors
		$database->setQuery( "SELECT w.watsid, u.id AS id FROM #__brazitrac_users AS w LEFT JOIN #__users AS u ON u.id = w.watsid WHERE u.id is null;" );
		$errors = $database->loadObjectList();
		// find errors
		// resolve errors
		foreach( $errors as $error )
		{
			// remove orphan users
			$orphanUser = new watsUserHTML();
			$orphanUser->loadWatsUser( $error->watsid );
			$orphanUser->delete( 'removeposts' );
		}
		// end resolve errors
		return count( $errors );
	}
	
	/**
	 * 
	 */
	function performUserPermissionsFormat()
	{
	    $database = JFactory::getDBO();
		$database->setQuery( "SELECT grpid, userrites FROM #__brazitrac_groups;" );
		$rows = $database->loadObjectList();
		$errors = array();
		$rites = array( 'V', 'M', 'E', 'D' );
		// find errors
		foreach( $rows as $row )
		{
			// check length
			if ( strlen( $row->userrites ) != 4 )
			{
				$errors[] = $row;
			}
			else
			{
				// prepare rites
				$ritesArray = $this->_stringToCharArray( strtoupper( $row->userrites ) );
				// check for unknown occurences
				for ( $i = 0; $i < 4 ; $i ++ )
				{
					if ( $ritesArray[$i] != $rites[$i] && $ritesArray[$i] != '-' )
					{
						// add error
						$errors[] = $row;
						// stop itearor
						$i = 4;
					}
				}
			}
		}
		// end find errors
		
		return count( $errors );
	}
	
	/**
	 * 
	 */
	function performPermissionSetsFormat()
	{
	    $database = JFactory::getDBO();
		$database->setQuery( "SELECT grpid, catid, type FROM #__brazitrac_permissions;" );
		$rows = $database->loadObjectList();
		$errors = array();
		$rites = array( 'V', 'M', 'R', 'C', 'D', 'P', 'A', 'O' );
		// find errors
		foreach( $rows as $row )
		{
			// check length
			if ( strlen( $row->type ) != 8 )
			{
				$errors[] = $row;
			}
			else
			{
				// prepare rites
				$ritesArray = $this->_stringToCharArray( strtoupper( $row->type ) );
				// check for unknown occurences
				for ( $i = 0; $i < 8 ; $i ++ )
				{
					if ( $ritesArray[$i] != $rites[$i] && $ritesArray[$i] != '-' )
					{
						// add error
						$errors[] = $row;
						// stop itearor
						$i = 8;
					}
				}
			}
		}
		// end find errors
		// resolve errors
		foreach( $errors as $error )
		{
			// rebuild rites
			$newRites = "";
			foreach( $rites as $rite )
			{
				if ( strstr( $error->type, strtoupper( $rite ) ) !== FALSE )
				{
					// All rites
					$newRites .= strtoupper( $rite );
				}
				else if ( strstr(  $error->type, strtolower( $rite ) ) !== FALSE )
				{
					// Own rites
					$newRites .= strtolower( $rite );
				}
				else
				{
					// No rites
					$newRites .= '-';
				}
			}
			// apply new rites string
			$database->setQuery( "UPDATE #__brazitrac_permissions SET p.type=".$database->Quote($newRites)." WHERE p.grpid=".intval($error->grpid)." AND p.catid=".$error->catid.";" );
			$database->query();
		}
		// end resolve errors
		return count( $errors );
	}
	
	/**
	 *
	 */
	function _stringToCharArray( $str )
	{
		$length = strlen( $str );
		$output = array();
		for( $i = 0; $i < $length; $i++ )
		{
			$output[$i] = $temp_output = substr( $str, $i, 1 );
		}
		return $output;
	}
	
	/**
	 * 
	 */
	function performOrphanPermissionSets()
	{
	    $database = JFactory::getDBO();
		// get group missing
		$database->setQuery( "SELECT p.grpid, p.catid FROM #__brazitrac_permissions AS p LEFT JOIN #__brazitrac_groups AS g ON p.grpid = g.grpid WHERE g.grpid IS NULL;" );
		$groupErrors = array();
		$groupErrors = $database->loadObjectList();
		// end group missing
		// get category missing
		$database->setQuery( "SELECT p.grpid, p.catid FROM #__brazitrac_permissions AS p LEFT JOIN #__brazitrac_category AS c ON p.catid = c.catid WHERE c.catid IS NULL;" );
		$categoryErrors = array();
		$categoryErrors = $database->loadObjectList();
		// end category missing
		
		// merge arrays
		$errors = $categoryErrors;
		foreach ( $groupErrors as $groupError )
		{
			$found = false;
			foreach ( $categoryErrors as $categoryError )
			{
				if ( $groupError->grpid == $categoryError->grpid && $groupError->catid == $categoryError->catid )
				{
					$found = true;
				}
			}
			if ( $found == false )
			{
				$errors[] = $groupError;
			}
		}
		// end merge arrays
	
		// resolve errors
		foreach( $errors as $error )
		{
			// apply new rites string
			$database->setQuery( "DELETE FROM #__brazitrac_permissions WHERE grpid=".intval($error->grpid)." AND catid=".intval($error->catid).";" );
			$database->query();
		}
		// end resolve errors*/
		return count( $errors );
	}
	
	/**
	 * 
	 */
	function performOrphanTickets()
	{
	    $database = JFactory::getDBO();
		
		// get user missing
		$database->setQuery( "SELECT t.ticketid, u.id FROM #__brazitrac_ticket AS t LEFT JOIN #__users AS u ON t.watsid = u.id WHERE u.id IS NULL;" );
		$userErrors = array();
		$userErrors = $database->loadObjectList();
		// end user missing
		// get category missing
		$database->setQuery( "SELECT t.ticketid, t.category, c.catid FROM #__brazitrac_ticket AS t LEFT JOIN #__brazitrac_category AS c ON t.category = c.catid WHERE c.catid IS NULL;" );
		$categoryErrors = array();
		$categoryErrors = $database->loadObjectList();
		// end category missing
		
		// merge arrays
		$errors = $categoryErrors;
		foreach ( $userErrors as $userError )
		{
			$found = false;
			foreach ( $categoryErrors as $categoryError )
			{
				if ( $userError->ticketid == $categoryError->ticketid )
				{
					$found = true;
				}
			}
			if ( $found == false )
			{
				$errors[] = $userError;
			}
		}
		// end merge arrays
	
		// resolve errors
		foreach( $errors as $error )
		{
			// remove messages
			$database->setQuery( "DELETE FROM #__brazitrac_msg WHERE ticketid=".intval($error->ticketid).";" );
			$database->query();
			// remove ticket
			$database->setQuery( "DELETE FROM #__brazitrac_ticket WHERE ticketid=".intval($error->ticketid).";" );
			$database->query();
		}
		// end resolve errors
		return count( $errors );
	}
	
	/**
	 * 
	 */
	function performOrphanMessages()
	{
	    $database = JFactory::getDBO();
		
		// get user missing
		$database->setQuery( "SELECT m.msgid FROM #__brazitrac_msg AS m LEFT JOIN #__users AS u ON m.watsid = u.id WHERE u.id IS NULL;" );
		$userErrors = array();
		$userErrors = $database->loadObjectList();
		// end user missing
		// get ticket missing
		$database->setQuery( "SELECT m.msgid FROM #__brazitrac_msg AS m LEFT JOIN #__brazitrac_ticket AS t ON m.ticketid = t.ticketid WHERE t.ticketid IS NULL;" );
		$ticketErrors = array();
		$ticketErrors = $database->loadObjectList();
		// end ticket missing
		
		// merge arrays
		$errors = $ticketErrors;
		foreach ( $userErrors as $userError )
		{
			$found = false;
			foreach ( $ticketErrors as $ticketError )
			{
				if ( $userError->msgid == $ticketError->msgid )
				{
					$found = true;
				}
			}
			if ( $found == false )
			{
				$errors[] = $userError;
			}
		}
		// end merge arrays
	
		// resolve errors
		foreach( $errors as $error )
		{
			// remove messages
			$database->setQuery( "DELETE FROM #__brazitrac_msg WHERE msgid=".intval($error->msgid).";" );
			$database->query();
		}
		// end resolve errors
		return count( $errors );
	}
	
	/**
	 * 
	 */
	function performMissingPermissionSets()
	{
	    $database = JFactory::getDBO();
		
		// get number of groups
		$database->setQuery( "SELECT COUNT(*) AS size FROM #__brazitrac_groups" );
		$groupCounter = $database->loadObjectList();
		// get number of categories
		$database->setQuery( "SELECT COUNT(*) AS size FROM #__brazitrac_category" );
		$categoryCounter = $database->loadObjectList();
		// get number of sets
		$database->setQuery( "SELECT COUNT(*) AS size FROM #__brazitrac_permissions" );
		$setCounter = $database->loadObjectList();
		// number of sets that should exist
		$sets = $groupCounter[0]->size * $categoryCounter[0]->size;
		// number of sets missing
		$totalMissingSets = $sets - $setCounter[0]->size;
		
		if ( $totalMissingSets == 0 )
		{
			// no inconsistencies
			return 0;
		}
		else
		{
			// determine where inconsistencies are and resolve them
			// get groups
			$database->setQuery( "SELECT grpid FROM #__brazitrac_groups" );
			$groups = array();
			$groups = $database->loadObjectList();
			// get categories
			$database->setQuery( "SELECT catid FROM #__brazitrac_category" );
			$categories = array();
			$categories = $database->loadObjectList();
			// itterate through groups
			foreach ( $groups as $group )
			{
				// itterate through categories
				foreach ( $categories as $category )
				{
					// check set exists
					$database->setQuery( "SELECT COUNT(*) AS size FROM #__brazitrac_permissions WHERE catid=".intval($category->catid)." AND grpid=".$group->grpid.";" );
					$result = $database->loadObjectList();
					// check exists
					if ( $result[0]->size != 1 )
					{
						// inconsistency found -> create missing set
						$watsUserGroup = new watsUserGroup( $database, $group->grpid );
						$watsUserGroup->newPermissionSet( $category->catid );
					}
				}
			}
		}
		return $totalMissingSets;
	}

}

?>