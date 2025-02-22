<?php

if (!class_exists("AccountIdentifier")) {
    /**
     * AccountIdentifier
     */
    class AccountIdentifier
    {
        /**
         * @access public
         * @var xsstring
         */
        public $email;
        /**
         * @access public
         * @var commonPhoneNumberType
         */
        public $phone;
    }
}

if (!class_exists("BaseAddress")) {
    /**
     * BaseAddress
     */
    class BaseAddress
    {
        /**
         * @access public
         * @var xsstring
         */
        public $line1;
        /**
         * @access public
         * @var xsstring
         */
        public $line2;
        /**
         * @access public
         * @var xsstring
         */
        public $city;
        /**
         * @access public
         * @var xsstring
         */
        public $state;
        /**
         * @access public
         * @var xsstring
         */
        public $postalCode;
        /**
         * @access public
         * @var xsstring
         */
        public $countryCode;
        /**
         * @access public
         * @var xsstring
         */
        public $type;
    }
}

if (!class_exists("ClientDetailsType")) {
    /**
     * ClientDetailsType
     */
    class ClientDetailsType
    {
        /**
         * @access public
         * @var xsstring
         */
        public $ipAddress;
        /**
         * @access public
         * @var xsstring
         */
        public $deviceId;
        /**
         * @access public
         * @var xsstring
         */
        public $applicationId;
        /**
         * @access public
         * @var xsstring
         */
        public $model;
        /**
         * @access public
         * @var xsstring
         */
        public $geoLocation;
        /**
         * @access public
         * @var xsstring
         */
        public $customerType;
        /**
         * @access public
         * @var xsstring
         */
        public $partnerName;
        /**
         * @access public
         * @var xsstring
         */
        public $customerId;
    }
}

if (!class_exists("CurrencyType")) {
    /**
     * CurrencyType
     */
    class CurrencyType
    {
        /**
         * @access public
         * @var xsstring
         */
        public $code;
        /**
         * @access public
         * @var xsdecimal
         */
        public $amount;
    }
}

if (!class_exists("ErrorData")) {
    /**
     * ErrorData
     */
    class ErrorData
    {
        /**
         * @access public
         * @var xslong
         */
        public $errorId;
        /**
         * @access public
         * @var xsstring
         */
        public $domain;
        /**
         * @access public
         * @var xsstring
         */
        public $subdomain;
        /**
         * @access public
         * @var commonErrorSeverity
         */
        public $severity;
        /**
         * @access public
         * @var commonErrorCategory
         */
        public $category;
        /**
         * @access public
         * @var xsstring
         */
        public $message;
        /**
         * @access public
         * @var xstoken
         */
        public $exceptionId;
        /**
         * @access public
         * @var commonErrorParameter
         */
        public $parameter;
    }
}

if (!class_exists("ErrorParameter")) {
    /**
     * ErrorParameter
     */
    class ErrorParameter
    {
    }
}

if (!class_exists("FaultMessage")) {
    /**
     * FaultMessage
     */
    class FaultMessage
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
        /**
         * @access public
         * @var commonErrorData
         */
        public $error;
    }
}

if (!class_exists("PhoneNumberType")) {
    /**
     * PhoneNumberType
     */
    class PhoneNumberType
    {
        /**
         * @access public
         * @var xsstring
         */
        public $countryCode;
        /**
         * @access public
         * @var xsstring
         */
        public $phoneNumber;
        /**
         * @access public
         * @var xsstring
         */
        public $extension;
    }
}

if (!class_exists("RequestEnvelope")) {
    /**
     * RequestEnvelope
     */
    class RequestEnvelope
    {
        /**
         * @access public
         * @var commonDetailLevelCode
         */
        public $detailLevel;
        /**
         * @access public
         * @var xsstring
         */
        public $errorLanguage;
    }
}

