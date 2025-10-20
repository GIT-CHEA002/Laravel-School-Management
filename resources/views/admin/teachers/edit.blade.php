@extends('navbar')
@section('contect')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Teacher
    </h2>
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Teacher Name --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name"
                                       value="{{ old('name', $teacher->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Teacher Email --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email"
                                       value="{{ old('email', $teacher->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Password --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password"
                                       placeholder="Leave blank to keep current password">
                                <div class="form-text">Leave blank to keep the current password</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password"
                                       class="form-control"
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>

                    {{-- Teacher Subject or Department --}}
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text"
                               class="form-control @error('department') is-invalid @enderror"
                               id="department" name="department"
                               value="{{ old('department', $teacher->department ?? '') }}">
                        @error('department')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Teacher</button>
                        <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn btn-info">View Profile</a>
                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

                {{-- Danger Zone --}}
                <hr class="my-4">

                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Danger Zone</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Once you delete this teacher, there’s no going back. Please confirm before deleting.</p>
                        <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this teacher? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Teacher</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

</body>
</html>
