<!-- Flash Messages -->
@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle mr-2"></i>
        {{ session('error') }}
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info">
        <i class="fas fa-info-circle mr-2"></i>
        {{ session('info') }}
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        {{ session('warning') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-error">
        <div class="font-medium mb-2">
            <i class="fas fa-exclamation-circle mr-2"></i>
            Terdapat beberapa kesalahan:
        </div>
        <ul class="list-disc list-inside ml-6">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif