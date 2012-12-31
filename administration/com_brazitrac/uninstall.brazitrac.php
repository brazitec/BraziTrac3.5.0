<?php
/**
 * @version $Id: uninstall.brazitec.php 66 2009-03-31 14:18:46Z webamoeba $
 * @copyright Copyright (C) James Kennard
 * @license GNU/GPL
 * @package wats
 */

// Don't allow direct linking
defined('_JEXEC') or die('Restricted Access');

function com_uninstall()
{
	$database = JFactory::getDBO();
	
	// setup settings
    require('components/com_brazitrac/classes/dbhelper.php');  
    require('components/com_brazitrac/classes/factory.php');  
    require('components/com_brazitrac/classes/config.php');
	require('components/com_brazitrac/admin.brazitrac.html.php');
	$wats = WFactory::getConfig();
	
	if ( $wats->get( 'upgrade' ) == 0 )
	{
		// uninstall
		$database->setQuery( "DROP TABLE IF EXISTS `#__brazitrac_category`;" );
		$database->query();
		$database->setQuery( "DROP TABLE IF EXISTS `#__brazitrac_groups`;" );
		$database->query();
		$database->setQuery( "DROP TABLE IF EXISTS `#__brazitrac_highlight`;" );
		$database->query();
		$database->setQuery( "DROP TABLE IF EXISTS `#__brazitrac_msg`;" );
		$database->query();
		$database->setQuery( "DROP TABLE IF EXISTS `#__brazitrac_permissions`;" );
		$database->query();
		$database->setQuery( "DROP TABLE IF EXISTS `#__brazitrac_settings`;" );
		$database->query();
		$database->setQuery( "DROP TABLE IF EXISTS `#__brazitrac_ticket`;" );
		$database->query();
		$database->setQuery( "DROP TABLE IF EXISTS `#__brazitrac_users`;" );
		$database->query();
	}

	return '<div style="text-align: center;"><h3>BraziTrac Ticket System</h3><p>Thanks for using the BraziTrac TicketSystem</p></div>';
}

?>