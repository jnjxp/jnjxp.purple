<?php
/**
 * Purple - Run tasks on collections
 *
 * PHP version 5
 *
 * Copyright (C) 2016 Jake Johns
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 *
 * @category  Runner
 * @package   Jnjxp\Purple
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2016 Jake Johns
 * @license   http://jnj.mit-license.org/2016 MIT License
 * @link      https://github.com/jnjxp/jnjxp.purple
 */

namespace Jnjxp\Purple;

use Countable;

/**
 * Runner
 *
 * @category Runner
 * @package  Jnjxp\Purple
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/ MIT License
 * @link     https://github.com/jnjxp/jnjxp.purple
 */
class Runner implements Countable
{
    /**
     * Resolver
     *
     * @var callable
     *
     * @access protected
     */
    protected $resolver;

    /**
     * Task factory
     *
     * @var callable
     *
     * @access protected
     */
    protected $taskFactory;

    /**
     * Tasks
     *
     * @var QueueInterface
     *
     * @access protected
     */
    protected $tasks;

    /**
     * __construct
     *
     * @param callable       $resolver DESCRIPTION
     * @param QueueInterface $queue    DESCRIPTION
     *
     * @access public
     */
    public function __construct(
        callable $resolver = null,
        QueueInterface $queue = null
    ) {
        $this->resolver = $resolver;
        $this->setTaskFactory([$this, 'newTask']);
        $this->tasks = $queue ?: new Queue;
    }

    /**
     * Set task factory
     *
     * @param callable $factory factory to create a task
     *
     * @return $this
     *
     * @access public
     */
    public function setTaskFactory(callable $factory)
    {
        $this->taskFactory = $factory;
        return $this;
    }

    /**
     * Add task
     *
     * @param mixed $task     task to be added
     * @param int   $priority priority of task
     *
     * @return $this
     *
     * @access public
     */
    public function addTask($task, $priority = 1000)
    {
        $this->tasks->insert($task, $priority);
        return $this;
    }

    /**
     * Task
     *
     * @param mixed $collection collection or collection spec
     * @param int   $priority   priority of task
     *
     * @return TaskInterface
     *
     * @access public
     */
    public function task($collection, $priority = 1000)
    {
        $task = call_user_func($this->taskFactory, $collection);
        $this->addTask($task, $priority);
        return $task;
    }

    /**
     * Execute all tasks
     *
     * @return void
     *
     * @access public
     */
    public function __invoke()
    {
        foreach ($this->tasks as $spec) {
            $task = $this->resolve($spec);
            $this->runTask($task);
        }
    }

    /**
     * Count
     *
     * @return int
     *
     * @access public
     */
    public function count()
    {
        return count($this->tasks);
    }

    /**
     * Run task
     *
     * @param TaskInterface $task task to run
     *
     * @return void
     *
     * @access protected
     */
    protected function runTask(TaskInterface $task)
    {
        $collection = $this->resolve($task->getCollection());

        // Item Tasks
        $itemTasks = $task->getItemTasks();
        $this->runItemTasks($collection, $itemTasks);

        // Collection Tasks
        $collectionTasks = $task->getCollectionTasks();
        $this->runCollectionTasks($collection, $collectionTasks);
    }

    /**
     * Run item tasks
     *
     * @param mixed $items items on which to execute tasks
     * @param mixed $tasks tasks to execute
     *
     * @return void
     *
     * @access protected
     */
    protected function runItemTasks($items, $tasks)
    {
        foreach ($tasks as $spec) {
            $task = $this->resolve($spec);
            foreach ($items as $key => $value) {
                $task($value, $key);
            }
        }
    }

    /**
     * Run collection tasks
     *
     * @param mixed $items collection on which to run tasks
     * @param mixed $tasks tasks to run
     *
     * @return void
     *
     * @access protected
     */
    protected function runCollectionTasks($items, $tasks)
    {
        foreach ($tasks as $spec) {
            $task = $this->resolve($spec);
            $task($items);
        }
    }

    /**
     * New task
     *
     * @param mixed $collection collection or collection spec
     *
     * @return Task
     *
     * @access protected
     */
    protected function newTask($collection)
    {
        return new Task(
            $collection,
            new Queue,
            new Queue
        );
    }

    /**
     * Resolve
     *
     * @param mixed $spec spec to resolve
     *
     * @return mixed
     *
     * @access protected
     */
    protected function resolve($spec)
    {
        if (! $this->resolver) {
            return $spec;
        }

        return call_user_func($this->resolver, $spec);
    }
}
