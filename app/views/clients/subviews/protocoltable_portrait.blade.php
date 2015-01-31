@section('js')
    @parent
    {{ HTML::script('assets/js/clients/subviews/protocoltable.js') }}
@stop

<div style="position:relative;">

    <div class="client-protocols-table-portrait-wrapper">

        <table class="client-protocols-table-portrait" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <th class="client-protocols-table-portrait-label-cell">Supplements</th>

                @foreach (Scheduletime::orderBy('index','asc')->get() as $scheduletime)
                    <th class="client-protocols-table-portrait-label-cell">
                        {{ $scheduletime->name }}
                    </th>
                @endforeach

            </tr>
            </thead>
            @foreach(
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
                    <tr height="20"></tr>
                    <tr class="client-protocols-table-portrait-row">
                        <td class="client-protocols-table-portrait-cell">
                            <a class="client-protocols-table-supplement-cell-link" href="{{ route('edit protocol',[$protocol->id]) }}">
                                {{ $protocol->supplement->name }}
                            </a>
                        </td>

                        @foreach (Scheduletime::orderBy('index','asc')->get() as $scheduletime)
                            <td class="client-protocols-table-portrait-cell">
                                {{ $protocol->schedules()->where('scheduletime_id',$scheduletime->id)->first()['prescription'] }}
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            @endforeach
        </table>

    </div>

</div>