<?php

namespace Modules\CommandPalette\DTO;

use Modules\CommandPalette\Enums\CommandIcon;

class SearchResult
{
    public ?string $icon = null;

    public ?string $description = null;

    public ?string $group = null;

    public function __construct(
        public string $title,
        public ?string $type = null,
        public ?CommandAction $action = null
    ) {
    }

    public static function make(...$arguments): static
    {
        return new static(...$arguments);
    }

    public function group($group): static
    {
        $this->group = $group;

        return $this;
    }

    public function action(CommandAction $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function description(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function icon(string|CommandIcon $icon): static
    {
        $this->icon = $icon instanceof CommandIcon ? $icon->value : $icon;

        return $this;
    }
}
