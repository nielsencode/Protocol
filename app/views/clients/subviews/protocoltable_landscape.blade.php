@section('js')
    @parent

    <script>
        $(function() {

            $('.protocol-table-row').each(function() {
                $(this).children('.protocol-table-cell,.protocol-table-supplement-cell').each(function(index) {
                    if ($(this).text().replace(/\s+/, '').length) {

                        var color = 'protocol-color'+(index%3+1);

                        $(this).addClass(color);

                    }
                });
            });

            $('.protocol-table-label-cell').each(function() {
                var contents = $(this).clone();
                var fixed = $('<div></div>').append(contents);

                fixed.css({
                    position:'absolute',
                    left:$(this).position().left,
                    top:$(this).position().top
                });

                contents.css({
                    height:$(this).height()+1,
                    width:$(this).width()+2,
                    verticalAlign:'middle'
                });

                $(this).after(fixed);
            });

        });
    </script>
@stop

<div style="position:relative;">

    <div class="protocol-table-wrapper">

        <table class="protocol-table" cellpadding="0" cellspacing="0">
            <thead class="protocol-table-head">
                <tr class="protocol-table-row">
                    <th class="protocol-table-label-cell">Supplements</th>

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
                            <th class="protocol-table-supplement-cell">
                                <a class="protocol-table-supplement-link" href="{{ route('edit protocol',[$protocol->id]) }}">
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
                            <th class="protocol-table-supplement-cell">
                                <a class="protocol-table-supplement-link" href="{{ route('supplement',[$protocol->supplement->id]) }}">
                                    {{ $protocol->supplement->name }}&nbsp;&nbsp;<i class="fa fa-info-circle"></i></span>
                                </a>
                            </th>
                        @endforeach
                    @endif

                </tr>
            </thead>
            @foreach (Scheduletime::orderBy('index','asc')->get() as $scheduletime)
                <tbody>
                    <tr class="protocol-table-row">
                        <td class="protocol-table-label-cell">{{ $scheduletime->name }}</td>
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
                            <td class="protocol-table-cell">
                                {{ $protocol->schedules()->where('scheduletime_id',$scheduletime->id)->first()['prescription'] }}
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            @endforeach
        </table>

    </div>

</div>