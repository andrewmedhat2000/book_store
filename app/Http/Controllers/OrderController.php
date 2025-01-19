<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    // Create an order
    public function create(Request $request)
    {
        $request->validate( [
            'books' => 'required|array',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $order = $this->orderService->createOrder($userId, $request->books);

        return response()->json([
            'message' => 'order updated successfully!',
            'order' => $order
        ]);
    }

    // Get all orders for the logged-in user
    public function index()
    {
        $userId = Auth::id();
        $orders = $this->orderService->getOrdersForUser($userId);

        return response()->json($orders);
    }

    // Update order status (admin only)
    public function updateStatus(Request $request, $id)
    {

        $request->validate( [
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order = $this->orderService->updateOrderStatus($id, $request->status);

        return response()->json([
            'message' => 'order updated successfully!',
            'order' => $order
        ]);
     }
}
