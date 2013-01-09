<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
echo "<script language=\"javascript\" type=\"text/javascript\" src=\"components/com_brazitrac/admin.wats.js\"></script>";
// add javaScript
$document =& JFactory::getDocument();
//$document->addScript("../components/com_brazitrac/wats.js");

// add CSS
//$document->addStyleDeclaration(".icon-48-wats { background-image:url(components/com_brazitrac/images/icon-48-watshead.png );}");

// set heading
JToolBarHelper::title("Brazitrac Ticket System", "wats");

// get settings
//$wats = WFactory::getConfig();
// stats
			$database = JFactory::getDBO();
			
			$database->setQuery( "SELECT COUNT(*) as count FROM #__brazitrac_ticket" );
			$set = $database->loadObjectList();
			$watsStatTickets = $set[0]->count;
			$watsStatTicketsRaw = $watsStatTickets;
			if ( $watsStatTickets == 0 )
				$watsStatTickets = 1;
			$database->setQuery( "SELECT COUNT(*) as count FROM #__brazitrac_ticket WHERE lifeCycle=1" );
			$set = $database->loadObjectList();
			$watsStatTicketsOpen = $set[0]->count;
			$database->setQuery( "SELECT COUNT(*) as count FROM #__brazitrac_ticket WHERE lifeCycle=2" );
			$set = $database->loadObjectList();
			$watsStatTicketsClosed =  $set[0]->count;;
			$database->setQuery( "SELECT COUNT(*) as count FROM #__brazitrac_ticket WHERE lifeCycle=3" );
			$set = $database->loadObjectList();
			$watsStatTicketsDead = $set[0]->count;
			$database->setQuery( "SELECT COUNT(*) as count FROM #__brazitrac_users" );
			$set = $database->loadObjectList();
			$watsStatUsers = $set[0]->count;
			$database->setQuery( "SELECT COUNT(*) as count FROM #__brazitrac_category" );
			$set = $database->loadObjectList();
			$watsStatCategories = $set[0]->count;
			// end stats;
?>
<table class="adminform"> 
  <tr> 
    <td width="55%" valign="top"> <div id="cpanel"> 
        <div style="float:left;"> 
          <div class="icon"> <a href="index.php?option=com_brazitrac"> 
            <div class="iconimage"> <img src="images/frontpage.png" alt="Frontpage Manager" align="middle" name="image" border="0" /> </div> 
          Brazitrac Ticket System</a> </div> 
        </div> 
        <div style="float:left;"> 
          <div class="icon"> <a href="index.php?option=com_brazitrac&act=configure"> 
            <div class="iconimage"> <img src="images/config.png" alt="Configuration" align="middle" name="image" border="0" /> </div> 
          Configuration</a> </div> 
        </div> 
        <div style="float:left;"> 
          <div class="icon"> <a href="index.php?option=com_brazitrac&act=css"> 
            <div class="iconimage"> <img src="images/menu.png" alt="CSS" align="middle" name="image" border="0" /> </div> 
          CSS</a> </div> 
        </div> 
        <div style="float:left;"> 
          <div class="icon"> <a href="index.php?option=com_brazitrac&act=user"> 
            <div class="iconimage"> <img src="images/user.png" alt="User Manager" align="middle" name="image" border="0" /> </div> 
          User Manager</a> </div> 
        </div> 
        <div style="float:left;"> 
          <div class="icon"> <a href="index.php?option=com_brazitrac&act=rites"> 
            <div class="iconimage"> <img src="images/impressions.png" alt="Rites Manager" align="middle" name="image" border="0" /> </div> 
          Rites Manager</a> </div> 
        </div> 
        <div style="float:left;"> 
          <div class="icon"> <a href="index.php?option=com_brazitrac&act=category"> 
            <div class="iconimage"> <img src="images/categories.png" alt="Category Manager" align="middle" name="image" border="0" /> </div> 
          Category Manager</a> </div> 
        </div> 
        <div style="float:left;"> 
          <div class="icon"> <a href="index.php?option=com_brazitrac&act=ticket"> 
            <div class="iconimage"> <img src="images/addedit.png" alt="Ticket Viewer" align="middle" name="image" border="0" /> </div> 
            Ticket Viewer </a></div> 
        </div> 
        <div style="float:left;"> 
          <div class="icon"> <a href="index.php?option=com_brazitrac&act=database"> 
            <div class="iconimage"> <img src="images/systeminfo.png" alt="Database Maintenance" align="middle" name="image" border="0" /> </div> 
          Database Maintenance </a></div> 
        </div> 
        <div style="float:left;"> 
          <div class="icon"> <a href="index.php?option=com_brazitrac&act=about"> 
            <div class="iconimage"> <img src="images/cpanel.png" alt="About" align="middle" name="image" border="0" /> </div> 
          About </a></div> 
        </div> 
      </div></td> 
    <td width="45%" valign="top"> <div style="width=100%;"> 
        <table class="adminlist"> 
          <tr> 
            <th colspan="3"> Statistics </th> 
          </tr> 
          <tr> 
            <td width="80"> Tickets</td>  
            <td width="60"><?php echo $watsStatTicketsRaw; ?> / 100%</td> 
			<td><img src="components/com_brazitrac/images/red.gif" style="height: 4px; width: 100%;"></td>
          </tr> 
          <tr> 
            <td> Open </td> 
            <td><?php echo $watsStatTicketsOpen; ?> / <?php echo intval((100/$watsStatTickets)*$watsStatTicketsOpen); ?>%</td> 
			<td><img src="components/com_brazitrac/images/red.gif" style="height: 4px; width: <?php echo (100/$watsStatTickets)*$watsStatTicketsOpen; ?>%;"></td>
          </tr>
          <tr>
            <td>Closed</td>
            <td><?php echo $watsStatTicketsClosed; ?> / <?php echo intval((100/$watsStatTickets)*$watsStatTicketsClosed); ?>%</td>
            <td><img src="components/com_brazitrac/images/red.gif" style="height: 4px; width: <?php echo (100/$watsStatTickets)*$watsStatTicketsClosed; ?>%;"></td>
          </tr>
          <tr>
            <td>Dead</td>
            <td><?php echo $watsStatTicketsDead; ?> / <?php echo intval((100/$watsStatTickets)*$watsStatTicketsDead); ?>%</td>
            <td><img src="components/com_brazitrac/images/red.gif" style="height: 4px; width: <?php echo (100/$watsStatTickets)*$watsStatTicketsDead; ?>%;"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Users</td>
            <td><?php echo $watsStatUsers; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Categories</td>
            <td><?php echo $watsStatCategories; ?></td>
			<td>&nbsp;</td>
          </tr> 
        </table> 
      </div></td> 
  </tr> 
</table>
