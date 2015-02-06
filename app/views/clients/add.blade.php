@extends('layouts.master.addeditform')

@section('js')
	@parent

	{{ HTML::script('assets/js/clients/add.js') }}
@stop

@section('breadcrumbs')
	{{ Breadcrumbs::make(array(
		'clients'=>route('clients'),
		'add'=>''
	)); }}
@stop

@section('title')
	Add Client
@stop

@section('form')
	{{ Form::open(['route'=>'add client']) }}
@stop

@section('form-fields')
	<tbody>
        <tr>
            <td class="form-label-cell">
                {{ Form::label('first_name','first name',[
                    'class'=>'required-form-label'
                ]) }}
            </td>
            <td class="form-cell">
                {{ Form::text('first_name',null,[
                    'class'=>$errors->has('first_name') ? 'form-field-error long-form-text' : 'long-form-text'
                ]) }}
            </td>
        </tr>
        <tr>
            <td class="form-label-cell">
                {{ Form::label('last_name','last name',[
                    'class'=>'required-form-label'
                ]) }}
            </td>
            <td class="form-cell">
                {{ Form::text('last_name',null,[
                    'class'=>$errors->has('last_name') ? 'form-field-error long-form-text' : 'long-form-text'
                ]) }}
            </td>
        </tr>
        <tr>
            <td class="form-label-cell">
                {{ Form::label('email','email',[
                    'class'=>'required-form-label'
                ]) }}
            </td>
            <td class="form-cell">
                {{ Form::text('email',null,[
                    'class'=>$errors->has('email') ? 'form-field-error long-form-text' : 'long-form-text'
                ]) }}
            </td>
        </tr>
    </tbody>

    @foreach (Addresstype::orderBy('name')->get() as $addresstype)
	    <tbody>
	        <tr>
	            <td class="form-section-header-title">
	                {{ $addresstype->name }} info:
	            </td>
	            <td class="form-section-header">
	                @if ($addresstype->name=='shipping')
		                {{ Form::checkbox('same_as_billing',1,null,[
		                    'id'=>'same_as_billing'
		                ]) }}

		                {{ Form::label('same_as_billing','same as billing',[
		                    'class'=>'alternate-form-label'
		                ]) }}
	                @endif
	            </td>
	        </tr>

	        @foreach (array('address','city','state','zip','phone') as $fieldName)
		        <tr>
		            <td class="form-label-cell">
		                {{ Form::label("{$addresstype->name}_$fieldName",$fieldName,[
		                    'class'=>$addresstype->name!='billing' && $fieldName=='phone' ? 'form-label' : 'required-form-label'
		                ]) }}
		            </td>
		            <td class="form-cell">
		                @if ($fieldName=='state')
			                {{ Form::select("{$addresstype->name}_$fieldName",$states,null,[
			                    'class'=>$errors->has("{$addresstype->name}_$fieldName") ? ' form-field-error form-select' : 'form-select'
			                ]) }}
		                @else
			                {{ Form::text("{$addresstype->name}_$fieldName",null,[
			                    'class'=>$errors->has("{$addresstype->name}_$fieldName") ? ' form-field-error long-form-text' : 'long-form-text'
			                ]) }}
		                @endif
		            </td>
		        </tr>
	        @endforeach

	    </tbody>
    @endforeach
@stop

@section('buttons')
	<a class="cancel" href="{{ isset($client) ? route('client',[$client['id']]) : route('clients') }}">cancel</a>
    {{ str_repeat('&nbsp;',4) }}
    {{ Form::submit('Save',['class'=>'button']) }}
@stop