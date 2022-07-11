<?php

namespace Modules\CommandPalette\ActionTypes;

use Modules\CommandPalette\DTO\CommandAction;
use Modules\CommandPalette\Enums\CommandActionType;

class NavigateAction extends CommandAction
{
    public function __construct(array $meta = [])
    {
        parent::__construct(CommandActionType::Navigate, $meta);
    }
}
