<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />

	{{ HTML::script('assets/js/jquery.min.js') }}
	<script>
		$(function() {
			//window.print();
		});
	</script>

	{{ HTML::style('assets/css/layouts/master/master.css') }}
	<style>
		.protocols-wrapper {
			width:1050px;
			padding:25px;
			margin:auto;
		}

		.protocols-table {
			border-collapse:collapse;
		}

		.print-protocols-cell,.print-protocols-header-cell,.print-protocols-label-cell {
			padding:10px;
			height:30px;
			text-align:center;
			border:1px solid #909090;
			page-break-inside:avoid;
		}

		.print-protocols-header-cell {
			width:100px;
			font-size:12px;
			border-bottom-width:2px;
			border-bottom-color:#606060;
		}

		.print-protocols-cell {
			width:100px;
			font-size:12px;
		}

		.print-protocols-label-cell {
			background-color:#a8a8a8;
			color:#fff;
			text-align:right;
			width:100px;
			text-transform:uppercase;
			font-size:12px;
		}

		.page {
			padding:25px 0;
		}

		.page-break {
			page-break-after:always;
		}

		.protocols-credit {
			text-align:right;
			font-size:9px;
			margin-top:10px;
		}

		.protocols-supplement-info-cell {
			padding:8px 0;
			vertical-align:top;
			font-size:11px;
		}
	</style>
</head>
<body>

	<div class="protocols-wrapper">
		@foreach ($protocols as $i=>$page)
			<div class="page-break page">
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
	                        <td class="print-protocols-label-cell">supplements</td>
	                        @foreach($page as $index=>$protocol)
	                            <td class="print-protocols-header-cell">
	                                {{ !empty($protocol) ? $protocol->supplement->name : '' }}
                                </td>
	                        @endforeach
	                    </tr>
	                    @foreach (Scheduletime::all() as $scheduletime)
	                        <tr height="8"></tr>
	                        <tr>
	                            <td class="print-protocols-label-cell">{{ $scheduletime->name }}</td>
	                            @foreach ($page as $index=>$protocol)
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
	            <div class="protocols-credit">
	                powered by protocol.
	            </div>
			</div>
		@endforeach

		<div class="page">
			<table cellpadding="0" cellspacing="0" style="width:100%;">
                <tr>
                    <td colspan="3">
                        <div class="heading">
							Supplement Information
							&nbsp;
							<span style="font-size:.66em; text-transform:uppercase;">{{ Subscriber::current()->name }}</span>
                        </div>
                    </td>
                </tr>

                @foreach ($client->protocols as $i=>$protocol)
                    @if ($i%2==0)
                        <tr>
                    @endif

                        <td class="protocols-supplement-info-cell">
                            {{ strtoupper($protocol->supplement->name) }}
                            <div style="margin-top:5px;">
                                {{ $protocol->supplement->short_description ? $protocol->supplement->short_description : 'no description' }}
                            </div>
                         </td>

                         @if ($i%2==0)
                            <td style="width:100px;"></td>
                         @endif

                    @if(($i+1)%2==0)
                        </tr>
                    @endif
                @endforeach
            </table>
            <div class="protocols-credit">
                powered by protocol.
            </div>
		</div>

	</div>

</body>
</html>