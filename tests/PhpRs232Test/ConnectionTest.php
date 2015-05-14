<?php

namespace Jbenoit\PhpRs232\Tests;

use Jbenoit\PhpRs232\Connection;
use PHPUnit_Framework_TestCase as PHPUnit;

class ConnectionTest extends PHPUnit
{
    public function testOpenConnection()
    {
        $connection = new Connection('/dev/cu.usbmodem1411');
        
        $connection->open();

        $this->assertNotEquals($connection->getConnection(), null);
        
        $connection->close();
    }
    
    public function testCloseConnection()
    {
        $connection = new Connection('/dev/cu.usbmodem1411');
        
        $connection->open();
        
        $connection->close();

        $this->assertEquals($connection->getConnection(), null);
    }
    
    public function testOpenWriteReadClose()
    {
        $connection = new Connection('/dev/cu.usbmodem1411');
        
        $connection->open();
        
        $connection->write('foobar');
        
        $output = $connection->read();

        $this->assertEquals($output, 'foobar');
        
        $connection->close();
    }
}
