<?php

namespace Modules\CommandPalette\ActionTypes;

use Modules\CommandPalette\DTO\CommandAction;
use Modules\CommandPalette\Enums\CommandActionType;

class ToastAction extends CommandAction
{
    public function __construct(array $meta = [])
    {
        parent::__construct(CommandActionType::Toast, $meta);
    }

    public function message(string|callable $message): static
    {
        $this->meta['message'] = value($message);

        return $this;
    }
}
