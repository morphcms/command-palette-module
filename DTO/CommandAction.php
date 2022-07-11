<?php

namespace Modules\CommandPalette\DTO;

use JetBrains\PhpStorm\ArrayShape;
use Modules\CommandPalette\Enums\CommandActionType;

class CommandAction implements \JsonSerializable
{
    public function __construct(public string|CommandActionType $type, public array $meta = [])
    {
    }

    public static function make(...$arguments): static
    {
        return new static(...$arguments);
    }

    public function meta(): array
    {
        return $this->meta;
    }

    public function with(array $data): static
    {
        $this->meta = array_merge($this->meta, $data);

        return $this;
    }

    #[ArrayShape(['type' => 'string', 'meta' => 'array'])]
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type instanceof CommandActionType ? $this->type->value : $this->type,
            'meta' => $this->meta,
        ];
    }
}
