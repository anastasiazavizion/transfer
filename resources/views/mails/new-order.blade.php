@component('mail::message')
    <h2>{{__('Hello')}}, <strong>{{ $order->client->first_name }} {{$order->client->last_name }}</strong></h2>
    <p>{{ __('You have a new order, total is ', ['order_number' => $order->id]) }} <strong>{{ $order->total_price }}</strong> €</p>
    <p><strong>{{__('From')}}</strong>: {{ $order->address_from }}</p>
    <p><strong>{{__('To')}}</strong>:{{ $order->address_to }}</p>
    <p><strong>{{__('Departure Date')}}</strong>:{{ $order->meeting_date }}</p>
    <p><strong>{{__('Departure Time')}}</strong>:{{ $order->meeting_time }}</p>
    <p><strong>{{__('Adults')}}</strong>:{{ $order->adults }}</p>
    <p><strong>{{__('Bags/Suitcases')}}</strong>:{{ $order->suitcases }}</p>
    {{__('Thanks')}}<br>
    {{ config('app.name') }}<br>
@endcomponent
