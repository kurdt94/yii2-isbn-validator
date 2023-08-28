
# yii2-isbn-validator
This extension adds ISBN-10 / ISBN-13 Form validation as a standalone validator to the Yii2 framework. 

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require kurdt94/yii2-isbn-validator "@dev"
```

or add

```
"kurdt94/yii2-isbn-validator": "@dev"
```

to the ```require``` section of your `composer.json` file.

## Usage

This extension extends the `yii\validators\Validator` class to validate ISBN-10 or ISBN-13 identifiers.
The `IsbnValidator` class can be applied using the alias `k-isbn` in your model rules. In this example we validate the "isbn_number" field:

```php
use yii\db\ActiveRecord;

class BooksModel extends ActiveRecord {
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            //...
            [['isbn_number'], 'k-isbn'],
        ];
    }
}
```
## Ajax Validation

Prefered is the use of AjaxValidation. This can be aplied using the ActiveForm `enableAjaxValidation` property.

```php
echo $form->field($model, 'isbn_number', ['enableAjaxValidation' => true]);
```

-- Or if you wish to enable AjaxValidation on the entire Form. --  

```php
echo $form = ActiveForm::begin(['id' => 'books-form', 'enableAjaxValidation' => true,]);
```

Don't forget to set up Ajax response in your controller-action. If the request `isAjax` and we can `load($_POST)` then return `\yii\widgets\ActiveForm::validate($model)`.

```php
$model = new Books();

if (Yii::$app->request->isAjax && $model->load($_POST))
{
    Yii::$app->response->format = 'json';
    return \yii\widgets\ActiveForm::validate($model);
}
```

## License
This extension is released under the **BSD-3-Clause License**. Please read `LICENSE.md` for more details.
