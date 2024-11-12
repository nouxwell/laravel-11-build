<?php

namespace App\Services\Enums\Payload;

enum PayloadExceptionMessage
{
    public const INTERNAL_ERROR = 'messages.payload.exception.internal_error';
    public const VALIDATION_ERROR = 'messages.payload.exception.validation_error';
    public const PASSWORDS_DO_NOT_MATCH_ERROR = 'messages.payload.exception.passwords_do_not_match_error';
    public const INCORRECT_PASSWORD_ERROR = 'messages.payload.exception.incorrect_password_error';
    public const XSS_ERROR = 'messages.payload.exception.xss_error';
    public const MAIL_NOT_SENT = 'messages.payload.exception.mail_not_sent';
    public const INVALID_EXPORT_TYPE = 'messages.payload.exception.invalid_export_type';
    public const MISSING_DATA = 'messages.payload.exception.missing_data';
    public const DATA_EXISTS = 'messages.payload.exception.data_exists';
    public const INVALID_MIN_LENGTH = 'messages.payload.exception.invalid_min_length';
    public const INVALID_MAX_LENGTH = 'messages.payload.exception.invalid_max_length';
    public const PERMISSION_DENIED = 'messages.payload.exception.permission_denied';
    public const DATA_PROCESSING_ERROR = 'messages.payload.exception.data_processing_error';
    public const INVALID_JWT_TOKEN = 'messages.payload.exception.invalid_jwt_token';
    public const MISSING_EMAIL_CLAIM = 'messages.payload.exception.missing_email_claim';
    public const TOKEN_VALIDATION_ERROR = 'messages.payload.exception.token_validation_error';
    public const AUTHENTICATION_ERROR = 'messages.payload.exception.authentication_error';
    public const DUPLICATE_ENTRY = 'messages.payload.exception.duplicate_entry';
    public const HTTP_ERROR = 'messages.payload.exception.http_error';
    public const DATABASE_CONNECTION_ERROR = 'messages.payload.exception.database_connection_error';
    public const ACCESS_DENIED = 'messages.payload.exception.access_denied';
    public const NOT_FOUND = 'messages.payload.exception.not_found';
    public const METHOD_NOT_ALLOWED = 'messages.payload.exception.method_not_allowed';
    public const INVALID_ARGUMENT = 'messages.payload.exception.invalid_argument';
    public const FILE_UPLOAD_ERROR = 'messages.payload.exception.file_upload_error';
    public const SERVER_ERROR = 'messages.payload.exception.server_error';
    public const UNAUTHORIZED_ERROR = 'messages.payload.exception.unauthorized_error';
    public const INVALID_CLASS = 'messages.payload.exception.invalid_class';
    public const INVALID_CREDENTIALS = 'messages.payload.exception.invalid_credentials';
    public const USER_ALREADY_VERIFIED = 'messages.payload.exception.user_already_verified';
    public const EMAIL_VERIFICATION_ERROR = 'messages.payload.exception.email_verification_error';
    public const USER_NOT_VERIFIED = 'messages.payload.exception.user_not_verified';
}
