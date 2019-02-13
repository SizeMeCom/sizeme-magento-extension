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
 * Meta data class which holds information about an order.
 * This is used during the order confirmation API request and the order
 * history export.
 *
 * @category SizeMe
 * @package  SizeMe_Measurements
 * @author   SizeMe Ltd <plugins@sizeme.com>
 */
class Sizeme_Measurements_Model_Meta_Order extends Mage_Core_Model_Abstract
{
    /**
     * @var bool if the special items, e.g. shipping cost, discounts, should be
     * included in the `$_items` list.
     */
    public $includeSpecialItems = true;

    /**
     * @var string|int the unique order number identifying the order.
     */
    protected $_orderNumber;

    /**
     * @var string|int the unique order identifier linking the products sent via javascript at add to cart.
     */
    protected $_orderIdentifier;

    /**
     * @var string the date when the order was placed.
     */
    protected $_createdDate;

    /**
     * @var Sizeme_Measurements_Model_Meta_Order_Buyer the user info of the buyer.
     */
    protected $_buyer;

    /**
     * @var Sizeme_Measurements_Model_Meta_Order_Item[] the items in the order.
     */
    protected $_items = array();

    /**
     * @var Sizeme_Measurements_Model_Meta_Order_Status the order status.
     */
    protected $_orderStatus;

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('sizeme_measurements/meta_order');
    }

    /**
     * Loads the order info from a Magento order model.
     *
     * @param Mage_Sales_Model_Order $order the order model.
     */
    public function loadData(Mage_Sales_Model_Order $order)
    {
        $this->_orderNumber = $order->getIncrementId();
        $this->_createdDate = $order->getCreatedAt();

        $helper = Mage::helper('sizeme_measurements');
        $this->_orderIdentifier = $helper->getSessionCookie();

        /** @var Sizeme_Measurements_Model_Meta_Order_Status $orderStatus */
        $orderStatus = Mage::getModel('sizeme_measurements/meta_order_status');
        $orderStatus->loadData($order);
        $this->_orderStatus = $orderStatus;

        /** @var Sizeme_Measurements_Model_Meta_Order_Buyer $orderBuyer */
        $orderBuyer = Mage::getModel('sizeme_measurements/meta_order_buyer');
        $orderBuyer->loadData($order);
        $this->_buyer = $orderBuyer;

        /** @var $item Mage_Sales_Model_Order_Item */
        foreach ($order->getAllVisibleItems() as $item) {
            /** @var Sizeme_Measurements_Model_Meta_Order_Item $orderItem */
            $orderItem = Mage::getModel('sizeme_measurements/meta_order_item');
            $orderItem->loadData($item);
            $this->_items[] = $orderItem;
        }

        if ($this->includeSpecialItems) {
            if (($discount = $order->getDiscountAmount()) > 0) {
                /** @var Sizeme_Measurements_Model_Meta_Order_Item $orderItem */
                $orderItem = Mage::getModel('sizeme_measurements/meta_order_item');
                $orderItem->loadSpecialItemData(
                    'Discount',
                    $discount,
                    $order->getOrderCurrencyCode()
                );
                $this->_items[] = $orderItem;
            }

            if (($shippingInclTax = $order->getShippingInclTax()) > 0) {
                /** @var Sizeme_Measurements_Model_Meta_Order_Item $orderItem */
                $orderItem = Mage::getModel('sizeme_measurements/meta_order_item');
                $orderItem->loadSpecialItemData(
                    'Shipping and handling',
                    $shippingInclTax,
                    $order->getOrderCurrencyCode()
                );
                $this->_items[] = $orderItem;
            }
        }
    }

    /**
     * Handles the order data in to array form
     *
     * @return array
     */
    public function handleOrderToArray()
    {
        $arr = array(
            'orderNumber' => $this->getOrderNumber(),
            'orderIdentifier' => $this->getOrderIdentifier(),
            'orderStatusCode' => $this->getOrderStatus()->getCode(),
            'orderStatusLabel' => $this->getOrderStatus()->getLabel(),
            'buyer' => array(
                'emailHash' => $this->getBuyerInfo()->getEmailHash(),
            ),
            'createdAt' => $this->getCreatedDate(),
            'purchasedItems' => array(),
        );

        foreach ($this->getPurchasedItems() as $item) {
            $arr['purchasedItems'][] = array(
                'SKU' => $item->getProductSKU(),
                'quantity' => (int)$item->getQuantity(),
                'name' => $item->getName(),
                'unitPriceInclTax' => round($item->getUnitPrice(), 2),
                'finalPriceExclTax' => round($item->getFinalPriceExclTax(), 2),
                'priceCurrencyCode' => strtoupper($item->getCurrencyCode()),
            );
        }

        return $arr;
    }

    /**
     * Sends the order data to SizeMe
     *
     * @return boolean success
     */
    public function send()
    {
        $helper = Mage::helper('sizeme_measurements');
        $apiKey = $helper->getApiKey();

        $dataString = json_encode($this->handleOrderToArray());

        $ch = curl_init(
            SizeMe_Measurements_Helper_Data::API_CONTEXT_ADDRESS . SizeMe_Measurements_Helper_Data::API_SEND_ORDER_INFO
        );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($dataString),
            'X-Sizeme-Apikey: ' . $apiKey)
        );

        $result = curl_exec($ch);

        if ($result !== false) {
            Mage::getModel('core/cookie')->set( SizeMe_Measurements_Helper_Data::COOKIE_SESSION, '', -3600 , '/' );
            unset( $_COOKIE[ SizeMe_Measurements_Helper_Data::COOKIE_SESSION ] );
        }

        return ($result !== false);
    }


    /**
     * The unique order number identifying the order.
     *
     * @return string|int the order number.
     */
    public function getOrderNumber()
    {
        return $this->_orderNumber;
    }

    /**
     * The unique order identifier from the frontend side.
     *
     * @return string|int the order number.
     */
    public function getOrderIdentifier()
    {
        return $this->_orderIdentifier;
    }

    /**
     * The date when the order was placed.
     *
     * @return string the creation date.
     */
    public function getCreatedDate()
    {
        return $this->_createdDate;
    }

    /**
     * The buyer info of the user who placed the order.
     *
     * @return SizeMeOrderBuyerInterface the meta data model.
     */
    public function getBuyerInfo()
    {
        return $this->_buyer;
    }

    /**
     * The purchased items which were included in the order.
     *
     * @return SizeMeOrderPurchasedItemInterface[] the meta data models.
     */
    public function getPurchasedItems()
    {
        return $this->_items;
    }

    /**
     * Returns the order status model.
     *
     * @return SizeMeOrderStatusInterface the model.
     */
    public function getOrderStatus()
    {
        return $this->_orderStatus;
    }
}
