<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ t('Your Shopping Cart') }}</title>
    <link href="https://fonts.bunny.net/css?family=Outfit:400,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Outfit', sans-serif; } </style>
</head>
<body class="antialiased bg-[#020617] text-slate-200">

    <nav class="fixed top-0 w-full z-50 bg-[#020617]/80 backdrop-blur-xl border-b border-white/5 px-8 pt-6 pb-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('products.index') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-tr from-rose-500 to-indigo-500 rounded-xl flex items-center justify-center font-black text-white">M</div>
                <div class="text-2xl font-black tracking-tighter text-white leading-none">Multi<span class="text-rose-400">Cart</span></div>
            </a>
            <div class="flex items-center space-x-6">
                <a href="{{ route('products.index') }}" class="text-sm font-bold text-slate-400 hover:text-white transition-colors">{{ t('Back to Shop') }}</a>
            </div>
        </div>
    </nav>

    <div class="min-h-screen pt-40 pb-20 px-6 max-w-4xl mx-auto">
        <h1 class="text-5xl font-black mb-12 text-white tracking-tighter">{{ t('Your Cart') }}</h1>

        @if(count($cart) > 0)
            <div class="space-y-6">
                @foreach($cart as $item)
                    <div class="flex justify-between items-center bg-white/[0.03] border border-white/5 p-8 rounded-[2rem] hover:bg-white/[0.06] transition-all">
                        <div class="flex flex-col space-y-1">
                            <span class="text-xl font-black text-white tracking-tight">{{ t($item['name']) }}</span>
                            <span class="text-slate-500 text-sm font-bold uppercase tracking-widest">{{ t('Price per Unit') }}: ${{ number_format($item['price'], 2) }}</span>
                        </div>
                        <div class="flex items-center space-x-12">
                            <div class="flex flex-col items-end">
                                <span class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-1">{{ t('Quantity') }}</span>
                                <span class="text-2xl font-black text-white">{{ $item['qty'] }}</span>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="text-xs text-rose-500 uppercase tracking-widest font-bold mb-1">{{ t('Total') }}</span>
                                <span class="text-2xl font-black text-rose-400">${{ number_format($item['price'] * $item['qty'], 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 pt-10 border-t border-white/10 flex flex-col items-end">
                <div class="flex space-x-12 mb-10 items-center">
                    <span class="text-xl font-bold text-slate-400">{{ t('Grand Total') }}:</span>
                    <span class="text-5xl font-black text-white tracking-widest">
                        ${{ number_format(array_reduce($cart, function($carry, $item) { return $carry + ($item['price'] * $item['qty']); }, 0), 2) }}
                    </span>
                </div>
                
                <div class="flex space-x-4">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-8 py-5 border border-white/10 rounded-2xl font-black text-rose-500 uppercase text-xs tracking-widest hover:bg-rose-500/10 transition-all active:scale-95">
                            {{ t('Clear Cart') }}
                        </button>
                    </form>
                    <button class="px-12 py-5 bg-gradient-to-r from-rose-500 to-indigo-600 rounded-2xl font-black text-white uppercase text-xs tracking-widest hover:shadow-indigo-500/20 shadow-xl active:scale-95 transition-all">
                        {{ t('Proceed to Checkout') }}
                    </button>
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-white/[0.03] rounded-[3rem] border-2 border-dashed border-white/5">
                <p class="text-2xl font-black text-slate-500 mb-6">{{ t('Your cart is empty.') }}</p>
                <a href="{{ route('products.index') }}" class="inline-block px-10 py-5 bg-white/5 rounded-2xl font-black text-indigo-400 uppercase text-xs tracking-widest shadow-xl">{{ t('Start Shopping') }}</a>
            </div>
        @endif
    </div>
</body>
</html>
