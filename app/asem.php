asesm ahmed sgaiobo congrateulation
from hamada diver 

////////////////////////////// hamada date //////////////////////////////////
 @php
$last2year = time() - (2 * 12 * 30 * 24 * 60 * 60);
$start_date = date('Y-m-d', $last2year);
@endphp
<input id='start_date' type="date" name="start_date" id="" class="form-control"
	value="{{ request()->start_date ?? $start_date }}">
////////////////////////////// hamada date //////////////////////////////////