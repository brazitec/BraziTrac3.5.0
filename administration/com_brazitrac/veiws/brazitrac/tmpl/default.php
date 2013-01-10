<div class="adminform">
    <div class="cpanel-left">
        <div id="cpanel">
            <div id="cpanel">
                <div style="float: left;">
                    <div class="icon">
                        <a href="<?php echo JRoute::_('index.php?option=com_brazitrac&task=announcement.list'); ?>">
                            <img alt="<?php echo JText::_('WHD_ANNOUNCEMENTS'); ?>" src="components/com_brazitrac/assets/icons/announcement.png"/>
                            <span><?php echo JText::_('WHD_ANNOUNCEMENTS'); ?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div id="cpanel">
                <div style="float: left;">
                    <div class="icon">
                        <a href="<?php echo JRoute::_('index.php?option=com_brazitrac&task=glossary.list'); ?>">
                            <img alt="<?php echo JText::_('WHD_GLOSSARY'); ?>" src="components/com_brazitrac/assets/icons/glossary.png"/>
                            <span><?php echo JText::_('WHD_GLOSSARY'); ?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div id="cpanel">
                <div style="float: left;">
                    <div class="icon">
                        <a href="<?php echo JRoute::_('index.php?option=com_brazitrac&task=faqcategories.list'); ?>">
                            <img alt="<?php echo JText::_('WHD_FC:FAQ CATEGORIES'); ?>" src="components/com_brazitrac/assets/icons/faqcategory.png"/>
                            <span><?php echo JText::_('WHD_FC:FAQ CATEGORIES'); ?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div id="cpanel">
                <div style="float: left;">
                    <div class="icon">
                        <a href="<?php echo JRoute::_('index.php?option=com_brazitrac&task=faq.list'); ?>">
                            <img alt="<?php echo JText::_('FAQS'); ?>" src="components/com_brazitrac/assets/icons/faq.png"/>
                            <span><?php echo JText::_('FAQS'); ?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div id="cpanel">
                <div style="float: left;">
                    <div class="icon">
                        <a href="<?php echo JRoute::_('index.php?option=com_brazitrac&task=requestcategory.list'); ?>">
                            <img alt="<?php echo JText::_('WHD_RC:REQUEST CATEGORIES'); ?>" src="components/com_brazitrac/assets/icons/requestcategory.png"/>
                            <span><?php echo JText::_('WHD_RC:REQUEST CATEGORIES'); ?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div id="cpanel">
                <div style="float: left;">
                    <div class="icon">
                        <a href="<?php echo JRoute::_('index.php?option=com_brazitrac&task=request.list'); ?>">
                            <img alt="<?php echo JText::_('WHD_R:REQUESTS'); ?>" src="components/com_brazitrac/assets/icons/request.png"/>
                            <span><?php echo JText::_('WHD_R:REQUESTS'); ?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div id="cpanel">
                <div style="float: left;">
                    <div class="icon">
                        <a href="<?php echo JRoute::_('index.php?option=com_brazitrac&task=requestpriority.list'); ?>">
                            <img alt="<?php echo JText::_('WHD_RP:REQUEST PRIORITIES'); ?>" src="components/com_brazitrac/assets/icons/requestpriority.png"/>
                            <span><?php echo JText::_('WHD_RP:REQUEST PRIORITIES'); ?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div id="cpanel">
                <div style="float: left;">
                    <div class="icon">
                        <a href="">
                            <img alt="<?php echo JText::_('WHD_STATISTICS'); ?>" src="components/com_brazitrac/assets/icons/statistics.png"/>
                            <span><?php echo JText::_('WHD_STATISTICS'); ?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div id="cpanel">
                <div style="float: left;">
                    <div class="icon">
                        <a href="<?php echo JRoute::_('index.php?option=com_plugins&view=plugins&filter_folder=brazitrac'); ?>">
                            <img alt="<?php echo JText::_('WHD_PLUGINS'); ?>" src="components/com_brazitrac/assets/icons/plugins.png"/>
                            <span><?php echo JText::_('WHD_PLUGINS'); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cpanel-right">
    <div class="pane-sliders" id="content-pane">
        <?php
        // get the sliders
        jimport('joomla.html.pane');
        $pane =& JPane::getInstance('sliders');
        ?>
        <?php echo $pane->startPane("fieldset-pane"); ?>
        <?php echo $pane->startPanel(JText:: _('STATISTICS'), 'statistics-panel'); ?>
        <div style="background-color: #FFFFFF; text-align: center; height: 260px;">
            <?php

            /*wimport('ofc.open-flash-chart-object');
            open_flash_chart_object(
                500,
                250,
                'http://localhost/WATS/svn_4.0/administrator/components/com_brazitrac/classes/ofc/lib/bar-chart.php',
                true,
                'components/com_brazitrac/classes/ofc/'
            );*/

            ?>
        </div>
        <?php echo $pane->endPanel(); ?>
        <?php echo $pane->endPane(); ?>
    </div>
