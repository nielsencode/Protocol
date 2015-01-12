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

                    @foreach ($client->protocols as $protocol)
                        <th class="client-protocols-table-header-cell">
                            @if (
                                Auth::user()
                                    ->has('edit')
                                    ->ofScope('Subscriber',Subscriber::current()->id)
                                    ->orScope('Protocol')
                                    ->over('Protocol',$protocol->id)
                            )
                                <a class="client-protocols-table-header-cell-link" href="{{ route('edit protocol',[$protocol->id]) }}">
                                    {{ $protocol->supplement->name }}
                                </a>
                            @else
                                <a class="client-protocols-table-header-cell-link" href="{{ route('supplement',[$protocol->supplement->id]) }}">
                                    {{ $protocol->supplement->name }}&nbsp;&nbsp;<i class="fa fa-info-circle"></i></span>
                                </a>
                            @endif
                        </th>
                    @endforeach
                </tr>
            </thead>
            @foreach (Scheduletime::orderBy('index','asc')->get() as $scheduletime)
                <tbody>
                    <tr height="20"></tr>
                    <tr class="client-protocols-table-row">
                        <td class="client-protocols-table-label-cell">{{ $scheduletime->name }}</td>
                        @foreach ($client->protocols as $protocol)
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