if (!class_exists("ResponseEnvelope")) {
    /**
     * ResponseEnvelope
     */
    class ResponseEnvelope
    {
        /**
         * @access public
         * @var xsdateTime
         */
        public $timestamp;
        /**
         * @access public
         * @var commonAckCode
         */
        public $ack;
        /**
         * @access public
         * @var xsstring
         */
        public $correlationId;
        /**
         * @access public
         * @var xsstring
         */
        public $build;
    }
}

if (!class_exists("Address")) {
    /**
     * Address
     */
    class Address
    {
        /**
         * @access public
         * @var xsstring
         */
        public $addresseeName;
        /**
         * @access public
         * @var commonBaseAddress
         */
        public $baseAddress;
        /**
         * @access public
         * @var xsstring
         */
        public $addressId;
    }
}

if (!class_exists("AddressList")) {
    /**
     * AddressList
     */
    class AddressList
    {
        /**
         * @access public
         * @var apAddress
         */
        public $address;
    }
}

if (!class_exists("CurrencyCodeList")) {
    /**
     * CurrencyCodeList
     */
    class CurrencyCodeList
    {
        /**
         * @access public
         * @var xsstring
         */
        public $currencyCode;
    }
}

if (!class_exists("CurrencyConversionList")) {
    /**
     * CurrencyConversionList
     */
    class CurrencyConversionList
    {
        /**
         * @access public
         * @var commonCurrencyType
         */
        public $baseAmount;
        /**
         * @access public
         * @var apCurrencyList
         */
        public $currencyList;
    }
}

if (!class_exists("CurrencyConversionTable")) {
    /**
     * CurrencyConversionTable
     */
    class CurrencyConversionTable
    {
        /**
         * @access public
         * @var apCurrencyConversionList
         */
        public $currencyConversionList;
    }
}

if (!class_exists("CurrencyList")) {
    /**
     * CurrencyList
     */
    class CurrencyList
    {
        /**
         * @access public
         * @var commonCurrencyType
         */
        public $currency;
    }
}

if (!class_exists("DisplayOptions")) {
    /**
     * DisplayOptions
     */
    class DisplayOptions
    {
        /**
         * @access public
         * @var xsstring
         */
        public $emailHeaderImageUrl;
        /**
         * @access public
         * @var xsstring
         */
        public $emailMarketingImageUrl;
        /**
         * @access public
         * @var xsstring
         */
        public $headerImageUrl;
        /**
         * @access public
         * @var xsstring
         */
        public $businessName;
    }
}

if (!class_exists("ErrorList")) {
    /**
     * ErrorList
     */
    class ErrorList
    {
        /**
         * @access public
         * @var commonErrorData
         */
        public $error;
    }
}

if (!class_exists("FundingConstraint")) {
    /**
     * FundingConstraint
     */
    class FundingConstraint
    {
        /**
         * @access public
         * @var apFundingTypeList
         */
        public $allowedFundingType;
    }
}

if (!class_exists("fundingTypeInfo")) {
    /**
     * FundingTypeInfo
     */
    class fundingTypeInfo
    {
        /**
         * @access public
         * @var xsstring
         */
        public $fundingType;
    }
}

if (!class_exists("FundingTypeList")) {
    /**
     * FundingTypeList
     */
    class FundingTypeList
    {
        /**
         * @access public
         * @var apFundingTypeInfo
         */
        public $fundingTypeInfo;
    }
}

if (!class_exists("CurrencyConversion")) {
    /**
     * CurrencyConversion
     */
    class CurrencyConversion
    {
        /**
         * @access public
         * @var commonCurrencyType
         */
        public $from;
        /**
         * @access public
         * @var commonCurrencyType
         */
        public $to;
        /**
         * @access public
         * @var xsdecimal
         */
        public $exchangeRate;
    }
}

if (!class_exists("FundingSource")) {
    /**
     * FundingSource
     */
    class FundingSource
    {
        /**
         * @access public
         * @var xsstring
         */
        public $lastFourOfAccountNumber;
        /**
         * @access public
         * @var xsstring
         */
        public $type;
        /**
         * @access public
         * @var xsstring
         */
        public $displayName;
        /**
         * @access public
         * @var xsstring
         */
        public $fundingSourceId;
        /**
         * @access public
         * @var xsboolean
         */
        public $allowed;
    }
}

