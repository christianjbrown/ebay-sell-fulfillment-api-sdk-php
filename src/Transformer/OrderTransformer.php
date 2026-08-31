<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Order;
use ChristianBrown\EBay\SellFulfillment\Model\OrderInterface;

use function is_array;
use function is_bool;
use function is_string;

final class OrderTransformer implements OrderTransformerInterface
{
    private AmountTransformerInterface $amountTransformer;
    private BuyerTransformerInterface $buyerTransformer;
    private CancelStatusTransformerInterface $cancelStatusTransformer;
    private FulfillmentStartInstructionsTransformerInterface $fulfillmentStartInstructionsTransformer;
    private LineItemsTransformerInterface $lineItemsTransformer;
    private PaymentSummaryTransformerInterface $paymentSummaryTransformer;
    private PricingSummaryTransformerInterface $pricingSummaryTransformer;
    private ProgramTransformerInterface $programTransformer;
    private StringsTransformerInterface $stringsTransformer;

    public function __construct(AmountTransformerInterface $amountTransformer, BuyerTransformerInterface $buyerTransformer, CancelStatusTransformerInterface $cancelStatusTransformer, FulfillmentStartInstructionsTransformerInterface $fulfillmentStartInstructionsTransformer, LineItemsTransformerInterface $lineItemsTransformer, PaymentSummaryTransformerInterface $paymentSummaryTransformer, PricingSummaryTransformerInterface $pricingSummaryTransformer, ProgramTransformerInterface $programTransformer, StringsTransformerInterface $stringsTransformer)
    {
        $this->amountTransformer = $amountTransformer;
        $this->buyerTransformer = $buyerTransformer;
        $this->cancelStatusTransformer = $cancelStatusTransformer;
        $this->fulfillmentStartInstructionsTransformer = $fulfillmentStartInstructionsTransformer;
        $this->lineItemsTransformer = $lineItemsTransformer;
        $this->paymentSummaryTransformer = $paymentSummaryTransformer;
        $this->pricingSummaryTransformer = $pricingSummaryTransformer;
        $this->programTransformer = $programTransformer;
        $this->stringsTransformer = $stringsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrderInterface
    {
        $order = new Order();

        $this->applyBuyer($order, $data);
        self::applyBuyerCheckoutNotes($order, $data);
        $this->applyCancelStatus($order, $data);
        self::applyCreationDate($order, $data);
        self::applyEbayCollectAndRemitTax($order, $data);
        $this->applyFulfillmentHrefs($order, $data);
        $this->applyFulfillmentStartInstructions($order, $data);
        self::applyLastModifiedDate($order, $data);
        self::applyLegacyOrderId($order, $data);
        $this->applyLineItems($order, $data);
        self::applyOrderFulfillmentStatus($order, $data);
        self::applyOrderId($order, $data);
        self::applyOrderPaymentStatus($order, $data);
        $this->applyPaymentSummary($order, $data);
        $this->applyPricingSummary($order, $data);
        $this->applyProgram($order, $data);
        self::applySalesRecordReference($order, $data);
        self::applySellerId($order, $data);
        $this->applyTotalFeeBasisAmount($order, $data);
        $this->applyTotalMarketplaceFee($order, $data);

        return $order;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyBuyer(Order $order, array $data): void
    {
        if (empty($data[self::KEY_BUYER])) {
            return;
        }
        if (!is_array($data[self::KEY_BUYER])) {
            return;
        }
        $order->setBuyer($this->buyerTransformer->transform($data[self::KEY_BUYER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBuyerCheckoutNotes(Order $order, array $data): void
    {
        if (empty($data[self::KEY_BUYER_CHECKOUT_NOTES])) {
            return;
        }
        if (!is_string($data[self::KEY_BUYER_CHECKOUT_NOTES])) {
            return;
        }
        $order->setBuyerCheckoutNotes($data[self::KEY_BUYER_CHECKOUT_NOTES]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCancelStatus(Order $order, array $data): void
    {
        if (empty($data[self::KEY_CANCEL_STATUS])) {
            return;
        }
        if (!is_array($data[self::KEY_CANCEL_STATUS])) {
            return;
        }
        $order->setCancelStatus($this->cancelStatusTransformer->transform($data[self::KEY_CANCEL_STATUS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCreationDate(Order $order, array $data): void
    {
        if (empty($data[self::KEY_CREATION_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_CREATION_DATE])) {
            return;
        }
        $order->setCreationDate($data[self::KEY_CREATION_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEbayCollectAndRemitTax(Order $order, array $data): void
    {
        if (!isset($data[self::KEY_EBAY_COLLECT_AND_REMIT_TAX])) {
            return;
        }
        if (!is_bool($data[self::KEY_EBAY_COLLECT_AND_REMIT_TAX])) {
            return;
        }
        $order->setEbayCollectAndRemitTax($data[self::KEY_EBAY_COLLECT_AND_REMIT_TAX]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyFulfillmentHrefs(Order $order, array $data): void
    {
        if (empty($data[self::KEY_FULFILLMENT_HREFS])) {
            return;
        }
        if (!is_array($data[self::KEY_FULFILLMENT_HREFS])) {
            return;
        }
        $order->setFulfillmentHrefs($this->stringsTransformer->transform($data[self::KEY_FULFILLMENT_HREFS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyFulfillmentStartInstructions(Order $order, array $data): void
    {
        if (empty($data[self::KEY_FULFILLMENT_START_INSTRUCTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_FULFILLMENT_START_INSTRUCTIONS])) {
            return;
        }
        $order->setFulfillmentStartInstructions($this->fulfillmentStartInstructionsTransformer->transform($data[self::KEY_FULFILLMENT_START_INSTRUCTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLastModifiedDate(Order $order, array $data): void
    {
        if (empty($data[self::KEY_LAST_MODIFIED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_LAST_MODIFIED_DATE])) {
            return;
        }
        $order->setLastModifiedDate($data[self::KEY_LAST_MODIFIED_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLegacyOrderId(Order $order, array $data): void
    {
        if (empty($data[self::KEY_LEGACY_ORDER_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LEGACY_ORDER_ID])) {
            return;
        }
        $order->setLegacyOrderId($data[self::KEY_LEGACY_ORDER_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLineItems(Order $order, array $data): void
    {
        if (empty($data[self::KEY_LINE_ITEMS])) {
            return;
        }
        if (!is_array($data[self::KEY_LINE_ITEMS])) {
            return;
        }
        $order->setLineItems($this->lineItemsTransformer->transform($data[self::KEY_LINE_ITEMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOrderFulfillmentStatus(Order $order, array $data): void
    {
        if (empty($data[self::KEY_ORDER_FULFILLMENT_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_ORDER_FULFILLMENT_STATUS])) {
            return;
        }
        $order->setOrderFulfillmentStatus($data[self::KEY_ORDER_FULFILLMENT_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOrderId(Order $order, array $data): void
    {
        if (empty($data[self::KEY_ORDER_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ORDER_ID])) {
            return;
        }
        $order->setOrderId($data[self::KEY_ORDER_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOrderPaymentStatus(Order $order, array $data): void
    {
        if (empty($data[self::KEY_ORDER_PAYMENT_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_ORDER_PAYMENT_STATUS])) {
            return;
        }
        $order->setOrderPaymentStatus($data[self::KEY_ORDER_PAYMENT_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPaymentSummary(Order $order, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_SUMMARY])) {
            return;
        }
        if (!is_array($data[self::KEY_PAYMENT_SUMMARY])) {
            return;
        }
        $order->setPaymentSummary($this->paymentSummaryTransformer->transform($data[self::KEY_PAYMENT_SUMMARY]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPricingSummary(Order $order, array $data): void
    {
        if (empty($data[self::KEY_PRICING_SUMMARY])) {
            return;
        }
        if (!is_array($data[self::KEY_PRICING_SUMMARY])) {
            return;
        }
        $order->setPricingSummary($this->pricingSummaryTransformer->transform($data[self::KEY_PRICING_SUMMARY]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyProgram(Order $order, array $data): void
    {
        if (empty($data[self::KEY_PROGRAM])) {
            return;
        }
        if (!is_array($data[self::KEY_PROGRAM])) {
            return;
        }
        $order->setProgram($this->programTransformer->transform($data[self::KEY_PROGRAM]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySalesRecordReference(Order $order, array $data): void
    {
        if (empty($data[self::KEY_SALES_RECORD_REFERENCE])) {
            return;
        }
        if (!is_string($data[self::KEY_SALES_RECORD_REFERENCE])) {
            return;
        }
        $order->setSalesRecordReference($data[self::KEY_SALES_RECORD_REFERENCE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySellerId(Order $order, array $data): void
    {
        if (empty($data[self::KEY_SELLER_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_SELLER_ID])) {
            return;
        }
        $order->setSellerId($data[self::KEY_SELLER_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTotalFeeBasisAmount(Order $order, array $data): void
    {
        if (empty($data[self::KEY_TOTAL_FEE_BASIS_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_TOTAL_FEE_BASIS_AMOUNT])) {
            return;
        }
        $order->setTotalFeeBasisAmount($this->amountTransformer->transform($data[self::KEY_TOTAL_FEE_BASIS_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTotalMarketplaceFee(Order $order, array $data): void
    {
        if (empty($data[self::KEY_TOTAL_MARKETPLACE_FEE])) {
            return;
        }
        if (!is_array($data[self::KEY_TOTAL_MARKETPLACE_FEE])) {
            return;
        }
        $order->setTotalMarketplaceFee($this->amountTransformer->transform($data[self::KEY_TOTAL_MARKETPLACE_FEE]));
    }
}
