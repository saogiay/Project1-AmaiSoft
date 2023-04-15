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
    @include('clients.admin.flash-message')
</div>
<div class="row">
    <div class="col-md-12 mt-5 mb-3">
        <div class="row">
            <div class="col-md-3 d-flex justify-content-evenly">
                <label for="">Tên khách hàng: </label>
                <p>{{ $customer->name }}</p>
            </div>
            <div class="col-md-3 d-flex justify-content-evenly">
                <label for="">Email: </label>
                <p>{{ $customer->email }}</p>
            </div>
            <div class="col-md-2 d-flex justify-content-evenly">
                <label for="">Số điện thoại: </label>
                <p>{{ $customer->phone }}</p>
            </div>
            <div class="col-md-2 d-flex justify-content-evenly">
                <label for="">Số voucher đã nhận: </label>
                <p>{{ count($vouchers) }}</p>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                    data-id="{{ $customer->id }}">
                    <i class="fa-solid fa-scroll"></i>
                    Tặng mã giảm giá
                </button>
            </div>
        </div>
    </div>
    @if (count($vouchers) > 0)
    <div class="col-md-8 m-auto overflow-auto" style="height: 60vh">
        <table class="table table-hover">
            <tr class="table-info">
                <th>
                    ID
                </th>
                <th>
                    Tên voucher
                </th>
                <th>
                    Mã voucher
                </th>
                <th>
                    Trạng thái
                </th>
                <th>
                    Số lần dùng
                </th>
            </tr>
            @foreach ($vouchers as $voucher)
            <tr>
                <td>
                    {{ $voucher->id }}
                </td>
                <td>
                    {{ $voucher->name }}
                </td>
                <td>
                    {{ $voucher->code }}
                </td>
                <td>
                    @if ($voucher->available == 0)
                    <span style="color:red">Ngừng phát hành</span>
                    @else
                    @if ($voucher->start_day > date('Y-m-d H:i:s'))
                    <span style="color:orange">Chưa phát hành</span>
                    @elseif($voucher->exp < date('Y-m-d H:i:s')) <span style="color:red">Đã hết hạn</span>
                        @else
                        <span style="color:blue">Đang kích hoạt</span>
                        @endif
                        @endif
                </td>
                <td>
                    {{ $voucher->solan }}
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="d-block card-footer">
        {{ $vouchers->links() }}
    </div>
    @endif
</div>

<form action="{{ route('admin.give_voucher_by_voucher', $customer->id) }}" method="POST">
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content w-100">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Chọn voucher</h5>
                </div>
                <div class="modal-body">
                    @csrf
                    <table id="vouchers_table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Chọn</th>
                                <th>Tên voucher</th>
                                <th>Mã giảm giá</th>
                                <th>Mức giảm giá(%)</th>
                                <th>Số lần còn lại</th>
                                <th>Ngày áp dụng</th>
                                <th>Ngày hết hạn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="list_voucher[]"
                                            value="{{ $coupon->id }}" id="flexCheckDefault">
                                    </div>
                                </td>
                                <td>
                                    {{ $coupon->name }}
                                </td>
                                <td>
                                    {{ $coupon->code }}
                                </td>
                                <td>
                                    {{ $coupon->discount }}
                                </td>
                                <td>
                                    {{ $coupon->quantity }}
                                </td>
                                <td>
                                    {{ $coupon->start_day }}
                                </td>
                                <td>
                                    {{ $coupon->exp }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close">
                        <i class="fas fa-regular fa-ban"></i>
                        Hủy
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-sharp fa-solid fa-paper-plane"></i>
                        Tặng
                    </button>

                </div>
            </div>
        </div>
    </div>
</form>
@endsection