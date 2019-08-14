<?php

 /**
 * Virtina
 * @package    Virtina_Faq
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class Virtina_Faq_Block_Faq extends Mage_Core_Block_Template
{
	# Constructor
	
    public function __construct(){
        parent::__construct();
        $collection = Mage::getModel('faq/faq')->getCollection();
        $this->setCollection($collection);
    }

    # To display pager limit
    
    protected function _prepareLayout(){
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit(array(5=>5,10=>10,15=>15,20=>20,'all'=>'all'));
        $pager->setCollection($this->getCollection()->addFieldToFilter('status','Approved'));
        $this->setChild('pager', $pager);
        $this->getCollection()->addFieldToFilter('status','Approved')->load();

        return $this;       
    }
    
    # Pager
    
    public function getPagerHtml(){
        return $this->getChildHtml('pager');
    }
    
    # Retrieving backend configured Module status
	
    public function getModuleStatus(){		
		$ModuleStatus = Mage::getStoreConfig('webfaqtab1/general/activemodule');			
		if($ModuleStatus == ""){
			$ModuleStatus = 1;  //set default module status
		}
		return $ModuleStatus;
    }
    
    # Retrieving backend configured Date Display status
    
    public function getDateStatus(){		
		$DateStatus = Mage::getStoreConfig('webfaqtab1/general/showposteddate');			
		if($DateStatus == ""){
			$DateStatus = 1;   //set default display date status
		}
		return $DateStatus;
    }
    
    # Retrieving backend configured Heading
    
    public function getCustomHeading(){		
		$CustomHeading = Mage::getStoreConfig('webfaqtab1/general/faqheading');			
		if($CustomHeading == ""){
			$CustomHeading = "FREQUENTLY ASKED QUESTIONS"; //set default Heading
		}
		return $CustomHeading;
    }
         
}
?>
