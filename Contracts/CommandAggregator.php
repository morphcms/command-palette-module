<?php

namespace Modules\CommandPalette\Contracts;

use Modules\CommandPalette\Events\CommandSearch;

interface CommandAggregator
{
    public function authorize(): bool;

    public function handle(CommandSearch $event);
}
