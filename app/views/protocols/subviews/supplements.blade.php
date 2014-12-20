<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />

	@section('js')
		<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
		{{ HTML::script('assets/js/jquery.min.js') }}
		{{ HTML::script('assets/js/clients/protocols/supplements.js') }}
	@show

	@section('css')
		{{ HTML::style('assets/css/clients/protocols/supplements.css') }}
	@show
</head>
<body>

	<div class="letters">
        @foreach (range('A','Z') as $letter)
            <a class="letter" href="?letter={{ $letter }}">{{ $letter }}</a>
        @endforeach
    </div>

    <div class="supplements">
        @foreach ($supplements as $supplement)
            <li class="supplement" supplement="{{ rawurlencode($supplement->toJson()) }}">{{ str_limit($supplement->name,100) }}</li>
        @endforeach
    </div>

	<div class="buttons">
      <a href="#" class="cancel">cancel</a>
      {{ str_repeat('&nbsp;',4) }}
      <a class="disabled-button" name="add button" disabled="disabled">Add</a>
	</div>

</body>
</html>