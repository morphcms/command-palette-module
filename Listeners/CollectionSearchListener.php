<?php

namespace Modules\CommandPalette\Listeners;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\CommandPalette\Contracts\CommandAggregator;
use Modules\CommandPalette\DTO\SearchResult;
use Modules\CommandPalette\Events\CommandSearch;

abstract class CollectionSearchListener implements CommandAggregator
{
    public function authorize(): bool
    {
        return true;
    }

    public function handle(CommandSearch $event): Collection|null
    {
        if (! $this->authorize()) {
            return null;
        }

        return $this->search($event, $this->items());
    }

    protected function search(CommandSearch $event, array $items): Collection|null
    {
        return collect($items)->filter(
            fn (SearchResult $result) => Str::of($result->title)->lower()->contains(strtolower($event->query))
        );
    }

    abstract public function items(): array;
}
