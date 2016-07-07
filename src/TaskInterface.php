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
 * TaskInterface
 *
 * @category Task
 * @package  Jnjxp\Purple
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://jnj.mit-license.org/ MIT License
 * @link     https://github.com/jnjxp/jnjxp.purple
 */
interface TaskInterface
{
    /**
     * Get collection
     *
     * @return mixed
     *
     * @access public
     */
    public function getCollection();

    /**
     * Get item tasks
     *
     * @return array
     *
     * @access public
     */
    public function getItemTasks();

    /**
     * Get collection tasks
     *
     * @return array
     *
     * @access public
     */
    public function getCollectionTasks();
}
