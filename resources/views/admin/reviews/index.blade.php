@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Reviews & Ratings</h1>
            </div>

            <div class="py-4">
                <div class="bg-white rounded-lg shadow-md">
                    <!-- Filter -->
                    <div class="p-4 border-b">
                        <form method="GET" class="flex gap-3">
                            <select name="status" class="border border-gray-300 rounded-lg px-4 py-2">
                                <option value="">All Status</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                            </select>
                            <select name="rating" class="border border-gray-300 rounded-lg px-4 py-2">
                                <option value="">All Ratings</option>
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                        {{ $i }} Stars</option>
                                @endfor
                            </select>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                            @if (request('status') || request('rating'))
                                <a href="{{ route('admin_reviews_index') }}"
                                    class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                                    <i class="fas fa-times mr-2"></i>Clear
                                </a>
                            @endif
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">User</th>
                                    <th class="px-4 py-3">Destination</th>
                                    <th class="px-4 py-3">Rating</th>
                                    <th class="px-4 py-3">Review</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&size=100&background=3477F6&color=fff"
                                                        alt="{{ $review->user->name }}" class="h-10 w-10 rounded-full">
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900">{{ $review->user->name }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $review->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <p class="font-medium">{{ $review->destination->title }}</p>
                                            @if ($review->is_verified)
                                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded">Verified
                                                    Purchase</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex gap-0.5">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star text-yellow-400 text-xs"></i>
                                                @endfor
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 max-w-xs">
                                            <p class="font-medium">{{ $review->title }}</p>
                                            <p class="text-xs text-gray-500">{{ Str::limit($review->review, 100) }}</p>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if ($review->is_approved)
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Approved</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex gap-2">
                                                @if ($review->is_approved)
                                                    <form action="{{ route('admin_review_unapprove', $review->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-yellow-600 hover:text-yellow-800"
                                                            title="Unapprove">
                                                            <i class="fas fa-times-circle text-lg"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin_review_approve', $review->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-800"
                                                            title="Approve">
                                                            <i class="fas fa-check-circle text-lg"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('admin_review_delete', $review->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800"
                                                        onclick="return confirm('Delete this review?')" title="Delete">
                                                        <i class="fas fa-trash text-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                            <i class="fas fa-star text-4xl mb-2"></i>
                                            <p>No reviews found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-t">
                        {{ $reviews->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
