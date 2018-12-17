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
 * @copyright Copyright (c) SizeMe Ltd (https://www.sizeme.com/)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adds the SizeMe attributes to all existing attribute sets.
 * This way they become available for all types of products and can be removed
 * per attribute set by the site administrator for products that does not need
 * them.
 *
 * @var SizeMe_Measurements_Model_Resource_Setup $installer
 */

$installer = $this;
/** @var Mage_Eav_Model_Entity_Setup $setup */
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();

$attributesToInstall = $installer->getAttributesToInstall();

/** @var Mage_Eav_Model_Entity_Attribute_Set[] $collection */
$collection = Mage::getResourceModel('eav/entity_attribute_set_collection')
    ->addFieldToFilter(
        'entity_type_id',
        $setup->getEntityTypeId('catalog_product')
    );

foreach ($collection as $attributeSet) {
    $attributeSetId = $attributeSet->getId();

    /** @var Mage_Catalog_Model_Product_Attribute_Group $attributeGroup */
    $attributeGroup = $setup->getAttributeGroup(
        'catalog_product',
        $attributeSetId,
        SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME
    );

    if (!$attributeGroup) {
        $setup->addAttributeGroup(
            'catalog_product',
            $attributeSet->getAttributeSetName(),
            SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
            1000
        );
    }

    $attributes = $installer->getAttributes($attributeSetId);
    $missingAttributeCodes = $installer->getMissingAttributeCodes(
        array_keys($attributesToInstall), $attributes
    );

    foreach ($missingAttributeCodes as $code) {
        if (isset($attributesToInstall[$code])) {
            $data = $attributesToInstall[$code];
            $data['attribute_set'] = $attributeSet->getAttributeSetName();
            $setup->addAttribute('catalog_product', $code, $data);
        }
    }
}

$installer->endSetup();
