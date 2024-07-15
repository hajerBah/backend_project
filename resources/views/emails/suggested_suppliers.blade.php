
<html>
<body>
    <p>Dear {{$brand->name}},</p>
    <p>Supplier with name "{{ $product->supplier->name }}" has added a new product for category "{{$product->category->name}}"</p>

    <p>Thank you for using our service.</p>
</body>
</html>
