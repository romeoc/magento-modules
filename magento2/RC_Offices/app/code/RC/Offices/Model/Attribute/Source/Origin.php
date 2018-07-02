<?php

namespace RC\Offices\Model\Attribute\Source;

class Origin extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * Get all options
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['label' => __('Europe'), 'value' => 'europe'],
                ['label' => __('USA'), 'value' => 'usa'],
                ['label' => __('Africa'), 'value' => 'africa'],
                ['label' => __('Asia'), 'value' => 'asia']
            ];
        }
        return $this->_options;
    }
}

