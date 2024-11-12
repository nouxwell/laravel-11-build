<?php

namespace App\Services\Enums\Notification;

enum NotificationType: string
{
    case INFO = 'info';
    case SUCCESS = 'success';
    case WARNING = 'warning';
    case ERROR = 'error';
    case DEFAULT = 'default';
}
