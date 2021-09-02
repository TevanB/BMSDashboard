@component('mail::message')


# Order Summary

@component('mail::table')
| Description       | Information   |
| -------------     |:-------------:|
| Order ID       | {{$order->order_id}}      |
| Order Type        | {{$type}} |
| Order Info        | {{$info}} |
| Order Price     | ${{$order->order_price}} USD |
@endcomponent

# Thanks for ordering with BMS Boosting.

Your order has been processed successfully.

Please login to your Dashboard below to manage your order.

If you requre assistance please contact Customer Support.

@component('mail::button', ['url' => 'http;//localhost/dashboard'])
Dashboard
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
