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
use PetrKnap\Enum\Test\Readme\MyBoolean;

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

And now the **same code [with enum](./tests/Readme/MyBoolean.php)** instead of constants:

```php
use PetrKnap\Enum\Test\Readme\MyBoolean;

$isTrue = function (MyBoolean $myBoolean): bool
{
    switch($myBoolean) {
        case MyBoolean::MY_TRUE():
            return true;
        case MyBoolean::MY_FALSE():
            return false;
    }
};

var_dump($isTrue(MyBoolean::MY_TRUE()));  // true - correct
var_dump($isTrue(MyBoolean::MY_FALSE())); // false - correct
```


## Usage of enum

### Enum declaration

```php
use PetrKnap\Enum\Enum;
use PetrKnap\Enum\ConstantsAsMembersTrait;

class DayOfWeek extends Enum
{
    use ConstantsAsMembersTrait;

    const SUNDAY = 0;
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
}

var_dump(DayOfWeek::getMembers());
```


### Enum usage

```php
if (DayOfWeek::FRIDAY() == DayOfWeek::FRIDAY()) {
    echo 'This is OK.' . PHP_EOL;
}

if (DayOfWeek::FRIDAY() == DayOfWeek::MONDAY()) {
    echo 'We are going to Hell!' . PHP_EOL;
}
```

```php
$isWeekend = function (DayOfWeek $dayOfWeek): bool
{
   switch ($dayOfWeek) {
       case DayOfWeek::SATURDAY():
       case DayOfWeek::SUNDAY():
           return true;
       default:
           return false;
   }
};

var_dump($isWeekend(DayOfWeek::FRIDAY()));   // false
var_dump($isWeekend(DayOfWeek::SATURDAY())); // true
```

```php
$dayOfWeek = (int) date('w', 1697220074);
if ($dayOfWeek === DayOfWeek::FRIDAY()->getValue()) {
    echo 'Finally it is Friday!' . PHP_EOL;
}
// or
if (DayOfWeek::getByValue($dayOfWeek) == DayOfWeek::FRIDAY()) {
    echo 'Finally it is Friday!' . PHP_EOL;
}
```

### Tips & Tricks

Enum is capable to carry any data type as values, including another enum instance.

```php
use PetrKnap\Enum\Enum;

class MixedValues extends Enum
{
    public static function getMembers(): array
    {
        return [
            "null" => null,
            "boolean" => true,
            "integer" => 1,
            "float" => 1.0,
            "string" => "s",
            "array" => [],
            "object" => new \stdClass(),
            "callable" => function(string $name): void {
                echo "Hello {$name}!" . PHP_EOL;
            },
        ];
    }
}

MixedValues::callable()->getValue()('World');
```

You can simply convert value to member instance and vice versa.

```php
#[ORM\Entity]
class MyEntity
{
    #[ORM\Column(type: 'integer')]
    private int $dayOfWeek;

    public function getDayOfWeek(): DayOfWeek
    {
        return DayOfWeek::getByValue($this->dayOfWeek);
    }

    public function setDayOfWeek(DayOfWeek $dayOfWeek): void
    {
        $this->dayOfWeek = $dayOfWeek->getValue();
    }
}

$myEntity = new MyEntity();
$myEntity->setDayOfWeek(DayOfWeek::MONDAY());
echo "It was {$myEntity->getDayOfWeek()}." . PHP_EOL;
```



[Enumerated type - Wikipedia, The Free Encyclopedia]:https://en.wikipedia.org/w/index.php?title=Enumerated_type&oldid=701057934

---

Run `composer require petrknap/enum` to install it.
You can [support this project via donation](https://petrknap.github.io/donate.html).
The project is licensed under [the terms of the `LGPL-3.0-or-later`](./COPYING.LESSER).
