<!DOCTYPE html>
<html>
<head>
    <title>{{ __('messages.template.mail.export_title') }}</title>
</head>
<body>
<p>{{ __('messages.template.mail.export_content', ['value' => $data['fullName']]) }}</p>
</body>
</html>
