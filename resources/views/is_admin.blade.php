@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                    <table class='table table-striped'>
                        <thead>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Admin</th>
                        </thead>
                        <tbody>
                            @if(isset($users))
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            <form action="{{route('register.index.update', $user->id)}}" method="post" >
                                                @csrf
                                                <select class="form-control select2 " onchange="submit()" name='statu' style="width: 100%;">    
                                                    <option value="Y" {{($user->admin == 'Y') ? 'selected':''}}>Admin</option>
                                                    <option value="N" {{($user->admin == 'N') ? 'selected':''}}>User</option>
                                                </select>  
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
