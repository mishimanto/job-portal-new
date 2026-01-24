@extends('layouts.admin')

@section('title', 'Contact Messages - Admin Panel')
@section('page-title', 'Messages')
@section('page-subtitle', 'Contact Messages')

@section('content')
<div class="container-fluid">
    <!-- Stats -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Messages</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $messages->total() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.286 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Unread</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $unreadCount }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Replied</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ \App\Models\ContactMessage::replied()->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Read</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ \App\Models\ContactMessage::read()->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Table with Filter on Right -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Contact Messages ({{ $messages->total() }})</h2>                    
                </div>   
                
                <!-- Filter Section - Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- Search Filter -->
                    <div>
                        <input type="text" name="search" id="searchFilter" value="{{ request('search') }}" 
                               placeholder="Search..."
                               class="block w-48 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <!-- Status Filter -->
                    <div>
                        <select name="status" id="statusFilter" class="block w-40 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">All Status</option>
                            <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                            <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>

                    <!-- Date Filter -->
                    <div>
                        <input type="date" name="date_from" id="dateFromFilter" value="{{ request('date_from') }}" 
                               class="block w-40 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="From Date">
                    </div>

                    <div>
                        <input type="date" name="date_to" id="dateToFilter" value="{{ request('date_to') }}" 
                               class="block w-40 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="To Date">
                    </div>                    

                    <!-- Reset Button -->
                    <a href="{{ route('admin.contact.messages') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Reset
                    </a>
                </div>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">From</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="messagesTableBody">
                    @forelse($messages as $message)
                    <tr class="{{ $message->status == 'unread' ? 'bg-blue-50' : 'hover:bg-gray-50' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-semibold">{{ strtoupper(substr($message->name, 0, 1)) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $message->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $message->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $message->subject }}</div>
                            <div class="text-xs text-gray-500 truncate max-w-xs">{{ $message->message_preview }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $message->formatted_created_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'unread' => 'bg-red-100 text-red-800',
                                    'read' => 'bg-blue-100 text-blue-800',
                                    'replied' => 'bg-green-100 text-green-800',
                                    'closed' => 'bg-gray-100 text-gray-800',
                                ];
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$message->status] }}">
                                {{ ucfirst($message->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.contact.show', $message->id) }}" 
                                   class="text-blue-600 hover:text-blue-900">
                                    View
                                </a>
                                @if($message->status != 'replied')
                                <a href="{{ route('admin.contact.show', $message->id) }}#reply" 
                                   class="text-green-600 hover:text-green-900">
                                    Reply
                                </a>
                                @endif
                                <form action="{{ route('admin.contact.delete', $message->id) }}" method="POST" 
                                      onsubmit="return deleteMessage(event)"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No contact messages found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($messages->hasPages())
        <div class="px-6 py-4 border-t border-gray-200" id="paginationContainer">
            {{ $messages->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function deleteMessage(event) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.submit();
        }
    });
    
    return false;
}

// Live Filter Functionality
// Live Filter Functionality
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('statusFilter');
    const dateFromFilter = document.getElementById('dateFromFilter');
    const dateToFilter = document.getElementById('dateToFilter');
    const searchFilter = document.getElementById('searchFilter');
    const messagesCountElement = document.querySelector('h2.text-lg.font-semibold.text-gray-900');
    const unreadCountElements = document.querySelectorAll('.stat-unread');
    
    let filterTimeout;
    
    function applyFilters() {
        const params = new URLSearchParams();
        
        if (statusFilter.value) {
            params.append('status', statusFilter.value);
        }
        if (dateFromFilter.value) {
            params.append('date_from', dateFromFilter.value);
        }
        if (dateToFilter.value) {
            params.append('date_to', dateToFilter.value);
        }
        if (searchFilter.value) {
            params.append('search', searchFilter.value);
        }
        
        // Show loading state
        const tableBody = document.getElementById('messagesTableBody');
        const paginationContainer = document.getElementById('paginationContainer');
        
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-8 text-center">
                    <div class="flex justify-center items-center">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
                        <span class="ml-3 text-gray-600">Loading messages...</span>
                    </div>
                </td>
            </tr>
        `;
        
        // Make AJAX request
        fetch(`{{ route('admin.contact.messages') }}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Update table body
            if (data.table_html) {
                tableBody.innerHTML = data.table_html;
            }
            
            // Update pagination
            if (paginationContainer && data.pagination_html) {
                paginationContainer.innerHTML = data.pagination_html;
            } else if (paginationContainer) {
                paginationContainer.innerHTML = '';
            }
            
            // Update messages count
            if (messagesCountElement && data.total !== undefined) {
                messagesCountElement.textContent = `Contact Messages (${data.total})`;
            }
            
            // Update unread count in stats
            if (unreadCountElements.length > 0 && data.unreadCount !== undefined) {
                unreadCountElements.forEach(el => {
                    el.textContent = data.unreadCount;
                });
            }
            
            // Update URL without page reload
            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.pushState({}, '', newUrl);
        })
        .catch(error => {
            console.error('Error:', error);
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-red-500">
                        Error loading messages. Please try again.
                    </td>
                </tr>
            `;
        });
    }
    
    // Add event listeners with debounce for search
    statusFilter.addEventListener('change', applyFilters);
    dateFromFilter.addEventListener('change', applyFilters);
    dateToFilter.addEventListener('change', applyFilters);
    
    searchFilter.addEventListener('input', function() {
        clearTimeout(filterTimeout);
        filterTimeout = setTimeout(applyFilters, 500);
    });
    
    // Initial load with any existing query parameters
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('status') || urlParams.has('date_from') || urlParams.has('date_to') || urlParams.has('search')) {
        // Set filter values from URL
        if (urlParams.has('status')) {
            statusFilter.value = urlParams.get('status');
        }
        if (urlParams.has('date_from')) {
            dateFromFilter.value = urlParams.get('date_from');
        }
        if (urlParams.has('date_to')) {
            dateToFilter.value = urlParams.get('date_to');
        }
        if (urlParams.has('search')) {
            searchFilter.value = urlParams.get('search');
        }
        
        // Apply filters after a short delay
        setTimeout(applyFilters, 100);
    }
});
</script>
@endpush
@endsection