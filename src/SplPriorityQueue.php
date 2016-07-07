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

/**
 * SplPriorityQueue
 *
 * @category Queue
 * @package  Jnjxp\Purple
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/ MIT License
 * @link     https://github.com/jnjxp/jnjxp.purple
 */
class SplPriorityQueue extends \SplPriorityQueue
{
    protected $order = PHP_INT_MAX;

    /**
     * Insert
     *
     * @param mixed $value    value
     * @param mixed $priority order priority
     *
     * @return mixed
     *
     * @access public
     */
    public function insert($value, $priority)
    {
        if (is_int($priority)) {
            $priority = array($priority, $this->order--);
        }
        parent::insert($value, $priority);
    }
}
