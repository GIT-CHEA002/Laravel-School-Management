@extends('navbar')

@section('content')
    <div class="top-navbar">
        <div class="dashboard-header">
            <h1>{{ $notice->title }}</h1>
        </div>
    </div>

    <div class="content-area">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Notice Details</h5>
                        <div>
                            <span class="badge 
                                @if($notice->isExpired())
                                    bg-danger
                                @elseif($notice->is_active)
                                    bg-success
                                @else
                                    bg-secondary
                                @endif">
                                @if($notice->isExpired())
                                    Expired
                                @elseif($notice->is_active)
                                    Active
                                @else
                                    Inactive
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h4>{{ $notice->title }}</h4>
                            <div class="text-muted small mb-3">
                                Created by {{ $notice->creator->name }} on {{ $notice->created_at->format('M d, Y \a\t H:i') }}
                                @if($notice->expires_at)
                                    • Expires on {{ $notice->expires_at->format('M d, Y \a\t H:i') }}
                                @endif
                            </div>
                        </div>

                        <div class="notice-content">
                            {!! nl2br(e($notice->content)) !!}
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.notices.edit', $notice) }}" class="btn btn-warning">Edit Notice</a>
                            <form method="POST" action="{{ route('admin.notices.destroy', $notice) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this notice?')">Delete Notice</button>
                            </form>
                            <a href="{{ route('admin.notices.index') }}" class="btn btn-secondary">Back to Notices</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6>Notice Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>ID:</strong> {{ $notice->id }}
                        </div>
                        <div class="mb-3">
                            <strong>Created:</strong><br>
                            {{ $notice->created_at->format('M d, Y') }}<br>
                            <small class="text-muted">{{ $notice->created_at->diffForHumans() }}</small>
                        </div>
                        @if($notice->updated_at != $notice->created_at)
                            <div class="mb-3">
                                <strong>Last Updated:</strong><br>
                                {{ $notice->updated_at->format('M d, Y') }}<br>
                                <small class="text-muted">{{ $notice->updated_at->diffForHumans() }}</small>
                            </div>
                        @endif
                        @if($notice->expires_at)
                            <div class="mb-3">
                                <strong>Expires:</strong><br>
                                {{ $notice->expires_at->format('M d, Y') }}<br>
                                @if($notice->expires_at->isFuture())
                                    <small class="text-muted">{{ $notice->expires_at->diffForHumans() }}</small>
                                @else
                                    <small class="text-danger">Expired {{ $notice->expires_at->diffForHumans() }}</small>
                                @endif
                            </div>
                        @endif
                        <div class="mb-3">
                            <strong>Created by:</strong><br>
                            {{ $notice->creator->name }}<br>
                            <small class="text-muted">{{ $notice->creator->email }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .notice-content {
            font-size: 1.1rem;
            line-height: 1.6;
            white-space: pre-wrap;
        }
    </style>
@endsection
