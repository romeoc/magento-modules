<?php

namespace RC\Offices\Ui\Component\Listing\Column;

class ImagePreview extends \Magento\Ui\Component\Listing\Columns\Column
{
    const ALT_FIELD = 'title';

    /**
     * Office image model
     * 
     * @var \RC\Offices\Model\Office\Image
     */
    protected $_imageModel;
    
    /**
     * URL builder
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;
    
    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \RC\Offices\Model\Office\Image $imageModel,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->_imageModel = $imageModel;
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            $baseUrl = $this->_imageModel->getBaseUrl();
            
            foreach($dataSource['data']['items'] as & $item) {
                $url = ($fieldName != '') ? $baseUrl . $item[$fieldName] : '';
                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_alt'] = $this->getAlt($item) ?: '';
                $item[$fieldName . '_link'] = $this->_urlBuilder->getUrl(
                    'rc/office/edit',
                    ['office_id' => $item['office_id']]
                );
                
                $item[$fieldName . '_orig_src'] = $url;
            }
        }

        return $dataSource;
    }

    /**
     * @param array $row
     * @return null|string
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return isset($row[$altField]) ? $row[$altField] : null;
    }
}
