<?php

declare(strict_types=1);

namespace PiotrekR\SortedLinkedList\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PiotrekR\SortedLinkedList\SortedLinkedList;
use PiotrekR\SortedLinkedList\Exception\IndexOutOfBoundsException;
use PiotrekR\SortedLinkedList\Exception\InvalidTypeException;
use PHPUnit\Framework\TestCase;
use PiotrekR\SortedLinkedList\SortedLinkedListNode;

#[CoversClass(SortedLinkedList::class)]
#[CoversClass(IndexOutOfBoundsException::class)]
#[CoversClass(InvalidTypeException::class)]
#[CoversClass(SortedLinkedListNode::class)]
class SortedLinkedListTest extends TestCase
{
    public static function invalidTypeProvider(): array
    {
        return [
            [1, 'a'],
            ['a', 1],
        ];
    }

    public function testAddingIntegers()
    {
        $list = $this->createIntegerList();
        static::assertEquals([1, 2, 2, 3, 3, 3, 4, 6], $list->toArray());

        $list = new SortedLinkedList();
        $list->add(2);
        $list->add(1);
        static::assertEquals([1, 2], $list->toArray());
    }

    public function testAddingStrings()
    {
        $list = $this->createStringList();
        static::assertEquals(['a', 'b', 'b', 'c', 'c', 'c', 'd', 'f'], $list->toArray());

        $list = new SortedLinkedList();
        $list->add('b');
        $list->add('a');
        static::assertEquals(['a', 'b'], $list->toArray());
    }

    #[DataProvider('invalidTypeProvider')]
    public function testAddingWrongType($value1, $value2)
    {
        $this->expectException(InvalidTypeException::class);
        $list = new SortedLinkedList();
        $list->add($value1);
        $list->add($value2);
    }

    public function testRemovingIntegers()
    {
        $list = $this->createIntegerList();

        $list->remove(3);

        static::assertEquals([1, 2, 2, 4, 6], $list->toArray());

        $list->remove(2, true);

        static::assertEquals([1, 2, 4, 6], $list->toArray());

        $list->remove(1);

        static::assertEquals([2, 4, 6], $list->toArray());

        $list = new SortedLinkedList();
        $list->remove(9);
        static::assertEquals([], $list->toArray());
    }

    public function testRemovingStrings()
    {
        $list = $this->createStringList();

        $list->remove('c');

        static::assertEquals(['a', 'b', 'b', 'd', 'f'], $list->toArray());

        $list->remove('b', true);

        static::assertEquals(['a', 'b', 'd', 'f'], $list->toArray());

        $list->remove('a');

        static::assertEquals(['b', 'd', 'f'], $list->toArray());

        $list = new SortedLinkedList();
        $list->remove('x');
        static::assertEquals([], $list->toArray());
    }

    public function testRemovingNonExistingValue()
    {
        $listInt = $this->createIntegerList();

        $listInt->remove(5);

        static::assertEquals([1, 2, 2, 3, 3, 3, 4, 6], $listInt->toArray());

        $listStr = $this->createStringList();

        $listStr->remove('e');

        static::assertEquals(['a', 'b', 'b', 'c', 'c', 'c', 'd', 'f'], $listStr->toArray());
    }

    public function testFindingFirstValue()
    {
        $listInt = $this->createIntegerList();

        static::assertEquals(3, $listInt->findFirst(3));
        static::assertEquals(0, $listInt->findFirst(1));
        static::assertEquals(7, $listInt->findFirst(6));
        static::assertNull($listInt->findFirst(5));

        $listStr = $this->createStringList();

        static::assertEquals(3, $listStr->findFirst('c'));
        static::assertEquals(0, $listStr->findFirst('a'));
        static::assertEquals(7, $listStr->findFirst('f'));
        static::assertNull($listStr->findFirst('e'));

        $listEmpty = new SortedLinkedList();
        static::assertNull($listEmpty->findFirst(1));
    }

    public function testFindingAllValues()
    {
        $listInt = $this->createIntegerList();

        static::assertEquals([3, 4, 5], $listInt->findAll(3));
        static::assertEquals([0], $listInt->findAll(1));
        static::assertEquals([6], $listInt->findAll(4));
        static::assertEquals([], $listInt->findAll(5));

        $listStr = $this->createStringList();

        static::assertEquals([3, 4, 5], $listStr->findAll('c'));
        static::assertEquals([0], $listStr->findAll('a'));
        static::assertEquals([6], $listStr->findAll('d'));
        static::assertEquals([], $listStr->findAll('e'));

        $listEmpty = new SortedLinkedList();
        static::assertEquals([], $listEmpty->findAll(1));
    }

    public function testGettingIntegerValueByIndex()
    {
        $listInt = $this->createIntegerList();

        static::assertEquals(1, $listInt->get(0));
        static::assertEquals(2, $listInt->get(1));
        static::assertEquals(4, $listInt->get(6));

        $this->expectException(IndexOutOfBoundsException::class);
        $listInt->get(8);
    }

    public function testGettingStringValueByIndex()
    {
        $listStr = $this->createStringList();

        static::assertEquals('a', $listStr->get(0));
        static::assertEquals('b', $listStr->get(1));
        static::assertEquals('d', $listStr->get(6));

        $this->expectException(IndexOutOfBoundsException::class);
        $listStr->get(8);
    }

    public function testIsEmpty()
    {
        $list = new SortedLinkedList();
        static::assertTrue($list->isEmpty());

        $list->add(1);
        static::assertFalse($list->isEmpty());
    }

    public function testClearingList()
    {
        $list = $this->createIntegerList();

        $list->clear();

        static::assertTrue($list->isEmpty());
    }

    public function testConvertingToArray()
    {
        $list = $this->createIntegerList();
        static::assertEquals([1, 2, 2, 3, 3, 3, 4, 6], $list->toArray());

        $list = $this->createStringList();
        static::assertEquals(['a', 'b', 'b', 'c', 'c', 'c', 'd', 'f'], $list->toArray());

        $list = new SortedLinkedList();
        static::assertEquals([], $list->toArray());
    }

    public function testIterator()
    {
        $listInt = $this->createIntegerList();
        $listIntArr = $listInt->toArray();
        foreach ($listInt as $key => $value) {
            static::assertEquals($listIntArr[$key], $value);
        }

        $listStr = $this->createStringList();
        $listStrArr = $listStr->toArray();
        foreach ($listStr as $key => $value) {
            static::assertEquals($listStrArr[$key], $value);
        }
    }

    public function testCounting()
    {
        $listInt = $this->createIntegerList();
        static::assertEquals(8, $listInt->count());

        $listStr = $this->createStringList();
        static::assertEquals(8, $listStr->count());

        $list = new SortedLinkedList();
        static::assertEquals(0, $list->count());
    }

    private function createIntegerList(): SortedLinkedList
    {
        $list = new SortedLinkedList();

        $list->add(1);
        $list->add(2);
        $list->add(3);
        $list->add(4);
        $list->add(6);
        $list->add(3);
        $list->add(2);
        $list->add(3);

        return $list;
    }

    private function createStringList(): SortedLinkedList
    {
        $list = new SortedLinkedList();

        $list->add('a');
        $list->add('b');
        $list->add('c');
        $list->add('d');
        $list->add('f');
        $list->add('c');
        $list->add('b');
        $list->add('c');

        return $list;
    }
}
