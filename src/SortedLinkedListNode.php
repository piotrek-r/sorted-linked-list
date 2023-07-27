<?php

declare(strict_types=1);

namespace PiotrekR\SortedLinkedList;

final class SortedLinkedListNode
{
    private ?SortedLinkedListNode $next = null;

    public function __construct(private readonly int|string $value)
    {
    }

    public function getValue(): int|string
    {
        return $this->value;
    }

    public function getNext(): ?SortedLinkedListNode
    {
        return $this->next;
    }

    public function setNext(?SortedLinkedListNode $next): void
    {
        $this->next = $next;
    }
}
