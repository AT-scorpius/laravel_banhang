<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkout\Bill;
use App\Models\Checkout\Customer;
use App\Jobs\SendEmail;
use App\Mail\OrderConfirm;
use App\Mail\SendMail;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    public function getListOrder()
    {
        $listOrder = Bill::all();
        $listCustomer = Customer::all();
        // dd($listOrder);
        return view('Admin.orders.list-order')
            ->with([
                'status' => 'Tất cả đơn hàng hiện có',
                'status_code' => 0,
                'listOrder' => $listOrder,
                'listCustomer' => $listCustomer
            ]);
    }

    public function waiting()
    {
        $listOrder = Bill::where('status', 'waiting')->get();
        $listCustomer = Customer::all();
        // dd($listOrder);
        return view('Admin.orders.list-order')
            ->with([
                'status' => 'Đơn hàng chờ xác nhận',
                'status_code' => 1,
                'listOrder' => $listOrder,
                'listCustomer' => $listCustomer
            ]);
    }


    public function confirmed()
    {
        $listOrder = Bill::where('status', 'confirmed')->get();
        $listCustomer = Customer::all();
        // dd($listOrder);
        return view('Admin.orders.list-order')
            ->with([
                'status' => 'Đơn hàng đã xác nhận',
                'status_code' => 2,
                'listOrder' => $listOrder,
                'listCustomer' => $listCustomer
            ]);
    }

    public function setConfirmed($id)
    {
        // $order=$request->input('cancel');
        $order = Bill::find($id);
        $user = Customer::where('id', $order->id_customer)->first();
        // dd($order);
        $message = [
            'type' => 'Email thông báo đặt hàng thành công',
            'thanks' => 'Cảm ơn ' . $user->name . ' đã đặt hàng.',
            'id_bill' => $order->id,
            'content' => 'Admin đã xác nhận đơn hàng và giao hàng sớm nhất có thể.',
        ];
        Mail::to($user->email)->send(new SendMail($message));
        // OrderConfirm::dispatch($message, $user->email);
        $listOrder = Bill::where('status', 'cancelled');
        $listCustomer = Customer::all();
        $order->status = 'confirmed';
        $order->save();
        // dd($listOrder);
        return redirect()->route('order.list');
    }


    public function delivering()
    {
        $listOrder = Bill::where('status', 'delivering')->get();
        $listCustomer = Bill::all();
        // dd($listOrder);
        return view('Admin.orders.list-order')
            ->with([
                'status' => 'Đơn hàng đang giao',
                'status_code' => 3,
                'listOrder' => $listOrder,
                'listCustomer' => $listCustomer
            ]);
    }

    public function setDelivering($id)
    {
        // $order=$request->input('cancel');
        $order = Bill::find($id);
        // dd($order);
        $listOrder = Bill::where('status', 'cancelled');
        $listCustomer = Customer::all();
        $order->status = 'delivering';
        $order->save();
        // dd($listOrder);
        return redirect()->route('order.list');
    }

    public function delivered()
    {
        $listOrder = Bill::where('status', 'delivered')->get();
        $listCustomer = Bill::all();
        // dd($listOrder);
        return view('Admin.orders.list-order')
            ->with([
                'status' => 'Đơn hàng đã giao',
                'status_code' => 4,
                'listOrder' => $listOrder,
                'listCustomer' => $listCustomer
            ]);
    }

    public function setDelivered($id)
    {
        // $order=$request->input('cancel');
        $order = Bill::find($id);
        // dd($order);
        $listOrder = Bill::where('status', 'cancelled');
        $listCustomer = Customer::all();
        $order->status = 'delivered';
        $order->save();
        // dd($listOrder);
        return redirect()->route('order.list');
    }

    public function cancelled()
    {
        $listOrder = Bill::where('status', 'cancelled')->get();
        $listCustomer = Bill::all();
        // dd($listOrder);
        return view('Admin.orders.list-order')
            ->with([
                'status' => 'Đơn hàng bị hủy',
                'status_code' => 5,
                'listOrder' => $listOrder,
                'listCustomer' => $listCustomer
            ]);
    }
    public function setCancelled($id)
    {
        // $order=$request->input('cancel');
        $order = Bill::find($id);
        // dd($order);
        $listOrder = Bill::where('status', 'cancelled');
        $listCustomer = Customer::all();
        $order->status = 'cancelled';
        $order->save();
        // dd($listOrder);
        return redirect()->route('order.list');
    }

    public function returnOrder($id)
    {
        // $order=$request->input('cancel');
        $order = Bill::find($id);
        // dd($order);
        $listOrder = Bill::where('status', 'cancelled');
        $listCustomer = Customer::all();
        $order->status = 'waiting';
        $order->save();
        // dd($listOrder);
        return redirect()->route('order.list');
    }
}
