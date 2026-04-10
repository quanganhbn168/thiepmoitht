@extends('layouts.app')

@section('title', 'Nhập mật khẩu - ' . $wedding->groom_name . ' & ' . $wedding->bride_name)

@section('content')
<div class="min-h-screen bg-gradient-to-b from-rose-50 to-white flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8">
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto mb-4 flex items-center justify-center bg-rose-100 rounded-full">
                <svg class="w-10 h-10 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="font-script text-3xl text-gray-800 mb-2">
                {{ $wedding->groom_name }} & {{ $wedding->bride_name }}
            </h1>
            <p class="text-gray-600">Vui lòng nhập mật khẩu để xem thiệp</p>
        </div>

        <form method="POST" action="{{ url()->current() }}">
            @csrf
            
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Mật khẩu
                </label>
                <input type="password" 
                    id="password" 
                    name="password" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                    placeholder="Nhập mật khẩu..."
                    autofocus
                    required>
            </div>

            <button type="submit" 
                class="w-full bg-rose-500 text-white py-3 rounded-lg hover:bg-rose-600 transition-colors font-medium">
                Xem thiệp
            </button>
        </form>
    </div>
</div>
@endsection
