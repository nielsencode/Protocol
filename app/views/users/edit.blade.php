@extends('...layouts.master.addeditform')

@section('js')
	@parent
	<script>
		$(function() {
			$('.addedit-delete-link').click(function() {
				if(confirm('Are you sure you want to delete "'+$(this).attr('name')+'"')) {
					$(this).closest('form').submit();
				}
			});
		});
	</script>
@stop

@section('breadcrumbs')
	@if (!Auth::user())
		{{ Breadcrumbs::make([
            'account'=>'',
            'edit'=>''
        ]) }}
	@elseif (
		Auth::user()
			->has('read')
			->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
			->over('User')
	)
		{{ Breadcrumbs::make(array(
            'users'=>url('users'),
            $user->name()=>url("users/{$user->id}"),
            'edit'=>''
        )) }}
	@else
		{{ Breadcrumbs::make(array(
			'home'=>url('home'),
			'account'=>url("users/{$user->id}/account"),
			'edit'=>''
		)) }}
	@endif
@stop

@section('title')
	Edit Account for {{ $user->name() }}
@stop

@if (
	Auth::user()
		->has('delete')
		->ofScope('Subscriber',Subscriber::current()->id)
		->orScope('Protocol')
		->over('User')
)
	@section('delete-link')
		{{ Form::open(['route'=>['delete user',$user->id]]) }}
			<a class="addedit-delete-link" name="{{ $user->name() }}" href="#">delete user</a>
		{{ Form::close() }}
	@stop
@endif

@section('form')
	{{ Form::model($user->toArray(),array('url'=>"users/{$user->id}/edit")) }}
	@if (Input::has('token'))
		{{ Form::hidden('token',Input::get('token')) }}
	@endif
@stop

@if (!$errors->all())
	@section('messages')
		@if (!Auth::user())
			<div class="messages">
	            <li class="message">Enter a password for your account below and click "Save."</li>
	        </div>
		@endif
	@stop
@endif

@section('form-fields')
	@if (Auth::user())
		<tr>
			<td class="form-label-cell">
				{{ Form::label('email','email (username)',array('class'=>'required-form-label')) }}
			</td>
			<td class="form-cell">
				{{ Form::text('email',null,array(
					'class'=>$errors->has('email') ? 'form-field-error long-form-text' : 'long-form-text'
				)) }}
			</td>
		</tr>
		<tr>
			<td class="form-label-cell">
				{{ Form::label('first_name','first name',array('class'=>'required-form-label')) }}
			</td>
			<td class="form-cell">
				{{ Form::text('first_name',null,array(
					'class'=>$errors->has('first_name') ? 'form-field-error long-form-text' : 'long-form-text'
				)) }}
			</td>
		</tr>
		<tr>
		    <td class="form-label-cell">
		        {{ Form::label('last_name','last name',array('class'=>'required-form-label')) }}
		    </td>
		    <td class="form-cell">
		        {{ Form::text('last_name',null,array(
		            'class'=>$errors->has('last_name') ? 'form-field-error long-form-text' : 'long-form-text'
		        )) }}
		    </td>
		</tr>
	@endif
	@if (!Auth::user() || Auth::user()->id==$user->id)
		<tr>
		   <td class="form-label-cell">
		       {{ Form::label('password',Input::has('token') ? 'password' : 'new password',array('class'=>Input::has('token') ? 'required-form-label' : 'form-label')) }}
		   </td>
		   <td class="form-cell">
		       {{ Form::password('password',array(
		           'class'=>$errors->has('password') ? 'form-field-error long-form-text' : 'long-form-text'
		       )) }}
		   </td>
		</tr>
		<tr>
		  <td class="form-label-cell">
		      {{ Form::label('retype_password','retype password',array('class'=>Input::has('token') ? 'required-form-label' : 'form-label')) }}
		  </td>
		  <td class="form-cell">
		      {{ Form::password('retype_password',array(
		          'class'=>$errors->has('retype_password') ? 'form-field-error long-form-text' : 'long-form-text'
		      )) }}
		  </td>
		</tr>
	@endif
@stop

@section('buttons')
	@if (Auth::user())
		<a href="{{ URL::previous() }}">cancel</a>
		{{ str_repeat('&nbsp;',4) }}
	@endif
	<button class="button">Save</button>
@stop