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
    const XML_PATH_UI_OPTION_PREPEND_TOP_HEADER_ELEMENT        = 'sizeme_measurements/ui_options/prepend_top_header_element';
    const XML_PATH_UI_OPTION_APPEND_IN_CONTENT_TOGGLER_ELEMENT = 'sizeme_measurements/ui_options/append_in_content_toggler_element';
    const XML_PATH_UI_OPTION_ACTUAL_SELECTION_ELEMENT          = 'sizeme_measurements/ui_options/actual_selection_element';
    const XML_PATH_UI_OPTION_VISUAL_SELECTION_ELEMENT          = 'sizeme_measurements/ui_options/visual_selection_element';
    const XML_PATH_UI_OPTION_APPEND_SLIDER_ELEMENT             = 'sizeme_measurements/ui_options/append_slider_element';
    const XML_PATH_UI_OPTION_SIZE_SELECTION_CONTAINER_ELEMENT  = 'sizeme_measurements/ui_options/size_selection_container_element';
    const XML_PATH_UI_OPTION_AFTER_DETAILED_LINK_ELEMENT       = 'sizeme_measurements/ui_options/after_detailed_link_element';
    const XML_PATH_UI_OPTION_AFTER_REMORSE_BOX_ELEMENT         = 'sizeme_measurements/ui_options/after_remorse_box_element';
    const XML_PATH_UI_OPTION_APPEND_DETAILED_VIEW_ELEMENT      = 'sizeme_measurements/ui_options/append_detailed_view_element';
    const XML_PATH_UI_OPTION_INSERT_MESSAGES_ELEMENT           = 'sizeme_measurements/ui_options/insert_messages_element';
    const XML_PATH_UI_OPTION_APPEND_SIZE_GUIDE_ELEMENT         = 'sizeme_measurements/ui_options/append_size_guide_element';

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
    const ATTRIBUTE_GROUP_NAME = 'SizeMe Measurements';

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
            'prepend_top_header_element'        => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_PREPEND_TOP_HEADER_ELEMENT, $store
            ),
            'append_in_content_toggler_element' => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_APPEND_IN_CONTENT_TOGGLER_ELEMENT,
                $store
            ),
            'actual_selection_element'          => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_ACTUAL_SELECTION_ELEMENT, $store
            ),
            'visual_selection_element'          => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_VISUAL_SELECTION_ELEMENT, $store
            ),
            'append_slider_element'             => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_APPEND_SLIDER_ELEMENT, $store
            ),
            'size_selection_container_element'  => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_SIZE_SELECTION_CONTAINER_ELEMENT,
                $store
            ),
            'after_detailed_link_element'       => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_AFTER_DETAILED_LINK_ELEMENT, $store
            ),
            'after_remorse_box_element'         => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_AFTER_REMORSE_BOX_ELEMENT, $store
            ),
            'append_detailed_view_element'      => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_APPEND_DETAILED_VIEW_ELEMENT, $store
            ),
            'insert_messages_element'           => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_INSERT_MESSAGES_ELEMENT, $store
            ),
            'append_size_guide_element'         => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_APPEND_SIZE_GUIDE_ELEMENT, $store
            ),
        );
    }

    /**
     * Returns the SizeMe CSS element class name of the size selection container.
     *
     * @param Mage_Core_Model_Store $store optional store (will use current store if null).
     *
     * @return string the CSS element class.
     */
    public function getSizeSelectionContainerElementClassName(Mage_Core_Model_Store $store = null)
    {
        $element = Mage::getStoreConfig(
            self::XML_PATH_UI_OPTION_SIZE_SELECTION_CONTAINER_ELEMENT, $store
        );

        return is_string($element) ? preg_replace(
            '/[^a-z0-9-]+/i', '', $element
        ) : '';
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
     * Checks if the swatches attributes is found in SizeMe attributes.
     *
     * @param Mage_Catalog_Model_Product $product
     *
     * @return bool
     */
    public function hasSwatchAttributes($product)
    {
        if (!$this->isSwatchesEnabled()) {
            return false;
        }

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
                    return true;
                }
            }
        }

        return false;
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
