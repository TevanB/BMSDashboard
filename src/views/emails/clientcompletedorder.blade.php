@component('mail::message')
# Order Completed

Your Order (ID: {{$order->order_id}}) from BMS Boosting has been marked as completed by management.

We would appreciate it if you could leave us a review at https://www.trustpilot.com/evaluate/bmsboosting.com.

Thanks again for choosing BMS Boosting for your order!

Regards,
BMS Boosting Customer Support Team

@component('mail::button', ['url' => 'https://app.bmsboosting.com/dashboard'])
Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
