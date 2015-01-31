<table class="protocols-table" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td colspan="9">
                <div class="heading">
                    Supplement Schedule for {{ $client->name() }} {{ $i!=0 ? '(cont.)' : '' }}
                    &nbsp;
                    <span style="font-size:.66em; text-transform:uppercase;">{{ Subscriber::current()->name }}</span>
                </div>
            </td>
        </tr>
        <tr>
            <td class="print-protocols-portrait-label-cell">supplements</td>

            @foreach (Scheduletime::all() as $scheduletime)
                <td class="print-protocols-portrait-label-cell">{{ $scheduletime->name }}</td>
            @endforeach
        </tr>
        @foreach($page as $index=>$protocol)
            <tr height="8"></tr>
            <tr>
                <td class="print-protocols-supplement-portrait-cell">
                    {{ !empty($protocol) ? $protocol->supplement->name : '' }}
                </td>
                @foreach (Scheduletime::all() as $scheduletime)
                    <td class="print-protocols-cell">
                        @if (!empty($protocol))
                            {{ $protocol->schedules()->where('scheduletime_id',$scheduletime->id)->first()['prescription'] }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>