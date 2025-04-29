@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Order Management</h2>

    @if ($errors->any())
    <script>
        $(document).ready(function () {
            $('#orderModal').modal('show');
        });
    </script>
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif



    {{-- Create Button --}}
    <button class="btn btn-primary mt-3 mb-3" onclick="openOrderModal()">Create New Order</button>

    {{-- Orders Table --}}
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Details</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->client }}</td>
                <td>{{ $order->details }}</td>
                <td>
                    <button class="btn btn-warning btn-sm"
                        onclick="openOrderModal({{ $order->id }}, '{{ $order->client }}', `{{ $order->details }}`)">
                        Edit
                    </button>
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Order Modal --}}
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="orderForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="{{ old('_method', 'POST') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel">Create/Edit Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="client" class="form-label">Client</label>
                            <input type="text" name="client" class="form-control @error('client') is-invalid @enderror" value="{{ old('client') }}" id="client">
                            @error('client')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">Details</label>
                            <textarea name="details" class="form-control @error('client') is-invalid @enderror" id="details" >{{old('details')}}</textarea>
                            @error('details')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Save Order</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script Section --}}
<script>
    function openOrderModal(id = null, client = '', details = '') {
        if (id) {
            $('#orderForm').attr('action', `/orders/${id}`);
            $('#formMethod').val('PUT');
            $('#orderModalLabel').text('Edit Order');
            $('#client').val(client);
            $('#details').val(details);
        } else {
            $('#orderForm').attr('action', '/orders');
            $('#formMethod').val('POST');
            $('#orderModalLabel').text('Create Order');
            $('#client').val('');
            $('#details').val('');
        }

        $('#orderModal').modal('show'); 
    }
</script>

@endsection
