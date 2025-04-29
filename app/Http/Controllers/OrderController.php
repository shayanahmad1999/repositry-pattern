<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Display a listing of the resource.
     */
    // public function index(): JsonResponse
    // {
    //     return response()->json([
    //         'data' => $this->orderRepository->getAllOrders()
    //     ]);
    // }
    public function index()
    {
        $orders = $this->orderRepository->getAllOrders();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreOrderRequest $request): JsonResponse
    // {
    //     $validatedData = $request->validated();

    //     $newOrder = $this->orderRepository->createOrder($validatedData);

    //     return response()->json([
    //         'data' => $newOrder
    //     ], Response::HTTP_CREATED);
    // }
    public function store(StoreOrderRequest $request)
    {
        $validatedData = $request->validated();

        $this->orderRepository->createOrder($validatedData);

        return redirect()->route('orders.index')
            ->with('success', 'Order created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order): JsonResponse
    {
        return response()->json([
            'data' => $this->orderRepository->getOrderById($order)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    // {
    //     $orderDetails = $request->validated();

    //     return response()->json([
    //         'data' => $this->orderRepository->updateOrder($order->id, $orderDetails)
    //     ]);
    // }
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());

        return redirect()->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Order $order): JsonResponse
    // {
    //     $this->orderRepository->deleteOrder($order->id);

    //     return response()->json(null, Response::HTTP_NO_CONTENT);
    // }
    public function destroy(Order $order)
    {
        $this->orderRepository->deleteOrder($order->id);

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}
