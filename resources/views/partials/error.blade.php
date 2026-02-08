@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
        
        @if(session('error_details'))
            <div class="mt-2 text-sm">
                <details class="cursor-pointer">
                    <summary class="font-semibold">Error Details</summary>
                    <div class="mt-2 pl-4">
                        @if(is_array(session('error_details')))
                            <ul class="list-disc list-inside">
                                @foreach(session('error_details') as $key => $value)
                                    <li>
                                        <span class="font-medium">{{ ucfirst($key) }}:</span>
                                        @if(is_array($value))
                                            <pre class="mt-1 text-xs">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                        @else
                                            {{ $value }}
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            {{ session('error_details') }}
                        @endif
                    </div>
                </details>
            </div>
        @endif
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Validation Error!</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif 