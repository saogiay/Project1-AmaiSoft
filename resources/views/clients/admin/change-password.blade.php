@extends('layouts.admin')

@section('content')
<div class="container pt-5">
    @include('clients.admin.flash-message')
</div>
<div class="container w-75">
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Đổi mật khẩu</h3>
        </div>

        <form action="" id="quickForm" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="old_password">Nhập mật khẩu cũ:</label>
                    <input type="password" name="old_password" class="form-control" id="old_password"
                        placeholder="Mật khẩu cũ">
                </div>
                <div class="form-group">
                    <label for="new_password">Mật khẩu mới:</label>
                    <input type="password" name="new_password" class="form-control" id="new_password"
                        placeholder="Mật khẩu mới">
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>
@endsection