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
 * System config source model for the extension service status selection.
 *
 * Valid statuses are:
 *
 * - off
 * - test
 * - on
 *
 * @category SizeMe
 * @package  SizeMe_Measurements
 * @author   SizeMe Ltd <plugins@sizeme.com>
 */
class SizeMe_Measurements_Model_System_Config_Source_Service_Status
{
    /**
     * Returns the status options for the extension.
     *
     * @return array the options.
     */
    public function toOptionArray()
    {
        return array(
            array(
                'label' => Mage::helper('sizeme_measurements')->__('Off'),
                'value' => SizeMe_Measurements_Helper_Data::SERVICE_STATUS_OFF
            ),
            array(
                'label' => Mage::helper('sizeme_measurements')->__('Test'),
                'value' => SizeMe_Measurements_Helper_Data::SERVICE_STATUS_TEST
            ),
            array(
                'label' => Mage::helper('sizeme_measurements')->__('A/B Testing'),
                'value' => SizeMe_Measurements_Helper_Data::SERVICE_STATUS_AB
            ),
            array(
                'label' => Mage::helper('sizeme_measurements')->__('On'),
                'value' => SizeMe_Measurements_Helper_Data::SERVICE_STATUS_ON
            ),
        );
    }
}
