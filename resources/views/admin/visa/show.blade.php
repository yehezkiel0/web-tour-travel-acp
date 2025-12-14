@extends('admin.layout.app')

@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')

    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center justify-between rounded-sm shadow-md">
                <h1 class="text-xl lg:text-2xl font-medium mt-1 text-gray-700">Visa Application Details</h1>
                <a href="{{ route('admin_visa_index') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Back to List
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Application Info --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 lg:col-span-2 space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Applicant</label>
                            <div class="font-medium text-gray-800">{{ $application->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $application->user->email }}</div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Applied
                                Date</label>
                            <div class="font-medium text-gray-800">{{ $application->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Target
                                Country</label>
                            <div class="font-medium text-gray-800">{{ $application->country }}</div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Visa
                                Type</label>
                            <div class="font-medium text-gray-800">{{ $application->visa_type }}</div>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <h3 class="font-bold text-gray-700">Documents</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($application->documents as $doc)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div
                                        class="bg-blue-100 text-blue-600 w-10 h-10 rounded flex items-center justify-center shrink-0">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="truncate">
                                        <div class="font-medium text-sm text-gray-800 truncate">{{ $doc->document_name }}
                                        </div>
                                        <div class="text-xs text-gray-500 truncate">{{ basename($doc->file_path) }}</div>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium px-2">
                                    View
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Status Management --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 h-fit">
                    <h3 class="font-bold text-gray-700 mb-4">Manage Application</h3>
                    <form action="{{ route('admin_visa_update', $application->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Current
                                Status</label>
                            <select name="status" id="status"
                                class="w-full rounded-md border-gray-300 focus:ring-primary focus:border-primary">
                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="documents_received"
                                    {{ $application->status == 'documents_received' ? 'selected' : '' }}>Documents Received
                                </option>
                                <option value="in_process" {{ $application->status == 'in_process' ? 'selected' : '' }}>In
                                    Process</option>
                                <option value="approved" {{ $application->status == 'approved' ? 'selected' : '' }}>
                                    Approved</option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>
                                    Rejected</option>
                            </select>
                        </div>

                        <div>
                            <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-1">Admin
                                Notes</label>
                            <textarea name="admin_notes" id="admin_notes" rows="4"
                                class="w-full rounded-md border-gray-300 focus:ring-primary focus:border-primary"
                                placeholder="Internal notes or reason for rejection...">{{ $application->admin_notes }}</textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-primary hover:bg-primary-800 text-white font-bold py-2 px-4 rounded shadow-md transition-colors">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
