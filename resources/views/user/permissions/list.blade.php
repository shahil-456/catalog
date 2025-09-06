@foreach ($permissions as $key => $role)
<tr id="roleRow{{ $role->id }}">
    <td>{{ $key + 1 }}</td>
    <td>{{ $role->name }}</td>
    <td>
        <div class="hstack gap-3 flex-wrap">
            <a href="{{ route('user.permission.edit', [$role->id]) }}" class="link-success fs-15">
                <i class="ri-edit-2-line"></i>
            </a>
            <a href="javascript:void(0);" class="link-danger fs-15 deleteRole" data-id="{{ $role->id }}">
                <i class="ri-delete-bin-line"></i>
            </a>
        </div>
    </td>
</tr>
@endforeach
@if ($permissions->hasPages())
<tr>
    <td colspan="4">
        {{ $permissions->links() }}
    </td>
</tr>
@endif