</div>
<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="adminForm">
    <!-- request options -->
    <input type="hidden" name="option"       value="com_brazitrac" />
    <input type="hidden" name="task"         value="" />
    <input type="hidden" name="targetType"   value="helpdesk" />
    <input type="hidden" name="targetIdentifier" value="helpdesk" />
    <input type="hidden" name="targetIdentifierAlias" value="<?php echo base64_encode(JText::_('Default Helpdesk Permissions')); ?>" />
    <input type="hidden" name="returnURI" value="<?php echo base64_encode(JRoute::_('index.php?option=com_brazitrac')); ?>" />
    <?php echo JHTML::_('form.token'); ?>
</form>



































<!--
<script type="text/javascript" src="components/com_brazitrac/assets/javascript/plootr/lib/excanvas/excanvas.js"></script>
<script type="text/javascript" src="components/com_brazitrac/assets/javascript/plootr/plootr_uncompressed.js"></script>

<div class="graph"> <canvas id="plotr1" height="500" width="600"> </canvas> </div>

<script type="text/javascript">
var Site={
			// Define a dataset.
			dataset : {
				'myFirstDataset': 	[[0, 3], [1, 2], [2, 1.414], [3, 2.3]],
				'mySecondDataset': 	[[0, 1.4], [1, 2.67], [2, 1.34], [3, 1.2]],
				'myThirdDataset': 	[[0, 0.46], [1, 1.45], [2, 1.0], [3, 1.6]],
				'myFourthDataset': 	[[0, 0.3], [1, 0.83], [2, 0.7], [3, 0.2]]
			},

			// Define options.
			options : {
				// Define a padding for the canvas node
				padding: {left: 30, right: 0, top: 10, bottom: 30},

				// Background color to render.
				backgroundColor: '#f2f2f2',

				// Use the predefined blue colorscheme.
				colorScheme: 'blue',

				// Set the labels.
			   	xTicks: [
					{v:0, label:'January'},
			      	{v:1, label:'Februari'},
			      	{v:2, label:'March'},
			      	{v:3, label:'April'}
				]
			},
			graph:function(){
				// Instantiate a new LineCart.
				var line = new Plotr.LineChart('lines1',Site.options);
				// Add a dataset to it.
				line.addDataset(Site.dataset);
				// Render it.
				line.render();

				// Instead of instantiating a new LineChart object,
				// you also can use reset(), that resets the options and datasets.
				line.reset();

				// Change some attributes.
				Object.extend(Site.options,{
					// Use the predefined red colorscheme.
					colorScheme: 'red',

					// Background color to render.
					backgroundColor: '#f2f2f2',

					shouldFill: false,

					// Set a custom colorScheme
					colorScheme: new Hash({
						'myFirstDataset': '#1c4a7e',
						'mySecondDataset': '#bb5b3d',
						'myThirdDataset': '#3a8133',
						'myFourthDataset': '#813379'
					}),

					// Set the labels.
					xTicks: [
						{v:0, label:'IE6'},
						{v:1, label:'IE7'},
						{v:2, label:'FF2'},
						{v:3, label:'Opera 9'}
					]
				});
				// Parse the table.
				line.addDataset(Site.dataset);
				// Render the BarChart.
				line.render('lines2', Site.options);
			}
		};
		window.addEvent('domready',Site.graph);
</script>
-->