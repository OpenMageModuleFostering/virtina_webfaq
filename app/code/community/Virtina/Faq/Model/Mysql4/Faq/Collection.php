<?php
 /**
 * Virtina
 * @package    Virtina_Faq
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Virtina_Faq_Model_Mysql4_Faq_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{ 
    public function _construct(){
		$this->_init('faq/faq');
    }
}
