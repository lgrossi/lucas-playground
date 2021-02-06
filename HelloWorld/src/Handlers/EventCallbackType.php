<?php declare(strict_types=1);

namespace HelloWorld\Handlers;

use JetBrains\PhpStorm\Pure;

class EventCallbackType
{
    public const MESSAGE = "message";
    public const WORKFLOW_STEP_EXECUTE = "workflow_step_execute";

    public function __construct(private string $value) {}

    #[Pure] public static function MESSAGE(): EventCallbackType
    {
        return new self(self::MESSAGE);
    }

    #[Pure] public static function WORKFLOW_STEP_EXECUTE(): EventCallbackType
    {
        return new self(self::WORKFLOW_STEP_EXECUTE);
    }

    #[Pure] public static function values(): array
    {
        $reflectionClass = new \ReflectionClass(EventCallbackType::class);
        return $reflectionClass->getConstants();
    }

    #[Pure] public function equals(EventCallbackType $type): bool
    {
        return $type->getValue() === $this->getValue();
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
