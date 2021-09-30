<table class="table table-sm w-100 pb-30">
    <thead>
        <tr>
            <th>#</th>
            <th>Case ID</th>
            <th>Date Received</th>
            <th>Mode</th>
            <th>Location</th>
            <!--<th>Alert Nature</th>
            <th>Chief Complaint</th>-->
            <th>Watcher</th>
            <th>Dispatcher</th>
            <th>Status</th>
            <th>TAT</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{ $item->case_number }}</td>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->alert_mode }}</td>
            <td>{{ $item->location }}</td>
            <!--<td>{{ $item->alert_nature }}</td>
            <td>{{ $item->chief_complaint }}</td>-->
            <td>{{ $item->watcher->name }}</td>
            <td>{{ $item->dispatcher->name }}</td>
            <td>
                @if ($item->status == 'submitted')
                <span class="badge badge-warning">Pending</span>
                @elseif ($item->status == 'dispatch_handling')
                <span class="badge badge-info">{{ $item->status }}</span>
                @elseif ($item->status == 'dispatched')
                <span class="badge badge-primary">{{ $item->status }}</span>
                @elseif ($item->status == 'resolved')
                <span class="badge badge-success">{{ $item->status }}</span>
                @else
                <span class="badge badge-secondary">{{ $item->status }}</span>
                @endif
            </td>
            <td>
                @if ($item->status == 'resolved')
                {{ $item->created_at->diffForHumans($item->updated_at, true) }}
                @else
                N/A
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>

</table>