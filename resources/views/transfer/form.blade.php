@extends('layout.index')
@section('home')

<div class="container mt-5">
    <h1 class="text-center mb-4">Transfer Between Accounts</h1>

    <!-- Display success or error messages -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('transfer.perform') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="from_account_id" class="form-label">From Account:</label>
            
            <select id="account_number" name="from_account_id" class="form-control" required>
                <option value="">-- Select Account --</option>
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->account_name }} (Balance: {{ $account->account_balance,2}})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="to_account_id" class="form-label">To Account:</label>
            
            <select id="account_number" name="to_account_id" class="form-control" required>
                <option value="">-- Select Account --</option>
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->account_name }} (Balance: {{ $account->account_balance,2}})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Amount:</label>
            <input type="number" name="amount" class="form-control" step="0.01" placeholder="Enter amount" required>
        </div>
        <div class="mb-3">
            <label for="Description" class="form-label">Description</label>
            <input type="text" class="form-control" id="Decription" name="Description" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Transfer</button>
    </form>
</div>

@endsection

@section('scripts')
<!-- Include any custom scripts here -->
@endsection
