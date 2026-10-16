<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ isset($title) ? $title.' · ' : '' }}{{ config('app.name') }}</title>
        <meta name="description" content="{{ __('Flying for fun: see how many people enjoy each airfield, and where they come from.') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-white font-sans text-slate-900 antialiased">
        <header class="border-b border-slate-200">
            <nav class="mx-auto flex max-w-5xl items-center justify-between px-4 py-3">
                <a href="{{ route('home') }}" class="text-lg font-semibold text-sky-brand">{{ config('app.name') }}</a>

                <ul class="hidden gap-6 sm:flex">
                    <li><a href="{{ route('about') }}" class="hover:text-sky-brand">{{ __('About') }}</a></li>
                </ul>

                <details class="relative sm:hidden">
                    <summary class="cursor-pointer list-none rounded px-2 py-1 ring-1 ring-slate-300">{{ __('Menu') }}</summary>
                    <ul class="absolute right-0 mt-2 w-48 rounded bg-white p-2 shadow ring-1 ring-slate-200">
                        <li><a href="{{ route('about') }}" class="block rounded px-2 py-1 hover:bg-slate-100">{{ __('About') }}</a></li>
                    </ul>
                </details>
            </nav>
        </header>

        <main class="mx-auto w-full max-w-5xl flex-1 px-4 py-8">
            {{ $slot }}
        </main>

        <footer class="border-t border-slate-200 text-sm text-slate-600">
            <div class="mx-auto max-w-5xl px-4 py-6">
                &copy; {{ now()->year }} {{ config('app.name') }}
            </div>
        </footer>
    </body>
</html>
