@component('mail::message')
# Product Price Changed Notification

Hello {{ $brand->name }},

We are writing to inform you that the price of the product "{{ $product->name }}" has changed by "{{ $supplier->name }}"".

Thank you,<br>
Your Company Name
@endcomponent


