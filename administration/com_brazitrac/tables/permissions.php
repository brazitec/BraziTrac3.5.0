<?php
/**
 * @version		$Id$
 * @package		brazitrac
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

// import JTable
jimport('joomla.database.table');

/**
 * Table handler for #__brazitrac_category
 */
class WTablePermissions extends JTable {
	/**
	 * Composite Primary Key
	 *
	 * @access public
	 * @var int
	 */
	var $grpid = null;

	/**
	 * Composite Primary Key
	 *
	 * @access public
	 * @var string
	 */
	var $catid = null;
	
	/**
	 * Permissions
	 *
	 * @access public
	 * @var string
	 */
	var $type = null;

	/**
	 * Constructor
	 *
	 * @access protected
	 * @param $database JDatabase DBO
	 */
	function __construct(&$database)
	{
		parent::__construct('#__brazitrac_permissions', null, $database);
	}

	/**
	 * Determines if buffer is valid.
	 */
	function check() {
		if ($this->grpid === null) {
			$this->setError("PERMISSIONS GROUP MUST EXIST");
			return false;
		}
		
		if ($this->catid === null) {
			$this->setError("PERMISSIONS CATEGORY MUST EXIST");
			return false;
		}
		
		if ($this->userrites{0} != "-" && strtoupper($this->userrites{0}) != "V") {
			$this->setError("GROUP RIGHTS ARE CORRUPT");
			return false;
		}
		if ($this->userrites{1} != "-" && $this->userrites{1} != "m") {
			$this->setError("GROUP RIGHTS ARE CORRUPT");
			return false;
		}
		if ($this->userrites{2} != "-" && strtoupper($this->userrites{2}) != "R") {
			$this->setError("GROUP RIGHTS ARE CORRUPT");
			return false;
		}
		if ($this->userrites{3} != "-" && strtoupper($this->userrites{3}) != "C") {
			$this->setError("GROUP RIGHTS ARE CORRUPT");
			return false;
		}
		if ($this->userrites{4} != "-" && strtoupper($this->userrites{4}) != "D") {
			$this->setError("GROUP RIGHTS ARE CORRUPT");
			return false;
		}
		if ($this->userrites{5} != "-" && strtoupper($this->userrites{5}) != "P") {
			$this->setError("GROUP RIGHTS ARE CORRUPT");
			return false;
		}
		if ($this->userrites{6} != "-" && strtoupper($this->userrites{6}) != "A") {
			$this->setError("GROUP RIGHTS ARE CORRUPT");
			return false;
		}
		if ($this->userrites{7} != "-" && strtoupper($this->userrites{7}) != "O") {
			$this->setError("GROUP RIGHTS ARE CORRUPT");
			return false;
		}
		
		return true;
	}
}
?>
