<!DOCTYPE html>
<html>
<head>
    <title>{{ __('messages.template.mail.verification_title') }}</title>
</head>
<body>
<p>{{ __('messages.template.mail.verification_content', ['value' => $data['fullName']]) }}</p>
<p><a href="{{ $data['verificationUrl'] }}">{{ __('messages.template.mail.verification_link_text') }}</a></p>
</body>
</html>
