<?php
/**
 * @version		$Id$
 * @package		wats
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

// import JTable
jimport('joomla.database.table');

/**
 * Table handler for #__wats_users
 */
class WTableUsers extends JTable {
	/**
	 * Primary Key
	 *
	 * @access public
	 * @var int
	 */
	var $watsid = null;

	/**
	 * Organisation user belongs to
	 *
	 * @access public
	 * @var string
	 */
	var $organisation = null;

	/**
	 * User has completed agreement
	 *
	 * @access public
	 * @var int|boolean
	 */
	var $agree = null;
	
	/**
	 * User's group
	 *
	 * @access public
	 * @var int
	 */
	var $grpid = null;

	/**
	 * Constructor
	 *
	 * @access protected
	 * @param $db JDatabase DBO
	 */
	function __construct(&$db)
	{
		parent::__construct('#__wats_msg', 'msgid', $db);
	}

	/**
	 * Determines if buffer is valid.
	 *
	 * @todo Add check for date and time
	 */
	function check() {
		if ($this->watsid === null) {
			$this->setError("USER MUST EXIST");
			return false;
		}
		
		if ($this->grpid === null) {
			$this->setError("USER USER GROUP MUST EXIST");
			return false;
		}
		
		return true;
	}
}
?>