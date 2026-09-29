<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Mengelola keranjang belanja milik pembeli.
 */
class CartController extends Controller
{
    /** Jumlah maksimal buku yang boleh dimasukkan pada satu baris keranjang. */
    private const MAX_QUANTITY_PER_ITEM = 99;

    /**
     * Menampilkan seluruh isi keranjang beserta total harganya.
     */
    public function index(Request $request): View
    {
        $cartItems = $this->cartItemsFor($request->user());

        return view('store.cart.index', [
            'cartItems' => $cartItems,
            'totalPrice' => $this->totalPriceOf($cartItems),
        ]);
    }

    /**
     * Menambahkan sebuah buku ke keranjang belanja.
     */
    public function store(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.self::MAX_QUANTITY_PER_ITEM],
        ]);

        // Buku yang stoknya habis tidak dapat dimasukkan ke keranjang.
        if (! $book->isAvailable()) {
            return back()->with('error', 'Maaf, stok buku ini sedang kosong.');
        }

        $cartItem = CartItem::query()->firstOrNew([
            'user_id' => $request->user()->id,
            'book_id' => $book->id,
        ]);

        // Buku yang sudah ada di keranjang cukup ditambah jumlahnya.
        $newQuantity = (int) $cartItem->quantity + $validated['quantity'];

        if ($newQuantity > $book->stock) {
            return back()->with('error', 'Jumlah yang diminta melebihi stok yang tersedia ('.$book->stock.' buku).');
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        return back()->with('success', 'Buku berhasil ditambahkan ke keranjang.');
    }

    /**
     * Mengubah jumlah buku pada satu baris keranjang.
     */
    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $this->authorize('update', $cartItem);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.self::MAX_QUANTITY_PER_ITEM],
        ]);

        if ($validated['quantity'] > $cartItem->book->stock) {
            return back()->with('error', 'Jumlah yang diminta melebihi stok yang tersedia ('.$cartItem->book->stock.' buku).');
        }

        $cartItem->update(['quantity' => $validated['quantity']]);

        return redirect()
            ->route('store.cart.index')
            ->with('success', 'Jumlah buku berhasil diperbarui.');
    }

    /**
     * Menghapus satu buku dari keranjang belanja.
     */
    public function destroy(CartItem $cartItem): RedirectResponse
    {
        $this->authorize('delete', $cartItem);

        $cartItem->delete();

        return redirect()
            ->route('store.cart.index')
            ->with('success', 'Buku berhasil dihapus dari keranjang.');
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
            ->latest()
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
