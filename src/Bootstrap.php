<?php
namespace kurdt94\isbn;

use yii\base\BootstrapInterface;
use yii\validators\Validator;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        Validator::$builtInValidators = array_merge(Validator::$builtInValidators, [
            'k-isbn' => 'kurdt94\isbn\IsbnValidator',
        ]);
    }
}