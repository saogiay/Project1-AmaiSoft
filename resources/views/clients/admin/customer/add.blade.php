@extends('layouts.admin')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="container-fluid">
        <a href="{{ route('admin.customer.index') }}" type="button" class="btn btn-secondary">
            <i class="fa-solid fa-circle-left"></i>
            Quay lại
        </a>
        <p class="h3 text-center">{{$title}}</p>
        <div class="row">
            <div class="col-md-8 mt-5 m-auto border rounded p-5 bg-light bg-gradien">
                @if (session('msg'))
                    <div class="alert alert-success">{{ session('msg') }}</div>
                @endif
    
                @if ($errors->any())
                    <div class="alert alert-danger text-center">
                        Thông tin điền vào chưa đúng. Vui lòng nhập lại.
                    </div>
                @endif
                <form action="{{route('admin.customer.store')}}" method="POST">
                    @method('POST')
                    <div class="form-group d-flex align-items-center">
                        <div class="col-md-3">
                            <label for="">Họ tên</label>
                        </div>
                        <div class="col-md-9">
                            @error('name')
                            <span style="color:red">{{$message}}</span>
                            @enderror
                            <input type="text" class="form-control" name = "name" placeholder="Họ và tên khách hàng" value="{{old('name')}}">
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <div class="col-md-3">
                            <label for="">Email</label>
                        </div>
                        <div class="col-md-9">
                            @error('email')
                            <span style="color:red">{{$message}}</span>
                            @enderror
                            <input type="text" class="form-control" name = "email" placeholder="Hòm thư điện tử"  value="{{old('email')}}">
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <div class="col-md-3">
                            <label for="">Số điện thoại</label>
                        </div>
                        <div class="col-md-9">
                            @error('phone')
                            <span style="color:red">{{$message}}</span>
                            @enderror
                            <input type="text" class="form-control" name = "phone" placeholder="Số điện thoại"  value="{{old('phone')}}">
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <div class="col-md-3">
                            <label for="">Số nhà</label>
                        </div>
                        <div class="col-md-9">
                            @error('no')
                            <span style="color:red">{{$message}}</span>
                            @enderror
                            <input type="text" class="form-control" name = "no" placeholder="Số nhà"  value="{{old('no')}}">
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <div class="col-md-3">
                            <label for="">Đường/Phố</label>
                        </div>
                        <div class="col-md-9">
                            @error('street')
                            <span style="color:red">{{$message}}</span>
                            @enderror
                            <input type="text" class="form-control" name = "street" placeholder="Đường/Phố/Xóm"  value="{{old('street')}}">
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <div class="col-md-3">
                            <label for="">Xã/Phường</label>
                        </div>
                        <div class="col-md-9">
                            @error('ward')
                            <span style="color:red">{{$message}}</span>
                            @enderror
                            <input type="text" class="form-control" name = "ward" placeholder="Xã/Phường/Thị trấn"  value="{{old('ward')}}">
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <div class="col-md-3">
                            <label for="">Quận/Huyện</label>
                        </div>
                        <div class="col-md-9">
                            @error('district')
                            <span style="color:red">{{$message}}</span>
                            @enderror
                            <input type="text" class="form-control" name = "district" placeholder="Quận/Huyện"  value="{{old('district')}}">
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <div class="col-md-3">
                            <label for="">Tỉnh/Thành phố</label>
                        </div>
                        <div class="col-md-9">
                            @error('city')
                            <span style="color:red">{{$message}}</span>
                            @enderror
                            <input type="text" class="form-control" name = "city" placeholder="Tỉnh/Thành phố"  value="{{old('city')}}">
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i>
                            Thêm
                        </button>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endsection
