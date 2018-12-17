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
 * Meta data class which holds information about an item included in an quote.
 * This is used during the add to cart API request.
 *
 * @category SizeMe
 * @package  SizeMe_Measurements
 * @author   SizeMe Ltd <plugins@sizeme.com>
 */
class Sizeme_Measurements_Model_Meta_Quote_Item extends Mage_Core_Model_Abstract
{
    /**
     * Sends the quote item info to SizeMe (triggerered at add to cart event)
     *
     * @return boolean success
     */
    public function send(Mage_Sales_Model_Quote_Item $item)
    {
        $helper = Mage::helper('sizeme_measurements');
        $apiKey = $helper->getApiKey();

        $dataString = json_encode($this->handleQuoteItemToArray($item));

        $ch = curl_init(
            SizeMe_Measurements_Helper_Data::API_CONTEXT_ADDRESS . SizeMe_Measurements_Helper_Data::API_SEND_ADD_TO_CART
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

        return ($result !== false);
    }

    /**
     * Handles the quote item data in to array form
     *
     * @return array
     */
    public function handleQuoteItemToArray(Mage_Sales_Model_Quote_Item $item)
    {

        $helper = Mage::helper('sizeme_measurements');
        $sessionCookie = $helper->getSessionCookie();
        $actionCookie = $helper->getActionCookie();

        $arr = array(
            'SKU' => $item->getSku(),
            'quantity' => (int)$item->getData('qty'),
            'name' => $item->getName(),
            'orderIdentifier' => $sessionCookie,
            'actionIdentifier' => $actionCookie,
        );
        return $arr;
    }

}
