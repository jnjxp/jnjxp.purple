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
 * @category  Task
 * @package   Jnjxp\Purple
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2016 Jake Johns
 * @license   http://jnj.mit-license.org/2016 MIT License
 * @link      https://github.com/jnjxp/jnjxp.purple
 */

namespace Jnjxp\Purple;

/**
 * Task
 *
 * @category Task
 * @package  Jnjxp\Purple
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/ MIT License
 * @link     https://github.com/jnjxp/jnjxp.purple
 *
 * @see TaskInterface
 */
class Task implements TaskInterface
{
    /**
     * Collection
     *
     * @var mixed
     *
     * @access protected
     */
    protected $collection;

    /**
     * Item tasks
     *
     * @var QueueInterface
     *
     * @access protected
     */
    protected $itemTasks;

    /**
     * Collection tasks
     *
     * @var QueueInterface
     *
     * @access protected
     */
    protected $collectionTasks;

    /**
     * __construct
     *
     * @param mixed          $collection          DESCRIPTION
     * @param QueueInterface $itemTaskQueue       DESCRIPTION
     * @param QueueInterface $collectionTaskQueue DESCRIPTION
     *
     * @access public
     */
    public function __construct(
        $collection,
        QueueInterface $itemTaskQueue = null,
        QueueInterface $collectionTaskQueue = null
    ) {
        $this->collection = $collection;
        $this->itemTasks = $itemTaskQueue ?: new Queue;
        $this->collectionTasks = $collectionTaskQueue ?: new Queue;
    }

    /**
     * Add an item task
     *
     * @param mixed $task     task or task spec
     * @param int   $priority priority of task
     *
     * @return $this
     *
     * @access public
     */
    public function each($task, $priority = 1000)
    {
        $this->itemTasks->insert($task, $priority);
        return $this;
    }

    /**
     * Add Item Tasks
     *
     * @param mixed $tasks    tasks to add
     * @param int   $priority task priority
     *
     * @return $this
     *
     * @access public
     */
    public function addItemTasks($tasks, $priority = 1000)
    {
        foreach ($tasks as $task) {
            $this->each($task, $priority);
        }
        return $this;
    }

    /**
     * Set Item Tasks
     *
     * @param mixed $tasks    Tasks to set
     * @param int   $priority Task priority
     *
     * @return $this
     *
     * @access public
     */
    public function setItemTasks($tasks, $priority = 1000)
    {
        $this->itemTasks->clear();
        return $this->addItemTasks($tasks, $priority);
    }

    /**
     * Add a collection task
     *
     * @param mixed $task     task
     * @param int   $priority order priority
     *
     * @return $this
     *
     * @access public
     */
    public function all($task, $priority = 1000)
    {
        $this->collectionTasks->insert($task, $priority);
        return $this;
    }

    /**
     * Add Collection Tasks
     *
     * @param mixed $tasks    tasks to add
     * @param int   $priority task priority
     *
     * @return $this
     *
     * @access public
     */
    public function addCollectionTasks($tasks, $priority = 1000)
    {
        foreach ($tasks as $task) {
            $this->all($task, $priority);
        }
        return $this;
    }

    /**
     * Set Collection Tasks
     *
     * @param mixed $tasks    tasks to set
     * @param int   $priority priority of tasks
     *
     * @return $this
     *
     * @access public
     */
    public function setCollectionTasks($tasks, $priority = 1000)
    {
        $this->collectionTasks->clear();
        return $this->addCollectionTasks($tasks, $priority);
    }

    /**
     * Get collection
     *
     * @return mixed
     *
     * @access public
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Get item tasks
     *
     * @return QueueInterface
     *
     * @access public
     */
    public function getItemTasks()
    {
        return $this->itemTasks;
    }

    /**
     * Get collection tasks
     *
     * @return QueueInterface
     *
     * @access public
     */
    public function getCollectionTasks()
    {
        return $this->collectionTasks;
    }
}
