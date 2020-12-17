asesm ahmed sgaiobo congrateulation
from hamada diver 
<<<<<<< HEAD

////////////////////////////// hamada date //////////////////////////////////
 @php
$last2year = time() - (2 * 12 * 30 * 24 * 60 * 60);
$start_date = date('Y-m-d', $last2year);
@endphp
<input id='start_date' type="date" name="start_date" id="" class="form-control"
	value="{{ request()->start_date ?? $start_date }}">
////////////////////////////// hamada date //////////////////////////////////
=======
date("mm/dd/yyyy", strtotime($row->license_renew_date))
>>>>>>> dfeebd152bbd6e3ea81fc45aa67adbcf87a9d318
