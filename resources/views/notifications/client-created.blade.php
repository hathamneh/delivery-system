@extends('notifications.layout')

@section('body')
### Dear {{ $client->trade_name }}

Thank you for registering on Kangaroo courier services, your user account details are :


**Account Number:** {{ $client->account_number }}

**Username:** {{ $client->user->username }}

**Password:** {{ $client->password }}

---

Your account is now active and you have access to our online services.
If you need any assistance, don't hesitate to contact us at : support@kangaroo-delivery.com.
@endsection