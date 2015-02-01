@section('js')
    @parent

    {{ HTML::script('assets/js/clients/subviews/protocoltable.js') }}
@stop

<div style="position:relative;">

    <div class="protocol-table-wrapper-portrait">

        <table class="protocol-table" cellpadding="0" cellspacing="0">
            <thead class="protocol-table-head-portrait">
                <tr class="protocol-table-row">
                    <th class="protocol-table-label-cell-portrait">Supplements</th>

                    @foreach (Scheduletime::orderBy('index','asc')->get() as $scheduletime)
                        <th class="protocol-table-label-cell-portrait">{{ $scheduletime->name }}</th>
                    @endforeach

                </tr>
            </thead>
            @if (
                Auth::user()
                    ->has('edit')
                    ->ofScope('Subscriber',Subscriber::current()->id)
                    ->orScope('Protocol')
                    ->over('Protocol')
            )
                @foreach (
                    $client
                        ->protocols()
                        ->with('Supplement')
                        ->get()
                        ->sortBy(function($item) {
                            return $item->supplement->name;
                        })
                    as $protocol
                )
                    <tbody>
                        <tr class="protocol-table-row-portrait">
                            <td class="protocol-table-supplement-cell-portrait">
                                <a class="protocol-table-supplement-link-portrait" href="{{ route('edit protocol',[$protocol->id]) }}">
                                    <span class="protocol-table-supplement-name">
                                        {{ $protocol->supplement->name }}
                                    </span>
                                </a>
                            </td>

                            @foreach (Scheduletime::orderBy('index','asc')->get() as $scheduletime)
                                <td class="protocol-table-cell-portrait">
                                    {{ $protocol->schedules()->where('scheduletime_id',$scheduletime->id)->first()['prescription'] }}
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                @endforeach
            @else
                @foreach (
                    $client
                        ->protocols()
                        ->with('Supplement')
                        ->get()
                        ->sortBy(function($item) {
                            return $item->supplement->name;
                        })
                    as $protocol
                )
                    <tbody>
                    <tr class="protocol-table-row-portrait">
                        <td class="protocol-table-supplement-cell-portrait">
                            <a class="protocol-table-supplement-link-portrait" href="{{ route('supplement',[$protocol->supplement->id]) }}">
                                <span class="protocol-table-supplement-name">
                                    {{ $protocol->supplement->name }}
                                </span>
                            </a>
                        </td>

                        @foreach (Scheduletime::orderBy('index','asc')->get() as $scheduletime)
                            <td class="protocol-table-cell-portrait">
                                {{ $protocol->schedules()->where('scheduletime_id',$scheduletime->id)->first()['prescription'] }}
                            </td>
                        @endforeach
                    </tr>
                    </tbody>
                @endforeach
            @endif
        </table>

    </div>

</div>