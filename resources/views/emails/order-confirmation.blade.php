<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Order Confirmation</title>
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
			background: linear-gradient(to right, #1e40af, #7c3aed);
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
			border-top: 2px solid #1e40af;
		}

		.customer-info {
			background: white;
			padding: 20px;
			border-radius: 8px;
			margin: 20px 0;
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
		<h1>Thank You for Your Order!</h1>
		<p>Order #{{ $order->id }}</p>
	</div>

	<div class="content">
		<p>Dear
			{{ $customerData['name'] }}
			,
		</p>

		<p>Thank you for your order! We've received your payment and are preparing your items for shipment.</p>

		<div class="order-details">
			<h2 style="margin-top: 0; color: #1e40af;">Order Details</h2>

			@foreach($order->orderItems as $item)
				<div class="item">
					<div>
						<strong>{{ $item->product->name }}</strong><br>
						<span style="color: #6b7280;">Quantity:
							{{ $item->quantity }}
						</span>
					</div>
					<div style="text-align: right;">
						<strong>€{{ number_format($item->price * $item->quantity, 2) }}</strong>
					</div>
				</div>
			@endforeach

			<div class="total">
				<div style="display: flex; justify-content: space-between;">
					<span>Total</span>
					<span>€{{ number_format($order->total_price, 2) }}</span>
				</div>
			</div>
		</div>

		<div class="customer-info">
			<h3 style="margin-top: 0; color: #1e40af;">Delivery Address</h3>
			<p style="margin: 5px 0;">{{ $customerData['name'] }}</p>
			<p style="margin: 5px 0;">{{ $customerData['address'] }}</p>
			<p style="margin: 5px 0;">{{ $customerData['zipcode'] }}
				{{ $customerData['city'] }}
			</p>
		</div>

		<div style="background: #dbeafe; padding: 15px; border-radius: 8px; border-left: 4px solid #1e40af;">
			<strong>Payment Status:</strong>
			{{ ucfirst($order->payment_status) }}
			<br>
			@if($order->payment_method)
				<strong>Payment Method:</strong>
				{{ ucfirst($order->payment_method) }}
			@endif
		</div>

		<p style="margin-top: 30px;">If you have any questions about your order, please don't hesitate to contact us.
		</p>
	</div>

	<div class="footer">
		<p>This is an automated email. Please do not reply to this message.</p>
		<p>&copy;
			{{ date('Y') }}
			AVSWebshop. All rights reserved.
		</p>
	</div>
</body>

</html>