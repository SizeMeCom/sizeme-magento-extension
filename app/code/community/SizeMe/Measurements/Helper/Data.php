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
 * Data helper class.
 *
 * @category SizeMe
 * @package  SizeMe_Measurements
 * @author   SizeMe Ltd <plugins@sizeme.com>
 */
class SizeMe_Measurements_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * General options store config save paths.
     */
    const XML_PATH_SERVICE_STATUS        = 'sizeme_measurements/general/service_status';
    const XML_PATH_API_KEY               = 'sizeme_measurements/general/api_key';
    const XML_PATH_CUSTOM_SIZE_SELECTION = 'sizeme_measurements/general/custom_size_selection';

    /**
     * Template settings store config save paths.
     */
    const XML_PATH_TEMPLATE_SETTINGS_REPLACE_PRODUCT_VIEW_TYPE_CONFIGURABLE_TEMPLATE = 
        'sizeme_measurements/template_settings/replace_product_view_type_configurable_template';

    /**
     * Product attribute store config save paths.
     */
    const XML_PATH_SIZE_ATTRIBUTES = 'sizeme_measurements/attribute_settings/size_attributes';

    /**
     * UI option store config save paths.
     */
    const XML_PATH_UI_OPTION_APPEND_CONTENT_TO      = 'sizeme_measurements/ui_options/append_content_to';
    const XML_PATH_UI_OPTION_INVOKE_ELEMENT         = 'sizeme_measurements/ui_options/invoke_element';
    const XML_PATH_UI_OPTION_ADD_TO_CART_ELEMENT    = 'sizeme_measurements/ui_options/add_to_cart_element';
    const XML_PATH_UI_OPTION_SIZE_SELECTOR_TYPE     = 'sizeme_measurements/ui_options/size_selector_type';
    const XML_PATH_UI_OPTION_LANG_OVERRIDE          = 'sizeme_measurements/ui_options/lang_override';
    const XML_PATH_UI_OPTION_SKIN_STRING            = 'sizeme_measurements/ui_options/skin_string';
    const XML_PATH_UI_OPTION_CUSTOM_CSS             = 'sizeme_measurements/ui_options/custom_css';
    const XML_PATH_UI_OPTION_ADDITIONAL_TRANSLATIONS = 'sizeme_measurements/ui_options/additional_translations';


    /**
     * Service statuses.
     */
    const SERVICE_STATUS_ON = 'on';
    const SERVICE_STATUS_OFF = 'off';
    const SERVICE_STATUS_TEST = 'test';
    const SERVICE_STATUS_AB = 'ab';

    /**
     * The module attribute set name.
     */
    const ATTRIBUTE_GROUP_NAME = 'SizeMe Item';

    /**
     * Info related to SizeMe API requests
     */
    const API_CONTEXT_ADDRESS   = 'https://sizeme.com';
    const API_SEND_ORDER_INFO   = '/shop-api/sendOrderComplete';
    const API_SEND_ADD_TO_CART  = '/shop-api/sendAddToCart';
    const COOKIE_SESSION        = 'frontend';       // Magento specific
    const COOKIE_ACTION         = 'sm_action';

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
     * Returns SizeMe API key
     *
     * @param Mage_Core_Model_Store $store optional store (will use current store if null).
     *
     * @return string
     */
    public function getApiKey(Mage_Core_Model_Store $store = null)
    {
        return (string)Mage::getStoreConfig(
            self::XML_PATH_API_KEY,
            $store
        );
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
                self::XML_PATH_UI_OPTION_APPEND_CONTENT_TO, $store
            ),
            'invoke_element' => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_INVOKE_ELEMENT, $store
            ),
            'add_to_cart_element' => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_ADD_TO_CART_ELEMENT, $store
            ),
            'size_selector_type'  => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_SIZE_SELECTOR_TYPE, $store
            ),
            'lang_override' => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_LANG_OVERRIDE, $store
            ),
            'skin_string' => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_SKIN_STRING, $store
            ),
            'custom_css' => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_CUSTOM_CSS, $store
            ),
            'additional_translations' => Mage::getStoreConfig(
                self::XML_PATH_UI_OPTION_ADDITIONAL_TRANSLATIONS, $store
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
     * Returns if service status is "test".
     *
     * @return bool true if test, false otherwise.
     */
    public function isServiceTest()
    {
        return ( $this->getServiceStatus() === self::SERVICE_STATUS_TEST);
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
            if (is_array($idList) && !empty($idList)) {
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
        $productVariations = $this->getVariations($product);
        $variation      = array_pop($productVariations);
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

    // Try to find the correct allowed configurable attribute first
    $sizeAttributeCode = '';

    // Read the allowed attributes
    $allowedSizeAttributeIds = $this->getSizeAttributeIds();

    // Read the configurable attributes from the parent product
    $attributes = $product->getTypeInstance(true)->getConfigurableAttributes($product);

    foreach ($attributes as $attribute) {
        if (in_array($attribute['attribute_id'], $allowedSizeAttributeIds)) {
            $sizeAttributeCode = $attribute->getProductAttribute()->getAttributeCode();
        }
    }

    if (!$sizeAttributeCode) return array();

        /** @var Mage_Catalog_Model_Product[] $collection */
        $collection = Mage::getModel('catalog/product_type_configurable')
            ->getUsedProductCollection($product)
            ->addAttributeToSelect('*');

        foreach ($collection as $item) {
            $sizeAttributeValue = $item->getData($sizeAttributeCode);

            if (($item->isSaleable() || $skipSaleableCheck) && !isset($variations[$sizeAttributeValue])) {
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

    /**
     * Returns the attribute value label for the "size" attribute for the product.
     *
     * @param Mage_Catalog_Model_Product $product
     * @param bool                       $one true if we want only one code, false if we want a list.
     *
     * @return string The attribute value label.
     */
    public function getSizeAttributeValueLabels(Mage_Catalog_Model_Product $product, $one = true)
    {
        $attributeCodes   = array();
        $sizeAttributeIds = $this->getSizeAttributeIds();

        foreach ($product->getAttributes() as $attribute) {
            if (in_array($attribute->getAttributeId(), $sizeAttributeIds)) {
                $attributeCodes[] = strtoupper(trim($attribute->getFrontend()->getValue($product)));
            }
        }

        return $one ? array_pop($attributeCodes) : $attributeCodes;
    }
	
    /**
     * Returns the session cookie value
     *
     * @return string|null
     */
    public function getSessionCookie()
    {
        $cookie = Mage::getModel('core/cookie');
        return $cookie->get(self::COOKIE_SESSION);
    }

    /**
     * Returns the SizeMe action cookie value
     *
     * @return string|null
     */
    public function getActionCookie()
    {
        $cookie = Mage::getModel('core/cookie');
        return $cookie->get(self::COOKIE_ACTION);
    }


}
