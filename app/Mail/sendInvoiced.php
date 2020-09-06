<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendInvoiced extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.mail')->with([
            'custName' => $this->data['cust_name'],
            'Price' => $this->data['price'],
            'SellDate' => $this->data['sale_date'],
            'Quantity' => $this->data['quantity']
        ])
        ->attach(storage_path('pdf').'_invoice.pdf', [
            'as' => 'invoice.pdf',
            'mime' => 'application/pdf',
        ]);
    }
}
