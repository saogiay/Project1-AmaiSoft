<h1> Booyah!! Bạn được tặng mã giảm giá của CDC-AMAI nè...</h1>

@if ($collection)

@foreach ($vouchers as $voucher)
<p> Voucher: {{ $voucher->name }}</p>
<p> Code: {{ $voucher->code }}</p>
<p> Mô tả: {{ $voucher->description }}</p>
<p>Ngày sử dụng {{ $voucher->start_day }}</p>
<p>Hạn sử dụng {{ $voucher->exp }}</p>
<hr>
@endforeach

@else
<p> Voucher: {{ $vouchers->name }}</p>
<p> Code: {{ $vouchers->code }}</p>
<p> Mô tả: {{ $vouchers->description }}</p>
<p>Ngày sử dụng {{ $vouchers->start_day }}</p>
<p>Hạn sử dụng {{ $vouchers->exp }}</p>
@endif