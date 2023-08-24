<?php

namespace kurdt94\isbn;
use yii;
use yii\validators\Validator;

class IsbnValidator extends Validator
{
    /**
     * Validate ISBN-10
     * @param $isbn
     * @return bool
     */
    private function isValidISBN10($isbn){
        // clean Input
        $isbn = preg_replace('/(\s+|:|-)/', '', $isbn);

        // Validate Lenght
        $isbn_len = strlen($isbn);
        if ($isbn_len !== 10) { return false; }

        // Checksum Calculation
        $sum = 0;
        $multiplier = 10;
        for($i = 0; $i < ( $isbn_len); ++$i) {

            if(is_numeric($isbn[$i])){
                $sum += ($isbn[$i] - 0) * $multiplier;
                $multiplier = $multiplier - 1;
            }

            else{ return false; }
        }

        return ($sum % 11 == 0);
    }

    /**
     * Erwin Graanstra
     * Yii2 Validate ISBN-13 Checksum
     * @param $isbn
     * @return bool
     */
    private function IsValidISBN13($isbn){

        // clean Input
        $isbn = preg_replace('/(\s+|:|-)/', '', $isbn);

        // Validate Lenght
        $isbn_len = strlen($isbn);

        if ($isbn_len !== 13) { return false; }

        // Checksum Calculation
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
        // ISBN
        $input = $model->$attribute;
        $validation = ($this->IsValidISBN10($input) || $this->IsValidISBN13($input));

        // ERROR
        if (!$validation) {
            $this->addError($model, $attribute, '"' . $model->$attribute . '" ' . Yii::t('yii','Is not a valid ISBN-10 or ISBN-13 identifier'));
        }
    }

}