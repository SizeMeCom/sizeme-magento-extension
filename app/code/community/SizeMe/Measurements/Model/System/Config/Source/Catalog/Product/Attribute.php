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
 * System config source model for the extension product "size" attribute
 * selection.
 *
 * @category SizeMe
 * @package  SizeMe_Measurements
 * @author   SizeMe Ltd <magento@sizeme.com>
 */
class SizeMe_Measurements_Model_System_Config_Source_Catalog_Product_Attribute
{
    /**
     * Returns the status options for the extension.
     *
     * @return array the options.
     */
    public function toOptionArray()
    {
        $options = array();

        $collection = Mage::getResourceModel('catalog/product_attribute_collection')
            ->addVisibleFilter()
            ->setFrontendInputTypeFilter('select')
            ->addFieldToFilter('additional_table.is_configurable', 1)
            ->addFieldToFilter('additional_table.is_visible', 1)
            ->addFieldToFilter('main_table.is_user_defined', 1)
            ->setOrder('frontend_label', Varien_Data_Collection::SORT_ORDER_ASC);

        foreach ($collection as $attribute) {
            $options[] = array(
                'label' => $attribute->getFrontendLabel(),
                'value' => $attribute->getId(),
            );
        }

        return $options;
    }
}
