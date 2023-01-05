<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order PDF</title>
</head>
<body>
    <h1>ORDER DETAILS</h1>

    Order ID: <h3>{{$order->id}}</h3>
    Customer Name: <h3>{{$order->name}}</h3>
    Customer Phone: <h3>{{$order->phone}}</h3>
    Customer Address: <h3>{{$order->address}}</h3>
    Product title: <h3>{{$order->product_name}}</h3>
    Product quantity: <h3>{{$order->quantity}}</h3>
    Total Price: <h3>{{$order->price}}</h3>
    Order Status: <h3>{{$order->status}}</h3>
  
    
</body>
</html>