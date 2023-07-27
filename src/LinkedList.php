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
    public function add(int $value): void;

    public function remove(int $value): void;

    public function contains(int $value): bool;

    public function findFirst(int|string $value): ?int;

    public function findAll(int $value): array;

    /**
     * @throws Exception\IndexOutOfBoundsException
     */
    public function get(int $index): int|string;

    public function isEmpty(): bool;

    public function clear(): void;

    public function toArray(): array;
}
