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
 * Setup model.
 *
 * Handles tasks when the extension is installed.
 *
 * @category SizeMe
 * @package  SizeMe_Measurements
 * @author   SizeMe Ltd <magento@sizeme.com>
 */
class SizeMe_Measurements_Model_Resource_Setup extends Mage_Eav_Model_Entity_Setup
{
    /**
     * @var array map of catalog_product attributes to add during install.
     */
    private static $_attributes = array(
        'install' => array(
            'smi_item_type' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'SizeMe Item Type',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
                'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                'unique' => false
            ),
            'smi_item_layer' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'SizeMe Item Layer',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'smi_item_thickness' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'SizeMe Item Thickness',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'smi_item_stretch' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'SizeMe Item Stretch',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_chest' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Chest',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_waist' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Waist',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_sleeve' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Sleeve',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_sleeve_top_width' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Sleeve top width',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_wrist_width' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Wrist width',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_underbust' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Underbust',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_neck_opening_width' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Neck opening width',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_shoulder_width' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Shoulder width',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_front_height' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Front height',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_pant_waist' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Pant waist',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_hips' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Hips',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_inseam' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Inseam',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_outseam' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Outseam',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_thigh_width' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Thigh width',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_knee_width' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Knee width',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_calf_width' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Calf width',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_pant_sleeve_width' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Pant sleeve width',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_shoe_inside_length' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Shoe inside length',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_shoe_inside_width' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Shoe inside width',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_hat_width' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Hat width',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
            'sm_hood_height' => array(
                'group' => SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME,
                'label' => 'Hood height',
                'visible' => true,
                'type' => 'int',
                'input' => 'text',
                'required' => false,
                'user_defined' => 1,
                'default' => 0,
            ),
        ),
    );

    /**
     * Returns the attributes to add to catalog products when installing the
     * extension.
     *
     * @return array the attributes.
     */
    public function getAttributesToInstall()
    {
        return self::$_attributes['install'];
    }

    /**
     * Returns all attribute codes for given attribute set ID.
     *
     * @param int $attributeSetId
     *
     * @return array
     */
    public function getAttributes($attributeSetId)
    {
        $attributes = Mage::getModel('catalog/product_attribute_api')
            ->items($attributeSetId);

        $codes = array();
        foreach ($attributes as $attribute) {
            $codes[] = $attribute['code'];
        }

        return $codes;
    }

    /**
     * Returns attributes that are missing in the attributes list.
     *
     * @param array $attributesToInstall
     * @param array $attributes
     *
     * @return array
     */
    public function getMissingAttributeCodes($attributesToInstall, $attributes)
    {
        return array_diff($attributesToInstall, $attributes);
    }
}
