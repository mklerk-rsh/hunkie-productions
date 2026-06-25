<?php

namespace App\Filament\Pages;

use App\Models\Contact;
use App\Models\ContactReply;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class Messaging extends Page
{
    use WithFileUploads;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string|\UnitEnum|null $navigationGroup = 'Leads';

    protected static ?string $navigationLabel = 'Messages';

    protected static ?string $slug = 'messages';

    protected string $view = 'filament.pages.messaging';

    public ?int $selectedContactId = null;

    public string $newMessage = '';

    public string $searchQuery = '';

    public array $attachments = [];

    public bool $showQuotationModal = false;

    public string $quotationMessage = '';

    public $quotationFile = null;

    public function getContactsProperty()
    {
        return Contact::withCount('replies')
            ->with(['replies' => fn ($q) => $q->latest()->take(1)])
            ->when($this->searchQuery !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', "%{$this->searchQuery}%")
                        ->orWhere('email', 'like', "%{$this->searchQuery}%")
                        ->orWhere('subject', 'like', "%{$this->searchQuery}%")
                        ->orWhere('message', 'like', "%{$this->searchQuery}%");
                });
            })
            ->orderByRaw('COALESCE((SELECT MAX(created_at) FROM contact_replies WHERE contact_id = contacts.id), contacts.created_at) DESC')
            ->take(50)
            ->get();
    }

    public function getSelectedContactProperty()
    {
        if (! $this->selectedContactId) {
            return null;
        }

        return Contact::with([
            'replies' => fn ($q) => $q->with(['admin', 'media'])->oldest(),
        ])->find($this->selectedContactId);
    }

    public function selectContact($id): void
    {
        $this->selectedContactId = (int) $id;
        $this->newMessage = '';
        $this->attachments = [];

        $contact = Contact::find($this->selectedContactId);
        if ($contact && ! $contact->is_read) {
            $contact->markAsRead();
        }
    }

    public function sendMessage(): void
    {
        $this->validate([
            'newMessage' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi,pdf,doc,docx,txt|max:102400',
        ]);

        if (! $this->selectedContactId) {
            return;
        }

        $reply = ContactReply::create([
            'contact_id' => $this->selectedContactId,
            'admin_id' => Auth::id(),
            'message' => $this->newMessage,
        ]);

        foreach ($this->attachments as $file) {
            $reply->addMedia($file->path())
                ->usingFileName($file->getClientOriginalName())
                ->toMediaCollection('attachments');
        }

        $contact = Contact::find($this->selectedContactId);
        if ($contact) {
            $contact->markAsReplied();
        }

        $this->newMessage = '';
        $this->attachments = [];

        Notification::make()
            ->title('Reply sent')
            ->success()
            ->send();
    }

    public function createQuotation(): void
    {
        $this->validate([
            'quotationMessage' => 'required|string',
            'quotationFile' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:51200',
        ]);

        if (! $this->selectedContactId) {
            return;
        }

        $reply = ContactReply::create([
            'contact_id' => $this->selectedContactId,
            'admin_id' => Auth::id(),
            'message' => $this->quotationMessage,
        ]);

        if ($this->quotationFile) {
            $reply->addMedia($this->quotationFile->path())
                ->usingFileName($this->quotationFile->getClientOriginalName())
                ->toMediaCollection('quotations');

            $reply->update([
                'quotation_filename' => $this->quotationFile->getClientOriginalName(),
            ]);
        }

        $contact = Contact::find($this->selectedContactId);
        if ($contact) {
            $contact->markAsReplied();
        }

        $this->resetQuotationForm();

        Notification::make()
            ->title('Quotation created')
            ->success()
            ->send();
    }

    public function resetQuotationForm(): void
    {
        $this->showQuotationModal = false;
        $this->quotationMessage = '';
        $this->quotationFile = null;
    }

    public function removeAttachment($index): void
    {
        unset($this->attachments[$index]);
        $this->attachments = array_values($this->attachments);
    }
}
