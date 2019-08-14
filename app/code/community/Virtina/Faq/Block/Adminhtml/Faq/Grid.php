<?php
 
 /**
 * Virtina
 * @package    Virtina_Faq
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class Virtina_Faq_Block_Adminhtml_Faq_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct(){
        parent::__construct();
        $this->setId('faqGrid');
        $this->setDefaultSort('faq_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection(){
        $collection = Mage::getModel('faq/faq')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    protected function _prepareMassaction()
	{
		$this->setMassactionIdField('faq_id');
		$this->getMassactionBlock()->setFormFieldName('faq_id');
		 
		$this->getMassactionBlock()->addItem('delete', array(
			'label'   => Mage::helper('faq')->__('Delete'),
			'url'     => $this->getUrl('*/*/massDelete', array('' => '')),
			'confirm' => Mage::helper('faq')->__('Are you sure?')
			));
		 
		return $this;
	}

    protected function _prepareColumns(){
        $this->addColumn('faq_id', array(
            'header'    => Mage::helper('faq')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'faq_id',
        ));
		$this->addColumn('name', array(
            'header'    => Mage::helper('faq')->__('Name'),
            'align'     => 'left',
            'width'     => '120px',          
            'default'   => '--',
            'index'     => 'name',
        ));
       $this->addColumn('email', array(
            'header'    => Mage::helper('faq')->__('Email'),
            'align'     => 'left',
            'width'     => '120px',           
            'default'   => '--',
            'index'     => 'email',
        )); 
        $this->addColumn('subject', array(
            'header'    => Mage::helper('faq')->__('Subject'),
            'align'     => 'left',
            'width'     => '120px',
            'default'   => '--',
            'index'     => 'subject',
        ));      
	   $this->addColumn('question', array(
            'header'    => Mage::helper('faq')->__('Question'),
            'align'     => 'left',
            'width'     => '120px',
            'default'   => '--',
            'index'     => 'question',
        ));    
       $this->addColumn('posted_time', array(
            'header'    => Mage::helper('faq')->__('posted_time'),
            'align'     => 'left',
            'width'     => '120px',
            'default'   => '--',
            'sortable'  => true,
            'index'     => 'posted_time',
        ));      
         $this->addColumn('status', array(
            'header'    => Mage::helper('faq')->__('Status'),
            'align'     => 'left',
            'width'     => '120px',
            'default'   => '--',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                'Approved' => 'Approved',
                'Pending'  => 'Pending',
            ),

        ));

        return parent::_prepareColumns();
    }
    
    public function getRowUrl($row){
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
