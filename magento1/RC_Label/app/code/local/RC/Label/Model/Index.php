<?php

/**
 * Labels Index Model
 * 
 * Module: Label
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */
class RC_Label_Model_Index extends Mage_Index_Model_Indexer_Abstract
{
    /**
     * Event key
     */
    const EVENT_MATCH_RESULT_KEY = 'labels_match_result';

    /**
     * Matched entities
     * @var array
     */
    protected $_matchedEntities = array(
        Mage_Catalog_Model_Product::ENTITY => array(
            Mage_Index_Model_Event::TYPE_SAVE,
            Mage_Index_Model_Event::TYPE_DELETE,
            Mage_Index_Model_Event::TYPE_MASS_ACTION
        ),
        RC_Label_Model_Label::ENTITY => array(
            Mage_Index_Model_Event::TYPE_SAVE,
            Mage_Index_Model_Event::TYPE_DELETE,
            Mage_Index_Model_Event::TYPE_MASS_ACTION
        )
    );

    /**
     * Indexer name
     * @return string
     */
    public function getName()
    {
        return Mage::helper('rc_label')->__('Product Labels');
    }

    /**
     * Indexer description
     * @return string
     */
    public function getDescription()
    {
        return Mage::helper('rc_label')->__('Index product labels');
    }

    /**
     * Indexer resource model
     * @return RC_Label_Model_Resource_Index
     */
    protected function _getIndexer()
    {
        return Mage::getResourceSingleton('rc_label/index');
    }

    
    /**
     * When an event is matched
     * @param Mage_Index_Model_Event $event
     * @return boolean
     */
    public function matchEvent(Mage_Index_Model_Event $event)
    {
        $data = $event->getNewData();
        if (isset($data[self::EVENT_MATCH_RESULT_KEY])) {
            return $data[self::EVENT_MATCH_RESULT_KEY];
        }

        $entity = $event->getEntity();
        $result = true;

        if ($entity !== Mage_Catalog_Model_Product::ENTITY && $entity !== RC_Label_Model_Label::ENTITY) {
            $result = false;
        }

        $event->addNewData(self::EVENT_MATCH_RESULT_KEY, $result);
        return $result;
    }

    /**
     * Register a new event
     * @param Mage_Index_Model_Event $event
     */
    protected function _registerEvent(Mage_Index_Model_Event $event)
    {
        $dataObj = $event->getDataObject();
        $entity    = $event->getEntity();
        
        switch ($event->getType()) {
            case (Mage_Index_Model_Event::TYPE_SAVE):
                $event->addNewData('process_ids', $dataObj->getId());
                break;
            case (Mage_Index_Model_Event::TYPE_DELETE):
                $event->addNewData('process_ids', array($dataObj->getId()));
                break;
            case (Mage_Index_Model_Event::TYPE_MASS_ACTION):
                if ($entity === Mage_Catalog_Model_Product::ENTITY) {
                    $event->addNewData('process_ids', $dataObj->getProductIds());
                } elseif ($entity === RC_Label_Model_Label::ENTITY) {
                    $event->addNewData('process_ids', $dataObj);
                }
                break;
        }
    }

    /**
     * We are processing the event here
     * @param Mage_Index_Model_Event $event
     */
    protected function _processEvent(Mage_Index_Model_Event $event)
    {
        $data = $event->getNewData();
        $entity = $event->getEntity();
        $type = $event->getType();
        $action = 'rebuildIndex';
        
        if ($entity === Mage_Catalog_Model_Product::ENTITY) {
            switch($type) {
                case (Mage_Index_Model_Event::TYPE_SAVE):
                    $action = 'refreshByProduct';
                    break;
                case (Mage_Index_Model_Event::TYPE_DELETE):
                    $action = 'dropForProduct';
                    break;
                case (Mage_Index_Model_Event::TYPE_MASS_ACTION):
                    $action = 'dropForProduct';
                    break;
            }
        } elseif ($entity === RC_Label_Model_Label::ENTITY) {
            switch($type) {
                case (Mage_Index_Model_Event::TYPE_SAVE):
                    $action = 'refreshByLabel';
                    break;
                case (Mage_Index_Model_Event::TYPE_DELETE):
                    $action = 'dropForLabel';
                    break;
                case (Mage_Index_Model_Event::TYPE_MASS_ACTION):
                    $action = 'dropForLabel';
                    break;
            }
        }
        
        $this->_getIndexer()->$action($data['process_ids']);
    }

    /**
     * Reindex all labels data
     * @return \RC_Label_Model_Index
     */
    public function reindexAll()
    {
        $this->_getIndexer()->rebuildIndex();
        return $this;
    }
}

