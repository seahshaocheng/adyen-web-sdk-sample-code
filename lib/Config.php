<?php

/**
 *                       ######
 *                       ######
 * ############    ####( ######  #####. ######  ############   ############
 * #############  #####( ######  #####. ######  #############  #############
 *        ######  #####( ######  #####. ######  #####  ######  #####  ######
 * ###### ######  #####( ######  #####. ######  #####  #####   #####  ######
 * ###### ######  #####( ######  #####. ######  #####          #####  ######
 * #############  #############  #############  #############  #####  ######
 *  ############   ############  #############   ############  #####  ######
 *                                      ######
 *                               #############
 *                               ############
 *
 * Adyen Checkout Example (https://www.adyen.com/)
 *
 * Copyright (c) 2017 Adyen BV (https://www.adyen.com/)
 *
 */
class Config
{
    const ENDPOINT_TEST = "https://checkout-test.adyen.com";
    const VERSION = "/v67";
    const PAYMENTSESSION = "/paymentSession";
    const PAYMENTSRESULT = "/payments/result";

    /** Function to define the protocol and base URL */
    public static function url()
    {
        if (!empty (getenv('PROTOCOL'))) {
            $protocol = getenv('PROTOCOL');
        } else {
            $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https' : 'http';
        }

        return sprintf(
            "%s://%s", $protocol, $_SERVER['HTTP_HOST']
        );
    }

    public static function getOrigin()
    {
        return self::url();
    }

    public static function getShopperIP()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public static function getReturnUrl()
    {
        return self::url();
    }

    public static function getPaymentSessionUrl()
    {
        return self::ENDPOINT_TEST . self::VERSION . self::PAYMENTSESSION;
    }

    public static function getPaymentsResultUrl()
    {
        return self::ENDPOINT_TEST . self::VERSION . self::PAYMENTSRESULT;
    }

    public static function getAuthentication()
    {
        $authentication = array();
        if (!empty (getenv('MERCHANT_ACCOUNT')) && !empty(getenv('CHECKOUT_API_KEY'))) {
            $authentication['merchantAccount'] = getenv('MERCHANT_ACCOUNT');
            $authentication['checkoutAPIkey'] = getenv('CHECKOUT_API_KEY');
        } else {
            if (file_exists(__DIR__ . '/../config/authentication.ini')) {
                $authentication = parse_ini_file(__DIR__ . '/../config/authentication.ini', true);
            }
        }
        if (empty($authentication)) {
            echo "Authentication not set. Please check README file.";
        }
        return $authentication;
    }
}
