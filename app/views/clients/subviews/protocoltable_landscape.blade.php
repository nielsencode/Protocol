@section('js')
	@parent
	{{ HTML::script('assets/js/clients/subviews/protocoltable.js') }}
@stop

<div style="position:relative;">

    <div class="client-protocols-table-wrapper">

        <table class="client-protocols-table" cellpadding="0" cellspacing="0">
            <thead>
                <tr class="client-protocols-table-row">
                    <th class="client-protocols-table-label-cell">Supplements</th>

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
                            <th class="client-protocols-table-header-cell">
                                <a class="client-protocols-table-supplement-cell-link" href="{{ route('edit protocol',[$protocol->id]) }}">
                                    {{ $protocol->supplement->name }}
                                </a>
                            </th>
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
                            <th class="client-protocols-table-header-cell">
                                <a class="client-protocols-table-supplement-cell-link" href="{{ route('supplement',[$protocol->supplement->id]) }}">
                                    {{ $protocol->supplement->name }}&nbsp;&nbsp;<i class="fa fa-info-circle"></i></span>
                                </a>
                            </th>
                        @endforeach
                    @endif

                </tr>
            </thead>
            @foreach (Scheduletime::orderBy('index','asc')->get() as $scheduletime)
                <tbody>
                    <tr height="20"></tr>
                    <tr class="client-protocols-table-row">
                        <td class="client-protocols-table-label-cell">{{ $scheduletime->name }}</td>
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
                            <td class="client-protocols-table-cell" style="height:10px;">
                                {{ $protocol->schedules()->where('scheduletime_id',$scheduletime->id)->first()['prescription'] }}
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            @endforeach
        </table>
    </div>

</div>