if (!class_exists("FundingPlanCharge")) {
    /**
     * FundingPlanCharge
     */
    class FundingPlanCharge
    {
        /**
         * @access public
         * @var commonCurrencyType
         */
        public $charge;
        /**
         * @access public
         * @var apFundingSource
         */
        public $fundingSource;
    }
}

if (!class_exists("FundingPlan")) {
    /**
     * FundingPlan
     */
    class FundingPlan
    {
        /**
         * @access public
         * @var xsstring
         */
        public $fundingPlanId;
        /**
         * @access public
         * @var commonCurrencyType
         */
        public $fundingAmount;
        /**
         * @access public
         * @var apFundingSource
         */
        public $backupFundingSource;
        /**
         * @access public
         * @var commonCurrencyType
         */
        public $senderFees;
        /**
         * @access public
         * @var apCurrencyConversion
         */
        public $currencyConversion;
        /**
         * @access public
         * @var apFundingPlanCharge
         */
        public $charge;
    }
}

if (!class_exists("InitiatingEntity")) {
    /**
     * InitiatingEntity
     */
    class InitiatingEntity
    {
        /**
         * @access public
         * @var apInstitutionCustomer
         */
        public $institutionCustomer;
    }
}

if (!class_exists("InstitutionCustomer")) {
    /**
     * InstitutionCustomer
     */
    class InstitutionCustomer
    {
        /**
         * @access public
         * @var xsstring
         */
        public $institutionId;
        /**
         * @access public
         * @var xsstring
         */
        public $firstName;
        /**
         * @access public
         * @var xsstring
         */
        public $lastName;
        /**
         * @access public
         * @var xsstring
         */
        public $displayName;
        /**
         * @access public
         * @var xsstring
         */
        public $institutionCustomerId;
        /**
         * @access public
         * @var xsstring
         */
        public $countryCode;
        /**
         * @access public
         * @var xsstring
         */
        public $email;
    }
}

if (!class_exists("InvoiceItem")) {
    /**
     * InvoiceItem
     */
    class InvoiceItem
    {
        /**
         * @access public
         * @var xsstring
         */
        public $name;
        /**
         * @access public
         * @var xsstring
         */
        public $identifier;
        /**
         * @access public
         * @var xsdecimal
         */
        public $price;
        /**
         * @access public
         * @var xsdecimal
         */
        public $itemPrice;
        /**
         * @access public
         * @var xsint
         */
        public $itemCount;
    }
}

if (!class_exists("InvoiceData")) {
    /**
     * InvoiceData
     */
    class InvoiceData
    {
        /**
         * @access public
         * @var apInvoiceItem
         */
        public $item;
        /**
         * @access public
         * @var xsdecimal
         */
        public $totalTax;
        /**
         * @access public
         * @var xsdecimal
         */
        public $totalShipping;
    }
}

if (!class_exists("PayError")) {
    /**
     * PayError
     */
    class PayError
    {
        /**
         * @access public
         * @var apReceiver
         */
        public $receiver;
        /**
         * @access public
         * @var commonErrorData
         */
        public $error;
    }
}

if (!class_exists("PayErrorList")) {
    /**
     * PayErrorList
     */
    class PayErrorList
    {
        /**
         * @access public
         * @var apPayError
         */
        public $payError;
    }
}

if (!class_exists("PaymentInfo")) {
    /**
     * PaymentInfo
     */
    class PaymentInfo
    {
        /**
         * @access public
         * @var xsstring
         */
        public $transactionId;
        /**
         * @access public
         * @var xsstring
         */
        public $transactionStatus;
        /**
         * @access public
         * @var apReceiver
         */
        public $receiver;
        /**
         * @access public
         * @var xsdecimal
         */
        public $refundedAmount;
        /**
         * @access public
         * @var xsboolean
         */
        public $pendingRefund;
        /**
         * @access public
         * @var xsstring
         */
        public $senderTransactionId;
        /**
         * @access public
         * @var xsstring
         */
        public $senderTransactionStatus;
        /**
         * @access public
         * @var xsstring
         */
        public $pendingReason;
    }
}

