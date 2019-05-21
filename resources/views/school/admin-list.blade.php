@extends('layouts.app')

@section('title', 'Admins')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" id="side-navbar">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('create-school')}}"> {{__('views.layouts-home-manageschool')}}</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10" id="main-container">
                <h2>{{__('views.adminlist-admins')}}</h2>
                <div class="panel panel-default">
                    @if(count($admins) > 0)
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <th>{{__('views.adminlist_action1')}}</th>
                                    <th>{{__('views.adminlist_action2') }}</th>
                                    <th>{{__('views.Name')}}</th>
                                    <th>{{__('views.adminlist_code')}}</th>
                                    <th>{{__('views.E-Mail_Address')}}</th>
                                    <th>{{__('views.Phone_Number')}}</th>
                                    <th>{{__('views.adminlist_address')}}</th>
                                    <th>{{__('views.adminlist_about')}}</th>
                                </tr>
                                @foreach ($admins as $admin)
                                    <tr>
                                        <td>
                                            @if($admin->active == 0)
                                                <a href="{{url('master/activate-admin/'.$admin->id)}}" class="btn btn-xs btn-success"
                                                   role="button"><i class="material-icons">
                                                        done
                                                    </i>{{__('views.adminlist_Activate')}}</a>
                                            @else
                                                <a href="{{url('master/deactivate-admin/'.$admin->id)}}" class="btn btn-xs btn-danger"
                                                   role="button"> <span class="glyphicon glyphicon-trash"> {{__('views.adminlist_Deactivate')}}</span></a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('edit/user/'.$admin->id)}}" class="btn btn-xs btn-info"
                                               role="button"><span class="glyphicon glyphicon-edit"> {{__('views.adminlist_edit')}}</span></a>
                                        </td>
                                        <td>
                                            {{$admin->name}}
                                        </td>
                                        <td>{{$admin->student_code}}</td>
                                        <td>{{$admin->email}}</td>
                                        <td>{{$admin->phone_number}}</td>
                                        <td>{{$admin->address}}</td>
                                        <td>{{$admin->about}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @else
                        <div class="panel-body">
                            {{__('views.adminlist_nodata')}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
