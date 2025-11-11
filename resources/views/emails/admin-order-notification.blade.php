<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>New Order Notification</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			line-height: 1.6;
			color: #333;
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
		}

		.header {
			background: linear-gradient(to right, #dc2626, #ea580c);
			color: white;
			padding: 30px;
			text-align: center;
			border-radius: 8px 8px 0 0;
		}

		.content {
			background: #f9fafb;
			padding: 30px;
			border: 1px solid #e5e7eb;
		}

		.order-details {
			background: white;
			padding: 20px;
			border-radius: 8px;
			margin: 20px 0;
		}

		.item {
			display: flex;
			justify-content: space-between;
			padding: 10px 0;
			border-bottom: 1px solid #e5e7eb;
		}

		.total {
			font-size: 18px;
			font-weight: bold;
			padding: 15px 0;
			margin-top: 10px;
			border-top: 2px solid #dc2626;
		}

		.customer-info {
			background: white;
			padding: 20px;
			border-radius: 8px;
			margin: 20px 0;
		}

		.alert {
			background: #fef2f2;
			border-left: 4px solid #dc2626;
			padding: 15px;
			margin: 20px 0;
			border-radius: 4px;
		}

		.footer {
			text-align: center;
			margin-top: 30px;
			padding-top: 20px;
			border-top: 1px solid #e5e7eb;
			color: #6b7280;
			font-size: 14px;
		}
	</style>
</head>

<body>
	<div class="header">
		<h1>🔔 New Order Received!</h1>
		<p>Order #{{ $order->id }}</p>
	</div>

	<div class="content">
		<div class="alert">
			<strong>⚠️ Action Required:</strong>
			A new order has been placed and requires processing.
		</div>

		<div class="order-details">
			<h2 style="margin-top: 0; color: #dc2626;">Order Details</h2>

			@foreach($order->orderItems as $item)
				<div class="item">
					<div>
						<strong>{{ $item->product->name }}</strong><br>
						<span style="color: #6b7280;">
							Quantity:
							{{ $item->quantity }}
							× €
							{{ number_format($item->price, 2) }}
						</span>
					</div>
					<div style="text-align: right;">
						<strong>€{{ number_format($item->price * $item->quantity, 2) }}</strong>
					</div>
				</div>
			@endforeach

			<div class="total">
				<div style="display: flex; justify-content: space-between;">
					<span>Total Amount</span>
					<span>€{{ number_format($order->total_price, 2) }}</span>
				</div>
			</div>
		</div>

		<div class="customer-info">
			<h3 style="margin-top: 0; color: #dc2626;">Customer Information</h3>
			<p style="margin: 5px 0;">
				<strong>Name:</strong>
				{{ $customerData['name'] }}
			</p>
			<p style="margin: 5px 0;">
				<strong>Email:</strong>
				{{ $customerData['email'] }}
			</p>
			<p style="margin: 5px 0;">
				<strong>Address:</strong>
				{{ $customerData['address'] }}
			</p>
			<p style="margin: 5px 0;">
				<strong>City:</strong>
				{{ $customerData['city'] }}
			</p>
			<p style="margin: 5px 0;">
				<strong>Zipcode:</strong>
				{{ $customerData['zipcode'] }}
			</p>
		</div>

		<div style="background: #fef3c7; padding: 15px; border-radius: 8px; border-left: 4px solid #f59e0b;">
			<strong>Order Status:</strong>
			{{ ucfirst($order->status) }}
			<br>
			<strong>Payment Status:</strong>
			{{ ucfirst($order->payment_status) }}
			<br>
			@if($order->payment_method)
				<strong>Payment Method:</strong>
				{{ ucfirst($order->payment_method) }}
				<br>
			@endif
			@if($order->payment_id)
				<strong>Payment ID:</strong>
				{{ $order->payment_id }}
			@endif
		</div>

		<p style="margin-top: 30px; text-align: center;">
			<strong>Order placed on:</strong>
			{{ $order->created_at->format('d/m/Y H:i') }}
		</p>
	</div>

	<div class="footer">
		<p>This is an automated notification from your webshop.</p>
		<p>&copy;
			{{ date('Y') }}
			AVSWebshop Admin Panel.
		</p>
	</div>
</body>

</html>