if (!class_exists("PaymentInfoList")) {
    /**
     * PaymentInfoList
     */
    class PaymentInfoList
    {
        /**
         * @access public
         * @var apPaymentInfo
         */
        public $paymentInfo;
    }
}

if (!class_exists("receiver")) {
    /**
     * Receiver
     */
    class receiver
    {
        /**
         * @access public
         * @var xsdecimal
         */
        public $amount;
        /**
         * @access public
         * @var xsstring
         */
        public $email;
        /**
         * @access public
         * @var commonPhoneNumberType
         */
        public $phone;
        /**
         * @access public
         * @var xsboolean
         */
        public $primary;
        /**
         * @access public
         * @var xsstring
         */
        public $invoiceId;
        /**
         * @access public
         * @var xsstring
         */
        public $paymentType;
        /**
         * @access public
         * @var xsstring
         */
        public $paymentSubType;
    }
}

if (!class_exists("ReceiverList")) {
    /**
     * ReceiverList
     */
    class ReceiverList
    {
        /**
         * @access public
         * @var apReceiver
         */
        public $receiver;
    }
}

if (!class_exists("ReceiverIdentifier")) {
    /**
     * ReceiverIdentifier
     */
    class ReceiverIdentifier extends AccountIdentifier
    {
    }
}

if (!class_exists("ReceiverOptions")) {
    /**
     * ReceiverOptions
     */
    class ReceiverOptions
    {
        /**
         * @access public
         * @var xsstring
         */
        public $description;
        /**
         * @access public
         * @var xsstring
         */
        public $customId;
        /**
         * @access public
         * @var apInvoiceData
         */
        public $invoiceData;
        /**
         * @access public
         * @var apReceiverIdentifier
         */
        public $receiver;
        /**
         * @access public
         * @var xsstring
         */
        public $referrerCode;
    }
}

if (!class_exists("RefundInfo")) {
    /**
     * RefundInfo
     */
    class RefundInfo
    {
        /**
         * @access public
         * @var apReceiver
         */
        public $receiver;
        /**
         * @access public
         * @var xsstring
         */
        public $refundStatus;
        /**
         * @access public
         * @var xsdecimal
         */
        public $refundNetAmount;
        /**
         * @access public
         * @var xsdecimal
         */
        public $refundFeeAmount;
        /**
         * @access public
         * @var xsdecimal
         */
        public $refundGrossAmount;
        /**
         * @access public
         * @var xsdecimal
         */
        public $totalOfAllRefunds;
        /**
         * @access public
         * @var xsboolean
         */
        public $refundHasBecomeFull;
        /**
         * @access public
         * @var xsstring
         */
        public $encryptedRefundTransactionId;
        /**
         * @access public
         * @var xsstring
         */
        public $refundTransactionStatus;
        /**
         * @access public
         * @var apErrorList
         */
        public $errorList;
    }
}

if (!class_exists("RefundInfoList")) {
    /**
     * RefundInfoList
     */
    class RefundInfoList
    {
        /**
         * @access public
         * @var apRefundInfo
         */
        public $refundInfo;
    }
}

if (!class_exists("SenderOptions")) {
    /**
     * SenderOptions
     */
    class SenderOptions
    {
        /**
         * @access public
         * @var xsboolean
         */
        public $requireShippingAddressSelection;
    }
}

if (!class_exists("SenderIdentifier")) {
    /**
     * SenderIdentifier
     */
    class SenderIdentifier extends AccountIdentifier
    {
        /**
         * @access public
         * @var xsboolean
         */
        public $useCredentials;
    }
}

if (!class_exists("CancelPreapprovalRequest")) {
    /**
     * CancelPreapprovalRequest
     */
    class CancelPreapprovalRequest
    {
        /**
         * @access public
         * @var commonRequestEnvelope
         */
        public $requestEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $preapprovalKey;
    }
}

