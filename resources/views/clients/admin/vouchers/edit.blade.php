@extends('layouts.admin')

@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="container-fluid">
        <a href="{{ route('admin.voucher.index') }}" type="button" class="btn btn-secondary">
            <i class="fa-solid fa-circle-left"></i>
            Quay lại
        </a>
        <p class="h3 text-center">{{$title}}</p>

        <div class="row">
            <div class="col-md-8 m-auto border rounded p-5 bg-light bg-gradien">
                @if (session('msg'))
                <div class="alert alert-success text-center">{{ session('msg') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger text-center msg">Dữ liệu nhập không hợp lệ. Vui lòng kiểm tra lại
                    {{ session('msg') }}</div>
            @endif
                <form method="POST" action="{{ route('admin.voucher.update',$voucher->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mt-5 form-group row">
                        <label class="col-sm-3 col-form-label">Tên:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" value="{{$voucher->name}}"
                                placeholder="Nhập tên voucher........">
                            @error('name')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-5 form-group row">
                        <label class="col-sm-3 col-form-label">Mã Giảm Giá: </label>
                        <div class="col-sm-9">
                            <input type="text" name="code" class="form-control" value="{{$voucher->code}}"
                                placeholder="Nhập mã giảm giá........">
                            @error('code')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5 form-group row">
                        <label class="col-sm-3 col-form-label">Số lượng: </label>
                        <div class="col-sm-9">
                            <input type="number" name="quantity" class="form-control" value="{{$voucher->quantity}}"
                                placeholder="Nhập số lượng........">
                            @error('quantity')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5 form-group row">
                        <label class="col-sm-3 col-form-label">Mô tả: </label>
                        <div class="col-sm-9">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="description">{{$voucher->description}}</textarea>
                                <label for="floatingTextarea" class ="text-secondary">Nhập mô tả</label>
                            </div>
                            @error('description')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5 form-group row">
                        <label class="col-sm-3 col-form-label">Giảm giá: </label>
                        <div class="col-sm-9">
                            <div class="d-flex">
                                <input type="number" min="0" max="100" step="0.1" name="discount" class="form-control" value="{{$voucher->discount}}" placeholder="Mức giảm giá.....">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                            @error('discount')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5 form-group row">
                        <label class="col-sm-3 col-form-label">Ngày bắt đầu: </label>
                        <div class="col-sm-9">
                            <input type="datetime-local" name="start_day" value="{{$voucher->start_day}}" class="form-control"
                                placeholder="Ngày bắt đầu........">
                            @error('start_day')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5 form-group row">
                        <label class="col-sm-3 col-form-label">Ngày hết hạn: </label>
                        <div class="col-sm-9">
                            <input type="datetime-local" name="exp" class="form-control" value="{{$voucher->exp}}">
                            @error('exp')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5 form-group d-flex align-items-center">
                        <label class="col-sm-8 col-form-label">Trạng thái của Voucher</label>
                        <div class="col-sm-4 d-flex mt-1">
                            <div class="form-check me-2">
                                <input class="form-check-input" type="radio" name="available" id="flexRadioDefault1" value="0" {{$voucher->available ==0?'checked':false}}>
                                <label class="form-check-label" for="flexRadioDefault1">
                                  Không kích hoạt
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="available" id="flexRadioDefault2" value="1" {{$voucher->available ==1?'checked':false}}>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Kích hoạt
                                </label>
                              </div>
                            @error('available')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5 form-group d-flex align-items-center">
                        <label class="col-sm-9 col-form-label">Bạn có muốn voucher này áp dụng nhiều lần cho một người hay
                            không ?</label>
                        <div class="col-sm-3 d-flex mt-1">
                            <div class="form-check me-2">
                                <input class="form-check-input" type="radio" name="allow_multi" id="flexRadioDefault1" value="1" {{$voucher->allow_multi ==1?'checked':false}}>
                                <label class="form-check-label" for="flexRadioDefault1">
                                  Có
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="allow_multi" id="flexRadioDefault2" value="0" {{$voucher->allow_multi ==0?'checked':false}}>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Không
                                </label>
                              </div>
                            @error('allow_multi')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5 text-center pb-3">
                        <button class="btn btn-success" type="reset">Hủy</button>
                        <button class="btn btn-primary" type="submit">Sửa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
