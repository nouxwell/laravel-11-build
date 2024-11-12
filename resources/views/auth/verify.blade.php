<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.template.email_verification_title') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
<div class="bg-white p-6 rounded-lg shadow-lg text-center">
    <h2 class="text-2xl font-semibold mb-4">{{ $result['message'] }}</h2>
    @if($result['status'])
        <p class="text-gray-700">{{ __('messages.template.email_success_verification_content') }}</p>
    @else
        <p class="text-gray-700">{{ __('messages.template.email_error_verification_content') }}</p>
    @endif
</div>
</body>
</html>