if (!class_exists("CancelPreapprovalResponse")) {
    /**
     * CancelPreapprovalResponse
     */
    class CancelPreapprovalResponse
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
    }
}

if (!class_exists("ConfirmPreapprovalRequest")) {
    /**
     * ConfirmPreapprovalRequest
     */
    class ConfirmPreapprovalRequest
    {
        /**
         * @access public
         * @var commonRequestEnvelope
         */
        public $requestEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $preapprovalKey;
        /**
         * @access public
         * @var xsstring
         */
        public $fundingSourceId;
        /**
         * @access public
         * @var xsstring
         */
        public $pin;
    }
}

if (!class_exists("ConfirmPreapprovalResponse")) {
    /**
     * ConfirmPreapprovalResponse
     */
    class ConfirmPreapprovalResponse
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
    }
}

if (!class_exists("ConvertCurrencyRequest")) {
    /**
     * ConvertCurrencyRequest
     */
    class ConvertCurrencyRequest
    {
        /**
         * @access public
         * @var commonRequestEnvelope
         */
        public $requestEnvelope;
        /**
         * @access public
         * @var apCurrencyList
         */
        public $baseAmountList;
        /**
         * @access public
         * @var apCurrencyCodeList
         */
        public $convertToCurrencyList;
    }
}

if (!class_exists("ConvertCurrencyResponse")) {
    /**
     * ConvertCurrencyResponse
     */
    class ConvertCurrencyResponse
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
        /**
         * @access public
         * @var apCurrencyConversionTable
         */
        public $estimatedAmountTable;
    }
}

if (!class_exists("ExecutePaymentRequest")) {
    /**
     * ExecutePaymentRequest
     */
    class ExecutePaymentRequest
    {
        /**
         * @access public
         * @var commonRequestEnvelope
         */
        public $requestEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $payKey;
        /**
         * @access public
         * @var xsstring
         */
        public $actionType;
        /**
         * @access public
         * @var xsstring
         */
        public $fundingPlanId;
    }
}

if (!class_exists("ExecutePaymentResponse")) {
    /**
     * ExecutePaymentResponse
     */
    class ExecutePaymentResponse
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $paymentExecStatus;
        /**
         * @access public
         * @var apPayErrorList
         */
        public $payErrorList;
    }
}

if (!class_exists("GetAllowedFundingSourcesRequest")) {
    /**
     * GetAllowedFundingSourcesRequest
     */
    class GetAllowedFundingSourcesRequest
    {
        /**
         * @access public
         * @var commonRequestEnvelope
         */
        public $requestEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $key;
    }
}

if (!class_exists("GetAllowedFundingSourcesResponse")) {
    /**
     * GetAllowedFundingSourcesResponse
     */
    class GetAllowedFundingSourcesResponse
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
        /**
         * @access public
         * @var apFundingSource
         */
        public $fundingSource;
    }
}

if (!class_exists("GetPaymentOptionsRequest")) {
    /**
     * GetPaymentOptionsRequest
     */
    class GetPaymentOptionsRequest
    {
        /**
         * @access public
         * @var commonRequestEnvelope
         */
        public $requestEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $payKey;
    }
}

if (!class_exists("GetPaymentOptionsResponse")) {
    /**
     * GetPaymentOptionsResponse
     */
    class GetPaymentOptionsResponse
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
        /**
         * @access public
         * @var apInitiatingEntity
         */
        public $initiatingEntity;
        /**
         * @access public
         * @var apDisplayOptions
         */
        public $displayOptions;
        /**
         * @access public
         * @var xsstring
         */
        public $shippingAddressId;
        /**
         * @access public
         * @var apSenderOptions
         */
        public $senderOptions;
        /**
         * @access public
         * @var apReceiverOptions
         */
        public $receiverOptions;
    }
}

