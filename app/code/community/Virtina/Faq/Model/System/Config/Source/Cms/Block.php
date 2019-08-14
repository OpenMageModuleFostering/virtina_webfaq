<?php

 /**
 * Virtina
 * @package    Virtina_Faq
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class Virtina_Faq_Model_System_Config_Source_Cms_Block
{
    protected $_options;

    # To display list of cms pages as dropdown
    
    public function toOptionArray(){
		if (!$this->_options) {   
			$collection = Mage::getModel('cms/page')->getCollection();
			$staticBlock = array(''=>'-- Select --');

			foreach($collection as $block){
				$staticBlock[$block->getIdentifier()] = $block->getTitle();			
			}

			$this->_options = $staticBlock;
		}
		return $this->_options;
    }
}
?>
