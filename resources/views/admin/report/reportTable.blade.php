<table class="table table-striped" dir="rtl">
	<thead>
	<tr>
		<th scope="col">ردیف</th>
		<th scope="col">نام اتحادیه/ نام کارگزار</th>
		<th scope="col">مبلغ <small>(ریال)</small></th>
		<th scope="col">شناسه واریز </th>
		<th scope="col">شماره حساب خدمات حمایتی </th>
		<th scope="col">تاریخ</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
    <?php
    $sumPrice = 0;
    ?>
	@foreach($response as $key => $res)

        <?php

        $sumPrice += $res->price;
        ?>
		<tr>
			<th scope="row">{{ $key + 1 }}</th>
			<th >{{ $res->name}}/{{$res->company}}</th>
			<td>{{$res->price}}</td>
			<td>3450397558263500650000000000001 </td>
			<td>ir250100004001039704005791</td>
			<td>{{ date('d-m-Y', strtotime($res->tarikh))}}</td>
		</tr>
	@endforeach

	<tr>
		<th scope="row"></th>
		<th ></th>
		<td>
            {{ $sumPrice }}</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th ></th>
		<td>T</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	</tbody>
</table>

