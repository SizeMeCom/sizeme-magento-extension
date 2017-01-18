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
 * @author    SizeMe Ltd <magento@sizeme.com>
 * @copyright Copyright (c) 2015 SizeMe Ltd (http://www.sizeme.com/)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Data helper class.
 *
 * @category SizeMe
 * @package  SizeMe_Measurements
 * @author   SizeMe Ltd <magento@sizeme.com>
 */
class SizeMe_Measurements_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * General options store config save paths.
     */
    const XML_PATH_SERVICE_STATUS        = 'sizeme_measurements/general/service_status';
    const XML_PATH_CUSTOM_SIZE_SELECTION = 'sizeme_measurements/general/custom_size_selection';

    /**
     * Template settings store config save paths.
     */
    const XML_PATH_TEMPLATE_SETTINGS_REPLACE_PRODUCT_VIEW_TYPE_CONFIGURABLE_TEMPLATE = 'sizeme_measurements/template_settings/replace_product_view_type_configurable_template';

    /**
     * Product attribute store config save paths.
     */
    const XML_PATH_SIZE_ATTRIBUTES = 'sizeme_measurements/attribute_settings/size_attributes';

    /**
     * UI option store config save paths.
     */
    const XML_PATH_UI_OPTION_APPEND_CONTENT_TO 		= 'sizeme_measurements/ui_options/append_content_to';
    const XML_PATH_UI_OPTION_APPEND_SPLASH_TO   	= 'sizeme_measurements/ui_options/append_splash_to';
    const XML_PATH_UI_OPTION_SIZE_SELECTION_ELEMENT = 'sizeme_measurements/ui_options/size_selection_element';
    const XML_PATH_UI_OPTION_INVOKE_ELEMENT			= 'sizeme_measurements/ui_options/invoke_element';
    const XML_PATH_UI_OPTION_INVOKE_EVENT  			= 'sizeme_measurements/ui_options/invoke_event';
    const XML_PATH_UI_OPTION_ADD_TO_CART_ELEMENT	= 'sizeme_measurements/ui_options/add_to_cart_element';
    const XML_PATH_UI_OPTION_ADD_TO_CART_EVENT  	= 'sizeme_measurements/ui_options/add_to_cart_event';
    const XML_PATH_UI_OPTION_FIRST_RECOMMENDATION   = 'sizeme_measurements/ui_options/first_recommendation';
    const XML_PATH_UI_OPTION_LANG_OVERRIDE         	= 'sizeme_measurements/ui_options/lang_override';
    const XML_PATH_UI_OPTION_CUSTOM_CSS         	= 'sizeme_measurements/ui_options/custom_css';

    /**
     * Service status on.
     */
    const SERVICE_STATUS_ON = 'on';

    /**
     * Service status off.
     */
    const SERVICE_STATUS_OFF = 'off';

    /**
     * Service status test.
     */
    const SERVICE_STATUS_TEST = 'test';

    /**
     * The module attribute set name.
     */
    const ATTRIBUTE_GROUP_NAME = 'SizeMe Item';

    /**
     * Returns the service status for the store.
     *
     * @param Mage_Core_Model_Store $store optional store (will use current store if null).
     *
     * @return string the status string, either "on", "off" or "test".
     */
    public function getServiceStatus(Mage_Core_Model_Store $store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_SERVICE_STATUS, $store);
    }

    /**
     * Returns the "size" attribute IDs configured for extension.
     *
     * @param Mage_Core_Model_Store $store optional store (will use current store if null).
     *
     * @return array
     */
    public function getSizeAttributeIds(Mage_Core_Model_Store $store = null)
    {
        $idString = Mage::getStoreConfig(
            self::XML_PATH_SIZE_ATTRIBUTES, $store
        );

        return $this->parseAttributeIds($idString);
    }

    /**
     * Returns option for the buttonize setting.
     *
     * @param Mage_Core_Model_Store $store optional store (will use current store if null).
     *
     * @return boolean
     */
    public function getCustomSizeSelection(Mage_Core_Model_Store $store = null)
    {
        return (bool)Mage::getStoreConfig(
            self::XML_PATH_CUSTOM_SIZE_SELECTION,
            $store
        );
    }

    /**
     * Returns the UI options from the store config.
     *
     * @param Mage_Core_Model_Store $store optional store (will use current store if null).
     *
     * @return array the UI options.
     */
    public function getUiOptionsArray(Mage_Core_Model_Store $store = null)
    {
        return array(
            'append_content_to' => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_APPEND_CONTENT_TO,
                $store
            ),
            'append_splash_to' => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_APPEND_SPLASH_TO, $store
            ),
            'size_selection_element' => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_SIZE_SELECTION_ELEMENT, $store
            ),
            'invoke_element' => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_INVOKE_ELEMENT, $store
            ),
            'invoke_event'  => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_INVOKE_EVENT, $store
            ),
            'add_to_cart_element' => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_ADD_TO_CART_ELEMENT, $store
            ),
            'add_to_cart_event'  => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_ADD_TO_CART_EVENT, $store
            ),
            'first_recommendation' => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_FIRST_RECOMMENDATION, $store
            ),
            'lang_override' => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_LANG_OVERRIDE, $store
            ),
            'custom_css' => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_CUSTOM_CSS, $store
            ),
        );
    }

    /**
     * Checks if the extension is active, i.e. if enabled and service status is
     * something else than "off".
     *
     * @return bool true if active, false otherwise.
     */
    public function isActive()
    {
        return ($this->isModuleEnabled()
            && ($this->getServiceStatus() !== self::SERVICE_STATUS_OFF)
            && ($this->getSizeAttributeIds() !== array())
        );
    }

    /**
     * Checks if the given attribute is a "size" attribute.
     *
     * Size attributes are configured for the extension in the system config.
     *
     * @param Mage_Catalog_Model_Product_Type_Configurable_Attribute $attribute the attribute.
     *
     * @return bool true if the attribute is a "size" attribute.
     */
    public function isSizeAttribute($attribute)
    {
        if ($attribute->hasData('attribute_id')) {
            $attributeIds = $this->getSizeAttributeIds();
            if (in_array($attribute->getData('attribute_id'), $attributeIds)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if we are "allowed" to replace the block template of specified
     * block.
     *
     * This is done by reading the system config values for the extension. We
     * do this check to make it possible for the store owner to not replace
     * the templates, in case he needs to do it in his theme. Then he is also
     * responsible for adding the required SizeMe CSS classes in the template.
     *
     * @param Mage_Core_Block_Template $block the block to check.
     *
     * @return boolean true if allowed, false otherwise.
     */
    public function canReplaceBlockTemplate(Mage_Core_Block_Template $block)
    {
        switch ($block->getData('type')) {
            case 'catalog/product_view_type_configurable':
                return (bool)Mage::getStoreConfig(
                    self::XML_PATH_TEMPLATE_SETTINGS_REPLACE_PRODUCT_VIEW_TYPE_CONFIGURABLE_TEMPLATE
                );

            default:
                return false;
        }
    }

    /**
     * Returns an array of ID's from a comma separated string.
     *
     * @param string $string The string to parse.
     *
     * @return array
     */
    protected function parseAttributeIds($string)
    {
        $attributeIds = array();
        if (is_string($string) && !empty($string)) {
            $idList = explode(',', $string);
            if (is_array($idList) && count($idList) > 0) {
                $attributeIds = $idList;
            }
        }

        return $attributeIds;
    }

    /**
     * Checks which SizeMe attributes are swatches attributes.
     *
     * @param Mage_Catalog_Model_Product $product
     *
     * @return bool
     */
    public function getSwatchAttributes($product)
    {
        if (!$this->isSwatchesEnabled()) {
            return false;
        }

		$arr = array();

        $swatchesAttributeIds = $this->parseAttributeIds(
            Mage::getStoreConfig('configswatches/general/swatch_attributes')
        );

        /** @var Mage_Catalog_Model_Product $variation */
        $variation      = array_pop($this->getVariations($product));
        $attributeCodes = $this->getSizeAttributeCodes($variation, false);

        $attributes = Mage::getModel('eav/entity_attribute')->getCollection()
            ->addFieldToFilter(
                'attribute_id', array('in' => $this->getSizeAttributeIds())
            );

        foreach ($attributes as $attribute) {
            $code = $attribute->getData('attribute_code');
            if (in_array($code, $attributeCodes)) {
                if (in_array(
                    $attribute->getData('attribute_id'), $swatchesAttributeIds
                )) {
                    $arr[] = $attribute->getData('attribute_id');
                }
            }
        }
        return $arr;
    }

    /**
     * Checks if the swatches are enabled.
     *
     * @return bool
     */
    public function isSwatchesEnabled()
    {
        return (bool)Mage::getStoreConfig(
            'configswatches/general/enabled'
        );
    }

    /**
     * Returns a list of product variations, i.e. the product size options.
     *
     * @param Mage_Catalog_Model_Product $product the product model.
     *
     * @return Mage_Catalog_Model_Product[] the variations.
     */
    public function getVariations(Mage_Catalog_Model_Product $product)
    {
        $variations        = array();
        $helper            = Mage::helper('catalog/product');
        $skipSaleableCheck = false;
        // Older versions doesn't have the function, e.g. 1.6.X.X
        if (method_exists($helper, 'getSkipSaleableCheck')) {
            $skipSaleableCheck = $helper->getSkipSaleableCheck();
        }

        /** @var Mage_Catalog_Model_Product[] $collection */
        $collection = Mage::getModel('catalog/product_type_configurable')
            ->getUsedProductCollection($product)
            ->addAttributeToSelect('*');
        foreach ($collection as $item) {
            $sizeAttributeValue = $this->getSizeAttributeValue($item);
            if ($item->isSaleable()
                || $skipSaleableCheck
                && !isset($variations[$sizeAttributeValue])
            ) {
                $variations[$sizeAttributeValue] = $item;
            }
        }

        return $variations;
    }

    /**
     * Returns the attribute value for the "size" attribute for the product.
     *
     * @param Mage_Catalog_Model_Product $product the product model.
     *
     * @return int the attribute value.
     */
    public function getSizeAttributeValue(Mage_Catalog_Model_Product $product)
    {
        return $product->getData($this->getSizeAttributeCodes($product));
    }

    /**
     * Returns the attribute code for the "size" attribute for the product.
     *
     * @param Mage_Catalog_Model_Product $product
     * @param bool                       $one true if we want only one code, false if we want a list.
     *
     * @return string The attribute code.
     */
    protected function getSizeAttributeCodes(Mage_Catalog_Model_Product $product, $one = true)
    {
        $attributeCodes   = array();
        $sizeAttributeIds = $this->getSizeAttributeIds();
        foreach ($product->getAttributes() as $attribute) {
            if (in_array($attribute->getAttributeId(), $sizeAttributeIds)) {
                $attributeCodes[] = $attribute->getAttributeCode();
            }
        }

        return $one ? array_pop($attributeCodes) : $attributeCodes;
    }
}
