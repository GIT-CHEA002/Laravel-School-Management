@extends('navbar')

@section('content')
    <div class="top-navbar">
        <div class="dashboard-header">
            <h1>Edit Notice</h1>
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
                        <form method="POST" action="{{ route('admin.notices.update', $notice) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Notice Title *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $notice->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Notice Content *</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                          id="content" name="content" rows="6" required>{{ old('content', $notice->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="expires_at" class="form-label">Expiration Date</label>
                                <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror" 
                                       id="expires_at" name="expires_at" value="{{ old('expires_at', $notice->expires_at?->format('Y-m-d\TH:i')) }}">
                                @error('expires_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Leave empty if the notice should not expire.</div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                           value="1" {{ old('is_active', $notice->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active Notice
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update Notice</button>
                                <a href="{{ route('admin.notices.show', $notice) }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6>Notice Details</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Created:</strong> {{ $notice->created_at->format('M d, Y H:i') }}</p>
                        <p><strong>Created by:</strong> {{ $notice->creator->name }}</p>
                        @if($notice->expires_at)
                            <p><strong>Expires:</strong> {{ $notice->expires_at->format('M d, Y H:i') }}</p>
                        @endif
                        <p><strong>Status:</strong> 
                            @if($notice->isExpired())
                                <span class="badge bg-danger">Expired</span>
                            @elseif($notice->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
