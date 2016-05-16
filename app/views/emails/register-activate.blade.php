@extends('emails/layouts/default')

@section('content')
<p>Hello {{ $user->first_name }},</p>

<p>Welcome to GiadinhPhuot! Please click on the following link to confirm your GiadinhPhuot account:</p>

<p><a href="{{ $activationUrl }}">{{ $activationUrl }}</a></p>

<p>Best regards,</p>

<p>GiadinhPhuot Team</p>
@stop
