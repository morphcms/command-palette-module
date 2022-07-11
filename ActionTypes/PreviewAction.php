<?php

namespace Modules\CommandPalette\ActionTypes;

use Modules\CommandPalette\DTO\CommandAction;
use Modules\CommandPalette\Enums\CommandActionType;

class PreviewAction extends CommandAction
{
    public function __construct(array $meta = [])
    {
        parent::__construct(CommandActionType::Preview, $meta);
    }
}
