<?php
/* 
 * Copyright (C) 2015 Julien BENOIT <jbenoit.jb+dev@gmail.com>.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this library. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Jbenoit\PhpRs232\Adapter;

interface Rs232AdapterInterface
{
    /**
     * Open connection.
     */
    public function open();

    /**
     * Read data from buffer.
     */
    public function read();

    /**
     * Write data to buffer.
     */
    public function write($data);

    /**
     * Close connection.
     */
    public function close();

    /**
     * Flush buffer.
     */
    public function flush();
}
