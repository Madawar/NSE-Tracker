<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShareAlerts extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($alertRisingStocks,$alertBuyStocks,$alertTrackingStocks,$alertDropStocks)
    {
        $this->alertBuyStocks = $alertBuyStocks;
        $this->alertRisingStocks = $alertRisingStocks;
        $this->alertTrackingStocks = $alertTrackingStocks;
        $this->alertDropStocks = $alertDropStocks;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('dwanyoike@codedcell.com')
            ->markdown('emails.alerts')->with([
                'alertBuyStocks' => $this->alertBuyStocks,
                'alertRisingStocks' => $this->alertRisingStocks,
                'alertTrackingStocks' => $this->alertTrackingStocks,
                'alertDropStocks'=>$this->alertDropStocks
            ]);;
    }
}
