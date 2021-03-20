<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;
    public $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     to array can be used for broadcasting and for database 
     */
    // public function toArray($notifiable)
    // {
    //      return [
    //         'invoice_id' => 1,
    //         'amount' => 1,
    //     ];
    // }

  public function toDatabase($notifiable)
    {
       $user = \Auth::user();
       $orderProduct =  $this->getOrderProduct();
       $msg =  $notifiable->id ===  $user->id ? 'You' : $user->name;
         return [
            'message' => $msg .' have created a order ',
            'products' => json_encode($orderProduct)
        ];
    }

    public function broadcastType()
    {
        return 'Order Create';
    }

    private function getOrderProduct()
    {
       $products = [];
        foreach($this->order->product as $index => $product) {
            $orderProduct = $product->order_product;
            $products[$index]['product_id'] = $orderProduct->product_id;
            $products[$index]['quantity'] = $orderProduct->quantity;
            $products[$index]['price'] = $orderProduct->price * $orderProduct->quantity;
            $products[$index]['name'] = $product->name;
        }
        return $orderProduct;
    }
}
