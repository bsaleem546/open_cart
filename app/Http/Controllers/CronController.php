<?php

namespace App\Http\Controllers;

use App\Mail\CustomerMail;
use App\Mail\NewOrderMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CronController extends Controller
{
    public function sendMail()
    {
        try {
            $orders = Order::where('is_sent', 0)->get();
            if (!$orders) print_r('no orders yet');
            foreach ($orders as $o){
                $orderProduct = $o->orderProducts;
                $customer = $o->customer;

                $mailBody = [
                    'order' => $o,
                    'orderProduct' => $orderProduct,
                    'customer' => $customer
                ];

                Mail::to($customer->email)->send(new CustomerMail($mailBody));
                Mail::to('sales@thetwinsfurnitures.com')->send(new NewOrderMail($mailBody));

                $o->is_sent = 1;
                $o->update();

                echo 'mail sent';
            }
        }
        catch (\Exception $e){
            echo $e;
        }
    }
}
