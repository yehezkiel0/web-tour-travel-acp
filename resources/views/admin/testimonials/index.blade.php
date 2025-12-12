@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md relative">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Service Testimonials</h1>
            </div>

            <div class="py-4">
                <div class="w-full mx-auto px-4 sm:px-0">
                    <div class="bg-white rounded-lg overflow-hidden">
                        <div class="relative shadow-md sm:rounded-lg overflow-hidden">
                            <!-- Filter Section -->
                            <div
                                class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                                <div class="w-full">
                                    <form method="GET" action="{{ route('admin_testimonials_index') }}"
                                        class="flex items-center gap-3">
                                        <select name="service_type"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2">
                                            <option value="">All Services</option>
                                            <option value="medical"
                                                {{ request('service_type') == 'medical' ? 'selected' : '' }}>Medical &
                                                Beauty</option>
                                            <option value="recruitment"
                                                {{ request('service_type') == 'recruitment' ? 'selected' : '' }}>Recruitment
                                            </option>
                                            <option value="entertainment"
                                                {{ request('service_type') == 'entertainment' ? 'selected' : '' }}>
                                                Entertainment</option>
                                        </select>

                                        <select name="status"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2">
                                            <option value="">All Status</option>
                                            <option value="approved"
                                                {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                        </select>

                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                                            <i class="fa-solid fa-filter mr-1"></i>
                                            Filter
                                        </button>

                                        @if (request('service_type') || request('status'))
                                            <a href="{{ route('admin_testimonials_index') }}"
                                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                                                <i class="fa-solid fa-times mr-1"></i>
                                                Clear
                                            </a>
                                        @endif
                                    </form>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-3">User</th>
                                            <th scope="col" class="px-4 py-3">Service</th>
                                            <th scope="col" class="px-4 py-3">Testimonial</th>
                                            <th scope="col" class="px-4 py-3">Rating</th>
                                            <th scope="col" class="px-4 py-3">Status</th>
                                            <th scope="col" class="px-4 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($testimonials as $testimonial)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            @if ($testimonial->photo)
                                                                <img src="{{ asset('storage/' . $testimonial->photo) }}"
                                                                    alt="{{ $testimonial->name }}"
                                                                    class="h-10 w-10 rounded-full object-cover">
                                                            @else
                                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial->name) }}&size=100&background=3477F6&color=fff"
                                                                    alt="{{ $testimonial->name }}"
                                                                    class="h-10 w-10 rounded-full">
                                                            @endif
                                                        </div>
                                                        <div class="ml-3">
                                                            <p class="text-sm font-medium text-gray-900">
                                                                {{ $testimonial->name }}</p>
                                                            <p class="text-xs text-gray-500">{{ $testimonial->location }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold rounded-full {{ $testimonial->service_type == 'medical' ? 'bg-blue-100 text-blue-800' : ($testimonial->service_type == 'recruitment' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                                                        {{ ucfirst($testimonial->service_type) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 max-w-xs">
                                                    <p class="font-medium text-gray-900">{{ $testimonial->title }}</p>
                                                    <p class="text-xs text-gray-500 truncate">
                                                        {{ Str::limit($testimonial->message, 60) }}</p>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="flex gap-0.5">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i
                                                                class="fa{{ $i <= $testimonial->rating ? 's' : 'r' }} fa-star text-yellow-400 text-xs"></i>
                                                        @endfor
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if ($testimonial->is_approved)
                                                        <span
                                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                                    @else
                                                        <span
                                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center gap-2">
                                                        @if ($testimonial->is_approved)
                                                            <form
                                                                action="{{ route('admin_testimonial_unapprove', $testimonial->id) }}"
                                                                method="POST" class="inline">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="text-yellow-600 hover:text-yellow-800"
                                                                    onclick="return confirm('Unapprove this testimonial?')"
                                                                    title="Unapprove">
                                                                    <i class="fas fa-times-circle text-lg"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form
                                                                action="{{ route('admin_testimonial_approve', $testimonial->id) }}"
                                                                method="POST" class="inline">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="text-green-600 hover:text-green-800"
                                                                    title="Approve">
                                                                    <i class="fas fa-check-circle text-lg"></i>
                                                                </button>
                                                            </form>
                                                        @endif

                                                        <form
                                                            action="{{ route('admin_testimonial_delete', $testimonial->id) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-800"
                                                                onclick="return confirm('Delete this testimonial permanently?')"
                                                                title="Delete">
                                                                <i class="fas fa-trash text-lg"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                                    <i class="fas fa-inbox text-4xl mb-2"></i>
                                                    <p>No testimonials found</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="px-4 py-3 border-t">
                                {{ $testimonials->links('vendor.pagination.custom') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
