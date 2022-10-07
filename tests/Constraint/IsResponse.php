<?php

namespace App\Tests\Constraint;

use JsonException;
use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\HttpFoundation\Response;

class IsResponse extends Constraint
{
    public function __construct(
        private readonly int $statusCode = Response::HTTP_OK,
        private readonly array $response = [],
    ) {
    }

    public function toString(): string
    {
        return 'is response';
    }

    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param mixed $other value or object to evaluate
     *
     * @throws JsonException
     */
    protected function matches($other): bool
    {
        if (
            !$other instanceof Response
            || $other->getStatusCode() !== $this->statusCode
            || 'application/json' !== $other->headers->get('Content-Type')
        ) {
            return false;
        }

        $content = $other->getContent();
        if (empty($content)) {
            return false;
        }

        $actualResponse = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        return $this->equalArrays($this->response, $actualResponse);
    }

    private function equalArrays(array $expected, array $actual): bool
    {
        foreach ($expected as $key => $value) {
            if (!array_key_exists($key, $actual)) {
                return false;
            }

            if (is_array($value) && is_array($actual[$key])) {
                if (!$this->equalArrays($value, $actual[$key])) {
                    return false;
                }
            } elseif ($value !== $actual[$key]) {
                return false;
            }
        }

        return true;
    }
}
