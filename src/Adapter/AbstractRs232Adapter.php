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

use Jbenoit\PhpRs232\Exception\DomainException;
use Jbenoit\PhpRs232\Exception\Exception;

abstract class AbstractRs232Adapter implements Rs232AdapterInterface
{
    protected $defaultOptions = array(
        'baud_rate' => '9600',
        'parity' => 'none',
        'flow_control' => 'none',
        'stop_bits' => '1',
        'char_length' => '8',
    );

    protected $options;

    protected $validBaudRates = array(
            110    => 11,
            150    => 15,
            300    => 30,
            600    => 60,
            1200   => 12,
            2400   => 24,
            4800   => 48,
            9600   => 96,
            19200  => 19,
            38400  => 38400,
            57600  => 57600,
            115200 => 115200,
    );

    protected $validParity = array(
        'none',
        'even',
        'odd',
        );

    protected $validStopBits = array(
        1,
        1.5,
        2,
    );

    protected $validFlowControl = array(
        'none',
        'rts/cts',
        'xon/xoff',
    );

    protected $validCharLength = array(
        5,
        6,
        7,
        8,
    );

    protected $device;

    protected $waitForReply = 1000000;

    protected $connection;

    protected $autoFlush = true;

    protected $buffer;

    const OPEN_MODE = 'r+b';

    public function __construct($device, $options)
    {
        $this->device = $device;
        $this->setOptions($options);
    }

    protected function exec($cmd)
    {
        $desc = array(
            1 => array("pipe", "w"),
            2 => array("pipe", "w"),
        );

        $proc = proc_open($cmd, $desc, $pipes);

        $this->output = stream_get_contents($pipes[1]);
        $this->error = stream_get_contents($pipes[2]);

        fclose($pipes[1]);
        fclose($pipes[2]);

        return proc_close($proc);
    }

    protected function setOptions($options)
    {
        if (!empty($options->getBaudRate())) {
            if (!$this->isValidBaudRate($options->getBaudRate())) {
                throw new DomainException('Invalid baud rate');
            }
            $this->setBaudRate($options->getBaudRate());
        }

        if (!empty($options->getParity())) {
            if (!$this->isValidParity($options->getParity())) {
                throw new DomainException('Invalid parity');
            }
            $this->setParity($options->getParity());
        }

        if (!empty($options->getStopBits())) {
            if (!$this->isValidStopBits($options->getStopBits())) {
                throw new DomainException('Invalid stop bits');
            }
            $this->setStopBits($options->getStopBits());
        }

        if (!empty($options->getFlowControl())) {
            if (!$this->isValidFlowControl($options->getFlowControl())) {
                throw new DomainException('Invalid flow control');
            }
            $this->setFlowControl($options->getFlowControl());
        }

        if (!empty($options->getCharLength())) {
            if (!$this->isValidCharLength($options->getCharLength())) {
                throw new DomainException('Invalid character length');
            }
            $this->setCharLength($options->getCharLength());
        }
    }

    protected function isValidBaudRate($baudRate)
    {
        return array_key_exists($baudRate, $this->validBaudRates);
    }

    protected function isValidParity($parity)
    {
        return array_key_exists($parity, $this->validParity);
    }

    protected function isValidStopBits($stopBits)
    {
        return in_array($stopBits, $this->validStopBits);
    }

    protected function isValidFlowControl($flowControl)
    {
        return array_key_exists($flowControl, $this->validFlowControl);
    }

    protected function isValidCharLength($charLength)
    {
        return in_array($charLength, $this->validCharLength);
    }

    protected function isOpen()
    {
        return !is_null($this->connection);
    }

    public function write($data)
    {
        if (!is_string($data)) {
            throw new Exception('You can only write string');
        }
        $this->buffer .= $data;
        if ($this->autoFlush === true) {
            $this->flush();
        }

        usleep($this->waitForReply);
    }

    public function flush()
    {
        if (fwrite($this->connection, $this->buffer) !== false) {
            $this->buffer = "";

            return true;
        }
        $this->buffer = "";
        trigger_error("Error while sending message", E_USER_WARNING);

        return false;
    }

    public function close()
    {
        if (is_resource($this->connection)) {
            if (!fclose($this->connection)) {
                throw new Exception('Unable to close RS232 connection.');
            }
            $this->connection = null;
        }

        return true;
    }

    public function open()
    {
        if (!$this->exec(static::CMD.' '.$this->device)) {
            $this->connection = fopen($this->device, self::OPEN_MODE);

            if ($this->connection !== false) {
                stream_set_blocking($this->connection, 0);
            }

            if (!$this->connection) {
                throw new Exception('Unable to open RS232 connection');
            }

            return true;
        }

        throw new Exception('Unable to set device for RS232 connection');
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
