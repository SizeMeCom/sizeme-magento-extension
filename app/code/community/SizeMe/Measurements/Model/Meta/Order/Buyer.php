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
 * Meta data class which holds information about the buyer of an order.
 * This is used during the order confirmation API request and the order history
 * export.
 *
 * @category SizeMe
 * @package  SizeMe_Measurements
 * @author   SizeMe Ltd <plugins@sizeme.com>
 */
class Sizeme_Measurements_Model_Meta_Order_Buyer extends Mage_Core_Model_Abstract
{
    /**
     * @var string the first name of the user who placed the order.
     */
    protected $_firstName;

    /**
     * @var string the last name of the user who placed the order.
     */
    protected $_lastName;

    /**
     * @var string the email address of the user who placed the order.
     */
    protected $_email;

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('sizeme_measurements/meta_order_buyer');
    }

    /**
     * Loads the buyer info from a Magento order model.
     *
     * @param Mage_Sales_Model_Order $order the order model.
     */
    public function loadData(Mage_Sales_Model_Order $order)
    {
        $this->_firstName = $order->getCustomerFirstname();
        $this->_lastName = $order->getCustomerLastname();
        $this->_email = $order->getCustomerEmail();
    }

    /**
     * Gets the first name of the user who placed the order.
     *
     * @return string the first name.
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * Gets the last name of the user who placed the order.
     *
     * @return string the last name.
     */
    public function getLastName()
    {
        return $this->_lastName;
    }

    /**
     * Gets the email address of the user who placed the order.
     *
     * @return string the email address.
     */
    public function getEmail()
    {
        return $this->_email;
    }
}
