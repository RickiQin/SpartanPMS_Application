<?php

class DataValidation {
    private static $REGEX_STANDARD_REQ = "/\w{1,}/";
    private static $REGEX_STANDARD_OPT = "/\w{0,}/";
    private static $REGEX_STANDARD_INT = "/\d{0,}/";
    private static $REGEX_EMAIL = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/";
    private static $REGEX_PASSWORD = "/^(?=.*[a-zA-Z])\w{6,}$/";
    private static $REGEX_CREDITCARD = "/^[0-9]{9,16}$/";
    private static $REGEX_CVD = "/[0-9]{2,5}/";
    private static $REGEX_PTIN = "/^[P][0-9]{8}$/";
    private static $REGEX_PHONE = "/^([0-9]){9,20}$/"; // strip all non-digit characters on input (except 'x'). == preg_replace("/[^0-9x]/", "", $testString);
    private static $REGEX_DATABASE_ID = "/[1-9][0-9]{0,}/";
    private static $REGEX_ZIP = "/^(-[0-9){3,15}$/";
    const FIELD_EMAIL = "email";
    const FIELD_PASSWORD = "password";
    const FIELD_CARD_NUMBER = "cardNumber";
    const FIELD_CVD = "cvd";
    const FIELD_PHONE = "phone";
    const FIELD_ZIP = "zip";
    const FIELD_DATABASE_ID = "db_id";
    const FIELD_STRING_REQUIRED = "str_req";
    const FIELD_STRING_OPTIONAL = "str_opt";
    const FIELD_INT = "int";
    
    
    static function validateField($field, $data) {
        $regex = self::$REGEX_STANDARD_OPT;
        switch($field) {
            case self::FIELD_EMAIL:
                $regex = self::$REGEX_EMAIL;
            break;
            case self::FIELD_PASSWORD:
                $regex = self::$REGEX_PASSWORD;
            break;
            case self::FIELD_CARD_NUMBER:
                $regex = self::$REGEX_CREDITCARD;
            break;
            case self::FIELD_CVD:
                $regex = self::$REGEX_CVD;
            break;
            case self::FIELD_PHONE:
                $regex = self::$REGEX_PHONE;
            break;
            case self::FIELD_ZIP:
                $regex = self::$REGEX_ZIP;
            break;
            case self::FIELD_DATABASE_ID:
                $regex = self::$REGEX_DATABASE_ID;
            break;
            case self::FIELD_STRING_REQUIRED:
                $regex = self::$REGEX_STANDARD_REQ;
            break;
            case self::FIELD_STRING_OPTIONAL:
                $regex = self::$REGEX_STANDARD_OPT;
            break;
            case self::FIELD_INT:
                $regex = self::$REGEX_STANDARD_INT;
            break;
        }
        if(preg_match($regex, $data))
            return true;
        
        return false;
    }
    
}

?>