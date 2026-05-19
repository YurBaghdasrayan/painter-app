New message from the contact form on {{ config('app.url') }}

Name: {{ $data['first_name'] }} {{ $data['last_name'] }}
Email: {{ $data['email'] }}
Phone: {{ $data['phone'] }}

Message:
{{ $data['message'] }}
