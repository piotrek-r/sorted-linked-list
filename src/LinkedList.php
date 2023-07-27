<?php

declare(strict_types=1);

namespace PiotrekR\SortedLinkedList;

use Countable;
use IteratorAggregate;

interface LinkedList extends Countable, IteratorAggregate
{
    /**
     * @throws Exception\InvalidTypeException
     */
    public function add(int|string $value): void;

    public function remove(int|string $value): void;

    public function findFirst(int|string $value): ?int;

    public function findAll(int|string $value): array;

    /**
     * @throws Exception\IndexOutOfBoundsException
     */
    public function get(int $index): int|string;

    public function isEmpty(): bool;

    public function clear(): void;

    public function toArray(): array;
}
