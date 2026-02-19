@extends('layouts.dashboard')

@section('title', 'Manage Users')

@section('content')
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="fw-semibold">Manage Users</h4>
                <p class="mb-0 text-muted">Search and manage user accounts</p>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.users.index') }}">
                        <div class="row g-2">
                            <div class="col-md-10">
                                <input 
                                    type="text" 
                                    name="search" 
                                    class="form-control" 
                                    placeholder="Search by name or email..." 
                                    value="{{ $search ?? '' }}"
                                >
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ri-search-line me-1"></i>Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Users ({{ $users->total() }})</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle text-nowrap table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="py-3">ID</th>
                                    <th class="py-3">Name</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Admin Status</th>
                                    <th class="py-3">Joined</th>
                                    <th class="py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img 
                                                    src="{{ asset('dashboard/assets/images/users/dummy-avatar.jpg') }}" 
                                                    alt="avatar" 
                                                    class="rounded-circle me-2" 
                                                    width="32" 
                                                    height="32"
                                                >
                                                <span>{{ $user->name }}</span>
                                                @if($user->id === Auth::id())
                                                    <span class="badge bg-info-subtle text-info ms-2">You</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->is_admin)
                                                <span class="badge bg-success-subtle text-success py-1 px-2">
                                                    <i class="ri-shield-check-line me-1"></i>Admin
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary py-1 px-2">
                                                    User
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($user->id !== Auth::id())
                                                <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button 
                                                        type="submit" 
                                                        class="btn btn-sm {{ $user->is_admin ? 'btn-warning' : 'btn-success' }}"
                                                        onclick="return confirm('Are you sure you want to {{ $user->is_admin ? 'revoke' : 'grant' }} admin access for {{ $user->name }}?')"
                                                    >
                                                        <i class="ri-shield-user-line me-1"></i>
                                                        {{ $user->is_admin ? 'Revoke Admin' : 'Make Admin' }}
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted small">Cannot modify own status</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            @if($search)
                                                No users found matching "{{ $search }}"
                                            @else
                                                No users found
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($users->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                            </div>
                            <div>
                                {{ $users->appends(['search' => $search])->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
