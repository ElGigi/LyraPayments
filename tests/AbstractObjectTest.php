<?php
/**
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2018 Ronan GIRON
 * @author    Ronan GIRON <https://github.com/ElGigi>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code, to the root.
 */

namespace ElGigi\SystemPay\Tests;

use ElGigi\SystemPay\AbstractObject;
use ElGigi\SystemPay\Exception\SystemPayException;
use PHPUnit\Framework\TestCase;

class AbstractObjectTest extends TestCase
{
    public function testConstructorBadParameters()
    {
        $this->expectException(SystemPayException::class);

        new class(
            ['test'  => 'string',
             'test2' => 'int',
             'test3' => 'string'],
            ['test'  => 'value1',
             'test2' => 'value2',
             'test3' => 'value3'])
            extends AbstractObject
        {
        };
    }

    private function getValidAbstractObject()
    {
        return
            new class(
                ['test'  => 'string',
                 'test2' => 'int',
                 'test3' => 'string'],
                ['test'  => 'value1',
                 'test2' => 1234,
                 'test3' => 'value3'])
                extends AbstractObject
            {
            };
    }

    public function testConstructor()
    {
        $object = $this->getValidAbstractObject();

        $this->assertEquals('value1', $object->get('test'));
        $this->assertEquals(1234, $object->get('test2'));
        $this->assertEquals('value3', $object->get('test3'));
    }

    public function testSet()
    {
        $object = $this->getValidAbstractObject();

        $object->__set('test', 'valuetest');

        $this->assertEquals('valuetest', $object->get('test'));
    }

    public function testSetNotValid()
    {
        $this->expectException(SystemPayException::class);

        $object = $this->getValidAbstractObject();

        $object->__set('test2', 'valuetest');
    }

    public function testSetData()
    {
        $object = $this->getValidAbstractObject();

        $object->setData(['test'  => 'valuetest',
                          'test2' => 4321]);

        $this->assertEquals('valuetest', $object->get('test'));
        $this->assertEquals(4321, $object->get('test2'));
    }

    public function testSetDataNotValid()
    {
        $this->expectException(SystemPayException::class);

        $object = $this->getValidAbstractObject();

        $object->setData(['test2' => 'test']);
    }

    public function testControlFormat()
    {
        // Bool type
        $this->assertEquals(true, AbstractObject::controlFormat('bool', true));
        $this->assertEquals(true, AbstractObject::controlFormat('bool', false));
        $this->assertEquals(false, AbstractObject::controlFormat('bool', 1));
        $this->assertEquals(false, AbstractObject::controlFormat('bool', 'test'));
        // Datetime type
        $this->assertEquals(true, AbstractObject::controlFormat('datetime', gmdate('Y-m-d\TH:i:s\Z')));
        $this->assertEquals(false, AbstractObject::controlFormat('datetime', gmdate('Y-m-d H:i:s')));
        // Integer
        $this->assertEquals(true, AbstractObject::controlFormat('int', 1));
        $this->assertEquals(false, AbstractObject::controlFormat('int', 'test'));
        // Long
        $this->assertEquals(true, AbstractObject::controlFormat('long', 1));
        $this->assertEquals(false, AbstractObject::controlFormat('long', 'test'));
        // String
        $this->assertEquals(true, AbstractObject::controlFormat('string', 'test'));
        $this->assertEquals(false, AbstractObject::controlFormat('string', 1));
        $this->assertEquals(false, AbstractObject::controlFormat('string', false));
        // SystemPay
        $this->assertEquals(true, AbstractObject::controlFormat('a2', 'te'));
        $this->assertEquals(false, AbstractObject::controlFormat('a2', 'test'));
        $this->assertEquals(false, AbstractObject::controlFormat('a2', 't1'));
        $this->assertEquals(true, AbstractObject::controlFormat('an2', 't1'));
        $this->assertEquals(false, AbstractObject::controlFormat('an2', 't11'));
        $this->assertEquals(true, AbstractObject::controlFormat('n1', '1'));
        $this->assertEquals(false, AbstractObject::controlFormat('n1', '11'));
        $this->assertEquals(true, AbstractObject::controlFormat('s3', 't2é'));
        $this->assertEquals(true, AbstractObject::controlFormat('an3', 't2e'));
        $this->assertEquals(false, AbstractObject::controlFormat('an3', 't2é'));
        $this->assertEquals(false, AbstractObject::controlFormat('s3', 't2'));
        $this->assertEquals(true, AbstractObject::controlFormat('s..10', 't2'));
        $this->assertEquals(true, AbstractObject::controlFormat('s..10', 'testestest'));
        $this->assertEquals(false, AbstractObject::controlFormat('s..10', 'testestestest'));
        // Unknown type
        $this->assertEquals(false, AbstractObject::controlFormat('unknown', 'test'));
        // Array type
        $this->assertEquals(true, AbstractObject::controlFormat('[test1,test2,test3]', 'test1'));
        $this->assertEquals(false, AbstractObject::controlFormat('[test1,test2,test3]', 'test4'));
    }
}
