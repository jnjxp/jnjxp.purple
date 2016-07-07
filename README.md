# jnjxp.purple
execute tasks on collections

[![Latest version][ico-version]][link-packagist]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]

```php
<?php

use Jnjxp\Purple;

/**
 * A traversable collection of data
 */
class Collection implements IteratorAggregate
{
    protected $data = [1,2,3,4];

    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }
}

/**
 * A task to execute on each item in the collection
 */
class EchoParamTask
{
    public function __invoke($value, $key)
    {
        echo ($key > 0)
            ? "+ $value\n"
            : "  $value\n";
    }
}

/**
 * A task to execute on the collection as a whole
 */
class SumParamsTask
{
    public function __invoke($collection)
    {
        $sum = array_sum(iterator_to_array($collection));
        echo "---\n";
        echo " $sum\n";
    }
}

/**
 * A function to resolve an object from a spec
 */
$resolver = function ($spec) {
    if (is_string($spec)) {
        return new $spec;
    }
    return $spec;
};



// Create a runner with the resolver
$runner = new Purple\Runner($resolver);


// Add tasks
$runner->task(Collection::class)  // Add a task w/ collection
    ->each(EchoParamTask::class)  // Add a task for each item
    ->all(SumParamsTask::class);  // Add a task for the whole

$runner(); // Execute tasks


/**
 *  Output:
 *
 *   1
 * + 2
 * + 3
 * + 4
 * ---
 *  10
 *
 */

```


[ico-version]: https://img.shields.io/packagist/v/jnjxp/purple.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/jnjxp/jnjxp.purple/develop.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/jnjxp/jnjxp.purple.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/jnjxp/jnjxp.purple.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/jnjxp/purple
[link-travis]: https://travis-ci.org/jnjxp/jnjxp.purple
[link-scrutinizer]: https://scrutinizer-ci.com/g/jnjxp/jnjxp.purple
[link-code-quality]: https://scrutinizer-ci.com/g/jnjxp/jnjxp.purple
