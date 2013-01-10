<?php
/**
 * @version $Id: toolbar.brazitec.php 66 2009-03-31 14:18:46Z brazitrac $
 * @copyright Copyright (C) BraziTech
 * @license GNU/GPL
 * @package brazitrac
 */

// Don't allow direct linking
defined('_JEXEC') or die('Restricted Access');

require_once(JPATH_COMPONENT_ADMINISTRATOR . DS . "toolbar.brazitrac.html.php");



if ($act)
{
	switch ( $act )
	{
		case 'configure':
			menuWATS::WATS_EDIT();
			break;
		case 'ticket':
		case 'database':
		case 'about':
			// no menus
			break;
		case 'css':
			menuWATS::WATS_EDIT_BACKUP();
			break;
		default:
			switch ( $task )
			{
				case 'edit';
				case 'view';
					menuWATS::WATS_EDIT();
					break;
				case 'add';
					menuWATS::WATS_NEW();
					break;
				default:
					menuWATS::WATS_LIST();
					break;
			}
			break;
	}
}
?>