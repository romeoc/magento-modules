<?php

namespace RC\Offices\Block\Adminhtml\Office\Helper;

class Image extends \Magento\Framework\Data\Form\Element\Image
{
    /**
     * Office image model
     * 
     * @var \RC\Offices\Model\Office\Image
     */
    protected $_imageModel;

    /**
     * constructor
     * 
     * @param \RC\Offices\Model\Office\Image $imageModel
     * @param \Magento\Framework\Data\Form\Element\Factory $factoryElement
     * @param \Magento\Framework\Data\Form\Element\CollectionFactory $factoryCollection
     * @param \Magento\Framework\Escaper $escaper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        \RC\Offices\Model\Office\Image $imageModel,
        \Magento\Framework\Data\Form\Element\Factory $factoryElement,
        \Magento\Framework\Data\Form\Element\CollectionFactory $factoryCollection,
        \Magento\Framework\Escaper $escaper,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $data
    )
    {
        $this->_imageModel = $imageModel;
        parent::__construct($factoryElement, $factoryCollection, $escaper, $urlBuilder, $data);
    }

    /**
     * Get image preview url
     *
     * @return string
     */
    protected function _getUrl()
    {
        $url = false;
        
        if ($this->getValue()) {
            $url = $this->_imageModel->getBaseUrl() . $this->getValue();
        }
        
        return $url;
    }
}
