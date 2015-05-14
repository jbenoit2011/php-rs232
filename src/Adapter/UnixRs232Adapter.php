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

use Jbenoit\PhpRs232\Exception\Exception;

abstract class UnixRs232Adapter extends AbstractRs232Adapter
{
    const CHAR_LENGTH_ARG_FLAG = 'cs';

    const STOP_BIT = "cstopb";

    protected $validFlowControl = array(
        "none" => "clocal -crtscts -ixon -ixoff",
        "rts/cts" => "-clocal crtscts -ixon -ixoff",
        "xon/xoff" => "-clocal -crtscts ixon ixoff",
    );

    protected $validParity = array(
            "none" => "-parenb",
            "odd"  => "parenb parodd",
            "even" => "parenb -parodd",
        );

    protected function setDevice($device)
    {
        if ($this->exec(static::CMD.' '.$device)) {
            throw new Exception('Unable to set device');
        }
        $this->device = $device;
    }

    protected function setBaudRate($baudRate)
    {
        if ($this->exec(static::CMD.' '.$this->device.' '.$baudRate)) {
            throw new Exception('Unable to set baud rate');
        }
    }

    protected function setStopBits($stopBit)
    {
        if ($this->exec(static::CMD.' '.$this->device.' '.(($stopBit == 1) ? "-" : "").self::STOP_BIT)) {
            throw new Exception('Unable to set stop bit');
        }
    }

    protected function setFlowControl($flowControl)
    {
        if ($this->exec(static::CMD.' '.$this->device.' '.$this->validFlowControl[$flowControl])) {
            throw new Exception('Unable to set flow control');
        }
    }

    protected function setCharLength($charLength)
    {
        if ($this->exec(static::CMD.' '.$this->device.' '.self::CHAR_LENGTH_ARG_FLAG.$charLength)) {
            throw new Exception('Unable to set character length');
        }
    }

    protected function setParity($parity)
    {
        if ($this->exec(static::CMD.' '.$this->device.' '.$this->validParity[$parity])) {
            throw new Exception('Unable to set parity');
        }
    }

    public function read($count = 0)
    {
        // Behavior in OSX isn't to wait for new data to recover, but just
        // grabs what's there!
        // Doesn't always work perfectly for me in OSX
        $content = "";
        $i = 0;
        if ($count !== 0) {
            do {
                if ($i > $count) {
                    $content .= fread($this->connection, ($count - $i));
                } else {
                    $content .= fread($this->connection, 128);
                }
            } while (($i += 128) === strlen($content));
        } else {
            do {
                $content .= fread($this->connection, 128);
            } while (($i += 128) === strlen($content));
        }

        return $content;
    }
}
