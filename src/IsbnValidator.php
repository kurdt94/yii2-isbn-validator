<?php
/**
 * Yii2-isbn-validator
 * Copyright 2023 - Erwin Graanstra
 * https://github.com/kurdt94/yii2-isbn-validator
 * v1.0.1
 */
namespace kurdt94\isbn;
use yii;
use yii\validators\Validator;

class IsbnValidator extends Validator
{
    /**
     * Validate ISBN-13 Checksum
     * @param $isbn
     * @return bool
     */
    private function isValidISBN10($isbn){

        // Validate Lenght
        $isbn_len = strlen($isbn);
        if ($isbn_len !== 10) { return false; }

        // ISBN-10 Checksum Calculation
        $sum = 0;
        $multiplier = 10;
        for($i = 0; $i < ( $isbn_len); ++$i) {
            if(is_numeric($isbn[$i])){ $sum += ($isbn[$i] - 0) * $multiplier; $multiplier--; }
            else{ return false; }
        }

        return ($sum % 11 == 0);
    }

    /**
     * Validate ISBN-13 Checksum
     * @param $isbn
     * @return bool
     */
    private function IsValidISBN13($isbn){

        // Validate Lenght
        $isbn_len = strlen($isbn);
        if ($isbn_len !== 13) { return false; }

        // ISBN-13 Checksum Calculation
        $sum = 0;
        for($i = 0; $i < $isbn_len; ++$i) {
            if(is_numeric($isbn[$i])){ $sum += ($isbn[$i] - 0) * ($i % 2 == 0 ? 1 : 3); }
            else{ return false; }
        }

        return ($sum % 10 == 0);

    }

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {

        // Clean Input
        $isbn = preg_replace('/(\s+|:|-)/', '', $model->$attribute);
        $validation = ($this->IsValidISBN10($isbn) || $this->IsValidISBN13($isbn));

        switch (strlen($isbn)) {
            case 10:
                $annotation = 'ISBN-10';
                break;
            case 13:
                $annotation = 'ISBN-13';
                break;
            default:
                $annotation = 'ISBN';
        }
        $message = Yii::t('yii','Is not a valid {isbn} identifier', ['isbn' => $annotation]);

        // ERROR
        if (!$validation) {
            $this->addError($model, $attribute, '"' . $model->$attribute . '" ' . $message);
        }
    }

}
