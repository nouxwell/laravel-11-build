<?php

namespace App\Services\Enums;

enum ExportType: string
{
    case EXCEL = 'excel';
    case CSV = 'csv';
    case PDF = 'pdf';
}
