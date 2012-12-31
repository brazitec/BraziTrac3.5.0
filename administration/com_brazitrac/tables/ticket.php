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
 * Table handler for #__wats_category
 */
class WTableTicket extends JTable {
	
	/**
	 * Primary Key
	 *
	 * @access public
	 * @var int
	 */
	var $ticketid = null;
	
	/**
	 * Ticket owner
	 *
	 * @access public
	 * @var int
	 */
	var $watsid = null;
	
	/**
	 * Name of ticket
	 *
	 * @access public
	 * @var string
	 */
	var $ticketname = null;

	/**
	 * Posiiton in ticket lifecycle
	 *
	 * @access public
	 * @var int
	 */
	var $lifecycle = null;

	/**
	 * Ticket submission date and time
	 *
	 * @access public
	 * @var string
	 */
	var $datetime = null;
	
	/**
	 * Ticket category
	 *
	 * @access public
	 * @var int
	 */
	var $catid = null;
	
	/**
	 * User to whom the ticket is assigned
	 *
	 * @access public
	 * @var int
	 */
	var $assign = null;

	/**
	 * Constructor
	 *
	 * @access protected
	 * @param $db JDatabase DBO
	 */
	function __construct(&$db)
	{
		parent::__construct('#__wats_ticket', 'ticketid', $db);
	}

	/**
	 * Determines if buffer is valid.
	 *
	 * @todo Add check for date and time
	 */
	function check() {
		if ($this->watsid === null) {
			$this->setError("TICKET USER MUST EXIST");
			return false;
		}
		
		if ($this->ticketname === null) {
			$this->setError("TICKET NAME MUST EXIST");
			return false;
		}
		
		if ($this->lifecycle < 1 && $this->lifecycle > 3) {
			$this->setError("TICKET LIFECYCLE STEP MUST EXIST");
			return false;
		}
		
		if ($this->datetime === null) {
			$this->setError("TICKET SUBMISSION DATETIME MUST EXIST");
			return false;
		}
		
		if ($this->category === null) {
			$this->setError("TICKET CATEGORY MUST EXIST");
			return false;
		}
		
		return true;
	}
}
?>
