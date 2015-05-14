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

namespace Jbenoit\PhpRs232;

use Jbenoit\PhpRs232\Exception\Exception;

class Connection
{
    /**
     * Connection options.
     *
     * @var array
     */
    protected $options;

    /**
     * Adapter instance.
     *
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * Output buffer.
     *
     * @var string
     */
    protected $output;

    /**
     * Error buffer.
     *
     * @var string
     */
    protected $error;

    /**
     * Connection.
     *
     * @var type
     */
    protected $connection = null;

    public function __construct($device, $options = [])
    {
        $this->device = $device;
        $this->setOptions($options);
        $this->loadAdapter(PHP_OS);
        register_shutdown_function(array($this, 'close'));
    }

    protected function loadAdapter($os)
    {
        $adapterClassname = __NAMESPACE__.'\\Adapter\\'.$os.'Rs232Adapter';
        if (class_exists($adapterClassname)) {
            $this->adapter = new $adapterClassname($this->device, $this->options);

            return;
        }

        throw new Exception('OS not supported.');
    }

    public function setDevice($device)
    {
        $this->adapter->setDevice($device);
    }

    public function open()
    {
        $this->adapter->open();
    }

    public function read()
    {
        return $this->adapter->read();
    }

    public function write($data)
    {
        $this->adapter->write($data);
    }

    public function close()
    {
        $this->adapter->close();
    }

    public function getLastError()
    {
        return $this->error;
    }

    public function getConnection()
    {
        return $this->adapter->getConnection();
    }

    protected function setOptions($options)
    {
        if (!$options instanceof ConnectionOptions) {
            $options = new ConnectionOptions($options);
        }
        $this->options = $options;
    }

    public function __destruct()
    {
        $this->close();
    }
}
