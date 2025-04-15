<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Notes') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Manage your notes') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <flux:modal.trigger name="create-note">
    <flux:button class="mt-4">Create Note</flux:button>
    </flux:modal.trigger>

        @session('success')
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => { show = false }, 3000)"
            class="fixed top-5 right-5 z-50 p-4 bg-green-600 text-white text-sm rounded-lg shadow-lg"
        >
            <p>{{ $value }}</p>
        </div> 
        @endsession('success')

    <livewire:create-note />
    <livewire:edit-note />

    {{-- Notes table --}}
    <table class="table-auto w-full bg-slate-800 shadow-md rounded-md mt-5">
        <thead>
            <tr class="bg-slate-700 text-white">
                <th class="px-6 py-3 text-left">Title</th>
                <th class="px-6 py-3 text-left">Content</th>
                <th class="px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($notes as $note)
            <tr class="bg-slate-600 text-white border-t">
                <td class="px-6 py-3">{{ $note->title }}</td>
                <td class="px-6 py-3">{{ $note->content }}</td>
                <td class="px-6 py-3">
                    <flux:button variant="primary" wire:click="edit({{ $note->id }})">Edit</flux:button>
                    <flux:button variant="danger" wire:click="delete({{ $note->id }})">Delete</flux:button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-6 py-3 text-center text-gray-400">No notes available.</td>
            </tr>
            @endforelse
        </tbody>

    </table>

    {{-- pagination links --}}
    <div class="mt-4">
        {{$notes->links()}}
    </div> 

    {{-- delete modal --}}

<flux:modal name="delete-note" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete note?</flux:heading>

            <flux:text class="mt-2">
                <p>You're about to delete this note.</p>
                <p>This action cannot be reversed.</p>
            </flux:text>
        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="submit" variant="danger" wire:click="deleteNote()">Delete note</flux:button>
        </div>
    </div>
</flux:modal>
</div>
