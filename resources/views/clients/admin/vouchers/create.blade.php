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

        @if (session('msg'))
            <div class="alert alert-success">{{ session('msg') }}</div>
        @endif

        <div class="row">
            <div class="col-md-8 m-auto border rounded p-5 bg-light bg-gradien">
                <form method="POST" action="{{ route('admin.voucher.store') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="mt-3 form-group row">
                        <label class="col-sm-3 col-form-label">Tên:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                placeholder="Nhập tên voucher........">
                            @error('name')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-3 form-group row">
                        <label class="col-sm-3 col-form-label">Mã Giảm Giá: </label>
                        <div class="col-sm-9">
                            <input type="text" name="code" class="form-control" value="{{ old('code') }}"
                                placeholder="Nhập mã giảm giá........">
                            @error('code')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3 form-group row">
                        <label class="col-sm-3 col-form-label">Số lượng: </label>
                        <div class="col-sm-9">
                            <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}"
                                placeholder="Nhập số lượng........">
                            @error('quantity')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3 form-group row">
                        <label class="col-sm-3 col-form-label">Mô tả: </label>
                        <div class="col-sm-9">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="description">{{ old('description') }}</textarea>
                                <label for="floatingTextarea" class="text-secondary">Nhập mô tả</label>
                            </div>
                            @error('description')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3 form-group row">
                        <label class="col-sm-3 col-form-label">Giảm giá: </label>
                        <div class="col-sm-9 ">
                            <div class="d-flex">
                                <input type="number" min="0" max="100" step="0.1" name="discount"
                                    class="form-control" placeholder="Mức giảm giá....." value="{{ old('discount') }}">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                            @error('discount')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3 form-group row">
                        <label class="col-sm-3 col-form-label">Ngày bắt đầu: </label>
                        <div class="col-sm-9">
                            <input type="datetime-local" name="start_day" value="{{ old('start_day') }}"
                                class="form-control" placeholder="Ngày bắt đầu........">
                            @error('start_day')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3 form-group row">
                        <label class="col-sm-3 col-form-label">Ngày hết hạn: </label>
                        <div class="col-sm-9">
                            <input type="datetime-local" name="exp" class="form-control" placeholder="Ngày hết hạn....."
                                value="{{ old('exp') }}">
                            @error('exp')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3 form-group d-flex align-items-center">
                        <label class="col-sm-9 col-form-label">Bạn có muốn voucher này áp dụng nhiều lần cho một người hay
                            không ?</label>
                        <div class="col-sm-3 d-flex mt-1">
                            <div class="form-check me-2">
                                <input class="form-check-input" type="radio" name="allow_multi" id="flexRadioDefault1"
                                    value="1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Có
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="allow_multi" id="flexRadioDefault2"
                                    value="0" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Không
                                </label>
                            </div>
                            @error('allow_multi')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3 text-center pb-3">
                        <button class="btn btn-success" type="reset">Hủy</button>
                        <button class="btn btn-primary" type="submit">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
