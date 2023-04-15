@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <p class="h3 text-center">{{$title}}</p>
    <form action="">
        <div class="select-option">
            <div class="row">
                <div class="col-sm-3 form-group row">
                    <label for="" class="col-form-label col-sm-4">Sắp xếp:</label>
                    <div class="col-sm-8">
                        <select name="sort_by" class="form-select" onchange="this.form.submit();" class="sorting">
                            <option {{ request('sort_by')=='latest' ? 'selected' : '' }} value="latest">
                                Ngày thêm ▼</option>
                            <option {{ request('sort_by')=='oldest' ? 'selected' : '' }} value="oldest">
                                Ngày thêm ▲</option>
                            <option {{ request('sort_by')=='name-accending' ? 'selected' : '' }} value="name-accending">
                                Tên A → Z</option>
                            <option {{ request('sort_by')=='name-descending' ? 'selected' : '' }}
                                value="name-descending">
                                Tên Z → A</option>
                            <option {{ request('sort_by')=='code-accending' ? 'selected' : '' }} value="code-accending">
                                Mã A → Z</option>
                            <option {{ request('sort_by')=='code-descending' ? 'selected' : '' }}
                                value="code-descending">
                                Mã Z → A</option>
                            <option {{ request('sort_by')=='quantity-accending' ? 'selected' : '' }}
                                value="quantity-accending">
                                Số lượng ▲</option>
                            <option {{ request('sort_by')=='quantity-descending' ? 'selected' : '' }}
                                value="quantity-descending">
                                Số lượng ▼</option>
                            <option {{ request('sort_by')=='exp-descending' ? 'selected' : '' }} value="exp-descending">
                                Ngày hết hạn ▼</option>
                            <option {{ request('sort_by')=='exp-ascending' ? 'selected' : '' }} value="exp-ascending">
                                Ngày hết hạn ▲</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3 form-group row">
                    <label for="" class="col-form-label col-sm-4">Hiển thị:</label>
                    <div class="col-sm-8">
                        <select class="form-select" name="show" onchange="this.form.submit();" class="p-show">
                            <option {{ request('show')=='9' ? 'selected' : '' }} value="9"> 9
                            </option>
                            <option {{ request('show')=='15' ? 'selected' : '' }} value="15"> 15
                            </option>
                            <option {{ request('show')=='30' ? 'selected' : '' }} value="30"> 30
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 d-flex justify-content-left">
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-outline-success">
                            <i class="fas fa-filter"></i>
                            Lọc kết quả
                        </button>
                    </div>
                    <div class="col">
                        <a href="{{ route('admin.voucher.create') }}" type="button" class="btn btn-success">
                            <i class="fa-solid fa-ticket"></i>
                            Thêm voucher
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="filter container-fluid mt-3">
            <div class="row">
                <div class="col-sm-3 form-group row ">
                    <label class="col-form-label col-sm-4">Tên: </label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" name="name" value="{{ request('name') }}"
                            placeholder="Nhập tên...">
                    </div>
                </div>

                <div class="col-sm-3 form-group row ">
                    <label class="col-form-label col-sm-4">Mã: </label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" name="code" value="{{ request('code') }}"
                            placeholder="Nhập mã...">
                    </div>
                </div>

                <div class="col-sm-3 d-flex justify-content-between">
                    <label class="col-form-label col-5">Ngày hết hạn: </label>
                    <input class="form-control" type="date" name="exp" value="{{ request('exp') }}">
                </div>

                <div class="col-sm-3 d-flex justify-content-between2">
                    <label class="col-form-label col-5">Ngày tạo: </label>
                    <input class="form-control" type="date" name="created_at" value="{{ request('created_at') }}">
                </div>
            </div>
        </div>
    </form>
    @include('clients.admin.flash-message')
    <div class="col-md-12 overflow-auto" style="height: 58vh">
        <table class="table table-striped table-hover text-center">
            <thead>
                <tr class="bg-info bg-opacity-25">
                    <th>STT</th>
                    <th>Tên voucher</th>
                    <th>Mã giảm giá</th>
                    <th>Số lượng</th>
                    <th>Mô tả</th>
                    <th>Giảm giá(theo %)</th>
                    <th>Ngày áp dụng</th>
                    <th>Ngày hết hạn</th>
                    <th>Trạng Thái</th>
                    <th>Sử dụng nhiều lần</th>
                    <th style="width: 15%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vouchers as $key => $voucher)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $voucher->name }}</td>
                    <td>{{ $voucher->code }}</td>
                    <td>{{ $voucher->quantity }}</td>
                    <td>{{ $voucher->description }}</td>
                    <td>{{ $voucher->discount }}%</td>
                    <td>{{ $voucher->start_day }}</td>
                    <td>{{ $voucher->exp }}</td>
                    <td>
                        @if ($voucher->available == 0)
                        <p style="color:red">Ngừng phát hành</p>
                        @else
                        @if ($voucher->start_day > date('Y-m-d H:i:s'))
                        <p style="color:orange">Chưa phát hành</p>
                        @elseif($voucher->exp < date('Y-m-d H:i:s')) <p style="color:red">Đã hết hạn</p>
                            @else
                            <p style="color:blue">Đang kích hoạt</p>
                            @endif
                            @endif
                    </td>
                    @if ($voucher->allow_multi == 0)
                    <td>Không</td>
                    @else
                    <td>Có</td>
                    @endif
                    <td>
                        <div class="container">
                            <a href="{{ route('admin.voucher.edit', $voucher->id) }}" type="button"
                                class="btn btn-info">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            <form class="d-inline" action="{{ route('admin.voucher.destroy', $voucher->id) }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Xóa cái này ?')">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.voucher.show', $voucher->id) }}" type="button"
                                class="btn btn-success">
                                <i class="fa-solid fa-gift"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-block card-footer">
        {{ $vouchers->links() }}
    </div>
</div>
@endsection
