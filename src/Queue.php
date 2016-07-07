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
 * @category  Queue
 * @package   Jnjxp\Purple
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2016 Jake Johns
 * @license   http://jnj.mit-license.org/2016 MIT License
 * @link      https://github.com/jnjxp/jnjxp.purple
 */

namespace Jnjxp\Purple;

use IteratorAggregate;

/**
 * Queue
 *
 * @category Queue
 * @package  Jnjxp\Purple
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/ MIT License
 * @link     https://github.com/jnjxp/jnjxp.purple
 */
class Queue implements IteratorAggregate, QueueInterface
{
    /**
     * Queue
     *
     * @var SplPriorityQueue
     *
     * @access protected
     */
    protected $queue;

    /**
     * __construct
     *
     * @access public
     */
    public function __construct()
    {
        $this->queue = new SplPriorityQueue;
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
        return count($this->queue);
    }

    /**
     * Insert
     *
     * @param mixed $value    value
     * @param mixed $priority order priority
     *
     * @return void
     *
     * @access public
     */
    public function insert($value, $priority)
    {
        $this->queue->insert($value, $priority);
    }

    /**
     * Get Iterator
     *
     * @return SplPriorityQueue
     *
     * @access public
     */
    public function getIterator()
    {
        return clone $this->queue;
    }
}
