<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder($userId, $booksData)
    {
        DB::beginTransaction();

        try {
            $order = Order::create([
                'order_number' => 'ORD' . strtoupper(uniqid()),
                'user_id' => $userId,
                'total_price' => 0, 
                'status' => Order::STATUS_PENDING,
            ]);

            $totalPrice = 0;
            foreach ($booksData as $bookData) {
                $book = Book::findOrFail($bookData['book_id']);
                $order->books()->attach($book->id, [
                    'quantity' => $bookData['quantity'],
                    'price' => $book->price,
                ]);
                $totalPrice += $book->price * $bookData['quantity'];
            }

            $order->update(['total_price' => $totalPrice]);

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateOrderStatus($orderId, $status)
    {
        $order = Order::findOrFail($orderId);

        if (!in_array($status, [Order::STATUS_PENDING, Order::STATUS_COMPLETED, Order::STATUS_CANCELLED])) {
            throw new \InvalidArgumentException("Invalid status.");
        }

        $order->update(['status' => $status]);

        return $order;
    }

    public function getOrdersForUser($userId)
    {
        return Order::where('user_id', $userId)->get();
    }
}
