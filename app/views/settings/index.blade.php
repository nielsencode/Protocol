@extends('layouts.master.addeditform')

@section('css')
    @parent

    {{ HTML::style('assets/css/bootstrap-editable.css') }}

    <style type="text/css">
        .form-cell {
            padding-top:8px;
            padding-bottom:8px;
        }

        .colorpicker-tile {
            padding:2px;
            margin:3px;
            border-radius:2px;
        }

        .colorpicker-tile-selected {
            border-color:#ffffff;
            box-shadow:0 0 1px rgba(0,0,0,.75);
        }
    </style>
@stop

@section('js')
    @parent

    {{ HTML::script('assets/js/colorpicker.js') }}
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js') }}
    {{ HTML::script('//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js') }}
    {{ HTML::script('assets/js/bootstrap-editable.js') }}

    <script>
        $(function() {
            $('.colors').each(function() {
                $(this).colorpicker({
                    rowsize:8
                });
            });

            $('.editable-list-item-inner').each(function() {
                $(this).editable({
                    mode:'inline',
                    inputclass:'editable-list-item-input',
                    unsavedclass:null,
                    highlight:false,
                    name:$(this).closest('.editable-list').attr('name')
                });
            });

            $('.editable-list').sortable({
                axis:'y'
            });

            $('form').submit(function() {
                $('.editable-list').each(function() {
                    var name = $(this).attr('name');

                    var values = [];

                    $(this).find('.editable-list-item-inner').each(function() {
                        values.push($(this).editable('getValue')[name]);
                    });

                    $(':input[name="'+name+'"]').val(JSON.stringify(values));
                });
            });
        });
    </script>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::make([
        'settings'=>''
    ]) }}
@stop

@section('title')
    {{ Subscriber::current()->name }} Settings
@stop

@if (Session::has('success'))
    @section('messages')
        <div class="messages">
            <li class="message">{{ Session::get('success') }}</li>
        </div>
    @stop
@endif

@section('form')
    {{ Form::open(['route'=>['settings'],'files'=>true]) }}
@stop

@section('form-fields')
    @foreach(
        Scope::where('name','Subscriber')
            ->first()
            ->settinggroups()
            ->orderBy('name','asc')
            ->get()
            as $i=>$group
    )

        <tbody>

           @if ($i!=0)
                <tr>
                    <td colspan="3">
                        <hr class="hr" style="margin-right:-40px;"/>
                    </td>
                </tr>
            @endif

            <tr>
                <td class="form-section-header-title">
                    {{ $group->name }}:
                </td>
                <td class="form-section-header"></td>
                <td class="form-section-header"></td>
            </tr>

            @foreach($group->settingnames as $setting)
                <tr>
                    <td class="form-label-cell">
                        {{ Form::label($setting->name,ucfirst($setting->name),['class'=>'form-label']) }}
                    </td>
                    <td class="form-cell">
                        @if ($setting->inputtype->name=='colorpicker')
                            {{ Form::select(
                                $setting->name,
                                array_combine($setting->values,$setting->values),
                                Subscriber::current()->setting($setting->name),
                                ['class'=>'colors']
                            ) }}
                        @endif

                        @if ($setting->inputtype->name=='file')
                            {{ Form::file($setting->name) }}
                        @endif

                        @if ($setting->inputtype->name=='text')
                            {{ Form::text($setting->name,Subscriber::current()->setting($setting->name),['class'=>'form-text']) }}
                        @endif

                        @if ($setting->inputtype->name=='checkbox')
                            {{ Form::hidden($setting->name,0,['id'=>'']) }}
                            {{ Form::checkbox($setting->name,1,Subscriber::current()->setting($setting->name)) }}
                        @endif

                        @if ($setting->inputtype->name=='dropdown')
                            {{ Form::select(
                                $setting->name,
                                array_combine($setting->values,array_map('ucfirst',$setting->values)),
                                Subscriber::current()->setting($setting->name),
                                ['class'=>'form-select']
                            ) }}
                        @endif
                    </td>
                    <td class="form-description-cell">
                        {{ $setting->description }}
                    </td>
                </tr>
            @endforeach

            @if($group->name=='protocols')
                <tr height="10"></tr>
                <tr>
                    <td class="form-label-cell" style="vertical-align:top;">
                        Times of day
                    </td>
                    <td class="form-cell">
                        <input type="hidden" name="scheduletimes"/>
                        <ul name="scheduletimes" class="editable-list">
                            @foreach(Scheduletime::all() as $scheduletime)
                                <li class="editable-list-item">
                                    <div class="editable-list-item-inner">
                                        {{ $scheduletime->name }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endif

        </tbody>

    @endforeach
@stop

@section('buttons')
    <a class="cancel" href="{{ URL::previous()==Request::url() ? route('home') : URL::previous() }}">cancel</a>
    {{ str_repeat('&nbsp;',4) }}
    <a href=""><button class="button">Save</button></a>
@stop