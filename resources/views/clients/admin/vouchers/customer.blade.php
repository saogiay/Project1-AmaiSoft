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
    @include('clients.admin.flash-message')
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="row">
            <div class="col-md-2 d-flex justify-content-evenly">
                <label for="">Tên voucher: </label>
                <p>{{ $voucher->name }}</p>
            </div>
            <div class="col-md-2 d-flex justify-content-evenly">
                <label for="">Mã giảm giá: </label>
                <p>{{ $voucher->code }}</p>
            </div>
            <div class="col-md-2 d-flex justify-content-evenly">
                <label for="">Số lượng còn lại: </label>
                <p>{{ $voucher->quantity }}</p>
            </div>
            <div class="col-md-2 d-flex justify-content-evenly">
                <label for="">Giảm giá: </label>
                <p>{{ $voucher->discount }}</p>
            </div>
            <div class="col-md-2 d-flex justify-content-evenly">
                <label for="">Trạng thái: </label>
                <p>{{ $voucher->available ? "Đã kích hoạt" : "Chưa kích hoạt" }}</p>
            </div>
            <div class="col-md-2 d-flex justify-content-evenly">
                <button type="button" class="btn btn-success send-voucher" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop" data-id="{{ $voucher->id }}"
                    data-multi="{{ $voucher->allow_multi }}" data-avai="{{ $voucher->available }}">
                    Tặng mã giảm giá
                </button>
            </div>

        </div>
    </div>
    @if (count($customers) > 0)
    <div class="col-md-8 m-auto">
        <table class="table table-hover">
            <tr class="table-info">
                <th>
                    ID
                </th>
                <th>
                    Tên
                </th>
                <th>
                    Số điện thoại
                </th>
                <th>
                    Email
                </th>
                <th>
                    Địa chỉ
                </th>
                <th>
                    Số lần dùng
                </th>
            </tr>
            @foreach ($customers as $customer)
            <tr>
                <td>
                    {{ $customer->id }}
                </td>
                <td>
                    {{ $customer->name }}
                </td>
                <td>
                    {{ $customer->phone }}
                </td>
                <td>
                    {{ $customer->email }}
                </td>
                <td>
                    {{ $customer->address }}
                </td>
                <td>
                    {{ $customer->solan }}
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif
</div>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content w-100">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Chọn khách hàng</h5>
            </div>
            <div class="modal-body">
                <form action="" id="users_table" method="POST">
                    @csrf
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Chọn</th>
                                <th>Tên</th>
                                <th>Số điện thoai</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody id="render">
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close">Đóng</button>
                <button onclick="send()" type="button" form="users_table" class="btn btn-primary">Tặng</button>
            </div>
        </div>
    </div>
</div>
<script>
    let x;
        $('.send-voucher').click(function() {
            x = $(this).data("id");
            let allow_multi = $(this).data("multi");
            let available = $(this).data("avai");
            $.ajax({
                url: "{{ route('admin.get_availabe_recipient') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    allow_multi: allow_multi,
                    available : available,
                    voucher_id: x
                },
                success: function(data) {
                    var str = "";
                    if (data.error == false) {
                        for (let i = 0; i < data.customers.length; i++) {
                            str += '<tr><td><div class="form-check">';
                            str +=
                                '<input class="form-check-input" type="checkbox" name="list_check[]" value="' +
                                data.customers[i]['id'] + '">';
                            str += '</div></td>';
                            str += '<td>' + data.customers[i]['name'] + '</td>';
                            str += '<td>' + data.customers[i]['phone'] + '</td>';
                            str += '<td>' + data.customers[i]['email'] + '</td>';
                        }
                    } else str = data.message;
                    $("#render").html(str);
                }
            });

    });

        function send() {
            var checked = [];
            $("input[type=checkbox]").each(function() {
                var self = $(this);
                if ($(this).is(':checked')) {
                    checked.push(self.val());
                }
            });
            $.ajax({
                url: '{{ route('admin.give_voucher_by_user') }}',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    voucher_id: x,
                    checked: checked
                },
                success: function(rs) {
                    alert(rs.message);
                    location.reload();
                }
            })
        }
</script>
@endsection