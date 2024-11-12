<?php

namespace App\Services\Enums\Notification;

enum NotificationCategory: string
{
    case NEWS = 'news';
    case ALERT = 'alert';
    case MESSAGE = 'message';
    case REMINDER = 'reminder';

    case export = 'bytesize:export';
}
