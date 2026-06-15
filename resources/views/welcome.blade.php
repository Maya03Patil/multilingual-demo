<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ t('Multilingual E-Commerce Marketplace') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Outfit:400,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
    </style>
</head>
<body class="antialiased bg-[#020617] text-slate-200">

    <!-- Fixed Glassmorphic Navbar -->
    <nav class="fixed top-0 w-full z-50 bg-[#020617]/80 backdrop-blur-xl border-b border-white/5 px-8 pt-6 pb-6 shadow-2xl">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            
            <!-- Branding -->
            <div class="flex items-center space-x-3 w-1/4">
                <div class="w-10 h-10 bg-gradient-to-tr from-rose-500 to-indigo-500 rounded-xl flex items-center justify-center font-black text-white shadow-xl shadow-rose-500/20">M</div>
                <div class="text-2xl font-black tracking-tighter text-white leading-none">Multi<span class="text-rose-400">Cart</span></div>
            </div>
            
            <!-- Lang Switcher & Cart Action -->
            <div class="flex items-center space-x-6 w-3/4 justify-end">
                
                <!-- View Cart Button -->
                <a href="{{ route('cart.index') }}" class="relative group flex items-center space-x-2 px-4 py-2 bg-white/5 border border-white/10 rounded-2xl hover:bg-white/10 hover:border-indigo-500/30 transition-all duration-300">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span class="font-bold text-sm">{{ t('View Cart') }}</span>
                    @if(count(Session::get('demo_cart', [])) > 0)
                        <span class="absolute -top-2 -right-2 w-5 h-5 bg-rose-500 text-white text-[10px] flex items-center justify-center rounded-full border-2 border-[#020617] font-black">
                            {{ count(Session::get('demo_cart', [])) }}
                        </span>
                    @endif
                </a>

                <!-- Language Selection (Bulletproof) -->
                <div class="relative">
                    <select onchange="window.location.href=this.value" class="appearance-none bg-white/5 border border-white/10 rounded-2xl text-white font-bold text-xs px-6 py-2.5 pr-10 hover:bg-white/10 hover:border-rose-500/50 focus:outline-none transition-all cursor-pointer backdrop-blur-md ring-rose-500/20">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <option class="bg-[#020617] text-white" value="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" 
                                @if(LaravelLocalization::getCurrentLocale() === $localeCode) selected @endif>
                                {{ $properties['native'] }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen pt-32 pb-20 px-6 max-w-7xl mx-auto flex flex-col items-center">
        
        <!-- Header Hero Section -->
        <header class="text-center space-y-8 mb-20 max-w-4xl">
            <h1 class="text-6xl md:text-8xl font-black tracking-tight leading-none">
                {{ t('The Future of') }} <span class="bg-clip-text text-transparent bg-gradient-to-r from-rose-400 via-indigo-400 to-indigo-600">{{ t('Global Commerce') }}</span>
            </h1>
            <p class="text-xl text-slate-400 leading-relaxed mx-auto max-w-2xl px-4">
                {{ t('Ready for your clients! This e-commerce app auto-translates its entire database on the fly using our magical t() backend helper. No broken JS, no missing SEO.') }}
            </p>
        </header>

        <!-- ADD PRODUCT INTERFACE -->
        <section class="max-w-4xl w-full bg-white/[0.03] border border-white/5 rounded-[2.5rem] p-10 mb-20 relative shadow-2xl backdrop-blur-3xl overflow-hidden">
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-rose-500/10 blur-[100px] rounded-full"></div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-indigo-500/10 blur-[100px] rounded-full"></div>

            <h2 class="text-3xl font-black text-white mb-8 tracking-tighter">{{ t('Add New Product') }}</h2>
            <form action="{{ route('products.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                @csrf
                <div class="space-y-4">
                    <label class="block text-sm font-bold text-slate-400 ml-4">{{ t('Product Name (English)') }}</label>
                    <input type="text" name="name" required placeholder="{{ t('e.g. Smart Watch Pro') }}" 
                           class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white focus:outline-none focus:border-rose-500/50 focus:ring-4 focus:ring-rose-500/20 transition-all placeholder:text-slate-600">
                </div>
                <div class="space-y-4">
                    <label class="block text-sm font-bold text-slate-400 ml-4">{{ t('Price ($)') }}</label>
                    <input type="number" name="price" step="0.01" required placeholder="199.99" 
                           class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white focus:outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/20 transition-all placeholder:text-slate-600">
                </div>
                <div class="md:col-span-2 space-y-4">
                    <label class="block text-sm font-bold text-slate-400 ml-4">{{ t('Description (English)') }}</label>
                    <textarea name="description" rows="3" required placeholder="{{ t('Describe your product in English...') }}" 
                              class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white focus:outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/20 transition-all placeholder:text-slate-600"></textarea>
                </div>
                <div class="md:col-span-2 pt-4">
                    <button type="submit" class="w-full bg-gradient-to-r from-rose-500 to-indigo-600 text-white font-black py-5 rounded-2xl shadow-xl hover:shadow-indigo-500/30 active:scale-[0.98] transition-all text-sm uppercase tracking-widest">
                        {{ t('Save and Auto-Translate Everywhere') }}
                    </button>
                    <p class="text-center text-xs text-slate-500 mt-4 italic">{{ t('Our AI backend will automatically translate this to 5+ languages instantly for your customers.') }}</p>
                </div>
            </form>
        </section>

        <!-- PRODUCT SHOWCASE GRID -->
        <h2 class="text-4xl font-black text-white w-full mb-10 tracking-tighter">{{ t('Active Marketplace') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full">
            @foreach($products as $product)
            <div class="group p-10 bg-white/[0.03] border border-white/5 rounded-[3rem] hover:bg-white/[0.06] hover:border-white/10 hover:-translate-y-3 transition-all duration-500 relative overflow-hidden flex flex-col justify-between shadow-xl">
                
                <!-- Card background glow -->
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-500/5 blur-[60px] rounded-full group-hover:bg-indigo-500/20 transition-all duration-700"></div>

                <div>
                    <div class="relative h-48 w-full bg-white/5 rounded-[2.5rem] mb-10 overflow-hidden flex items-center justify-center border border-white/10 group-hover:border-indigo-500/20 transition-colors duration-500">
                        <img src="{{ $product->image ?? 'https://via.placeholder.com/400' }}" alt="product" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-950/40"></div>
                        <div class="absolute top-5 right-5 bg-[#020617]/80 backdrop-blur-md px-4 py-1.5 rounded-full text-rose-400 font-black text-sm border border-white/10 shadow-xl">
                            ${{ number_format($product->price, 2) }}
                        </div>
                    </div>

                    <h3 class="text-2xl font-black mb-4 text-white leading-tight tracking-tight px-2">{{ t($product->name) }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-10 px-2 group-hover:text-slate-300 transition-colors duration-300">{{ t($product->description) }}</p>
                </div>

                <form action="{{ route('cart.add') }}" method="POST" class="px-2">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <input type="hidden" name="name" value="{{ $product->name }}">
                    <input type="hidden" name="price" value="{{ $product->price }}">
                    <button type="submit" class="w-full px-6 py-5 bg-white/5 border border-white/10 text-white font-black rounded-[2rem] hover:bg-gradient-to-r hover:from-indigo-600 hover:to-indigo-500 hover:border-transparent hover:shadow-2xl hover:shadow-indigo-500/40 active:scale-95 transition-all duration-300 text-xs uppercase tracking-widest">
                        {{ t('Add to Cart') }}
                    </button>
                </form>
            </div>
            @endforeach
        </div>

    </div>
</body>
</html>
