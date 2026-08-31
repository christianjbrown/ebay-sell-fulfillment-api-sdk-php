<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PaymentDispute;
use ChristianBrown\EBay\SellFulfillment\Model\PaymentDisputeInterface;

use function is_array;
use function is_int;
use function is_string;

final class PaymentDisputeTransformer implements PaymentDisputeTransformerInterface
{
    private DisputeEvidencesTransformerInterface $disputeEvidencesTransformer;
    private EvidenceRequestsTransformerInterface $evidenceRequestsTransformer;
    private InfoFromBuyerTransformerInterface $infoFromBuyerTransformer;
    private MonetaryTransactionsTransformerInterface $monetaryTransactionsTransformer;
    private OrderLineItemsTransformerInterface $orderLineItemsTransformer;
    private PaymentDisputeOutcomeDetailTransformerInterface $paymentDisputeOutcomeDetailTransformer;
    private ReturnAddressTransformerInterface $returnAddressTransformer;
    private SimpleAmountTransformerInterface $simpleAmountTransformer;
    private StringsTransformerInterface $stringsTransformer;

    public function __construct(DisputeEvidencesTransformerInterface $disputeEvidencesTransformer, EvidenceRequestsTransformerInterface $evidenceRequestsTransformer, InfoFromBuyerTransformerInterface $infoFromBuyerTransformer, MonetaryTransactionsTransformerInterface $monetaryTransactionsTransformer, OrderLineItemsTransformerInterface $orderLineItemsTransformer, PaymentDisputeOutcomeDetailTransformerInterface $paymentDisputeOutcomeDetailTransformer, ReturnAddressTransformerInterface $returnAddressTransformer, SimpleAmountTransformerInterface $simpleAmountTransformer, StringsTransformerInterface $stringsTransformer)
    {
        $this->disputeEvidencesTransformer = $disputeEvidencesTransformer;
        $this->evidenceRequestsTransformer = $evidenceRequestsTransformer;
        $this->infoFromBuyerTransformer = $infoFromBuyerTransformer;
        $this->monetaryTransactionsTransformer = $monetaryTransactionsTransformer;
        $this->orderLineItemsTransformer = $orderLineItemsTransformer;
        $this->paymentDisputeOutcomeDetailTransformer = $paymentDisputeOutcomeDetailTransformer;
        $this->returnAddressTransformer = $returnAddressTransformer;
        $this->simpleAmountTransformer = $simpleAmountTransformer;
        $this->stringsTransformer = $stringsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PaymentDisputeInterface
    {
        $paymentDispute = new PaymentDispute();

        $this->applyAmount($paymentDispute, $data);
        $this->applyAvailableChoices($paymentDispute, $data);
        $this->applyBuyerProvided($paymentDispute, $data);
        self::applyBuyerUsername($paymentDispute, $data);
        self::applyClosedDate($paymentDispute, $data);
        $this->applyEvidence($paymentDispute, $data);
        $this->applyEvidenceRequests($paymentDispute, $data);
        $this->applyLineItems($paymentDispute, $data);
        $this->applyMonetaryTransactions($paymentDispute, $data);
        self::applyNote($paymentDispute, $data);
        self::applyOpenDate($paymentDispute, $data);
        self::applyOrderId($paymentDispute, $data);
        self::applyPaymentDisputeId($paymentDispute, $data);
        self::applyPaymentDisputeStatus($paymentDispute, $data);
        self::applyReason($paymentDispute, $data);
        $this->applyResolution($paymentDispute, $data);
        self::applyRespondByDate($paymentDispute, $data);
        $this->applyReturnAddress($paymentDispute, $data);
        self::applyRevision($paymentDispute, $data);
        self::applySellerResponse($paymentDispute, $data);

        return $paymentDispute;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAmount(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_AMOUNT])) {
            return;
        }
        $paymentDispute->setAmount($this->simpleAmountTransformer->transform($data[self::KEY_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAvailableChoices(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_AVAILABLE_CHOICES])) {
            return;
        }
        if (!is_array($data[self::KEY_AVAILABLE_CHOICES])) {
            return;
        }
        $paymentDispute->setAvailableChoices($this->stringsTransformer->transform($data[self::KEY_AVAILABLE_CHOICES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyBuyerProvided(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_BUYER_PROVIDED])) {
            return;
        }
        if (!is_array($data[self::KEY_BUYER_PROVIDED])) {
            return;
        }
        $paymentDispute->setBuyerProvided($this->infoFromBuyerTransformer->transform($data[self::KEY_BUYER_PROVIDED]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBuyerUsername(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_BUYER_USERNAME])) {
            return;
        }
        if (!is_string($data[self::KEY_BUYER_USERNAME])) {
            return;
        }
        $paymentDispute->setBuyerUsername($data[self::KEY_BUYER_USERNAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyClosedDate(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_CLOSED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_CLOSED_DATE])) {
            return;
        }
        $paymentDispute->setClosedDate($data[self::KEY_CLOSED_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEvidence(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_EVIDENCE])) {
            return;
        }
        if (!is_array($data[self::KEY_EVIDENCE])) {
            return;
        }
        $paymentDispute->setEvidence($this->disputeEvidencesTransformer->transform($data[self::KEY_EVIDENCE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEvidenceRequests(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_EVIDENCE_REQUESTS])) {
            return;
        }
        if (!is_array($data[self::KEY_EVIDENCE_REQUESTS])) {
            return;
        }
        $paymentDispute->setEvidenceRequests($this->evidenceRequestsTransformer->transform($data[self::KEY_EVIDENCE_REQUESTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLineItems(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_LINE_ITEMS])) {
            return;
        }
        if (!is_array($data[self::KEY_LINE_ITEMS])) {
            return;
        }
        $paymentDispute->setLineItems($this->orderLineItemsTransformer->transform($data[self::KEY_LINE_ITEMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyMonetaryTransactions(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_MONETARY_TRANSACTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_MONETARY_TRANSACTIONS])) {
            return;
        }
        $paymentDispute->setMonetaryTransactions($this->monetaryTransactionsTransformer->transform($data[self::KEY_MONETARY_TRANSACTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNote(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_NOTE])) {
            return;
        }
        if (!is_string($data[self::KEY_NOTE])) {
            return;
        }
        $paymentDispute->setNote($data[self::KEY_NOTE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOpenDate(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_OPEN_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_OPEN_DATE])) {
            return;
        }
        $paymentDispute->setOpenDate($data[self::KEY_OPEN_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOrderId(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_ORDER_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ORDER_ID])) {
            return;
        }
        $paymentDispute->setOrderId($data[self::KEY_ORDER_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPaymentDisputeId(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_DISPUTE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PAYMENT_DISPUTE_ID])) {
            return;
        }
        $paymentDispute->setPaymentDisputeId($data[self::KEY_PAYMENT_DISPUTE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPaymentDisputeStatus(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_DISPUTE_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_PAYMENT_DISPUTE_STATUS])) {
            return;
        }
        $paymentDispute->setPaymentDisputeStatus($data[self::KEY_PAYMENT_DISPUTE_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyReason(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_REASON])) {
            return;
        }
        if (!is_string($data[self::KEY_REASON])) {
            return;
        }
        $paymentDispute->setReason($data[self::KEY_REASON]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyResolution(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_RESOLUTION])) {
            return;
        }
        if (!is_array($data[self::KEY_RESOLUTION])) {
            return;
        }
        $paymentDispute->setResolution($this->paymentDisputeOutcomeDetailTransformer->transform($data[self::KEY_RESOLUTION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRespondByDate(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_RESPOND_BY_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_RESPOND_BY_DATE])) {
            return;
        }
        $paymentDispute->setRespondByDate($data[self::KEY_RESPOND_BY_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyReturnAddress(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_RETURN_ADDRESS])) {
            return;
        }
        if (!is_array($data[self::KEY_RETURN_ADDRESS])) {
            return;
        }
        $paymentDispute->setReturnAddress($this->returnAddressTransformer->transform($data[self::KEY_RETURN_ADDRESS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRevision(PaymentDispute $paymentDispute, array $data): void
    {
        if (!isset($data[self::KEY_REVISION])) {
            return;
        }
        if (!is_int($data[self::KEY_REVISION])) {
            return;
        }
        $paymentDispute->setRevision($data[self::KEY_REVISION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySellerResponse(PaymentDispute $paymentDispute, array $data): void
    {
        if (empty($data[self::KEY_SELLER_RESPONSE])) {
            return;
        }
        if (!is_string($data[self::KEY_SELLER_RESPONSE])) {
            return;
        }
        $paymentDispute->setSellerResponse($data[self::KEY_SELLER_RESPONSE]);
    }
}
