@extends('navbar')

@section('content')
    <div class="top-navbar">
        <div class="dashboard-header">
            <h1>Create New Notice</h1>
        </div>
    </div>

    <div class="content-area">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Notice Information</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.notices.store') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Notice Title *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Notice Content *</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                          id="content" name="content" rows="6" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="expires_at" class="form-label">Expiration Date (Optional)</label>
                                <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror" 
                                       id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                                @error('expires_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Leave empty if the notice should not expire.</div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Create Notice</button>
                                <a href="{{ route('admin.notices.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6>Guidelines</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">• Keep the title short and descriptive</li>
                            <li class="mb-2">• Use clear and concise language</li>
                            <li class="mb-2">• Set expiration dates for time-sensitive notices</li>
                            <li class="mb-2">• Notices will appear on the dashboard for all users</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
