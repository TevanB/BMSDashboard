@component('mail::message')

# New Order from BMS Boosting (Order ID #{{$order->order_id}})

# Order Summary

@component('mail::table')
| Description       | Information   |
| -------------     |:-------------:|
| Order ID       | {{$order->order_id}}      |
| Order Type        | {{$type}} |
| Order Info        | {{$info}} |
| Order Price     | ${{$order->order_price}} USD |
| Order Region     | {{strtoupper($message->region)}} |
| Order Username     | {{$message->username}} |
| Order Password     | {{$message->password}} |
| Order Client Email     | {{$message->email}} |
| Order Summoner Name     | {{$message->summoner_name}} |
| Order Discord     | {{$message->discord}} |
| Order Message     | {{$message->message}} |
@endcomponent



Thanks,<br>
{{ config('app.name') }}
@endcomponent
