<?php
// @codingStandardsIgnoreFile

namespace Jnjxp\Purple;

class RunnerTest extends \PHPUnit_Framework_TestCase
{

    protected $each;

    protected $all;

    public function setUp()
    {
        $test = $this;

        $this->input = [1,2,3,4];
        $input = $this->input;

        $this->each = function ($value, $key, $context) use ($test, $input) {
            static $idx = 0;
            $test->assertEquals($value, $idx + 1);
            $test->assertEquals($key, $idx);
            $this->assertEquals($context, $input);
            $idx++;
        };

        $this->all = function ($params) use ($test) {
            $this->assertEquals($params, $this->input);
        };
    }

    public function testRunner()
    {
        $runner = new Runner;

        $this->assertEquals(0, count($runner));

        $runner->task($this->input)
            ->each($this->each)
            ->all($this->all);

        $this->assertEquals(1, count($runner));

        $runner();
    }

    public function testSetters()
    {
        $runner = new Runner;
        $this->assertEquals(0, count($runner));

        $runner->addTasks(['foo', 'bar']);
        $this->assertEquals(2, count($runner));

        $runner->setTasks(['foo']);
        $this->assertEquals(1, count($runner));
    }

    public function testTaskSetters()
    {
        $task = new Task($this->input);
        $task->addItemTasks(['foo', 'bar']);
        $this->assertEquals(2, count($task->getItemTasks()));

        $task->setItemTasks(['abc']);
        $this->assertEquals(1, count($task->getItemTasks()));

        // Collection
        $task->addCollectionTasks(['foo', 'bar']);
        $this->assertEquals(2, count($task->getCollectionTasks()));

        $task->setCollectionTasks(['abc']);
        $this->assertEquals(1, count($task->getCollectionTasks()));
    }

    public function testResolution()
    {
        $resolver = [$this, 'resolver'];

        $runner = new Runner($resolver);

        $runner->task($this->input)
            ->each($this->each)
            ->all($this->all);

        $runner();
    }

    public function resolver($spec)
    {
        static $idx = 0;
        switch($idx) {
        case 0:
            $this->assertInstanceOf(Task::class, $spec);
            break;
        case 1:
            $this->assertEquals($spec, $this->input);
            break;
        case 2:
            $this->assertSame($spec, $this->each);
            break;
        case 3:
            $this->assertSame($spec, $this->all);
            break;
        }

        $idx++;

        return $spec;
    }
}
