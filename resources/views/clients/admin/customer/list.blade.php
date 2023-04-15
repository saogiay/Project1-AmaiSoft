@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <p class="h3 text-center">{{$title}}</p>
    <div class="row">
        <div class="col-md-12 mb-3">
            <form action="">
                <div class="row">
                    <div class="col-md-12 mt-3 d-flex justify-content-between align-items-center">
                        <div class="col-4 mb-3 d-flex align-items-center">
                            <label class="col-4" for="">Sắp xếp:</label>
                            <select name="sort_by" class="form-select" onchange="this.form.submit();" class="sorting">
                                <option {{ request('sort_by')=='latest' ? 'selected' : '' }} value="latest">
                                    Ngày thêm ▼</option>
                                <option {{ request('sort_by')=='oldest' ? 'selected' : '' }} value="oldest">
                                    Ngày thêm ▲</option>
                                <option {{ request('sort_by')=='name-accending' ? 'selected' : '' }}
                                    value="name-accending">
                                    Tên A → Z</option>
                                <option {{ request('sort_by')=='name-descending' ? 'selected' : '' }}
                                    value="name-descending">
                                    Tên Z → A</option>
                                <option {{ request('sort_by')=='update-descending' ? 'selected' : '' }}
                                    value="update-descending">
                                    Ngày cập nhật ▼</option>
                                <option {{ request('sort_by')=='update-ascending' ? 'selected' : '' }}
                                    value="update-ascending">
                                    Ngày cập nhật ▲</option>
                            </select>
                        </div>
                        <div class="col-4 mb-3 d-flex align-items-center">
                            <label class="col-4" for="">Hiển thị:</label>
                            <select class="form-select" name="show" onchange="this.form.submit();" class="p-show">
                                <option {{ request('show')=='9' ? 'selected' : '' }} value="9">
                                    9
                                </option>
                                <option {{ request('show')=='15' ? 'selected' : '' }} value="15">
                                    15
                                </option>
                                <option {{ request('show')=='30' ? 'selected' : '' }} value="30">
                                    30
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('admin.customer.create') }}" type="button" class="btn btn-success">
                                <i class="fas fa-user-plus"></i>
                                Thêm khách hàng mới
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <div class="col-md-4 mb-3 d-flex align-items-center">
                            <label class="col-4">Họ tên:</label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập tên khách hàng"
                                value="{{ request('name') }}">
                        </div>
                        <div class="col-md-4 mb-3 d-flex align-items-center">
                            <label class="col-4">Email hoặc SDT:</label>
                            <input type="text" name="contact" class="form-control"
                                placeholder="Nhập email hoặc số điện thoại" value="{{ request('contact') }}">
                        </div>
                        <div class="col-4 text-right">
                            <button type="submit" class="btn btn-outline-success">
                                <i class="fas fa-filter"></i>
                                Lọc kết quả
                            </button>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
    @include('clients.admin.flash-message')
    <div class="col-md-12 overflow-auto" style="height: 58vh">
        <table class="table table-striped table-hover">
            <thead>
                <tr class="bg-info bg-opacity-25">
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Cập nhật lúc</th>
                    <th>Cập nhật bởi</th>
                    <th style="width: 15%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $key => $customer)
                <tr>
                    <td>
                        {{ $key + 1}}
                    </td>
                    <td>
                        {{ $customer->name }}
                    </td>
                    <td>
                        {{ $customer->email }}
                    </td>
                    <td>
                        {{ $customer->phone }}
                    </td>
                    <td>
                        {{ $customer->address }}
                    </td>
                    <td>
                        {{ $customer->created_at }}
                    </td>
                    <td>
                        {{ $customer->admin->name }}
                    </td>
                    <td>
                        <a href="{{ route('admin.customer.edit', $customer->id) }}" type="button" class="btn btn-info">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <form class="d-inline" action="{{ route('admin.customer.destroy', $customer->id) }}"
                            method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Xóa cái này ?')">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                        <a href="{{ route('admin.customer.show', $customer->id) }}" type="button"
                            class="btn btn-success">
                            <i class="fa-solid fa-gift"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-block card-footer">
        {{ $customers->links() }}
    </div>
</div>
</div>
@endsection
