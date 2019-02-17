<?php

namespace App\Http\Controllers;

use App\Dtos\Response\Order\OrderListDto;
use App\Dtos\response\Order\Partials\OrderSummaryDto;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Tymon\JWTAuth\Facades\JWTAuth;


class OrderController extends BaseController
{

    public function __construct()
    {
        // $this->middleware('is_admin');
        // $this->middleware('jwt.verify', ['except' => ['store']]);
        $this->middleware('jwt.check');
    }

    public function index(Request $request)
    {

        $page = (int)$request->get('page', 1);
        $page_size = (int)$request->get('page_size', 10);

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $user = JWTAuth::parseToken()->authenticate();
        $products = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')
            ->paginate($page_size);

        return $this->sendSuccess(OrderListDto::build($products, $request->path()));

    }

    public function show($id)
    {
        $order = Order::where('id', $id)->first();
        if (is_null($order))
            return $this->sendError('Product was not found');

        return $this->sendSuccessResponse(OrderSummaryDto::build($order));
    }

    public function store(Request $request)
    {
        $orderData = $request->all();

        // $user = JWTAuth::parseToken()->authenticate();
        $user = auth()->user();

        if ($request->has('address_id')) {
            $address = Address::find($request->get('address_id'));

            if (!$user)
                return $this->sendError('You can not use an address if you are not signed in');


            if (!$address->user || $address->user->id != $user->id)
                return $this->sendError('You can not use this address');

            $order = new Order(['address_id' => $address->id,  'order_status' => 0]);
        } else {
            $address = new Address($request->only('address', 'first_name', 'last_name', 'zip_code', 'city', 'country', 'phone_number'));
            if ($user)
                $address->user_id = $user->id;

            $address->save();
            $order = new Order(['order_status' => 0]);
            $order->address_id = $address->id;
        }


        if ($user != null)
            $order->user_id = $user->id;

        $order->save();
        $cartItems = $request->get('cart_items');
        if (is_array($cartItems)) {
            $productIds = array_map(function ($cartItem) {
                return $cartItem['id'];
            }, $cartItems);

            $products = Product::whereIn('id', $productIds)->get();
            if (count($products) != count($cartItems))
                return $this->sendError('Please make sure all products are still available');

            foreach ($products as $index => $product) {

                $order->orderItems()->save(new OrderItem([
                    'product_id' => $product->id,
                    'quantity' => $cartItems[$index]['quantity'],
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                ]));
            }
        }


        $order->save();

        return $this->sendSuccessResponse(OrderSummaryDto::build($order));
    }

    public function orderSuccess()
    {

    }
}