@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Mis Tareas</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Tarea
        </a>
    </div>

    @if($tasks->count() > 0)
        <div class="row">
            @foreach($tasks as $task)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card {{ $task->completed ? 'border-success' : '' }}">
                        <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="badge bg-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                            @if($task->completed)
                                <i class="fas fa-check-circle text-success"></i>
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title {{ $task->completed ? 'text-decoration-line-through' : '' }}">
                                {{ $task->title }}
                            </h5>
                            @if($task->description)
                                <p class="card-text">{{ Str::limit($task->description, 100) }}</p>
                            @endif
                            @if($task->due_date)
                                <small class="text-muted">
                                    <i class="fas fa-calendar"></i> {{ $task->due_date->format('d/m/Y') }}
                                </small>
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="btn-group w-100" role="group">
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-{{ $task->completed ? 'secondary' : 'success' }} btn-sm">
                                        <i class="fas fa-{{ $task->completed ? 'undo' : 'check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $tasks->links() }}
    @else
        <div class="text-center">
            <i class="fas fa-tasks fa-5x text-muted mb-3"></i>
            <h4>No hay tareas todavía</h4>
            <p class="text-muted">Crea tu primera tarea para comenzar.</p>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Crear Primera Tarea
            </a>
        </div>
    @endif
@endsection
