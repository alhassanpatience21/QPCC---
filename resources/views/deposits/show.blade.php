@extends('layouts.app')

@section('title', 'Payment Receipt')

@section('content')
<style>

.blog {
	font-size: 14px;
	font-weight: bold;
	text-align: center;
	position: absolute;
	bottom: 15px;
	left: 50%;
	transform: translateX(-50%);
	z-index: 1;
}
svg,
img {
	display: block;
}
/* container */
.container {
	width: 320px;
	height: auto;
	border-radius: 5px;
	background-color: white;
	box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	z-index: 1;
}

/* receipt_box */
.receipt_box > * {
	padding: 16px 32px;
}

/* head */
.head {
	display: flex;
	align-items: center;
}
.head .logo {
	flex: 1 0 30%;
}
.head .number {
	flex: 1 0 70%;
	color: slategray;
	font-size: 14px;
	line-height: 1.6;
}

/* body */
.body .info {
	margin-bottom: 24px;
	position: relative;
}
.body .info:before {
	content: "";
	display: block;
	width: 5px;
	height: 100%;
	background-color: #1e88e5;
	position: absolute;
	top: 0;
	left: -32px;
}
.body .info .welcome {
	margin-bottom: 8px;
	font-weight: bold;
}
.body .info .welcome .username {
	color: #1e88e5;
}
.body .info p {
	color: rosybrown;
	font-size: 14px;
}
.cart .title {
	margin-bottom: 16px;
	font-size: 20px;
	font-weight: bold;
	text-align: center;
	text-transform: capitalize;
}
.cart .title:after {
	content: ":";
	display: inline-block;
	margin-left: 4px;
	margin-right: 4px;
}
.cart .content {
	font-size: 14px;
}

.cart_list {
	color: dimgray;
}
.cart_list .cart_item {
	display: flex;
	padding: 12px 0;
}
.cart_list .cart_item + .cart_item {
	border-top: 2px dashed #1e88e5;
}
.cart_list .cart_item .index {
	margin-right: 8px;
	width: 18px;
	overflow: hidden;
}
.cart_list .cart_item .name {
	flex-grow: 1;
}
.cart_list .cart_item .price {
	color: #1e88e5;
	font-weight: bold;
}
.cart .total {
	padding: 12px 0;
	font-weight: bold;
	text-transform: uppercase;
	border-top: 2px solid #1e88e5;
}
.cart .total_price {
	float: right;
	color: #1e88e5;
}

/* foot */
.foot {
	border-top: 2px dotted #1e88e5;
	position: relative;
}
.foot:before,
.foot:after {
	border: 4px solid transparent;
	position: absolute;
	top: -5px;
}
.foot:before {
	content: "";
	display: block;
	border-left: 7px solid #1e88e5;
	left: -1px;
}
.foot:after {
	content: "";
	display: block;
	border-right: 7px solid #1e88e5;
	right: -1px;
}
.foot img {
	width: 100%;
}

</style>
<div class="container">
		<div class="receipt_box">
			<div class="head">
				<div class="logo">
					<svg height="42" width="42" viewBox="0 0 64 64">
						<path class="path1" fill="rgb(0, 157, 223)" d="M58.125 19.288c-2.987 13.262-12.212 20.262-26.75 20.262h-4.837l-3.363 21.35h-4.050l-0.212 1.375c-0.137 0.913 0.563 1.725 1.475 1.725h10.35c1.225 0 2.263-0.888 2.462-2.1l0.1-0.525 1.95-12.362 0.125-0.675c0.188-1.212 1.237-2.1 2.462-2.1h1.538c10.025 0 17.875-4.075 20.175-15.85 0.862-4.475 0.538-8.275-1.425-11.1z"></path>
						<path class="path2" fill="rgb(0, 46, 135)" d="M51.938 4.825c-2.962-3.375-8.325-4.825-15.175-4.825h-19.887c-1.4 0-2.6 1.012-2.813 2.4l-8.287 52.525c-0.162 1.038 0.638 1.975 1.688 1.975h12.287l3.087-19.563-0.1 0.612c0.212-1.388 1.4-2.4 2.8-2.4h5.837c11.462 0 20.438-4.65 23.063-18.125 0.075-0.4 0.15-0.788 0.2-1.163 0.775-4.975 0-8.375-2.7-11.438z"></path>
					</svg>
				</div>
				<div class="number">
					<div class="date">2021/03/25</div>
					<div class="ref">of-113</div>
				</div>
			</div>
			<div class="body">
				<div class="info">
					<div class="welcome">Hi, <span class="username">Kai Cheng</span></div>
					<p>You've purchased (3) items in our store</p>
				</div>
				<div class="cart">
					<div class="title">cart</div>
					<div class="content">
						<ul class="cart_list">
							<li class="cart_item">
								<span class="index">1</span>
								<span class="name">T-Shirt Locaste</span>
								<span class="price">$48.00</span>
							</li>
							<li class="cart_item">
								<span class="index">2</span>
								<span class="name">Sikers Nike</span>
								<span class="price">$125.00</span>
							</li>
							<li class="cart_item">
								<span class="index">3</span>
								<span class="name">All Stars</span>
								<span class="price">$69.00</span>
							</li>
						</ul>
						<div class="total">
							<span>total</span>
							<span class="total_price">$242.00</span>
						</div>
					</div>
				</div>
			</div>
			<div class="foot">
				<img src="https://i.ibb.co/c8CQvBq/barcode.png" alt="barcode" class="barcode" />
			</div>
		</div>
	</div>
@endsection
