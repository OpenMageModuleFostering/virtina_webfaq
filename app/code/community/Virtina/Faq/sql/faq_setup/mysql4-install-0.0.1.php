<?php 
 
 /**
 * Virtina
 * @package    Virtina_Faq
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
$installer = $this;
$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('faq_details')};
CREATE TABLE {$this->getTable('faq_details')} (
  `faq_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `subject` text NOT NULL default '',
  `question` text NOT NULL default '',
  `posted_time` datetime NULL,
  `answer` text NOT NULL default '',
  `status` text NOT NULL default '',
  `checkstatus` smallint(6) NOT NULL default '0',
  PRIMARY KEY (`faq_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->endSetup(); 
