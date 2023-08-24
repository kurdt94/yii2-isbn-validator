
# yii2-isbn-validator
This extension adds ISBN-10/13 Form validation to the Yii2 framework. 

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
The `PhoneValidator` class can be easily used via the alias `k-isbn` in your model validation rules. For example in your 
model you can use this as shown below:

```php
use yii\db\ActiveRecord;

class BooksModel extends ActiveRecord {
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ...
            [['isbn_number'], 'k-isbn'],
        ];
    }
}
```

## License
This extension is released under the **BSD-3-Clause License**. See the bundled `LICENSE.md` for details.