if (!class_exists("PaymentDetailsRequest")) {
    /**
     * PaymentDetailsRequest
     */
    class PaymentDetailsRequest
    {
        /**
         * @access public
         * @var commonRequestEnvelope
         */
        public $requestEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $payKey;
        /**
         * @access public
         * @var xsstring
         */
        public $transactionId;
        /**
         * @access public
         * @var xsstring
         */
        public $trackingId;
    }
}

if (!class_exists("PaymentDetailsResponse")) {
    /**
     * PaymentDetailsResponse
     */
    class PaymentDetailsResponse
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $cancelUrl;
        /**
         * @access public
         * @var xsstring
         */
        public $currencyCode;
        /**
         * @access public
         * @var xsstring
         */
        public $ipnNotificationUrl;
        /**
         * @access public
         * @var xsstring
         */
        public $memo;
        /**
         * @access public
         * @var apPaymentInfoList
         */
        public $paymentInfoList;
        /**
         * @access public
         * @var xsstring
         */
        public $returnUrl;
        /**
         * @access public
         * @var xsstring
         */
        public $senderEmail;
        /**
         * @access public
         * @var xsstring
         */
        public $status;
        /**
         * @access public
         * @var xsstring
         */
        public $trackingId;
        /**
         * @access public
         * @var xsstring
         */
        public $payKey;
        /**
         * @access public
         * @var xsstring
         */
        public $actionType;
        /**
         * @access public
         * @var xsstring
         */
        public $feesPayer;
        /**
         * @access public
         * @var xsboolean
         */
        public $reverseAllParallelPaymentsOnError;
        /**
         * @access public
         * @var xsstring
         */
        public $preapprovalKey;
        /**
         * @access public
         * @var apFundingConstraint
         */
        public $fundingConstraint;
        /**
         * @access public
         * @var apSenderIdentifier
         */
        public $sender;
    }
}

if (!class_exists("PayRequest")) {
    /**
     * PayRequest
     */
    class PayRequest
    {
        /**
         * @access public
         * @var commonRequestEnvelope
         */
        public $requestEnvelope;
        /**
         * @access public
         * @var commonClientDetailsType
         */
        public $clientDetails;
        /**
         * @access public
         * @var xsstring
         */
        public $actionType;
        /**
         * @access public
         * @var xsstring
         */
        public $cancelUrl;
        /**
         * @access public
         * @var xsstring
         */
        public $currencyCode;
        /**
         * @access public
         * @var xsstring
         */
        public $feesPayer;
        /**
         * @access public
         * @var xsstring
         */
        public $ipnNotificationUrl;
        /**
         * @access public
         * @var xsstring
         */
        public $memo;
        /**
         * @access public
         * @var xsstring
         */
        public $pin;
        /**
         * @access public
         * @var xsstring
         */
        public $preapprovalKey;
        /**
         * @access public
         * @var apReceiverList
         */
        public $receiverList;
        /**
         * @access public
         * @var xsboolean
         */
        public $reverseAllParallelPaymentsOnError;
        /**
         * @access public
         * @var xsstring
         */
        public $senderEmail;
        /**
         * @access public
         * @var xsstring
         */
        public $returnUrl;
        /**
         * @access public
         * @var xsstring
         */
        public $trackingId;
        /**
         * @access public
         * @var apFundingConstraint
         */
        public $fundingConstraint;
        /**
         * @access public
         * @var apSenderIdentifier
         */
        public $sender;
    }
}

if (!class_exists("PayResponse")) {
    /**
     * PayResponse
     */
    class PayResponse
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $payKey;
        /**
         * @access public
         * @var xsstring
         */
        public $paymentExecStatus;
        /**
         * @access public
         * @var apPayErrorList
         */
        public $payErrorList;
        /**
         * @access public
         * @var apFundingPlan
         */
        public $defaultFundingPlan;
    }
}

if (!class_exists("PreapprovalDetailsRequest")) {
    /**
     * PreapprovalDetailsRequest
     */
    class PreapprovalDetailsRequest
    {
        /**
         * @access public
         * @var commonRequestEnvelope
         */
        public $requestEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $preapprovalKey;
        /**
         * @access public
         * @var xsboolean
         */
        public $getBillingAddress;
    }
}

