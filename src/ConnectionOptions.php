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

use Zend\Stdlib\AbstractOptions;

class ConnectionOptions extends AbstractOptions
{
    /**
     * Baud rate
     * Allowed values: 110, 150, 300, 600, 1200,
     * 2400, 4800, 9600, 19200, 38400, 57600, 115200.
     *
     * @var int
     */
    protected $baudRate = 9600;

    /**
     * Parity
     * Allowed values: none, even, odd.
     *
     * @var string
     */
    protected $parity = 'none';

    /**
     * Flow control
     * Allowed values: none, rts/cts, xon/xoff.
     *
     * @var string
     */
    protected $flowControl = 'none';

    /**
     * Stop bit
     * Allowed values: 1, 1.5, 2
     * May vary on some systems, refer to suitable adapter.
     *
     * @var int
     */
    protected $stopBits = 1;

    /**
     * Character length
     * Allowed values: 5, 6, 7, 8.
     *
     * @var int
     */
    protected $charLength = 8;

    /**
     * Get baud rate.
     *
     * @return string
     */
    public function getBaudRate()
    {
        return $this->baudRate;
    }

    /**
     * Get parity.
     *
     * @return string
     */
    public function getParity()
    {
        return $this->parity;
    }

    /**
     * Get flow control.
     *
     * @return string
     */
    public function getFlowControl()
    {
        return $this->flowControl;
    }

    /**
     * Get stop bits.
     *
     * @return string
     */
    public function getStopBits()
    {
        return $this->stopBits;
    }

    /**
     * Get character length.
     *
     * @return string
     */
    public function getCharLength()
    {
        return $this->charLength;
    }

    /**
     * Set baud rate.
     *
     * @param string $baudRate
     *
     * @return ConnectionOptions
     */
    public function setBaudRate($baudRate)
    {
        $this->baudRate = $baudRate;

        return $this;
    }

    /**
     * Set parity.
     *
     * @param string $parity
     *
     * @return ConnectionOptions
     */
    public function setParity($parity)
    {
        $this->parity = $parity;

        return $this;
    }

    /**
     * Set flow control.
     *
     * @param string $flowControl
     *
     * @return ConnectionOptions
     */
    public function setFlowControl($flowControl)
    {
        $this->flowControl = $flowControl;

        return $this;
    }

    /**
     * Set stop bits.
     *
     * @param string $stopBits
     *
     * @return ConnectionOptions
     */
    public function setStopBits($stopBits)
    {
        $this->stopBits = $stopBits;

        return $this;
    }

    /**
     * Set character length.
     *
     * @param string $charLength
     *
     * @return ConnectionOptions
     */
    public function setCharLength($charLength)
    {
        $this->charLength = $charLength;

        return $this;
    }
}
