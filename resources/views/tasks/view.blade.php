@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Detalles de la Tarea</h4>
                    <span class="badge bg-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'secondary') }} fs-6">
                    Prioridad: {{ ucfirst($task->priority) }}
                </span>
                </div>
                <div class="card-body">
                    <h2 class="{{ $task->completed ? 'text-decoration-line-through text-muted' : '' }}">
                        {{ $task->title }}
                        @if($task->completed)
                            <i class="fas fa-check-circle text-success ms-2"></i>
                        @endif
                    </h2>

                    @if($task->description)
                        <div class="mt-3">
                            <h5>Descripción:</h5>
                            <p>{{ $task->description }}</p>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <strong>Estado:</strong>
                            <span class="badge bg-{{ $task->completed ? 'success' : 'warning' }}">
                            {{ $task->completed ? 'Completada' : 'Pendiente' }}
                        </span>
                        </div>
                        @if($task->due_date)
                            <div class="col-md-6">
                                <strong>Fecha límite:</strong>
                                <span class="{{ $task->due_date->isPast() && !$task->completed ? 'text-danger' : '' }}">
                                {{ $task->due_date->format('d/m/Y') }}
                                    @if($task->due_date->isPast() && !$task->completed)
                                        <i class="fas fa-exclamation-triangle"></i>
                                    @endif
                            </span>
                            </div>
                        @endif
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <strong>Creada:</strong> {{ $task->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Actualizada:</strong> {{ $task->updated_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        <div>
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-{{ $task->completed ? 'secondary' : 'success' }}">
                                    <i class="fas fa-{{ $task->completed ? 'undo' : 'check' }}"></i>
                                    {{ $task->completed ? 'Marcar Pendiente' : 'Completar' }}
                                </button>
                            </form>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Estás seguro de eliminar esta tarea?')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
