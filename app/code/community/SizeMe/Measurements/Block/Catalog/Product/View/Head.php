<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category  SizeMe
 * @package   SizeMe_Measurements
 * @author    SizeMe Ltd <plugins@sizeme.com>
 * @copyright Copyright (c) 2017 SizeMe Ltd (https://www.sizeme.com/)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * SizeMe catalog product view head block.
 *
 * Adds the needed CSS && JS to the page <head> element.
 *
 * @category SizeMe
 * @package  SizeMe_Measurements
 * @author   SizeMe Ltd <plugins@sizeme.com>
 */
class SizeMe_Measurements_Block_Catalog_Product_View_Head extends Mage_Catalog_Block_Product_Abstract
{

    /**
     * Render the view file if module is active, i.e. if enabled and service
     * status is something else than "off".
     *
     * @return string
     */
    protected function _toHtml()
    {
        /** @var SizeMe_Measurements_Helper_Data $helper */
        $helper = $this->helper('sizeme_measurements');
        $product = $this->getProduct();
        if (!$helper->isActive()
            || !$product->isConfigurable()
        ) {
            return '';
        }

        return parent::_toHtml();
    }

    /**
     * Returns the service status for the current store.
     *
     * @return string the status string "on", "off" or "test".
     */
    public function getServiceStatus()
    {
        return $this->helper('sizeme_measurements')->getServiceStatus();
    }


    /**
     * Get the option for the custom size selection.
     *
     * @return string
     */
    public function getCustomSizeSelection()
    {
        return $this->helper('sizeme_measurements')->getCustomSizeSelection() ? 'yes' : 'no';
    }
	
    /**
     * Returns the version number of the extension.
     *
     * @return string the module version.
     */
    public function getModuleVersion()
    {
        // Path is hard-coded to be like in "etc/config.xml".
        return (string)"MAG1-".Mage::getConfig()->getNode('modules/SizeMe_Measurements/version');
    }


}
