<?php

 /**
 * Virtina
 * @package    Virtina_Faq
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Virtina_Faq_Model_Observer
{
    #To include cms page link in Topmenu 
    
    public function addToTopmenu(Varien_Event_Observer $observer){
        $cms_page = Mage::getStoreConfig('webfaqtab1/general/dropdown');		
		$cms_page_url =  Mage::getUrl($cms_page);
		$cms_page_link = Mage::getStoreConfig('webfaqtab1/general/faqheading');  
        if($cms_page != ''){
			$menu = $observer->getMenu();
			$tree = $menu->getTree();
			$node = new Varien_Data_Tree_Node(array(
				'name'   => $cms_page_link,
				'id'     => 'faq',
				'url'    => $cms_page_url,
			), 'id', $tree, $menu);

			$menu->addChild($node);
		}
    }
}
