@extends('admin_layout_view')
@section('admin_content')
<p> Nội dung dashboard </p>
<!-- tasks -->
<div class="agile-last-grids">
	<div class="col-md-4 agile-last-left">
		<div class="agile-last-grid">
			<div class="area-grids-heading">
				<h3>Tháng</h3>
			</div>
			<div id="graph7"></div>
			<script>
			// This crosses a DST boundary in the UK.
			Morris.Area({
			  element: 'graph7',
			  data: [
				{x: '2013-03-30 22:00:00', y: 3, z: 3},
				{x: '2013-03-31 00:00:00', y: 2, z: 0},
				{x: '2013-03-31 02:00:00', y: 0, z: 2},
				{x: '2013-03-31 04:00:00', y: 4, z: 4}
			  ],
			  xkey: 'x',
			  ykeys: ['y', 'z'],
			  labels: ['Y', 'Z']
			});
			</script>

		</div>
	</div>
	<div class="col-md-4 agile-last-left agile-last-middle">
		<div class="agile-last-grid">
			<div class="area-grids-heading">
				<h3>Ngày</h3>
			</div>
			<div id="graph8"></div>
			<script>
			/* data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type */
			var day_data = [
			  {"period": "2016-10-01", "licensed": 3407, "sorned": 660},
			  {"period": "2016-09-30", "licensed": 3351, "sorned": 629},
			  {"period": "2016-09-29", "licensed": 3269, "sorned": 618},
			  {"period": "2016-09-20", "licensed": 3246, "sorned": 661},
			  {"period": "2016-09-19", "licensed": 3257, "sorned": 667},
			  {"period": "2016-09-18", "licensed": 3248, "sorned": 627},
			  {"period": "2016-09-17", "licensed": 3171, "sorned": 660},
			  {"period": "2016-09-16", "licensed": 3171, "sorned": 676},
			  {"period": "2016-09-15", "licensed": 3201, "sorned": 656},
			  {"period": "2016-09-10", "licensed": 3215, "sorned": 622}
			];
			Morris.Bar({
			  element: 'graph8',
			  data: day_data,
			  xkey: 'period',
			  ykeys: ['licensed', 'sorned'],
			  labels: ['Licensed', 'SORN'],
			  xLabelAngle: 60
			});
			</script>
		</div>
	</div>
	<div class="col-md-4 agile-last-left agile-last-right">
		<div class="agile-last-grid">
			<div class="area-grids-heading">
				<h3>Năm</h3>
			</div>
			<div id="graph9"></div>
			<script>
			var day_data = [
			  {"elapsed": "I", "value": 34},
			  {"elapsed": "II", "value": 24},
			  {"elapsed": "III", "value": 3},
			  {"elapsed": "IV", "value": 12},
			  {"elapsed": "V", "value": 13},
			  {"elapsed": "VI", "value": 22},
			  {"elapsed": "VII", "value": 5},
			  {"elapsed": "VIII", "value": 26},
			  {"elapsed": "IX", "value": 12},
			  {"elapsed": "X", "value": 19}
			];
			Morris.Line({
			  element: 'graph9',
			  data: day_data,
			  xkey: 'elapsed',
			  ykeys: ['value'],
			  labels: ['value'],
			  parseTime: false
			});
			</script>

		</div>
	</div>
	<div class="clearfix"> </div>
</div>
<!-- //tasks -->
<div class="agil-info-calendar">
	<!-- calendar -->
	<div class="col-md-6 agile-calendar">
		<div class="calendar-widget">
	        <div class="panel-heading ui-sortable-handle">
				<span class="panel-icon">
	              <i class="fa fa-calendar-o"></i>
	            </span>
	            <span class="panel-title"> Calendar Widget</span>
	        </div>
			<!-- grids -->
				<div class="agile-calendar-grid">
					<div class="page">
						
						<div class="w3l-calendar-left">
							<div class="calendar-heading">
								
							</div>
							<div class="monthly" id="mycalendar"></div>
						</div>
						
						<div class="clearfix"> </div>
					</div>
				</div>
		</div>
	</div>
</div>
<!-- //calendar -->	
@endsection