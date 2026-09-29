<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\OrderStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Menangani proses checkout keranjang menjadi pesanan.
 */
class CheckoutController extends Controller
{
    /**
     * Menampilkan formulir checkout beserta ringkasan keranjang.
     */
    public function index(): View|RedirectResponse
    {
        $user = request()->user();
        $cartItems = $this->cartItemsFor($user);

        // Checkout tidak dapat dilanjutkan bila keranjang masih kosong.
        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('store.cart.index')
                ->with('error', 'Keranjang belanja masih kosong.');
        }

        return view('store.checkout.index', [
            'cartItems' => $cartItems,
            'totalPrice' => $this->totalPriceOf($cartItems),
            'user' => $user,
        ]);
    }

    /**
     * Membuat pesanan baru dari isi keranjang belanja.
     */
    public function store(CheckoutRequest $request): RedirectResponse
    {
        $user = $request->user();
        $cartItems = $this->cartItemsFor($user);

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('store.cart.index')
                ->with('error', 'Keranjang belanja masih kosong.');
        }

        // Seluruh proses pembuatan pesanan dijalankan dalam satu transaksi database
        // agar tidak ada data pesanan yang tersimpan setengah jalan.
        $order = DB::transaction(function () use ($request, $user, $cartItems): Order {
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => Order::generateOrderNumber(),
                'status' => OrderStatus::Pending,
                'total_price' => $this->totalPriceOf($cartItems),
                'customer_name' => $request->validated('customer_name'),
                'customer_phone' => $request->validated('customer_phone'),
                'shipping_address' => $request->validated('shipping_address'),
                'note' => $request->validated('note'),
            ]);

            foreach ($cartItems as $cartItem) {
                $this->createOrderItem($order, $cartItem);
            }

            // Keranjang dikosongkan setelah pesanan berhasil dibuat.
            $user->cartItems()->delete();

            return $order;
        });

        return redirect()
            ->route('store.orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat. Silakan lanjutkan pembayaran.');
    }

    /**
     * Menyimpan satu rincian pesanan dan mengurangi stok buku.
     */
    private function createOrderItem(Order $order, CartItem $cartItem): void
    {
        $book = $cartItem->book;

        // Stok diperiksa ulang agar pesanan tidak melebihi persediaan.
        if ($cartItem->quantity > $book->stock) {
            throw ValidationException::withMessages([
                'quantity' => 'Stok buku '.$book->title.' tidak mencukupi.',
            ]);
        }

        OrderItem::create([
            'order_id' => $order->id,
            'book_id' => $book->id,
            'book_title' => $book->title,
            'price' => $book->price,
            'quantity' => $cartItem->quantity,
            'subtotal' => $cartItem->subtotal(),
        ]);

        // Stok dikurangi sesuai jumlah buku yang dibeli.
        $book->decrement('stock', $cartItem->quantity);
    }

    /**
     * Mengambil seluruh isi keranjang milik pengguna.
     *
     * @return Collection<int, CartItem>
     */
    private function cartItemsFor(User $user): Collection
    {
        return CartItem::query()
            ->with('book.category')
            ->where('user_id', $user->id)
            ->get();
    }

    /**
     * Menghitung total harga seluruh buku di keranjang.
     *
     * @param  Collection<int, CartItem>  $cartItems
     */
    private function totalPriceOf(Collection $cartItems): int
    {
        return (int) $cartItems->sum(fn (CartItem $cartItem): int => $cartItem->subtotal());
    }
}
