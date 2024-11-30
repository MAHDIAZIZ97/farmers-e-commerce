<x-mail::message>
# Order Place Successfully

Thank you for your order. Your order number is : {{$order->id}}.

Visit Again 😊

<x-mail::button :url="$url">
View Order
</x-mail::button>

Thanks,<br>
Local Farm
</x-mail::message>
