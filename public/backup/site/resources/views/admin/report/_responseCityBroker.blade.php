<table class="table table-striped">
	<thead>
		<tr>
			<th scope="col">ردیف</th>
			<th scope="col">نام کارگزار</th>
			<th scope="col">نام شرکت</th>
			<th scope="col">شهرستان</th>
			<th scope="col">عنوان کود</th>
			<th scope="col">تعداد درخواست <small>(کیسه 50 کیلویی)</small></th>
			<th scope="col">تعداد کشاورز</th>
			<th scope="col">سطح زیر کشت</th>
			<th scope="col">مقدار درخواست <small>(تن)</small></th>
			<th scope="col">مبلغ <small>(ریال)</small></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$sumKise = 0; 
		$sumVal = 0;
		$sumPrice = 0;
		$sumKeshavarz = 0;
		$sumZamin = 0;
		?>
		@foreach($response as $key => $res)
		<?php 
		$sumKise += $res->kise; 
		$sumVal += $res->tone;
		$sumPrice += $res->price;
		$sumKeshavarz += $res->keshavarz;
		$sumZamin += $res->sathZirKesht;
		?>
		<tr>
			<th scope="row">{{ $key + 1 }}</th>
			<th >{{ ($ch == 0)?$res->name:"همه کارگزارها" }}</th>
			<td>{{ ($ch == 0)?$res->company:"" }}</td>
			<td>{{ ($ch == 0)?$res->city:"" }}</td>
			<td>{{ $res->title }}</td>
			<td>{{ number_format($res->kise) }}</td>
			<td>{{ $res->keshavarz }}</td>
			<td>{{ number_format($res->sathZirKesht,1) }}</td>
			<td>{{ number_format($res->tone,2) }}</td>
			<td>{{ number_format($res->price) }}</td>
			<td>
				@if($ch == 0)
				<a href="#{{ $res->id }}" onClick="showuser({{ $res->id }})" title="مشاهده بهره برداران"><i class="fas fa-eye text-dark"></i></i></a>
				@endif
			</td>
		</tr>
		@endforeach
		
		<tr>
			<th scope="row" class="font-weight-bold">مجموع</th>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td class="font-weight-bold">{{ number_format($sumKise) }}</td>
			<td class="font-weight-bold">{{ number_format($sumKeshavarz) }}</td>
			<td class="font-weight-bold">{{ number_format($sumZamin,1) }}</td>
			<td class="font-weight-bold">{{ number_format($sumVal,2) }}</td>
			<td class="font-weight-bold">{{ number_format($sumPrice) }}</td>
			<td class="font-weight-bold"></td>
		</tr>
	</tbody>
</table>