<?php

namespace App\Enums;

#[\Attribute] enum ExportType: string
{

    use EnumValues;

    case CSV = 'csv';
    case XML = 'xml';
    case TXT = 'txt';

}
