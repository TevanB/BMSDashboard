@component('mail::message')
# Welcome to BMS Boosting!

We created the dashboard on our website to allow users to manage their orders with ease, without removing the necessity for quality management at every step of the way.

When your order, you will have access to a page to manage your order where you can communicate with your booster, all the while having BMS Boosting management only a few clicks away!


@component('mail::button', ['url' => 'https://app.bmsboosting.com/dashboard'])
Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
