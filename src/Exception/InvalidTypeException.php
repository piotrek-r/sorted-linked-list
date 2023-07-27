<?php

declare(strict_types=1);

namespace PiotrekR\SortedLinkedList\Exception;

use InvalidArgumentException;
use Throwable;

class InvalidTypeException extends InvalidArgumentException implements LinkedListException
{
    public function __construct(string $currentType, string $givenType, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('Invalid type. Expected %s, got %s', $currentType, $givenType), $code, $previous);
    }
}
