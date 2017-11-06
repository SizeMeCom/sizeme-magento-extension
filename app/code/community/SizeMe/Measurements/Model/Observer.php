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
 * Event observer model.
 * Used to interact with Magento events.
 *
 * @category SizeMe
 * @package  SizeMe_Measurements
 * @author   SizeMe Ltd <plugins@sizeme.com>
 */
class SizeMe_Measurements_Model_Observer
{
    /**
     * Event observer for the when blocks are about to be rendered.
     * The configurable product options template is overridden here to support
     * SizeMe functionality. It is done in an observer to provide an easy way
     * for the admin to disable the override though the system config.
     *
     * Event 'core_block_abstract_to_html_before'.
     *
     * @param Varien_Event_Observer $observer the event observer.
     *
     * @return SizeMe_Measurements_Model_Observer
     */
    public function onCoreBlockAbstractToHtmlBefore(Varien_Event_Observer $observer)
    {
        /** @var Mage_Core_Block_Template $block */
        $block = $observer->getBlock();

        if ($block instanceof Mage_Core_Block_Template) {
            /** @var SizeMe_Measurements_Helper_Data $helper */
            $helper = Mage::helper('sizeme_measurements');

            switch ($block->getData('type')) {
                case 'catalog/product_view_type_configurable':
                    if ($block->getNameInLayout()
                        === 'product.info.options.configurable'
                    ) {
                        if ($helper->canReplaceBlockTemplate($block)) {
                            $block->setTemplate(
                                'sizememeasurements/catalog/product/view/type/options/configurable.phtml'
                            );
                        }
                    }
                    break;

                default:
                    break;
            }
        }

        return $this;
    }

    /**
     * Event observer for when the catalog product edit page form is prepared.
     * The form fieldset renderer widget template is overridden here for the
     * "SizeMe Measurements" tab only. This is done to inject additional content
     * to the config page.
     *
     * Event 'adminhtml_catalog_product_edit_prepare_form'.
     *
     * @param Varien_Event_Observer $observer the event observer.
     *
     * @return SizeMe_Measurements_Model_Observer
     */
    public function onAdminhtmlCatalogProductEditPrepareForm(Varien_Event_Observer $observer)
    {
        /** @var Varien_Data_Form $form */
        $form = $observer->getForm();

        foreach ($form->getElements() as $fieldset) {
            /** @var Varien_Data_Form_Element_Fieldset $fieldset */
            if ($fieldset->getData('legend')
                === SizeMe_Measurements_Helper_Data::ATTRIBUTE_GROUP_NAME
            ) {
                /** @var Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset $renderer */
                $renderer = $form->getFieldsetRenderer();
                $renderer->setTemplate(
                    'sizememeasurements/widget/form/renderer/fieldset.phtml'
                );
            }
        }

        return $this;
    }

    /**
     * Sends a product info API request to SizeMe if a product is added to the cart.
     *
     * Event 'checkout_cart_product_add_after'.
     *
     * @param Varien_Event_Observer $observer the event observer.
     *
     * @return SizeMe_Measurements_Model_Observer
     */
    public function sendAddToCart(Varien_Event_Observer $observer)
    {
        if (Mage::helper('sizeme_measurements')->isModuleEnabled()) {
            try {
                /** @var Mage_Sales_Model_Quote_Item $mageItem */
                $mageItem = $observer->getEvent()->getQuoteItem();

                /** @var Sizeme_Measurements_Model_Meta_Quote_Item $item */
                $item = Mage::getModel('sizeme_measurements/meta_quote_item');
                $item->send($mageItem);
            } catch (Exception $e) {
                Mage::log("\n" . $e->__toString(), Zend_Log::ERR, 'sizeme_measurements.log');
            }
        }

        return $this;
    }

    /**
     * Sends an order confirmation API request to SizeMe if the order is completed.
     *
     * Event 'sales_order_place_after'.
     *
     * @param Varien_Event_Observer $observer the event observer.
     *
     * @return SizeMe_Measurements_Model_Observer
     */
    public function sendOrderConfirmation(Varien_Event_Observer $observer)
    {
        if (Mage::helper('sizeme_measurements')->isModuleEnabled()) {
            try {
                /** @var Mage_Sales_Model_Order $mageOrder */
                $mageOrder = $observer->getEvent()->getOrder();

                /** @var SizeMe_Measurements_Model_Meta_Order $order */
                $order = Mage::getModel('sizeme_measurements/meta_order');
                $order->loadData($mageOrder);

                $order->send();
            } catch (Exception $e) {
                Mage::log("\n" . $e->__toString(), Zend_Log::ERR, 'sizeme_measurements.log');
            }
        }

        return $this;
    }
}
