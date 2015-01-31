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

	{{ HTML::style('assets/css/clients/protocols/print/index.css') }}
</head>
<body>

	<div class="protocols-wrapper">
		@foreach ($protocols as $i=>$page)
			<div class="page-break page">

				@include('clients.protocols.print.subviews.protocoltable_'.Subscriber::current()->setting('protocol table orientation'))

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