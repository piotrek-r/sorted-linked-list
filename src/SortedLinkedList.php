<?php

declare(strict_types=1);

namespace PiotrekR\SortedLinkedList;

use Traversable;

final class SortedLinkedList implements LinkedList
{
    private ?SortedLinkedListNode $head = null;

    private int $size = 0;

    private ?string $type = null;

    public function add(int|string $value): void
    {
        $valueType = gettype($value);
        if ($this->type === null) {
            $this->type = $valueType;
        } elseif ($this->type !== $valueType) {
            throw new Exception\InvalidTypeException($this->type, $valueType);
        }

        $node = new SortedLinkedListNode($value);

        if ($this->head === null) {
            $this->head = $node;
        } else {
            $current = $this->head;
            $previous = null;
            while ($current !== null && $current->getValue() < $value) {
                $previous = $current;
                $current = $current->getNext();
            }
            if ($previous === null) {
                $node->setNext($this->head);
                $this->head = $node;
            } else {
                $node->setNext($current);
                $previous->setNext($node);
            }
        }

        $this->size++;
    }

    public function remove(int|string $value): void
    {
        if ($this->head === null || $this->type !== gettype($value)) {
            return;
        }

        $current = $this->head;
        $previous = null;
        while ($current !== null) {
            if ($current->getValue() === $value) {
                if ($previous === null) {
                    $this->head = $current->getNext();
                } else {
                    $previous->setNext($current->getNext());
                }
                $this->size--;
            } else {
                $previous = $current;
            }
            $current = $current->getNext();
        }
    }

    public function contains(int|string $value): bool
    {
        if ($this->head === null || $this->type !== gettype($value)) {
            return false;
        }

        $current = $this->head;
        do {
            if ($current->getValue() === $value) {
                return true;
            }
            $current = $current->getNext();
        } while ($current !== null);

        return false;
    }

    public function findFirst(int|string $value): ?int
    {
        if ($this->head === null || $this->type !== gettype($value)) {
            return null;
        }

        $current = $this->head;
        $index = 0;
        do {
            if ($current->getValue() === $value) {
                return $index;
            }
            if ($current->getValue() > $value) {
                break;
            }
            $current = $current->getNext();
            $index++;
        } while ($current !== null);

        return null;
    }

    public function findAll(int|string $value): array
    {
        if ($this->head === null || $this->type !== gettype($value)) {
            return [];
        }

        $output = [];

        $current = $this->head;
        $index = 0;
        do {
            if ($current->getValue() === $value) {
                $output[] = $index;
            }
            if ($current->getValue() > $value) {
                break;
            }
            $current = $current->getNext();
            $index++;
        } while ($current !== null);

        return $output;
    }

    public function get(int $index): int|string
    {
        if ($this->head === null || $index < 0 || $index >= $this->size) {
            throw new Exception\IndexOutOfBoundsException($index, $this->size);
        }

        $current = $this->head;
        for ($i = 0; $i < $index; $i++) {
            $current = $current->getNext();
        }

        return $current->getValue();
    }

    public function isEmpty(): bool
    {
        return $this->size === 0;
    }

    public function clear(): void
    {
        $this->head = null;
        $this->size = 0;
    }

    public function toArray(): array
    {
        $output = [];

        $current = $this->head;
        while ($current !== null) {
            $output[] = $current->getValue();
            $current = $current->getNext();
        }

        return $output;
    }

    public function getIterator(): Traversable
    {
        $current = $this->head;
        while ($current !== null) {
            yield $current->getValue();
            $current = $current->getNext();
        }
    }

    public function count(): int
    {
        return $this->size;
    }
}