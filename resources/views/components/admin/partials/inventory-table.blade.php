@foreach($items as $item)
<tr data-id="{{ $item->id }}">
    <td>{{ $item->object_id }}</td>
    <td>{{ \Carbon\Carbon::parse($item->date_purchased)->format('m/d/Y') }}</td>
    <td>{{ $item->supply_type }}</td>
    <td>{{ $item->item_name }}</td>
    <td>{{ $item->quantity }} {{ $item->unit }}</td>
    <td>{{ $item->remarks }}</td>
    <td class="text-center">
        <a href="{{ route('admin.inventory.editPage', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
        <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
        </form>
    </td>   
</tr>
@endforeach
