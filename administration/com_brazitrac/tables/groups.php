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
 * Table handler for #__brazitrac_category
 */
class WTableGroups extends JTable {
	/**
	 * Primary Key
	 *
	 * @access public
	 * @var int
	 */
	var $grpid = null;

	/**
	 * Group's name
	 *
	 * @access public
	 * @var string
	 */
	var $name = null;

	/**
	 * Group image
	 *
	 * @access public
	 * @var string
	 */
	var $image = null;
	
	/**
	 * Group user rights
	 *
	 * @access public
	 * @var string
	 */
	var $userrites = null;

	/**
	 * Constructor
	 *
	 * @access protected
	 * @param $db JDatabase DBO
	 */
	function __construct(&$db)
	{
		parent::__construct('#__brazitrac_groups', 'grpid', $db);
	}

	/**
	 * Determines if buffer is valid.
	 */
	function check() {
		if (strlen($this->name) > 0) {
			$this->setError("GROUP NAME MUST EXIST");
			return false;
		}
		
		if ($this->userrites{0} != "-" && strtoupper($this->userrites{0}) != "V") {
			$this->setError("GROUP RIGHTS ARE CORRUPT");
			return false;
		}
		if ($this->userrites{1} != "-" && strtoupper($this->userrites{1}) != "M") {
			$this->setError("GROUP RIGHTS ARE CORRUPT");
			return false;
		}
		if ($this->userrites{2} != "-" && strtoupper($this->userrites{2}) != "E") {
			$this->setError("GROUP RIGHTS ARE CORRUPT");
			return false;
		}
		if ($this->userrites{3} != "-" && strtoupper($this->userrites{3}) != "D") {
			$this->setError("GROUP RIGHTS ARE CORRUPT");
			return false;
		}
		
		return true;
	}
}
?>
