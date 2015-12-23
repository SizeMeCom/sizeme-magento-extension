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
 * SizeMe catalog product view content block.
 *
 * Adds the SizeMe product meta-data to product pages.
 *
 * @category SizeMe
 * @package  SizeMe_Measurements
 * @author   SizeMe Ltd <magento@sizeme.com>
 */
class SizeMe_Measurements_Block_Catalog_Product_View_Content extends Mage_Catalog_Block_Product_Abstract
{

    /**
     * Render the view file if module is active, i.e. if enabled, service
     * status is something else than "off" and the product is a "Configurable"
     * product. The product type restriction is added due to SizeMe affects
     * only products that can have a "size" option that is chosen by the
     * customer.
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
            || $helper->hasSwatchAttributes($product)
        ) {
            return '';
        }

        return parent::_toHtml();
    }

    /**
     * Returns a list of product variations, i.e. the product size options.
     *
     * @param Mage_Catalog_Model_Product $product the product model.
     *
     * @return Mage_Catalog_Model_Product[] the variations.
     */
    protected function getVariations(Mage_Catalog_Model_Product $product)
    {
        /** @var SizeMe_Measurements_Helper_Data $helper */
        $helper = Mage::helper('sizeme_measurements');
        return $helper->getVariations($product);
    }

    /**
     * Returns a map of SizeMe attribute names with their corresponding values.
     *
     * The map can be directly converted into and JS SizeMe product item in the
     * view file.
     *
     * Format:
     *
     * array(
     *   "chest"              => 530,
     *   "waist"              => 510,
     *   "sleeve"             => 220,
     *   "sleeve_top_width"   => 208,
     *   "wrist_width"        => 175,
     *   "underbust"          => 0,
     *   "neck_opening_width" => 0,
     *   "shoulder_width"     => 126,
     *   "front_height"       => 720,
     *   "pant_waist"         => 0,
     *   "hips"               => 510,
     *   "inseam"             => 0,
     *   "outseam"            => 0,
     *   "thigh_width"        => 0,
     *   "knee_width"         => 0,
     *   "calf_width"         => 0,
     *   "pant_sleeve_width"  => 0,
     *   "shoe_inside_length" => 0,
     *   "shoe_inside_width"  => 0,
     *   "hat_width"          => 0,
     *   "hood_height"        => 0,
     * )
     *
     * @param Mage_Catalog_Model_Product $product the product model.
     *
     * @return array the attribute map.
     */
    protected function getVariationSizeMeAttributes(Mage_Catalog_Model_Product $product)
    {
        $attributes = array();
        foreach ($product->getData() as $attribute => $value) {
            if (substr($attribute, 0, 3) === "sm_") {
                $attributes[substr($attribute, 3)] = $value;
            }
        }

        return $attributes;
    }
}
