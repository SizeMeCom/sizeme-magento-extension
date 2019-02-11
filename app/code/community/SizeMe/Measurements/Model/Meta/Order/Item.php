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
 * Meta data class which holds information about an item included in an order.
 * This is used during the order confirmation API request.
 *
 * @category SizeMe
 * @package  SizeMe_Measurements
 * @author   SizeMe Ltd <plugins@sizeme.com>
 */
class Sizeme_Measurements_Model_Meta_Order_Item extends Mage_Core_Model_Abstract
{
    /**
     * @var string|int unique identifier of the purchased item.
     * If this item is for discounts or shipping cost, the id might be empty.
     */
    protected $_SKU;

    /**
     * @var int the quantity of the item included in the order.
     */
    protected $_quantity;

    /**
     * @var string the name of the item included in the order.
     */
    protected $_name;

    /**
     * @var float The unit price of the item included in the order.
     */
    protected $_unitPrice;
    
    /**
     * @var float The unit price of the item included in the order excluding all taxes.
     */
    protected $_unitPriceExclTax;    

    /**
     * @var string the 3-letter ISO code (ISO 4217) for the item currency.
     */
    protected $_currencyCode;

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('sizeme_measurements/meta_order_item');
    }

    /**
     * Loads the item info from the Magento order item model.
     *
     * @param Mage_Sales_Model_Order_Item $item the item model.
     */
    public function loadData(Mage_Sales_Model_Order_Item $item)
    {
        $order = $item->getOrder();
        $this->_SKU = $item->getSku();
        $this->_quantity = (int)$item->getQtyOrdered();
        $this->_name = $this->fetchProductName($item);
        $this->_unitPrice = $item->getPriceInclTax();
        $this->_finalPriceExclTax = $this->fetchFinalPriceExclTax($item);
        $this->_currencyCode = strtoupper($order->getOrderCurrencyCode());
    }

    /**
     * Loads the "special item" info from provided data.
     * A "special item" is an item that is included in an order but does not
     * represent an item being bought, e.g. shipping fees, discounts etc.
     *
     * @param string $name the name of the item.
     * @param float|int|string $unitPrice the unit price of the item.
     * @param string $currencyCode the currency code for the item unit price.
     */
    public function loadSpecialItemData($name, $unitPrice, $currencyCode)
    {
        $this->_SKU = '';
        $this->_quantity = 1;
        $this->_name = (string)$name;
        $this->_unitPrice = $unitPrice;
        $this->_unitPriceExclTax = 0;
        $this->_currencyCode = strtoupper($currencyCode);
    }

    /**
     * Returns the name for a sales item.
     *
     * @param Mage_Sales_Model_Order_Item $item the sales item model.
     *
     * @return string
     */
    protected function fetchProductName(Mage_Sales_Model_Order_Item $item)
    {
        $name = $item->getName();
        return $name;
    }
    
    /**
     * Finds the final price excluding tax for a given item (final means after possible discounts and stuff)
     *
     * @param Mage_Sales_Model_Order_Item $item the sales item model.
     *
     * @return float|int
     */
    protected function fetchFinalPriceExclTax(Mage_Sales_Model_Order_Item $item)
    {
        $_product = $item->getProduct();
        $finalPriceExcludingTax = Mage::helper('tax')
            ->getPrice($_product, $_product->getFinalPrice(), false);
        return $finalPriceExcludingTax;
    }

    /**
     * The SKU of the purchased item.
     *
     * @return string|int
     */
    public function getProductSKU()
    {
        return $this->_SKU;
    }

    /**
     * The quantity of the item included in the order.
     *
     * @return int the quantity.
     */
    public function getQuantity()
    {
        return $this->_quantity;
    }

    /**
     * The name of the item included in the order.
     *
     * @return string the name.
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * The unit price of the item included in the order.
     *
     * @return float the unit price.
     */
    public function getUnitPrice()
    {
        return $this->_unitPrice;
    }
    
    /**
     * The unit price of the item included in the order excluding tax.
     *
     * @return float the unit price.
     */
    public function getFinalPriceExclTax()
    {
        return $this->_finalPriceExclTax;
    }

    /**
     * The 3-letter ISO code (ISO 4217) for the item currency.
     *
     * @return string the currency ISO code.
     */
    public function getCurrencyCode()
    {
        return $this->_currencyCode;
    }
}
