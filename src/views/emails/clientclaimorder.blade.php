@component('mail::message')
# Order Claimed

Your Order (ID: {{$order->order_id}}) from BMS Boosting has been claimed by a booster.

You can visit the Dashboard and manage your order by clicking the link below.

Thank you for choosing BMS Boosting for your order!

Regards,
BMS Boosting Customer Support Team

@component('mail::button', ['url' => 'https://app.bmsboosting.com/dashboard'])
Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
