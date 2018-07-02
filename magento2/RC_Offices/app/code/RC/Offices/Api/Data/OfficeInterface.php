<?php

namespace RC\Offices\Api\Data;

/**
 * Office Interface
 */
interface OfficeInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**
     * Get office id
     * @return int|null
     */
    public function getId();
    
    /**
     * Set office id
     * 
     * @param int
     * @return $this
     */
    public function setId($id);

    /**
     * Get office name
     * @return string
     */
    public function getName();
    
    /**
     * Set office id
     * 
     * @param string
     * @return $this
     */
    public function setName($name);

    /**
     * Get office description
     * @return string
     */
    public function getDescription();
    
    /**
     * Set office description
     * 
     * @param string
     * @return $this
     */
    public function setDescription($description);
    
    /**
     * Get office image
     * @return string
     */
    public function getImage();
    
    /**
     * Set office image
     * 
     * @param string
     * @return $this
     */
    public function setImage($image);
    
    /**
     * Get origin
     * @return string
     */
    public function getOrigin();
    
    /**
     * Set origin
     * 
     * @param string
     * @return $this
     */
    public function setOrigin($origin);
}

