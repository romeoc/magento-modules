<?php 

namespace RC\Offices\Model;

class Office extends \Magento\Framework\Model\AbstractExtensibleModel implements \RC\Offices\Api\Data\OfficeInterface
{
    const CACHE_TAG = 'rc_office';

    protected $_cacheTag = 'rc_office';
    protected $_eventPrefix = 'rc_office';

    const NAME = 'name';
    const DESCRIPTION = 'description';
    const IMAGE = 'image';
    const ORIGIN = 'orign';
    
    /**
     * Initialize Office Model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('RC\Offices\Model\ResourceModel\Office');
    }

    /**
     * Get office name
     * @return string
     */
    public function getName()
    {
        return $this->_getData(self::NAME);
    }
    
    /**
     * Set office id
     * 
     * @param string
     * @return $this
     */
    public function setName($name)
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * Get office description
     * @return string
     */
    public function getDescription()
    {
        return $this->_getData(self::DESCRIPTION);
    }
    
    /**
     * Set office description
     * 
     * @param string
     * @return $this
     */
    public function setDescription($description)
    {
        $this->setData(self::DESCRIPTION, $description);
    }
    
    /**
     * Get office image
     * @return string
     */
    public function getImage()
    {
        return $this->_getData(self::IMAGE);
    }
    
    /**
     * Set office image
     * 
     * @param string
     * @return $this
     */
    public function setImage($image)
    {
        $this->setData(self::IMAGE, $image);
    }
    
    /**
     * Get origin
     * @return string
     */
    public function getOrigin()
    {
        return $this->_getData(self::ORIGIN);
    }
    
    /**
     * Set origin
     * 
     * @param string
     * @return $this
     */
    public function setOrigin($origin)
    {
        $this->setData(self::ORIGIN, $origin);
    }
}
