<table class="table">
    <tr>
        <th>Id</th>
        <th>Email</th>
        <th>Name</th>
        <th>Image</th>
        <th>Action</th>
    </tr>
    @foreach ($data as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->name }}</td>
            <td>
            @if ($item->image != '')
                <img src="/images/{{ $item->image }}" width="200" height="auto" />
            @else
                <img src="/images/avatar.png" width="200" height="200" />
            @endif
            </td>
            <td>
                <button class="btn btn-warning" onClick="show({{ $item->id }})">Edit</button>
                <button class="btn btn-danger" onClick="destroy({{ $item->id }})">Delete</button>
            </td>
        </tr>
    @endforeach
</table>