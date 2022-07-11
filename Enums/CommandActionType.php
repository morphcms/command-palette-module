<?php

namespace Modules\CommandPalette\Enums;

enum CommandActionType: string
{
    case Navigate = 'navigate';
    case Preview = 'preview';
    case Toast = 'toast';
}
