<!-- filepath: resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTH / LUXESOLE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=Space+Grotesk:wght@300;400;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
        }

        .logo-font {
            font-family: 'Caveat', cursive;
        }

        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }

        /* Inner shadow effect for inputs */
        .input-inset {
            box-shadow: inset 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>

<body class="bg-zinc-950 min-h-screen flex flex-col items-center justify-center p-6 text-zinc-200">

    <div class="w-full max-w-[420px]">
        {{-- Card Form --}}
        <div
            class="bg-zinc-900 border border-zinc-800/60 shadow-[20px_20px_0px_0px_rgba(0,0,0,1)] p-8 md:p-12 rounded-none relative overflow-hidden">

            {{-- Decorative Industrial Top-Left Corner --}}
            <div class="absolute top-0 left-0 w-10 h-10 border-t-2 border-l-2 border-zinc-700"></div>

            <div class="text-center mb-12">
                <h1 class="text-6xl logo-font text-yellow-500 mb-2 select-none">Luxesole</h1>
                <p class="text-[10px] text-zinc-500 font-black tracking-[0.4em] uppercase">Private Terminal v.1.0</p>
            </div>

            @if($errors->any())
                <div class="bg-red-950/20 border-l-2 border-red-600 p-4 mb-8 rounded-none">
                    <p class="text-[11px] font-bold text-red-500 uppercase tracking-widest italic">
                        Access Denied: {{ $errors->first() }}
                    </p>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-8">
                @csrf

                <div>
                    <label for="email"
                        class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-3">Identity /
                        Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-4 text-zinc-200 focus:outline-none focus:border-zinc-600 transition-all placeholder-zinc-800 text-sm input-inset"
                        placeholder="INPUT IDENTITY">
                </div>

                <div class="relative">
                    <label for="password"
                        class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-3">Key /
                        Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-4 text-zinc-200 focus:outline-none focus:border-zinc-600 transition-all placeholder-zinc-800 text-sm input-inset"
                            placeholder="INPUT KEY">
                        <button type="button" id="togglePassword"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-zinc-600 hover:text-zinc-400 p-1">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center group cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 rounded-none bg-zinc-950 border-zinc-800 text-zinc-700 focus:ring-0 focus:ring-offset-0">
                        <span
                            class="ml-3 text-[10px] font-bold text-zinc-500 group-hover:text-zinc-400 uppercase tracking-widest transition-colors">Remember</span>
                    </label>
                    <a href="#"
                        class="text-[10px] font-bold text-zinc-600 hover:text-zinc-400 uppercase tracking-widest transition-colors">Forgot?</a>
                </div>

                <button type="submit"
                    class="w-full bg-zinc-800 hover:bg-zinc-700 text-zinc-100 font-black uppercase tracking-[0.3em] py-5 rounded-none transition-all mt-4 border border-zinc-700 active:scale-[0.98]">
                    Mulai Shift
                </button>
            </form>
        </div>

        {{-- Footer Copywriting --}}
        <div class="mt-16 text-center space-y-3">
            <p class="text-zinc-600 italic text-xs tracking-tighter">
                "Kapan terakhir kali kamu dapat tertidur tenang?"
            </p>
            <p class="text-zinc-700 text-[9px] font-bold uppercase tracking-[0.5em] opacity-40">
                BAWA PESAN INI KE PERADABAN.
            </p>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // toggle the icon
            if (type === 'password') {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            } else {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                `;
            }
        });
    </script>

</body>

</html>