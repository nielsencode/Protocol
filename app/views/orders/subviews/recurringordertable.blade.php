<table class="index-table">
    <thead class="index-table-head">
        <tr>
            <th class="index-table-column">Order</th>
            <th class="index-table-column">Quantity</th>
            <th class="index-table-column">Supplement</th>
            @if (Auth::user()->role->name!=='client')
                <th class="index-table-column">Client</th>
            @endif
            <th class="index-table-column">Date</th>
            <th class="index-table-column">Fulfillment status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $autoshipOrder)
            <tr class="index-table-row">
                <td class="index-table-cell">
                    <a href="{{ route('order',$autoshipOrder->id) }}">{{ "#{$autoshipOrder->order_id}" }}</a>
                </td>
                <td class="index-table-cell">
                    <a href="{{ route('order',$autoshipOrder->id) }}">{{ $autoshipOrder->quantity }}</a>
                </td>
                <td class="index-table-cell">
                    <a href="{{ route('order',$autoshipOrder->id) }}">{{ $autoshipOrder->supplement->name }}</a>
                </td>
                @if (Auth::user()->role->name!=='client')
                    <td class="index-table-cell">
                         <a href="{{ route('order',$autoshipOrder->id) }}">{{ $autoshipOrder->client->name() }}</a>
                    </td>
                @endif
                <td class="index-table-cell">
                    <a href="{{ route('order',$autoshipOrder->id) }}">{{ timeForHumans($autoshipOrder->date) }}</a>
                </td>
                <td class="index-table-cell">
                    <a href="{{ route('order',$autoshipOrder->id) }}">
                        <span class="{{ $autoshipOrder->fulfilled_at ? '' : 'warning-' }}messages-small">
                            {{ $autoshipOrder->fulfilled_at ? 'fulfilled' : 'not fulfilled' }}
                        </span>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>