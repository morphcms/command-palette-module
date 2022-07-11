<?php

namespace Modules\CommandPalette\Enums;

enum CommandIcon: string
{
    case Document = 'DocumentIcon';
    case DocumentText = 'DocumentTextIcon';
    case DocumentReport = 'DocumentReportIcon';
    case DocumentRemove = 'DocumentRemoveIcon';
    case DocumentSearch = 'DocumentSearchIcon';
    case DocumentDuplicate = 'DocumentDuplicateIcon';
    case DocumentAdd = 'DocumentAddIcon';
    case DocumentDownload = 'DocumentDownloadIcon';

    case ExternalLink = 'ExternalLinkIcon';
    case Link = 'LinkIcon';

    case Adjustments = 'AdjustmentsIcon';
    case AtSymbol = 'AtSymbolIcon';
    case ClipboardList = 'ClipboardListIcon';

    case Folder = 'FolderIcon';
    case Hashtag = 'HashtagIcon';
    case GlobeAlt = 'GlobeAltIcon';
    case Globe = 'GlobeIcon';

    case LightningBolt = 'LightningBoltIcon';

    case Reply = 'ReplyIcon';
    case Tag = 'TagIcon';
    case Sparkles = 'SparklesIcon';
    case ShoppingCart = 'ShoppingCartIcon';
}
