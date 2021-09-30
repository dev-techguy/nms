<table>
    <thead>
    <tr>
        <td>Case ID</td>
        <td>Alert Mode</td>
        <td>Location</td>
        <td>Sub County</td>
        <td>Alert Nature</td>
        <td>Status</td>
        <td>Date Received</td>
    </tr>
    </thead>
    <tbody>
    @foreach($reports as $report)
        <tr>
            <td>{{ $report->case_number }}</td>
            <td>{{ $report->alert_mode }}</td>
            <td>{{ $report->location }}</td>
            <td>{{ $report->sub_county }}</td>
            <td>{{ $report->alert_nature }}</td>
            <td>{{ $report->status }}</td>
            <td>{{ date('F d, Y h:i a', strtotime($report->updated_at)) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
