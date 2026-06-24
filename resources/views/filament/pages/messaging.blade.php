<?php
    /**
 * @var \App\Models\Contact $selectedContact
 * @var \Illuminate\Support\Collection $contacts
 * @var array $attachments
 */
?>

<div class="flex h-full -mx-6 -mb-6" x-data="{
    selectedId: @entangle('selectedContactId'),
    init() {
        this.$watch('selectedId', () => {
            if (this.selectedId) {
                setTimeout(() => this.scrollToBottom(), 100);
            }
        });
    },
    scrollToBottom() {
        const container = this.$refs.messagesContainer;
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    },
}">
    {{-- Conversation List --}}
    <div class="w-80 lg:w-96 flex-shrink-0 border-r border-gray-200 dark:border-gray-700 flex flex-col bg-gray-50 dark:bg-gray-900/50">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">Conversations</h2>
                <x-filament::link
                    :href="\App\Filament\Resources\ContactResource::getUrl('create')"
                    icon="heroicon-o-plus"
                    size="sm"
                    color="primary"
                >
                    New
                </x-filament::link>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto">
            @forelse($this->contacts as $contact)
                <button
                    wire:click="selectContact({{ $contact->id }})"
                    class="w-full text-left px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors border-b border-gray-100 dark:border-gray-800 {{ $selectedContactId === $contact->id ? 'bg-indigo-50 dark:bg-indigo-900/20 border-l-4 border-l-indigo-500' : 'border-l-4 border-l-transparent' }}"
                >
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-sm truncate {{ $contact->is_read ? 'text-gray-700 dark:text-gray-300' : 'text-gray-900 dark:text-white' }}">
                                    {{ $contact->name ?? $contact->email }}
                                </span>
                                @if(!$contact->is_read)
                                    <span class="w-2 h-2 rounded-full bg-indigo-500 flex-shrink-0"></span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate">
                                {{ $contact->subject ?? 'No subject' }}
                            </p>
                            @php
                                $lastMsg = $contact->replies->first()?->message ?? $contact->message;
                            @endphp
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 truncate">
                                {{ Str::limit(strip_tags($lastMsg), 50) }}
                            </p>
                        </div>
                        <div class="text-xs text-gray-400 dark:text-gray-500 flex-shrink-0 ml-2">
                            @php
                                $lastTime = $contact->replies->first()?->created_at ?? $contact->created_at;
                            @endphp
                            {{ $lastTime->diffForHumans(['parts' => 1]) }}
                        </div>
                    </div>
                </button>
            @empty
                <div class="p-6 text-center text-gray-400 dark:text-gray-500">
                    No conversations yet.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Message Thread --}}
    <div class="flex-1 flex flex-col bg-white dark:bg-gray-900">
        @if($selectedContact)
            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">
                        {{ $selectedContact->name ?? $selectedContact->email }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $selectedContact->subject }}
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <x-filament::link
                        :href="\App\Filament\Resources\ContactResource::getUrl('edit', ['record' => $selectedContact])"
                        icon="heroicon-o-pencil"
                        size="sm"
                        color="gray"
                    >
                        Edit
                    </x-filament::link>
                    <x-filament::link
                        :href="\App\Filament\Resources\ContactResource::getUrl('view', ['record' => $selectedContact])"
                        icon="heroicon-o-arrow-top-right-on-square"
                        size="sm"
                        color="gray"
                    >
                        View
                    </x-filament::link>
                </div>
            </div>

            {{-- Messages --}}
            <div
                x-ref="messagesContainer"
                class="flex-1 overflow-y-auto px-6 py-4 space-y-4"
                x-init="$nextTick(() => scrollToBottom())"
            >
                {{-- Original message --}}
                <div class="flex justify-start">
                    <div class="max-w-[75%] bg-gray-100 dark:bg-gray-800 rounded-2xl rounded-tl-sm px-4 py-3">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">
                                {{ $selectedContact->name ?? $selectedContact->email }}
                            </span>
                            <span class="text-xs text-gray-400 dark:text-gray-500">
                                {{ $selectedContact->created_at->format('M d, H:i') }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-wrap">
                            {{ $selectedContact->message }}
                        </div>
                    </div>
                </div>

                {{-- Replies --}}
                @foreach($selectedContact->replies as $reply)
                    <div class="flex justify-end">
                        <div class="max-w-[75%] bg-indigo-500 rounded-2xl rounded-tr-sm px-4 py-3">
                            <div class="flex items-center gap-2 mb-1 justify-end">
                                <span class="text-xs text-indigo-200">
                                    {{ $reply->created_at->format('M d, H:i') }}
                                </span>
                                <span class="text-xs font-semibold text-indigo-100">
                                    {{ $reply->admin?->name ?? 'Admin' }}
                                </span>
                            </div>
                            <div class="text-sm text-white whitespace-pre-wrap">
                                {{ $reply->message }}
                            </div>

                            {{-- Attachments --}}
                            @php
                                $mediaItems = $reply->getMedia('attachments');
                            @endphp
                            @if($mediaItems->isNotEmpty())
                                <div class="mt-2 pt-2 border-t border-indigo-400 flex flex-wrap gap-2">
                                    @foreach($mediaItems as $media)
                                        @if(str_starts_with($media->mime_type, 'image/'))
                                            <a href="{{ $media->getUrl() }}" target="_blank" class="block w-20 h-20 rounded-lg overflow-hidden hover:opacity-90 transition">
                                                <img src="{{ $media->getUrl('thumb') ?? $media->getUrl() }}" alt="{{ $media->name }}" class="w-full h-full object-cover">
                                            </a>
                                        @else
                                            <a href="{{ $media->getUrl() }}" target="_blank" class="inline-flex items-center gap-1 text-xs bg-indigo-400/30 text-white rounded px-2 py-1 hover:bg-indigo-400/50 transition">
                                                <x-filament::icon icon="heroicon-o-paper-clip" class="w-3 h-3" />
                                                {{ $media->file_name }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            {{-- Quotation badge --}}
                            @if($reply->hasQuotation())
                                <div class="mt-2 pt-2 border-t border-indigo-400">
                                    <span class="inline-flex items-center gap-1 text-xs text-indigo-100 bg-indigo-400/30 rounded-full px-2 py-0.5">
                                        <x-filament::icon icon="heroicon-o-document-arrow-down" class="w-3 h-3" />
                                        Quotation attached
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Reply Input --}}
            <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-3 bg-white dark:bg-gray-900">
                <form wire:submit="sendMessage">
                    <div class="flex items-end gap-2">
                        <div class="flex-1 relative">
                            <textarea
                                wire:model="newMessage"
                                placeholder="Type your message..."
                                class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 rounded-xl px-4 py-2.5 text-sm resize-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                rows="2"
                                x-on:keydown.enter.prevent="if(!$event.shiftKey) $el.form?.requestSubmit()"
                            ></textarea>

                            {{-- Attachment previews --}}
                            @if($attachments)
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach($attachments as $index => $file)
                                        <div class="relative group">
                                            @if(str_starts_with($file->getMimeType(), 'image/'))
                                                <img src="{{ $file->temporaryUrl() }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200 dark:border-gray-600">
                                            @else
                                                <div class="w-12 h-12 rounded-lg border border-gray-200 dark:border-gray-600 flex items-center justify-center text-xs text-gray-500 bg-gray-50 dark:bg-gray-800">
                                                    {{ Str::of($file->getClientOriginalName())->afterLast('.') }}
                                                </div>
                                            @endif
                                            <button type="button" wire:click="removeAttachment({{ $index }})" class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-red-500 text-white rounded-full text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow-sm">
                                                &times;
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-1 pb-1">
                            {{-- Attach files --}}
                            <label class="cursor-pointer p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                                <input
                                    type="file"
                                    wire:model="attachments"
                                    multiple
                                    accept="image/*,video/*,.pdf,.doc,.docx,.txt"
                                    class="hidden"
                                />
                                <x-filament::icon icon="heroicon-o-paper-clip" class="w-5 h-5" />
                            </label>

                            {{-- Create Quotation --}}
                            <button
                                type="button"
                                x-on:click="$dispatch('open-quotation-modal')"
                                class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800"
                            >
                                <x-filament::icon icon="heroicon-o-plus" class="w-5 h-5" />
                            </button>

                            {{-- Send --}}
                            <button
                                type="submit"
                                class="p-2 text-white bg-indigo-500 hover:bg-indigo-600 transition rounded-lg"
                            >
                                <x-filament::icon icon="heroicon-o-paper-airplane" class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @else
            {{-- Empty state --}}
            <div class="flex-1 flex items-center justify-center text-gray-400 dark:text-gray-500">
                <div class="text-center">
                    <x-filament::icon icon="heroicon-o-chat-bubble-left-right" class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600" />
                    <p class="text-lg font-medium">Select a conversation</p>
                    <p class="text-sm mt-1">Choose a conversation from the left to start messaging</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Quotation Modal --}}
    @if($selectedContact)
        <div
            x-data="{ open: false }"
            x-on:open-quotation-modal.window="open = true"
            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center"
        >
            <div x-show="open" x-on:click="open = false" class="absolute inset-0 bg-black/50"></div>
            <div
                x-show="open"
                x-on:click.outside="open = false"
                class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-lg mx-4 p-6"
            >
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Create Quotation</h3>
                    <button type="button" x-on:click="open = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <x-filament::icon icon="heroicon-o-x-mark" class="w-5 h-5" />
                    </button>
                </div>

                <form wire:submit="createQuotation" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Customer</label>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $selectedContact->name ?? $selectedContact->email }}</p>
                    </div>

                    <div>
                        <label for="quotationMessage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quotation Message</label>
                        <textarea
                            wire:model="quotationMessage"
                            id="quotationMessage"
                            rows="4"
                            class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Describe the quotation..."
                        ></textarea>
                        @error('quotationMessage')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="quotationFile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quotation File (optional)</label>
                        <input
                            type="file"
                            wire:model="quotationFile"
                            id="quotationFile"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                            class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900/50"
                        />
                        @error('quotationFile')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button
                            type="button"
                            x-on:click="open = false"
                            class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            x-on:click="setTimeout(() => open = false, 300)"
                            class="px-4 py-2 text-sm text-white bg-indigo-500 hover:bg-indigo-600 rounded-lg transition"
                        >
                            Create Quotation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
