<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Administrator ID</th>
        <th>Administrator</th>
        <th>User Access ID</th>
        <th>User Access</th>
        <th>Created At</th>
        <th>Confirmed</th>
    </tr>
    </thead>
    <tbody>
        @foreach($access as $item)
            <tr>
                <th>{{ $item->id }}</th>
                <td>{{ $item->users_admin_all->id }} </td>
                <td>{{ $item->users_admin_all->firstname }} {{ $item->users_admin_all->middlename }} {{ $item->users_admin_all->lastname }}</td>
                <td>{{ $item->users_access_all->id }}</td>
                <td>{{ $item->users_access_all->firstname }} {{ $item->users_access_all->middlename }} {{ $item->users_access_all->lastname }}</td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->confirmed ? 'TRUE' : 'FALSE' }}</td>
            </tr>

        @endforeach
    </tbody>
</table>
