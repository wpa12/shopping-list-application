<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Shopping List</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    @livewireStyles
</head>
<body class="antialiased">
    <div class="app-wrapper flex flex-col">
        <header class="navbar bg-neutral text-neutral-content justify-between flex-1 flex-wrap">
            <h1 class="btn btn-ghost normal-case text-xl">
                Laravel / Livewire Shopping List
            </h1>
            <a 
                href="https://github.com/wpa12/shopping-list-application.git"
                target="__blank"
                class="btn btn-success"
            > 
                Checkout the Github project
            </a>

            @auth
            <form action="/api/logout" method="POST">
                @csrf
                @method('post')
                <button class="btn btn-error">Logout</button>
            </form>
            @endauth
        </header>
    </div>
    <div>
        @auth
        <div class="wrapper w-full">
            @livewire('shopping-list')
        </div>
        @endauth
        @guest
        <div 
            class="form-wrapper flex justify-center items-center gap-[5rem] flex-wrap py-[2rem]" 
            x-data="{register_open: @if($errors->any()) true @else false @endif }" 
            x-transition.duration.200ms
        >
        <div class="flex flex-col gap-5 justify-center items-center">
            @if(session('success'))
            <div class="alert alert-success shadow-lg">
                <div>
                    <svg 
                        xmlns="http://www.w3.org/2000/svg" 
                        class="stroke-current flex-shrink-0 h-6 w-6" 
                        fill="none" 
                        viewBox="0 0 24 24"
                    >
                    <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        stroke-width="2" 
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" 
                    />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif
        <form method="POST" action="/api/login">
            @csrf
            @method('post')
            <div class="card w-96 bg-neutral text-neutral-content">
                <div class="card-body items-center text-center">
                    <h2 class="card-title">Log in!</h2>
                    <p>Please Log in below</p>
                    <div class="card-actions justify-end">
                        <div class="form-control w-full max-w-xs">
                            <label class="label">
                                <span class="label-text">Email address:</span>
                            </label>
                            <input 
                                type="text" 
                                placeholder="Type here" 
                                name="email"
                                class="input input-bordered w-full max-w-xs" 
                            />
                        </div>
                        <div class="form-control w-full max-w-xs">
                            <label class="label">
                                <span class="label-text">Password:</span>
                            </label>
                            <input 
                                type="password" 
                                placeholder="Type here" 
                                class="input input-bordered w-full max-w-xs" 
                                name="password" 
                            />
                        </div>
                        <button class="btn btn-primary">Log in</button>
                        <div class="form-control">
                            <label class="cursor-pointer label">
                                <span class="label-text text-left">Don't have an account? check this box to register one!</span>
                                <input 
                                    type="checkbox" 
                                    class="checkbox checkbox-accent" 
                                    x-model="register_open"
                                >
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div 
        class="flex justify-center items-center" 
        style="display:none;" 
        x-show="register_open" 
        x-transition.duration.200ms
    >
    <form action="/api/register" method="POST">
        @csrf
        @method('post')
        <div class="card w-96 bg-white text-base-100">
            <div class="card-body items-center text-center">
                <h2 class="card-title">Register Now!</h2>
                <p>Please Enter your details below</p>
                <div class="alert alert-warning text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <span>Warning: Test only! Do not use real-world sensitive data.</span>
                  </div>
                <div class="card-actions justify-end">
                    <div class="form-control w-full max-w-xs">
                        <label class="label">
                            <span class="label-text text-base-100">Name:</span>
                        </label>
                        <input 
                            type="text" 
                            name="register_name" 
                            placeholder="Type here" 
                            class="input input-bordered text-white w-full max-w-xs" 
                            value="{{ old('register_name') }}" 
                        />
                        @error('register_name')
                        <p class="text-error text-left">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-control w-full max-w-xs">
                        <label class="label">
                            <span class="label-text text-base-100">Email address:</span>
                        </label>
                        <input 
                            type="text" 
                            name="register_email_address" 
                            placeholder="Type here" 
                            class="input input-bordered text-white w-full max-w-xs" 
                            value="{{ old('register_email_address') }}" 
                        />
                        @error('register_email_address')
                        <p class="text-error text-left">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-control w-full max-w-xs">
                        <label class="label">
                            <span class="label-text text-base-100">Password:</span>
                        </label>
                        <input 
                            type="password" 
                            name="register_password" 
                            placeholder="Type here" 
                            class="input input-bordered text-white w-full max-w-xs"  
                        />
                        @error('register_password')
                        <p class="text-error text-left">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-control w-full max-w-xs">
                        <label class="label">
                            <span class="label-text text-base-100">Password confirmation:</span>
                        </label>
                        <input 
                            type="password" 
                            name="register_password_confirmation" 
                            placeholder="Type here" 
                            class="input input-bordered text-white w-full max-w-xs" 
                        />
                    </div>
                    <button class="btn btn-secondary">Register Account</button>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
<footer class="flex flex-1 p-4 justify-center">
    <div>All Data posted in the form will be wiped every 24hrs</div>
</footer>
@endguest
</div>
@livewireScripts
</body>
</html>
