@extends('layouts.master.addeditform')

@section('breadcrumbs')
	{{ Breadcrumbs::make([
		'supplements'=>route('supplements'),
		'add'=>''
	]) }}
@stop

@section('title')
	Add Supplement
@stop

@section('form')
	{{ Form::open(['route'=>'add supplement']) }}
@stop

@section('form-fields')
	<tbody>
        <tr>
            <td class="form-label-cell">
                {{ Form::label('name','name',[
                    'class'=>'required-form-label'
                ]) }}
            </td>
            <td class="form-cell">
                {{ Form::text('name',null,[
                    'class'=>$errors->has('name') ? 'form-field-error long-form-text' : 'long-form-text'
                ]) }}
            </td>
        </tr>
        <tr>
            <td class="form-label-cell">
                {{ Form::label('price','price',[
                    'class'=>'required-form-label'
                ]) }}
            </td>
            <td class="form-cell">
                {{ Form::text('price',null,[
                    'class'=>$errors->has('price') ? 'form-field-error price-form-text' : 'price-form-text'
                ]) }}
            </td>
        </tr>
        <tr>
            <td class="form-label-cell">
                {{ Form::label('short_description','short description',[
                    'class'=>'form-label'
                ]) }}
            </td>
            <td class="form-cell">
                {{ Form::text('short_description',null,[
                    'class'=>$errors->has('short_description') ? 'form-field-error long-form-text' : 'long-form-text',
                    'maxlength'=>150
                ]) }}
            </td>
        </tr>
        <tr>
            <td class="form-textarea-label-cell">
                {{ Form::label('description','long description',[
                    'class'=>'form-label'
                ]) }}
            </td>
            <td class="form-cell">
                {{ Form::textarea('description',null,[
                    'class'=>$errors->has('description') ? 'form-field-error form-text-area' : 'form-text-area'
                ]) }}
            </td>
        </tr>
    </tbody>
@stop

@section('buttons')
	<a class="cancel" href="{{ isset($supplement) ? route('supplement',[$supplement['id']]) : route('supplements') }}">cancel</a>
    {{ str_repeat('&nbsp;',4) }}
    {{ Form::submit('Save',['class'=>'button']) }}
@stop