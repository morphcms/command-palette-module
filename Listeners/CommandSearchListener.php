<?php

namespace Modules\CommandPalette\Listeners;

use Illuminate\Support\Collection;
use Modules\CommandPalette\Contracts\CommandAggregator;
use Modules\CommandPalette\Events\CommandSearch;

abstract class CommandSearchListener implements CommandAggregator
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

        return $this->search($event);
    }

    abstract protected function search(CommandSearch $event): Collection|null;
}
