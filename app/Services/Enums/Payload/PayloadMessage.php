<?php

namespace App\Services\Enums\Payload;

enum PayloadMessage
{
    public const LOGIN_SUCCESS = 'messages.payload.message.login_success_message';
    public const LOGOUT_SUCCESS = 'messages.payload.message.logout_success_message';
    public const PROFILE_FETCHED_SUCCESS = 'messages.payload.message.profile_fetched_message';
    public const REFRESH_TOKEN_SUCCESS = 'messages.payload.message.refresh_token_success_message';

    public const LOGIN_FAILED = 'messages.payload.message.login_failed_message';
    public const CREATED = 'messages.payload.message.created';
    public const SHOWED = 'messages.payload.message.showed';
    public const UPDATED = 'messages.payload.message.updated';
    public const DELETED = 'messages.payload.message.deleted';
    public const CHANGED = 'messages.payload.message.changed';
    public const CHANGE_STATUS = 'messages.payload.message.change_status';
    public const ACTIVE = 'messages.payload.message.active_message';
    public const INACTIVE = 'messages.payload.message.inactive_message';
    public const LISTED = 'messages.payload.message.listed';
    public const EMAIL_SEND_SUCCESS = 'messages.payload.message.email_send_success_message';
    public const REGISTRATION_SUCCESS = 'messages.payload.message.register_success_message';
}