if (!class_exists("PreapprovalDetailsResponse")) {
    /**
     * PreapprovalDetailsResponse
     */
    class PreapprovalDetailsResponse
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
        /**
         * @access public
         * @var xsboolean
         */
        public $approved;
        /**
         * @access public
         * @var xsstring
         */
        public $cancelUrl;
        /**
         * @access public
         * @var xslong
         */
        public $curPayments;
        /**
         * @access public
         * @var xsdecimal
         */
        public $curPaymentsAmount;
        /**
         * @access public
         * @var xslong
         */
        public $curPeriodAttempts;
        /**
         * @access public
         * @var xsdateTime
         */
        public $curPeriodEndingDate;
        /**
         * @access public
         * @var xsstring
         */
        public $currencyCode;
        /**
         * @access public
         * @var xsint
         */
        public $dateOfMonth;
        /**
         * @access public
         * @var commonDayOfWeek
         */
        public $dayOfWeek;
        /**
         * @access public
         * @var xsdateTime
         */
        public $endingDate;
        /**
         * @access public
         * @var xsdecimal
         */
        public $maxAmountPerPayment;
        /**
         * @access public
         * @var xsint
         */
        public $maxNumberOfPayments;
        /**
         * @access public
         * @var xsint
         */
        public $maxNumberOfPaymentsPerPeriod;
        /**
         * @access public
         * @var xsdecimal
         */
        public $maxTotalAmountOfAllPayments;
        /**
         * @access public
         * @var xsstring
         */
        public $paymentPeriod;
        /**
         * @access public
         * @var xsstring
         */
        public $pinType;
        /**
         * @access public
         * @var xsstring
         */
        public $returnUrl;
        /**
         * @access public
         * @var xsstring
         */
        public $senderEmail;
        /**
         * @access public
         * @var xsstring
         */
        public $memo;
        /**
         * @access public
         * @var xsdateTime
         */
        public $startingDate;
        /**
         * @access public
         * @var xsstring
         */
        public $status;
        /**
         * @access public
         * @var xsstring
         */
        public $ipnNotificationUrl;
        /**
         * @access public
         * @var apAddressList
         */
        public $addressList;
        /**
         * @access public
         * @var xsstring
         */
        public $feesPayer;
        /**
         * @access public
         * @var xsboolean
         */
        public $displayMaxTotalAmount;
    }
}

if (!class_exists("PreapprovalRequest")) {
    /**
     * PreapprovalRequest
     */
    class PreapprovalRequest
    {
        /**
         * @access public
         * @var commonRequestEnvelope
         */
        public $requestEnvelope;
        /**
         * @access public
         * @var commonClientDetailsType
         */
        public $clientDetails;
        /**
         * @access public
         * @var xsstring
         */
        public $cancelUrl;
        /**
         * @access public
         * @var xsstring
         */
        public $currencyCode;
        /**
         * @access public
         * @var xsint
         */
        public $dateOfMonth;
        /**
         * @access public
         * @var commonDayOfWeek
         */
        public $dayOfWeek;
        /**
         * @access public
         * @var xsdateTime
         */
        public $endingDate;
        /**
         * @access public
         * @var xsdecimal
         */
        public $maxAmountPerPayment;
        /**
         * @access public
         * @var xsint
         */
        public $maxNumberOfPayments;
        /**
         * @access public
         * @var xsint
         */
        public $maxNumberOfPaymentsPerPeriod;
        /**
         * @access public
         * @var xsdecimal
         */
        public $maxTotalAmountOfAllPayments;
        /**
         * @access public
         * @var xsstring
         */
        public $paymentPeriod;
        /**
         * @access public
         * @var xsstring
         */
        public $returnUrl;
        /**
         * @access public
         * @var xsstring
         */
        public $memo;
        /**
         * @access public
         * @var xsstring
         */
        public $ipnNotificationUrl;
        /**
         * @access public
         * @var xsstring
         */
        public $senderEmail;
        /**
         * @access public
         * @var xsdateTime
         */
        public $startingDate;
        /**
         * @access public
         * @var xsstring
         */
        public $pinType;
        /**
         * @access public
         * @var xsstring
         */
        public $feesPayer;
        /**
         * @access public
         * @var xsboolean
         */
        public $displayMaxTotalAmount;
    }
}

