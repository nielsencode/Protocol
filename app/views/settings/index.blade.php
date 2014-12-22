@extends('layouts.master.addeditform')

@section('css')
    @parent

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

    <script>
        $(function() {
            $('.colors').each(function() {
                $(this).colorpicker({
                    rowsize:$(this).find('option').length
                });
            });
        });
    </script>
@stop

@section('title')
    {{ Subscriber::current()->name }} Settings
@stop

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
                        <label class="form-label">{{ ucfirst($setting->name) }}</label>
                    </td>
                    <td class="form-cell">
                        @if ($setting->inputtype->name=='colorpicker')
                            {{ Form::select(
                                $setting->name,
                                array_combine($setting->values,$setting->values),
                                $setting->subscriberValue,
                                ['class'=>'colors']
                            ) }}
                        @endif

                        @if ($setting->inputtype->name=='file')
                            {{ Form::file($setting->name) }}
                        @endif

                        @if ($setting->inputtype->name=='text')
                            {{ Form::text($setting->name,$setting->subscriberValue,['class'=>'form-text']) }}
                        @endif
                    </td>
                    <td class="form-description-cell">
                        {{ $setting->description }}
                    </td>
                </tr>
            @endforeach

        </tbody>

    @endforeach
@stop

@section('buttons')
    <a href=""><button class="button">Save</button></a>
@stop