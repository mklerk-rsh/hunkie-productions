<?php
/**
 * @var \App\Models\Contact|null $selectedContact
 * @var \Illuminate\Support\Collection $contacts
 * @var array $attachments
 * @var string $newMessage
 * @var string $quotationMessage
 */
?>

@php
    $contacts = $this->contacts;
    $selectedContact = $this->selectedContact;
    $pinnedContacts = $contacts->where('is_read', false);

    if ($pinnedContacts->isEmpty()) {
        $pinnedContacts = $contacts->take(2);
    } else {
        $pinnedContacts = $pinnedContacts->take(2);
    }
@endphp

<x-filament-panels::page>
<style>
    .hp-chat {
        --chat-border: #d7dee8;
        --chat-soft-border: #eef2f7;
        --chat-text: #101828;
        --chat-muted: #667085;
        --chat-faint: #98a2b3;
        --chat-panel: #ffffff;
        --chat-sidebar: #fbfcfe;
        --chat-hover: #f5f8fc;
        --chat-blue: #4aa8ee;
        --chat-blue-dark: #2688d7;
        overflow: hidden;
        min-height: calc(100vh - 10.5rem);
        border: 1px solid var(--chat-border);
        border-radius: 10px;
        background: var(--chat-panel);
        box-shadow: 0 18px 50px rgba(15, 23, 42, 0.06);
    }

    .dark .hp-chat {
        --chat-border: #263241;
        --chat-soft-border: #17202c;
        --chat-text: #f8fafc;
        --chat-muted: #a8b3c3;
        --chat-faint: #64748b;
        --chat-panel: #090e16;
        --chat-sidebar: #0c121d;
        --chat-hover: #111a28;
        background: var(--chat-panel);
        box-shadow: none;
    }

    .hp-chat-grid {
        display: grid;
        min-height: calc(100vh - 10.5rem);
        grid-template-columns: minmax(280px, 330px) minmax(0, 1fr);
    }

    .hp-chat-sidebar {
        display: flex;
        min-width: 0;
        flex-direction: column;
        background: var(--chat-sidebar);
        border-right: 1px solid var(--chat-border);
    }

    .hp-chat-sidebar-header {
        padding: 18px 18px 14px;
    }

    .hp-chat-title-row,
    .hp-chat-topbar,
    .hp-chat-actions,
    .hp-chat-composer {
        display: flex;
        align-items: center;
    }

    .hp-chat-title-row,
    .hp-chat-topbar {
        justify-content: space-between;
        gap: 14px;
    }

    .hp-chat-title {
        margin: 0;
        color: var(--chat-text);
        font-size: 15px;
        font-weight: 800;
        letter-spacing: 0.02em;
    }

    .hp-chat-icon-btn {
        display: inline-flex;
        width: 30px;
        height: 30px;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        border-radius: 8px;
        color: var(--chat-muted);
        transition: 160ms ease;
    }

    .hp-chat-icon-btn:hover {
        border-color: var(--chat-soft-border);
        background: #fff;
        color: var(--chat-text);
    }

    .dark .hp-chat-icon-btn:hover {
        background: #111827;
    }

    .hp-chat-search {
        position: relative;
        margin-top: 14px;
    }

    .hp-chat-search svg {
        position: absolute;
        left: 12px;
        top: 50%;
        width: 15px;
        height: 15px;
        color: var(--chat-faint);
        transform: translateY(-50%);
        pointer-events: none;
    }

    .hp-chat-search input {
        width: 100%;
        height: 38px;
        border: 1px solid #d9e1ea;
        border-radius: 999px;
        background: #fff;
        padding: 0 14px 0 36px;
        color: var(--chat-text);
        font-size: 12px;
        outline: none;
        transition: 160ms ease;
    }

    .hp-chat-search input:focus {
        border-color: #aacdea;
        box-shadow: 0 0 0 4px rgba(74, 168, 238, 0.12);
    }

    .dark .hp-chat-search input {
        border-color: #263241;
        background: #090e16;
    }

    .hp-chat-scroll {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding: 0 12px 18px;
    }

    .hp-chat-section {
        margin-top: 10px;
    }

    .hp-chat-section-title {
        margin: 0 0 8px;
        padding: 0 5px;
        color: var(--chat-text);
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0.01em;
    }

    .hp-thread {
        display: flex;
        width: 100%;
        min-width: 0;
        gap: 10px;
        border: 0;
        border-radius: 10px;
        background: transparent;
        padding: 9px 8px;
        text-align: left;
        transition: 150ms ease;
    }

    .hp-thread:hover,
    .hp-thread.is-active {
        background: var(--chat-hover);
    }

    .hp-thread.is-active {
        box-shadow: inset 3px 0 0 var(--chat-blue);
    }

    .hp-avatar {
        position: relative;
        display: inline-flex;
        width: 38px;
        height: 38px;
        flex: 0 0 auto;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-radius: 50%;
        background:
            radial-gradient(circle at 35% 25%, #fff4dc 0 18%, transparent 19%),
            linear-gradient(135deg, #f9c26b, #e7836d 54%, #7fb4e8);
        color: #21140d;
        font-size: 13px;
        font-weight: 900;
        box-shadow: inset 0 0 0 2px rgba(255, 255, 255, 0.72);
    }

    .hp-avatar.hp-avatar-blue {
        background:
            radial-gradient(circle at 35% 25%, #e8f7ff 0 18%, transparent 19%),
            linear-gradient(135deg, #8bd3ff, #5ba8ef 54%, #4666c7);
        color: #07233d;
    }

    .hp-unread-dot {
        position: absolute;
        right: -1px;
        top: -1px;
        width: 11px;
        height: 11px;
        border: 2px solid var(--chat-sidebar);
        border-radius: 50%;
        background: var(--chat-blue);
    }

    .hp-thread-body {
        min-width: 0;
        flex: 1;
    }

    .hp-thread-meta {
        display: flex;
        min-width: 0;
        align-items: baseline;
        gap: 7px;
    }

    .hp-thread-name {
        overflow: hidden;
        color: var(--chat-text);
        font-size: 12px;
        font-weight: 800;
        line-height: 1.3;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .hp-thread.is-active .hp-thread-name {
        color: var(--chat-blue-dark);
    }

    .hp-thread-date {
        flex: 0 0 auto;
        color: var(--chat-blue);
        font-size: 11px;
        line-height: 1.3;
    }

    .hp-thread-preview {
        margin-top: 2px;
        overflow: hidden;
        color: var(--chat-muted);
        font-size: 11px;
        line-height: 1.45;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .hp-empty-small {
        padding: 8px 6px 14px;
        color: var(--chat-faint);
        font-size: 12px;
    }

    .hp-chat-main {
        display: flex;
        min-width: 0;
        flex-direction: column;
        background: var(--chat-panel);
    }

    .hp-chat-topbar {
        min-height: 62px;
        border-bottom: 1px solid var(--chat-soft-border);
        padding: 0 18px;
    }

    .hp-chat-person {
        display: flex;
        min-width: 0;
        align-items: center;
        gap: 10px;
    }

    .hp-chat-person .hp-avatar {
        width: 36px;
        height: 36px;
    }

    .hp-chat-person-name {
        overflow: hidden;
        color: var(--chat-text);
        font-size: 14px;
        font-weight: 800;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .hp-chat-person-subject {
        overflow: hidden;
        color: var(--chat-faint);
        font-size: 11px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .hp-chat-actions {
        gap: 4px;
    }

    .hp-message-area {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding: 26px 28px;
        background:
            radial-gradient(circle at 80% 8%, rgba(74, 168, 238, 0.04), transparent 28%),
            var(--chat-panel);
    }

    .hp-message-stack {
        display: flex;
        max-width: 880px;
        min-height: 100%;
        margin: 0 auto;
        flex-direction: column;
        justify-content: flex-start;
        gap: 12px;
    }

    .hp-message-row {
        display: flex;
    }

    .hp-message-row.is-out {
        justify-content: flex-end;
    }

    .hp-bubble {
        max-width: min(620px, 72%);
        border-radius: 18px;
        padding: 10px 13px;
        color: var(--chat-text);
        font-size: 12px;
        line-height: 1.55;
    }

    .hp-bubble.is-in {
        border-top-left-radius: 7px;
        background: #f2f5f9;
    }

    .dark .hp-bubble.is-in {
        background: #111827;
    }

    .hp-bubble.is-out {
        border-top-right-radius: 7px;
        background: linear-gradient(135deg, #5eb5f2, #399ce5);
        color: #fff;
        box-shadow: 0 8px 18px rgba(57, 156, 229, 0.2);
    }

    .hp-bubble-meta {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 3px;
        color: var(--chat-muted);
        font-size: 10px;
        font-weight: 700;
    }

    .hp-bubble.is-out .hp-bubble-meta {
        justify-content: flex-end;
        color: rgba(255, 255, 255, 0.78);
    }

    .hp-bubble-text {
        white-space: pre-wrap;
    }

    .hp-attachments {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: 9px;
        padding-top: 9px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .hp-attachment-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border-radius: 7px;
        background: rgba(255, 255, 255, 0.16);
        padding: 5px 7px;
        color: #fff;
        font-size: 11px;
    }

    .hp-attachment-image {
        width: 74px;
        height: 74px;
        overflow: hidden;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.16);
    }

    .hp-attachment-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hp-composer-wrap {
        border-top: 1px solid var(--chat-soft-border);
        padding: 14px 18px 16px;
        background: var(--chat-panel);
    }

    .hp-pending-files {
        display: flex;
        max-width: 880px;
        margin: 0 auto 10px;
        flex-wrap: wrap;
        gap: 8px;
    }

    .hp-pending-file {
        position: relative;
        width: 48px;
        height: 48px;
        border: 1px solid var(--chat-soft-border);
        border-radius: 10px;
        background: var(--chat-hover);
        color: var(--chat-muted);
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .hp-pending-file img {
        width: 100%;
        height: 100%;
        border-radius: 10px;
        object-fit: cover;
    }

    .hp-remove-file {
        position: absolute;
        right: -6px;
        top: -6px;
        display: flex;
        width: 18px;
        height: 18px;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #ef4444;
        color: #fff;
        font-size: 12px;
        opacity: 0;
        transition: 140ms ease;
    }

    .hp-pending-file:hover .hp-remove-file {
        opacity: 1;
    }

    .hp-chat-composer {
        max-width: 880px;
        margin: 0 auto;
        gap: 7px;
        border: 1px solid #d9e1ea;
        border-radius: 999px;
        background: #fff;
        padding: 6px 7px 6px 16px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }

    .dark .hp-chat-composer {
        border-color: #263241;
        background: #090e16;
    }

    .hp-chat-composer input[type='text'] {
        min-width: 0;
        flex: 1;
        border: 0;
        background: transparent;
        color: var(--chat-text);
        font-size: 12px;
        outline: none;
        box-shadow: none;
    }

    .hp-chat-composer input[type='text']:focus {
        box-shadow: none;
    }

    .hp-composer-action,
    .hp-composer-send {
        display: inline-flex;
        width: 31px;
        height: 31px;
        flex: 0 0 auto;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: 150ms ease;
    }

    .hp-composer-action {
        color: var(--chat-faint);
    }

    .hp-composer-action:hover {
        background: var(--chat-hover);
        color: var(--chat-text);
    }

    .hp-composer-send {
        background: var(--chat-blue);
        color: #fff;
    }

    .hp-composer-send:hover {
        background: var(--chat-blue-dark);
    }

    .hp-empty-state {
        display: flex;
        flex: 1;
        align-items: center;
        justify-content: center;
        padding: 32px;
        text-align: center;
    }

    .hp-empty-card {
        max-width: 360px;
    }

    .hp-empty-icon {
        display: flex;
        width: 62px;
        height: 62px;
        margin: 0 auto;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(74, 168, 238, 0.12);
        color: var(--chat-blue);
    }

    .hp-empty-card h3 {
        margin: 16px 0 6px;
        color: var(--chat-text);
        font-size: 15px;
        font-weight: 800;
    }

    .hp-empty-card p {
        margin: 0;
        color: var(--chat-muted);
        font-size: 13px;
        line-height: 1.55;
    }

    .hp-modal-panel {
        position: relative;
        width: 100%;
        max-width: 520px;
        margin: 0 16px;
        border-radius: 14px;
        background: var(--chat-panel);
        padding: 24px;
        box-shadow: 0 26px 70px rgba(15, 23, 42, 0.24);
    }

    @media (max-width: 1023px) {
        .hp-chat-grid {
            grid-template-columns: 1fr;
        }

        .hp-chat-sidebar {
            border-right: 0;
            border-bottom: 1px solid var(--chat-border);
        }
    }

    @media (max-width: 640px) {
        .hp-chat {
            border-radius: 8px;
        }

        .hp-message-area {
            padding: 20px 14px;
        }

        .hp-bubble {
            max-width: 86%;
        }
    }
</style>

<div
    class="hp-chat"
    x-data="{
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
            if (container) container.scrollTop = container.scrollHeight;
        }
    }"
>
    <div class="hp-chat-grid">
        <aside class="hp-chat-sidebar">
            <div class="hp-chat-sidebar-header">
                <div class="hp-chat-title-row">
                    <h2 class="hp-chat-title">Messages</h2>
                    <a
                        href="{{ \App\Filament\Resources\ContactResource::getUrl('create') }}"
                        class="hp-chat-icon-btn"
                        title="New conversation"
                    >
                        <x-filament::icon icon="heroicon-o-pencil-square" class="h-4 w-4" />
                    </a>
                </div>

                <div class="hp-chat-search">
                    <x-filament::icon icon="heroicon-o-magnifying-glass" />
                    <input
                        type="search"
                        wire:model.live.debounce.300ms="searchQuery"
                        placeholder="Search messages"
                    />
                </div>
            </div>

            <div class="hp-chat-scroll">
                <div class="hp-chat-section">
                    <h3 class="hp-chat-section-title">Pinned conversations</h3>

                    @forelse($pinnedContacts as $contact)
                        @php
                            $lastMsg = $contact->replies->first()?->message ?? $contact->message ?? '';
                            $lastTime = $contact->replies->first()?->created_at ?? $contact->created_at;
                            $label = $contact->name ?? $contact->email;
                        @endphp
                        <button
                            type="button"
                            wire:click="selectContact({{ $contact->id }})"
                            class="hp-thread {{ $selectedContactId === $contact->id ? 'is-active' : '' }}"
                        >
                            <span class="hp-avatar">
                                {{ Str::of($label)->substr(0, 1)->upper() }}
                                @if(!$contact->is_read)
                                    <span class="hp-unread-dot"></span>
                                @endif
                            </span>
                            <span class="hp-thread-body">
                                <span class="hp-thread-meta">
                                    <span class="hp-thread-name">{{ $label }}</span>
                                    <span class="hp-thread-date">{{ $lastTime?->format('M j') }}</span>
                                </span>
                                <span class="hp-thread-preview">{{ Str::limit(strip_tags($lastMsg), 46) }}</span>
                            </span>
                        </button>
                    @empty
                        <p class="hp-empty-small">No pinned conversations.</p>
                    @endforelse
                </div>

                <div class="hp-chat-section">
                    <h3 class="hp-chat-section-title">All conversations</h3>

                    @forelse($contacts as $contact)
                        @php
                            $lastMsg = $contact->replies->first()?->message ?? $contact->message ?? '';
                            $lastTime = $contact->replies->first()?->created_at ?? $contact->created_at;
                            $label = $contact->name ?? $contact->email;
                        @endphp
                        <button
                            type="button"
                            wire:click="selectContact({{ $contact->id }})"
                            class="hp-thread {{ $selectedContactId === $contact->id ? 'is-active' : '' }}"
                        >
                            <span class="hp-avatar hp-avatar-blue">
                                {{ Str::of($label)->substr(0, 1)->upper() }}
                                @if(!$contact->is_read)
                                    <span class="hp-unread-dot"></span>
                                @endif
                            </span>
                            <span class="hp-thread-body">
                                <span class="hp-thread-meta">
                                    <span class="hp-thread-name">{{ $label }}</span>
                                    <span class="hp-thread-date">{{ $lastTime?->format('M j') }}</span>
                                </span>
                                <span class="hp-thread-preview">{{ Str::limit(strip_tags($lastMsg), 50) }}</span>
                            </span>
                        </button>
                    @empty
                        <div class="hp-empty-state" style="padding: 28px 8px;">
                            <div class="hp-empty-card">
                                <div class="hp-empty-icon" style="width: 48px; height: 48px;">
                                    <x-filament::icon icon="heroicon-o-inbox" class="h-6 w-6" />
                                </div>
                                <h3>No conversations yet</h3>
                                <p>New contact messages will appear here.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </aside>

        <section class="hp-chat-main">
            @if($selectedContact)
                <div class="hp-chat-topbar">
                    <div class="hp-chat-person">
                        <span class="hp-avatar">
                            {{ Str::of($selectedContact->name ?? $selectedContact->email)->substr(0, 1)->upper() }}
                        </span>
                        <div style="min-width: 0;">
                            <div class="hp-chat-person-name">{{ $selectedContact->name ?? $selectedContact->email }}</div>
                            <div class="hp-chat-person-subject">{{ $selectedContact->subject ?? 'No subject' }}</div>
                        </div>
                    </div>

                    <div class="hp-chat-actions">
                        <a
                            href="{{ \App\Filament\Resources\ContactResource::getUrl('edit', ['record' => $selectedContact]) }}"
                            class="hp-chat-icon-btn"
                            title="Edit contact"
                        >
                            <x-filament::icon icon="heroicon-o-pencil" class="h-4 w-4" />
                        </a>
                        <a
                            href="{{ \App\Filament\Resources\ContactResource::getUrl('view', ['record' => $selectedContact]) }}"
                            class="hp-chat-icon-btn"
                            title="View contact"
                        >
                            <x-filament::icon icon="heroicon-o-arrow-top-right-on-square" class="h-4 w-4" />
                        </a>
                    </div>
                </div>

                <div
                    x-ref="messagesContainer"
                    class="hp-message-area"
                    x-init="$nextTick(() => scrollToBottom())"
                >
                    <div class="hp-message-stack">
                        <div class="hp-message-row">
                            <div class="hp-bubble is-in">
                                <div class="hp-bubble-meta">
                                    <span>{{ $selectedContact->name ?? $selectedContact->email }}</span>
                                    <span>{{ $selectedContact->created_at?->format('M d, H:i') }}</span>
                                </div>
                                <div class="hp-bubble-text">{{ $selectedContact->message }}</div>
                            </div>
                        </div>

                        @foreach($selectedContact->replies as $reply)
                            <div class="hp-message-row is-out">
                                <div class="hp-bubble is-out">
                                    <div class="hp-bubble-meta">
                                        <span>{{ $reply->created_at?->format('M d, H:i') }}</span>
                                        <span>{{ $reply->admin?->name ?? 'Admin' }}</span>
                                    </div>
                                    <div class="hp-bubble-text">{{ $reply->message }}</div>

                                    @php
                                        $mediaItems = $reply->getMedia('attachments');
                                    @endphp
                                    @if($mediaItems->isNotEmpty())
                                        <div class="hp-attachments">
                                            @foreach($mediaItems as $media)
                                                @if(str_starts_with($media->mime_type, 'image/'))
                                                    <a href="{{ $media->getUrl() }}" target="_blank" class="hp-attachment-image">
                                                        <img src="{{ $media->getUrl('thumb') ?? $media->getUrl() }}" alt="{{ $media->name }}">
                                                    </a>
                                                @else
                                                    <a href="{{ $media->getUrl() }}" target="_blank" class="hp-attachment-link">
                                                        <x-filament::icon icon="heroicon-o-paper-clip" class="h-3 w-3" />
                                                        {{ $media->file_name }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($reply->hasQuotation())
                                        <div class="hp-attachments">
                                            <span class="hp-attachment-link">
                                                <x-filament::icon icon="heroicon-o-document-arrow-down" class="h-3 w-3" />
                                                Quotation attached
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="hp-composer-wrap">
                    <form wire:submit="sendMessage">
                        @if(!empty($attachments))
                            <div class="hp-pending-files">
                                @foreach($attachments as $index => $file)
                                    <div class="hp-pending-file">
                                        @if(str_starts_with($file->getMimeType(), 'image/'))
                                            <img src="{{ $file->temporaryUrl() }}" alt="">
                                        @else
                                            <span style="display: grid; height: 100%; place-items: center;">
                                                {{ Str::of($file->getClientOriginalName())->afterLast('.') }}
                                            </span>
                                        @endif
                                        <button type="button" wire:click="removeAttachment({{ $index }})" class="hp-remove-file">
                                            &times;
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="hp-chat-composer">
                            <input
                                type="text"
                                wire:model="newMessage"
                                placeholder="Type here..."
                            />

                            <label class="hp-composer-action" title="Attach files">
                                <input type="file" wire:model="attachments" multiple accept="image/*,video/*,.pdf,.doc,.docx,.txt" class="hidden">
                                <x-filament::icon icon="heroicon-o-paper-clip" class="h-4 w-4" />
                            </label>

                            <button type="button" x-on:click="$dispatch('open-quotation-modal')" class="hp-composer-action" title="Create quotation">
                                <x-filament::icon icon="heroicon-o-document-plus" class="h-4 w-4" />
                            </button>

                            <button type="submit" class="hp-composer-send" title="Send">
                                <x-filament::icon icon="heroicon-o-paper-airplane" class="h-4 w-4" />
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="hp-chat-topbar">
                    <h3 class="hp-chat-title">Select a conversation</h3>
                </div>

                <div class="hp-empty-state">
                    <div class="hp-empty-card">
                        <div class="hp-empty-icon">
                            <x-filament::icon icon="heroicon-o-chat-bubble-left-right" class="h-8 w-8" />
                        </div>
                        <h3>Select a conversation</h3>
                        <p>Choose a conversation from the left to view the message thread and reply.</p>
                    </div>
                </div>
            @endif
        </section>
    </div>

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
                class="hp-modal-panel"
            >
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-base font-bold text-gray-950 dark:text-white">Create Quotation</h3>
                    <button type="button" x-on:click="open = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <x-filament::icon icon="heroicon-o-x-mark" class="h-5 w-5" />
                    </button>
                </div>

                <form wire:submit="createQuotation" class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $selectedContact->name ?? $selectedContact->email }}</p>
                    </div>

                    <div>
                        <label for="quotationMessage" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Quotation Message</label>
                        <textarea
                            wire:model="quotationMessage"
                            id="quotationMessage"
                            rows="4"
                            class="block w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-200"
                            placeholder="Describe the quotation..."
                        ></textarea>
                        @error('quotationMessage')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="quotationFile" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Quotation File (optional)</label>
                        <input
                            type="file"
                            wire:model="quotationFile"
                            id="quotationFile"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 dark:text-gray-400 dark:file:bg-blue-500/10 dark:file:text-blue-300"
                        />
                        @error('quotationFile')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" x-on:click="open = false" class="rounded-lg px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">
                            Cancel
                        </button>
                        <button type="submit" x-on:click="setTimeout(() => open = false, 300)" class="rounded-lg bg-blue-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-600">
                            Create Quotation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
</x-filament-panels::page>
