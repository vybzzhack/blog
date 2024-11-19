{{-- resources/views/admin/users.blade.php --}}

@foreach($users as $user)
    <div>
        <span>{{ $user->name }} ({{ $user->role }})</span>
        
        @if($user->role !== 'admin')
            <form action="{{ route('admin.makeAdmin', $user->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit">Make Admin</button>
            </form>
        @endif
    </div>
@endforeach

{{-- resources/views/admin/users.blade.php --}}

@foreach ($users as $user)
    <div>
        <span>{{ $user->name }} (Current Role: {{ $user->role }})</span>

        <form action="{{ route('admin.changeRole', $user->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <select name="role">
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <button type="submit">Change Role</button>
        </form>
    </div>
@endforeach
