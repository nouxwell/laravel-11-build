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
    public const DATA_LISTED_FOR_DATATABLE = 'messages.payload.message.data_listed_for_datatable';
    public const DATA_LISTED_FOR_SELECT = 'messages.payload.message.data_listed_for_select';
    public const EXCEL_EXPORTED_MESSAGE = 'messages.payload.message.excel_exported_message';
    public const CSV_EXPORTED_MESSAGE = 'messages.payload.message.csv_exported_message';
    public const PDF_EXPORTED_MESSAGE = 'messages.payload.message.pdf_exported_message';
    public const EXCEL_DOWNLOAD_LINK_MESSAGE = 'messages.payload.message.excel_download_link';
    public const CSV_DOWNLOAD_LINK_MESSAGE = 'messages.payload.message.csv_download_link';
    public const PDF_DOWNLOAD_LINK_MESSAGE = 'messages.payload.message.pdf_download_link';
    public const NOTIFICATION_EXPORT_TITLE = 'messages.payload.message.notification.export.title';
    public const NOTIFICATION_EXPORT_CONTENT = 'messages.payload.message.notification.export.content';
    public const DATA_EXPORTED = 'messages.payload.message.data_exported';
    public const EMAIL_VERIFIED = 'messages.payload.message.email_verified';
    public const EMAIL_VERIFICATION = 'messages.payload.message.email_verification';
    public const ENABLE_TWO_FACTOR = 'messages.payload.message.enable_two_factor';
    public const DISABLE_TWO_FACTOR = 'messages.payload.message.disable_two_factor';
    public const RESET_TWO_FACTOR = 'messages.payload.message.reset_two_factor';
    public const GENERATE_QR_CODE = 'messages.payload.message.generate_qr_code';
    public const LOGIN_CHECK = 'messages.payload.message.login_check';
}
