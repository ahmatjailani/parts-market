<?php

namespace App\Http\Controllers\landing;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductModel;
use App\Models\ServiceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())->where('status', 'unsend')->get();

        foreach ($carts as &$cart) {
            // Check if it's a product or a service and assign the respective data
            if ($cart->type === 'product') {
                $cart->item = ProductModel::find($cart->product_id);
            } elseif ($cart->type === 'service') {
                $cart->item = ServiceModel::find($cart->product_id);
            }
        }

        return view('landing.cart', compact('carts'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized. Please login first.'], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required'
        ]);

        // Cari apakah item dengan user_id, product_id, dan type yang sama sudah ada di cart
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->where('type', $request->type)
            ->first();

        if ($existingCart) {
            // Jika item sudah ada, update quantity-nya
            $existingCart->quantity += $request->quantity;
            $existingCart->save();
        } else {
            // Jika item belum ada, buat item baru
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'type' => $request->type,
                'status' => 'unsend',
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json(['message' => 'Product added to cart successfully!']);
    }

    public function updateCart(Request $request, $cartId)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized. Please login first.'], 401);
        }

        $cart = Cart::find($cartId);

        if ($cart) {
            $cart->quantity = $request->quantity;
            $cart->save();

            return response()->json(['message' => 'Cart updated successfully!']);
        }

        return response()->json(['message' => 'Cart not found!'], 404);
    }

    public function removeFromCart($cartId)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized. Please login first.'], 401);
        }

        $cart = Cart::find($cartId);

        if ($cart) {
            $cart->delete();

            return response()->json(['message' => 'Product removed from cart']);
        }

        return response()->json(['message' => 'Cart not found!'], 404);
    }

    public function submitOrder(Request $request)
    {
        // Validasi input form
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string|max:15',
            'address' => 'required|string',
            'message' => 'nullable|string',
        ]);

        // Ambil data cart dari session atau database untuk dikirim ke email
        $carts = Cart::where('user_id', Auth::id())->where('status', 'unsend')->get();

        if ($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // Simpan data order ke tabel orders
        $order = Order::create([
            'user_id' => Auth::id(),
            'name'    => $request->input('name'),
            'email'   => $request->input('email'),
            'phone'   => $request->input('phone'),
            'address' => $request->input('address'),
            'message' => $request->input('message'),
        ]);

        // Simpan data cart ke tabel order_details
        foreach ($carts as &$cart) {
            $price = 0;

            if ($cart->type === 'product') {
                $cart->item = ProductModel::find($cart->product_id);
            } elseif ($cart->type === 'service') {
                $cart->item = ServiceModel::find($cart->product_id);
            }

            if ($cart->item) {
                $price = $cart->item->price;
            }

            OrderDetail::create([
                'order_id'   => $order->id,
                'product_id' => $cart->type === 'product' ? $cart->product_id : null,
                'service_id' => $cart->type === 'service' ? $cart->product_id : null,
                'type'       => $cart->type,
                'quantity'   => $cart->quantity,
                'price'      => $price,
            ]);
        }
        // Data untuk email
        $data = [
            'carts'    => $carts,
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'phone'    => $request->input('phone'),
            'address'  => $request->input('address'),
            'pesan'    => $request->input('pesan'),
        ];

        // Kirim email
        Mail::send('landing.email.order-product', $data, function ($messages) use ($request) {
            $messages->from('ahmatjailani9@gmail.com', 'Order System');
            $messages->to($request->input('email'))
                ->subject('Order Confirmation');
        });

        // Update status cart menjadi 'sent' setelah email berhasil dikirim
        Cart::where('user_id', Auth::id())->update(['status' => 'send']);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Order has been sent successfully!');
    }
}
