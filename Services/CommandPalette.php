<?php

namespace Modules\CommandPalette\Services;

use Illuminate\Support\Collection;
use Modules\CommandPalette\Events\CommandSearch;

class CommandPalette
{
    public function search(string $query, int $limit = 5): Collection
    {
        $event = new CommandSearch($query, $limit);

        return collect([
            ...event($event),
        ])
            ->filter() // Filter out empty values
            ->flatten()
            ->groupBy('group')
            ->map(
                fn ($items, $key) => ['group' => $key, 'items' => $items]
            )->values();
    }
}
