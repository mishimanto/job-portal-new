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

@if($messages->hasPages())
<div class="px-6 py-4 border-t border-gray-200" id="paginationContainer">
    {{ $messages->links() }}
</div>
@endif