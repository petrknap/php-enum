# Enumerated type for PHP

* [What is Enum?](#what-is-enum)
* [Why use Enums instead of Constants?](#why-use-enums-instead-of-constants)
* [Usage of php-enum](#usage-of-php-enum)
    * [Enum declaration](#enum-declaration)
    * [Enum usage](#enum-usage)
    * [Tips & Tricks](#tips--tricks)
* [How to install](#how-to-install)


## What is Enum?

> In computer programming, an **enumerated type** (also called **enumeration** or **enum**, or **factor** in the R programming language, and a **categorical variable** in statistics) is a data type consisting of a set of named values called **elements**, **members**, **enumeral**, or **enumerators** of the type. The enumerator names are usually identifiers that behave as constants in the language. A variable that has been declared as having an enumerated type can be assigned any of the enumerators as a value. In other words, an *enumerated type has values that are different from each other*, and that can be compared and assigned, but which are not specified by the programmer as having any particular concrete representation in the computer's memory; compilers and interpreters can represent them arbitrarily.
-- [Enumerated type - Wikipedia, The Free Encyclopedia]


## Why use Enums instead of Constants?

Because **it is safer and less scary** than using constants. Don't trust me? Let see at this code:

```php
use PetrKnap\Enum\Readme\MyBoolean;

$isTrue = function (int $myBoolean)
{
    switch($myBoolean) {
        case MyBoolean::MY_TRUE:
            return true;
        case MyBoolean::MY_FALSE:
            return false;
    }
};

var_dump($isTrue(MyBoolean::MY_TRUE));  // true - correct
var_dump($isTrue(MyBoolean::MY_FALSE)); // false - correct
var_dump($isTrue(0));                   // none
var_dump($isTrue(1));                   // true - expected
var_dump($isTrue(2));                   // false
var_dump($isTrue((int) true));          // true - expected
var_dump($isTrue((int) false));         // none
```

And now the **same code [with enum](https://www.php.net/manual/en/language.types.enumerations.php)** instead of constants:

```php
use PetrKnap\Enum\Readme\MyBoolean;

$isTrue = function (MyBoolean $myBoolean): bool
{
    switch($myBoolean) {
        case MyBoolean::MyTrue:
            return true;
        case MyBoolean::MyFalse:
            return false;
    }
};

var_dump($isTrue(MyBoolean::MyTrue));  // true - correct
var_dump($isTrue(MyBoolean::MyFalse)); // false - correct
```



[Enumerated type - Wikipedia, The Free Encyclopedia]:https://en.wikipedia.org/w/index.php?title=Enumerated_type&oldid=701057934

---

Run `composer require petrknap/enum` to install it.
You can [support this project via donation](https://petrknap.github.io/donate.html).
The project is licensed under [the terms of the `LGPL-3.0-or-later`](./COPYING.LESSER).
