@component('mail::message')
    # NSE Shares for {{\Carbon\Carbon::today()}}

    # Rising Stocks
    @foreach($alertRisingStocks as $stock)
        | {{$stock->stock}} | {{$stock->value}} |
    @endforeach

    # Consider Buying
    @foreach($alertBuyStocks as $stock)
        | {{$stock->stock}} | {{$stock->value}} |
    @endforeach

    # Stocks You Own
    @foreach($alertTrackingStocks as $stock)
        | {{$stock->stock}} | {{$stock->value}} = {{$stock->value*$stock->stockNo}} |  Bought At: {{$stock->origVal}}= {{$stock->value*$stock->stockNo}}
    @endforeach


    The body of your message.



    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
