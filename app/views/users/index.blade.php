@extends('layouts.master.indextable')

@section('js')
    @parent
    <script>
        $(function() {
            /*$('.import-supplements').click(function() {
                $('.modal-dialog').css('left',0);
            });*/
        });
    </script>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::make([
        'users'=>''
    ]) }}
@stop

{{--
@section('content')
    @include('layouts.master.subviews.modaldialog',['title'=>'import supplements','url'=>route('import supplements')])
    @parent
@stop
--}}

@section('index-tools-left')
    @if (
        Auth::user()
            ->has('add')
            ->ofScope('Subscriber',Subscriber::current()->id)
			->orScope('Protocol')
            ->over('User')
    )
        <a class="button" href="{{ route('add user') }}">New User</a>
        {{--
        {{ str_repeat('&nbsp;',6) }}
        <a class="index-tools-link import-supplements">import supplements</a>
        {{ str_repeat('&nbsp;',3).'&rsaquo;'.str_repeat('&nbsp;',3) }}
        <a class="index-tools-link" href="{{ route('export supplements') }}" target="_blank">export supplements</a>
        --}}
    @endif
@stop

@section('index-table-header')
    <th class="index-table-column">
        <a class="index-table-column-link" href="{{ sortby('first_name',$sortorder) }}">
            First name
        </a>
    </th>
    <th class="index-table-column">
        <a class="index-table-column-link" href="{{ sortby('last_name',$sortorder) }}">
            Last name
        </a>
    </th>
    <th class="index-table-column">
        <a class="index-table-column-link" href="{{ sortby('roles.name',$sortorder) }}">
            Role
        </a>
    </th>
    <th class="index-table-column">
        <a class="index-table-column-link" href="{{ sortby('email',$sortorder) }}">
            Email
        </a>
    </th>
    <th class="index-table-column">
        <a class="index-table-column-link" href="{{ sortby('password',$sortorder) }}">
            Verified
        </a>
    </th>
@stop

@section('index-table-rows')
    @if (!count($users))
        <tr class="index-table-row">
            <td class="index-table-cell" colspan="4">
                <a>no users.</a>
            </td>
        </tr>
    @else
        @foreach ($users as $user)
            <tr class="index-table-row">
                <td class="index-table-cell">
                    <a href="{{ route('user',$user->id) }}">{{ $user->first_name }}</a>
                </td>
                <td class="index-table-cell">
                    <a href="{{ route('user',$user->id) }}">{{ $user->last_name }}</a>
                </td>
                <td class="index-table-cell">
                    <a href="{{ route('user',$user->id) }}">{{ ucfirst($user->role->name) }}</a>
                </td>
                <td class="index-table-cell">
                    <a href="{{ route('user',$user->id) }}">{{ $user->email }}</a>
                </td>
                <td class="index-table-cell">
                    <span class="{{ $user->password ? '' : 'warning-' }}messages-small">{{ $user->password ? 'verified' : 'not verified' }}</span>
                </td>
            </tr>
        @endforeach
    @endif
@stop

@section('index-table-pagination')
    {{ pageLinks($users) }}
@stop