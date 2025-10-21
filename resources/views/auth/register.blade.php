<x-guest-layout>
    <!-- Registration Notice -->
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-graduation-cap text-blue-500 text-lg"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-semibold text-blue-800">Student Account Registration</h3>
                <p class="text-sm text-blue-700 mt-1">
                    This form creates a student account. Admin and teacher accounts are managed separately by administrators.
                </p>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        There were some errors with your submission
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Full Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-user mr-2 text-blue-500"></i>{{ __('Full Name') }}
            </label>
            <div class="relative">
                <input id="name" 
                       class="form-input block w-full pl-3 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out" 
                       type="text" 
                       name="name" 
                       :value="old('name')" 
                       required 
                       autofocus 
                       autocomplete="name"
                       placeholder="Enter your full name" />
            </div>
            @error('name')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-envelope mr-2 text-blue-500"></i>{{ __('Email Address') }}
            </label>
            <div class="relative">
                <input id="email" 
                       class="form-input block w-full pl-3 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out" 
                       type="email" 
                       name="email" 
                       :value="old('email')" 
                       required 
                       autocomplete="username"
                       placeholder="Enter your email address" />
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-lock mr-2 text-blue-500"></i>{{ __('Password') }}
            </label>
            <div class="relative">
                <input id="password" 
                       class="form-input block w-full pl-3 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="new-password"
                       placeholder="Choose a strong password" />
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-lock mr-2 text-blue-500"></i>{{ __('Confirm Password') }}
            </label>
            <div class="relative">
                <input id="password_confirmation" 
                       class="form-input block w-full pl-3 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out" 
                       type="password" 
                       name="password_confirmation" 
                       required 
                       autocomplete="new-password"
                       placeholder="Confirm your password" />
            </div>
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Terms and Agreement -->
        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input id="terms" 
                       type="checkbox" 
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                       required>
            </div>
            <div class="ml-3 text-sm">
                <label for="terms" class="text-gray-700">
                    I agree to the <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Terms of Service</a> and <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Privacy Policy</a>
                </label>
            </div>
        </div>

        <!-- Register Button -->
        <div>
            <button type="submit" 
                    class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out transform hover:scale-105">
                <i class="fas fa-user-plus mr-2"></i>
                {{ __('Create Student Account') }}
            </button>
        </div>
    </form>

    <!-- Login Section -->
    <div class="mt-8">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500 font-medium">Already have an account?</span>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out transform hover:scale-105">
                <i class="fas fa-sign-in-alt mr-2 text-blue-500"></i>
                {{ __('Sign In Instead') }}
            </a>
        </div>
    </div>
</x-guest-layout>
