@extends('layout.index')
@section('home')

<div class="container my-5">
    <h3 class="text-center">Monthly Attendance Report</h3>
    <p class="text-center">{{ \Carbon\Carbon::create($year, $month)->format('F Y') }}</p>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <form action="{{ route('attendance-report.index') }}" method="GET" class="d-flex gap-2">
            <select name="month" class="form-select" required>
                @foreach(range(1, 12) as $m)
                <option value="{{ $m }}" @if($m == $month) selected @endif>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                @endforeach
            </select>
            <select name="year" class="form-select" required>
                @foreach(range(date('Y') - 5, date('Y') + 1) as $y)
                <option value="{{ $y }}" @if($y == $year) selected @endif>{{ $y }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <div>
            <button class="btn btn-success">CSV</button>
            <button class="btn btn-info">Excel</button>
            <button class="btn btn-primary" id="printBtn"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>

    <table class="table table-bordered">
    <thead class="table-primary">
        <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Total Days [Worked Days]</th>
            <th>Total Hours</th>
        </tr>
    </thead>
    <tbody>
        @foreach($attendanceReport as $key => $data)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $data['name'] }}</td>
            <td>{{ $data['daysWorked'] }} out of {{ $data['totalDaysInMonth'] }} days</td>
            <td>{{ $data['totalHours'] }} hours</td>
        </tr>
        @endforeach
    </tbody>
</table>


    <div class="d-flex justify-content-between align-items-center">
        <span>Showing {{ count($attendanceReport) }} entries</span>
        <nav>
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>
<script>
    document.getElementById('printBtn').addEventListener('click', function () {
        window.print();
    });
</script>

@endsection
