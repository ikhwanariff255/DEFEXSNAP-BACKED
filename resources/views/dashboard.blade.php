@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">DefexSnap Dashboard</h1>
            <p class="text-gray-500 mt-1">Welcome back, <span class="font-semibold text-gray-700">{{ Auth::user()->name }}</span>. Here is your task summary.</p>
        </div>
    </div>

    <!-- Success Message (If any) -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-lg text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Quick Actions & Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Stat Card: Total Inspections -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Projects</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalInspections }}</h3>
            </div>
            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl shadow-sm">
                <i class="fa-solid fa-house-circle-check"></i>
            </div>
        </div>

        <!-- Action Card: Start New Project -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center hover:shadow-md transition-shadow">
            <p class="text-sm font-medium text-gray-500 mb-3 text-center">Have a new client?</p>
            <a href="{{ route('inspection.create') }}" class="block text-center w-full py-2.5 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 transition-colors">
                <i class="fa-solid fa-plus mr-1"></i> Start New Inspection
            </a>
        </div>

        <!-- Action Card: Full List -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center hover:shadow-md transition-shadow">
            <p class="text-sm font-medium text-gray-500 mb-3 text-center">Manage existing records</p>
            <a href="{{ route('inspection.index') }}" class="block text-center w-full py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-200 transition-colors">
                <i class="fa-solid fa-list mr-1"></i> View Project List
            </a>
        </div>
    </div>

    <!-- Recent Projects Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Recent Records</h3>
            <a href="{{ route('inspection.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">View All &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="py-3 px-6 font-semibold">Property Title</th>
                        <th class="py-3 px-6 font-semibold">Client</th>
                        <th class="py-3 px-6 font-semibold">Date Registered</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @forelse($recentInspections as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6">
                                <p class="font-bold text-gray-900">{{ $item->title }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-md">
                                    {{ $item->type }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-medium text-gray-800">{{ $item->clientname }}</td>
                            <td class="py-4 px-6 text-gray-500">{{ $item->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-8 text-center text-gray-400">
                                <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                                No inspection projects have been recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection