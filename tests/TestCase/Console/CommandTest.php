<?php
/**
 * CakePHP :  Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP Project
 * @since         3.6.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Test\TestCase\Console;

use Cake\Console\Command;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\Locator\TableLocator;
use Cake\ORM\Table;
use Cake\TestSuite\TestCase;

/**
 * Test case for Console\Command
 */
class CommandTest extends TestCase
{
    /**
     * test orm locator is setup
     *
     * @return void
     */
    public function testConstructorSetsLocator()
    {
        $command = new Command();
        $result = $command->getTableLocator();
        $this->assertInstanceOf(TableLocator::class, $result);
    }

    /**
     * test loadModel is configured properly
     *
     * @return void
     */
    public function testConstructorLoadModel()
    {
        $command = new Command();
        $command->loadModel('Comments');
        $this->assertInstanceOf(Table::class, $command->Comments);
    }

    /**
     * Test name
     *
     * @return void
     */
    public function testSetName()
    {
        $command = new Command();
        $this->assertSame($command, $command->setName('routes show'));
        $this->assertSame('routes show', $command->getName());
    }

    /**
     * Test option parser fetching
     *
     * @return void
     */
    public function testGetOptionParser()
    {
        $command = new Command();
        $command->setName('cake routes show');
        $parser = $command->getOptionParser();
        $this->assertInstanceOf(ConsoleOptionParser::class, $parser);
        $this->assertSame('cake routes show', $parser->getCommand());
    }

    /**
     * Test option parser fetching
     *
     * @expectedException RuntimeException
     * @return void
     */
    public function testGetOptionParserInvalid()
    {
        $command = $this->getMockBuilder(Command::class)
            ->setMethods(['buildOptionParser'])
            ->getMock();
        $command->expects($this->once())
            ->method('buildOptionParser')
            ->will($this->returnValue(null));
        $command->getOptionParser();
    }
}