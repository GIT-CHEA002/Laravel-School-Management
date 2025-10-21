<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Header with Logo -->
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <div class="bg-white rounded-full p-4 shadow-lg border border-gray-100">
                        <img src="{{ url('photo/photo1.jpg') }}" alt="School Logo" class="w-20 h-20 rounded-full object-cover">
                    </div>
                </a>
                <h1 class="text-3xl font-bold text-gray-800 mt-4">Education Management</h1>
                <p class="text-gray-600 mt-2">School Management System</p>
            </div>

            <!-- Login/Register Card -->
            <div class="w-full sm:max-w-md">
                <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white text-center">
                            @if(request()->routeIs('login'))
                                Welcome Back
                            @elseif(request()->routeIs('register'))
                                Create Account
                            @else
                                Sign In
                            @endif
                        </h2>
                        <p class="text-blue-100 text-center mt-2">
                            @if(request()->routeIs('login'))
                                Sign in to your account
                            @elseif(request()->routeIs('register'))
                                Join our education platform
                            @endif
                        </p>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="px-8 py-8">
                        {{ $slot }}
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-500">
                        © {{ date('Y') }} Education Management System. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
        
        <style>
            /* Custom animations */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .fade-in-up {
                animation: fadeInUp 0.6s ease-out;
            }
            
            /* Enhanced form styling */
            .form-input {
                transition: all 0.3s ease;
            }
            
            .form-input:focus {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
            }
        </style>
    </body>
</html>