if (!class_exists("PreapprovalResponse")) {
    /**
     * PreapprovalResponse
     */
    class PreapprovalResponse
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $preapprovalKey;
    }
}

if (!class_exists("RefundRequest")) {
    /**
     * RefundRequest
     */
    class RefundRequest
    {
        /**
         * @access public
         * @var commonRequestEnvelope
         */
        public $requestEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $currencyCode;
        /**
         * @access public
         * @var xsstring
         */
        public $payKey;
        /**
         * @access public
         * @var xsstring
         */
        public $transactionId;
        /**
         * @access public
         * @var xsstring
         */
        public $trackingId;
        /**
         * @access public
         * @var apReceiverList
         */
        public $receiverList;
    }
}

if (!class_exists("RefundResponse")) {
    /**
     * RefundResponse
     */
    class RefundResponse
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $currencyCode;
        /**
         * @access public
         * @var apRefundInfoList
         */
        public $refundInfoList;
    }
}

if (!class_exists("SetPaymentOptionsRequest")) {
    /**
     * SetPaymentOptionsRequest
     */
    class SetPaymentOptionsRequest
    {
        /**
         * @access public
         * @var commonRequestEnvelope
         */
        public $requestEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $payKey;
        /**
         * @access public
         * @var apInitiatingEntity
         */
        public $initiatingEntity;
        /**
         * @access public
         * @var apDisplayOptions
         */
        public $displayOptions;
        /**
         * @access public
         * @var xsstring
         */
        public $shippingAddressId;
        /**
         * @access public
         * @var apSenderOptions
         */
        public $senderOptions;
        /**
         * @access public
         * @var apReceiverOptions
         */
        public $receiverOptions;
    }
}

if (!class_exists("SetPaymentOptionsResponse")) {
    /**
     * SetPaymentOptionsResponse
     */
    class SetPaymentOptionsResponse
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
    }
}

if (!class_exists("GetFundingPlansRequest")) {
    /**
     * GetFundingPlansRequest
     */
    class GetFundingPlansRequest
    {
        /**
         * @access public
         * @var commonRequestEnvelope
         */
        public $requestEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $payKey;
    }
}

if (!class_exists("GetFundingPlansResponse")) {
    /**
     * GetFundingPlansResponse
     */
    class GetFundingPlansResponse
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
        /**
         * @access public
         * @var apFundingPlan
         */
        public $fundingPlan;
    }
}

if (!class_exists("GetAvailableShippingAddressesRequest")) {
    /**
     * GetAvailableShippingAddressesRequest
     */
    class GetAvailableShippingAddressesRequest
    {
        /**
         * @access public
         * @var commonRequestEnvelope
         */
        public $requestEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $key;
    }
}

if (!class_exists("GetAvailableShippingAddressesResponse")) {
    /**
     * GetAvailableShippingAddressesResponse
     */
    class GetAvailableShippingAddressesResponse
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
        /**
         * @access public
         * @var apAddress
         */
        public $availableAddress;
    }
}

if (!class_exists("GetShippingAddressesRequest")) {
    /**
     * GetShippingAddressesRequest
     */
    class GetShippingAddressesRequest
    {
        /**
         * @access public
         * @var commonRequestEnvelope
         */
        public $requestEnvelope;
        /**
         * @access public
         * @var xsstring
         */
        public $key;
    }
}

if (!class_exists("GetShippingAddressesResponse")) {
    /**
     * GetShippingAddressesResponse
     */
    class GetShippingAddressesResponse
    {
        /**
         * @access public
         * @var commonResponseEnvelope
         */
        public $responseEnvelope;
        /**
         * @access public
         * @var apAddress
         */
        public $selectedAddress;
    }
}