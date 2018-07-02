<?php

namespace RC\Offices\Model\Office;

class Image
{
    /**
     * Media sub folder
     * @var string
     */
    const UPLOAD_PATH = 'rc/offices';

    /**
     * URL builder
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    /**
     * File system model
     * @var \Magento\Framework\Filesystem
     */
    protected $_fileSystem;

    /**
     * constructor
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magento\Framework\Filesystem $fileSystem
     */
    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Filesystem $fileSystem
    ) {
        $this->_urlBuilder = $urlBuilder;
        $this->_fileSystem = $fileSystem;
    }
    
    /**
     * get images base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->_urlBuilder->getBaseUrl(['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]) . self::UPLOAD_PATH;
    }
    /**
     * get base image dir
     *
     * @return string
     */
    public function getBaseDir()
    {
        return $this->_fileSystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath(self::UPLOAD_PATH);
    }
}

