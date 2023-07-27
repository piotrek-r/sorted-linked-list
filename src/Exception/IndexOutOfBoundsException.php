<?php

declare(strict_types=1);

namespace PiotrekR\SortedLinkedList\Exception;

use OutOfBoundsException;
use Throwable;

class IndexOutOfBoundsException extends OutOfBoundsException implements LinkedListException
{
    public function __construct(int $index, int $size, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('Index %d is out of bounds. Size is %d.', $index, $size), $code, $previous);
    }
}
