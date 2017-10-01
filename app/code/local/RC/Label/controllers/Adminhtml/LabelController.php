<?php

/**
 * Label Controller
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Adminhtml_LabelController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Initialize Menu
     *
     * @return \RC_Label_Adminhtml_LabelController
     */
    protected function _initializeMenu()
    {
        $this->loadLayout()
            ->_setActiveMenu('catalog/rc_label')
            ->_addBreadcrumb(Mage::helper('rc_label')->__('Labels Manager'), Mage::helper('rc_label')->__('Labels Manager'));

        return $this;
    }

    public function indexAction()
    {
        $this->_initializeMenu()->renderLayout();
    }
    
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('rc_label/label')->load($id);
        
        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

            if (!empty($data)) {
                $model->setData($data);
            }

            $model->getConditions()->setJsFormObject('rule_label_conditions');
            Mage::register('label_data', $model);
            
            $this->loadLayout();
            $this->_setActiveMenu('catalog/rc_label');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Label Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Labels'), Mage::helper('adminhtml')->__('Label'));
            
            //create block for layout
            $this->_addContent($this->getLayout()->createBlock('rc_label/adminhtml_label_edit'))
                 ->_addLeft($this->getLayout()->createBlock('rc_label/adminhtml_label_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('rc_label')->__('Label does not exist'));
            $this->_redirect('*/*/');
        }
    }
    
    public function newAction()
    {
        $this->_forward('edit');
    }
    
    public function saveAction()
    {       
        $model = Mage::getModel('rc_label/label');
        $helper = Mage::helper('rc_label');
        
        $labelId = $this->getRequest()->getParam('id');
        $labelData = $this->getRequest()->getPost();
        
        $model->prepareDataForSave($labelData)->setId($labelId);

        try {
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess($helper->__('Label was successfully saved!'));
            Mage::getSingleton('adminhtml/session')->setFormData(false);
            
            Mage::getSingleton('index/indexer')->processEntityAction(
                $model, $model::ENTITY, Mage_Index_Model_Event::TYPE_SAVE
            );

            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
            } else {
                $this->_redirect('*/*/');
            }
            
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($labelData);
            $this->_redirect('*/*/edit', array('id' => $labelId));
            return;
        }
        
        Mage::getSingleton('adminhtml/session')->addError($helper->__('Unable to find label to save'));
        $this->_redirect('*/*/');
    }
    
    public function deleteAction()
    {
        $labelId = $this->getRequest()->getParam('id');
        if ($labelId > 0) {
            try {
                $model = Mage::getModel('rc_label/label');
                $model->setId($labelId)->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('rc_label')->__('Label was successfully deleted!'));
                
                Mage::getSingleton('index/indexer')->processEntityAction(
                    $model, $model::ENTITY, Mage_Index_Model_Event::TYPE_DELETE
                );
                
                $this->_redirect('*/*/');
                
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $labelId));
            }
        }
        $this->_redirect('*/*/');
    }
    
    public function massDeleteAction() 
    {
        $labelIds = $this->getRequest()->getParam('labels');
        if (!is_array($labelIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select labels'));
        } else {
            try {
                foreach ($labelIds as $labelId) {
                    $label = Mage::getModel('rc_label/label')->load($labelId);
                    $label->delete();
                }
                
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('rc_label')->__(
                                'Total of %d label(s) were successfully deleted', count($labelIds)
                        )
                );
                
                Mage::getSingleton('index/indexer')->processEntityAction(
                    $labelIds, $label::ENTITY, Mage_Index_Model_Event::TYPE_MASS_ACTION
                );
                
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/');
    }
}

