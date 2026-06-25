<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hunkie Productions - Capturing Moments, Creating Masterpieces</title>
    <meta name="description" content="Hunkie Productions is a premier media, photography, and video production company. We capture moments and create masterpieces for our clients.">
    <meta name="keywords" content="photography, video production, media production, Hunkie Productions, content creation">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        royal: { DEFAULT: '#1E40AF', 50: '#EBF0FF', 100: '#D6E2FF', 200: '#ADC5FF', 300: '#85A8FF', 400: '#5C8BFF', 500: '#336EFF', 600: '#1E40AF', 700: '#18338C', 800: '#122669', 900: '#0C1A46' },
                        gold: { DEFAULT: '#D4AF37', 50: '#FDF8ED', 100: '#FBF1DB', 200: '#F7E3B7', 300: '#F3D593', 400: '#EFC76F', 500: '#D4AF37', 600: '#B8942E', 700: '#9C7A25', 800: '#80601C', 900: '#644613' },
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        display: ['Playfair Display', 'serif'],
                    },
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    @verbatim
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Hunkie Productions",
        "description": "Premier media, photography, and video production company.",
        "url": "{{ url('/') }}",
        "telephone": "+1234567890",
        "email": "info@hunkieproductions.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "123 Production Lane",
            "addressLocality": "Nairobi",
            "addressCountry": "KE"
        },
        "sameAs": [
            "https://facebook.com/hunkieproductions",
            "https://instagram.com/hunkieproductions",
            "https://twitter.com/hunkiepro"
        ]
    }
    </script>
    @endverbatim

    <style>
        html { scroll-behavior: smooth; }
        .navbar-scrolled { background: rgba(15, 23, 42, 0.95) !important; backdrop-filter: blur(10px); box-shadow: 0 2px 20px rgba(0,0,0,0.3); }
        .floating-icon { animation: float 6s ease-in-out infinite; }
        .floating-icon:nth-child(2) { animation-delay: 1s; }
        .floating-icon:nth-child(3) { animation-delay: 2s; }
        .floating-icon:nth-child(4) { animation-delay: 3s; }
        .floating-icon:nth-child(5) { animation-delay: 4s; }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        .step-connector { position: absolute; top: 2.5rem; left: 50%; width: 100%; height: 2px; background: linear-gradient(to right, #D4AF37, #1E40AF, #D4AF37); }
        @media (max-width: 768px) { .step-connector { display: none; } }
        .swiper-pagination-bullet-active { background: #D4AF37 !important; }
        .polaroid { background: white; padding: 8px 8px 40px 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .polaroid:hover { transform: rotate(-2deg) scale(1.03); }
        .polaroid:nth-child(even):hover { transform: rotate(2deg) scale(1.03); }
        .service-card { transition: all 0.3s ease; }
        .service-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
        .portfolio-item .overlay { opacity: 0; transition: opacity 0.3s ease; }
        .portfolio-item:hover .overlay { opacity: 1; }
        .brand-logo { filter: grayscale(1); opacity: 0.5; transition: all 0.3s; }
        .brand-logo:hover { filter: grayscale(0); opacity: 1; }
        [x-cloak] { display: none !important; }
        .modal-backdrop { animation: fadeIn 0.2s ease-out; }
        .modal-content { animation: slideUp 0.3s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="font-sans antialiased bg-white text-slate-800">

    {{-- Navbar --}}
    <nav id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <a href="#home" class="flex items-center space-x-2">
                    <span class="text-3xl font-black font-display text-gold">HUNKIE</span>
                    <span class="text-xl font-bold text-white hidden sm:inline">PRODUCTIONS</span>
                </a>
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="#home" class="text-white/90 hover:text-gold transition text-sm font-medium">Home</a>
                    <a href="#about" class="text-white/90 hover:text-gold transition text-sm font-medium">About</a>
                    <a href="#services" class="text-white/90 hover:text-gold transition text-sm font-medium">Services</a>
                    <a href="#portfolio" class="text-white/90 hover:text-gold transition text-sm font-medium">Portfolio</a>
                    <a href="#reviews" class="text-white/90 hover:text-gold transition text-sm font-medium">Reviews</a>
                    <a href="#gallery" class="text-white/90 hover:text-gold transition text-sm font-medium">Gallery</a>
                    <a href="#contact" class="text-white/90 hover:text-gold transition text-sm font-medium">Contact</a>
                    <a href="tel:+1234567890" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gold text-gold rounded-full text-sm font-semibold hover:bg-gold hover:text-slate-900 transition">
                        <i class="fas fa-phone-alt text-xs"></i> Call Now
                    </a>
                </div>
                <button id="mobile-menu-btn" class="lg:hidden text-white text-2xl focus:outline-none" onclick="toggleMobileMenu()">
                    <i id="menu-icon" class="fas fa-bars"></i>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden lg:hidden bg-slate-900/95 backdrop-blur-md border-t border-white/10">
            <div class="px-4 py-4 space-y-3">
                <a href="#home" class="block text-white/80 hover:text-gold py-2" onclick="toggleMobileMenu()">Home</a>
                <a href="#about" class="block text-white/80 hover:text-gold py-2" onclick="toggleMobileMenu()">About</a>
                <a href="#services" class="block text-white/80 hover:text-gold py-2" onclick="toggleMobileMenu()">Services</a>
                <a href="#portfolio" class="block text-white/80 hover:text-gold py-2" onclick="toggleMobileMenu()">Portfolio</a>
                <a href="#reviews" class="block text-white/80 hover:text-gold py-2" onclick="toggleMobileMenu()">Reviews</a>
                <a href="#gallery" class="block text-white/80 hover:text-gold py-2" onclick="toggleMobileMenu()">Gallery</a>
                <a href="#contact" class="block text-white/80 hover:text-gold py-2" onclick="toggleMobileMenu()">Contact</a>
                <a href="tel:+1234567890" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gold text-gold rounded-full text-sm font-semibold">
                    <i class="fas fa-phone-alt text-xs"></i> Call Now
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section id="home" class="relative min-h-screen flex items-center justify-center overflow-hidden" style="background: linear-gradient(135deg, #0F172A 0%, #1E3A8A 50%, #0F172A 100%);">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-[15%] left-[10%] floating-icon text-white/10 text-6xl"><i class="fas fa-camera"></i></div>
            <div class="absolute top-[25%] right-[15%] floating-icon text-white/10 text-5xl"><i class="fas fa-video"></i></div>
            <div class="absolute bottom-[30%] left-[20%] floating-icon text-white/10 text-4xl"><i class="fas fa-film"></i></div>
            <div class="absolute bottom-[20%] right-[10%] floating-icon text-white/10 text-5xl"><i class="fas fa-cut"></i></div>
            <div class="absolute top-[50%] left-[5%] floating-icon text-white/10 text-4xl"><i class="fas fa-music"></i></div>
            <div class="absolute top-[60%] right-[5%] floating-icon text-white/10 text-3xl"><i class="fas fa-photo-video"></i></div>
        </div>
        <div class="relative z-10 text-center px-4 max-w-5xl">
            <div class="mb-4 inline-block">
                <span class="text-gold text-lg tracking-[0.3em] font-medium uppercase">Premier Media Production</span>
            </div>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black font-display leading-tight mb-6">
                <span class="text-gold">HUNKIE</span>
                <span class="text-white"> PRODUCTIONS</span>
            </h1>
            <p class="text-xl md:text-2xl text-slate-300 font-light mb-10 max-w-3xl mx-auto">Capturing Moments, Creating Masterpieces</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#portfolio" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-gold text-slate-900 rounded-full text-lg font-bold hover:bg-gold-600 transition shadow-lg shadow-gold/25">
                    <i class="fas fa-play-circle"></i> View Our Work
                </a>
                <a href="#contact" class="inline-flex items-center justify-center gap-3 px-8 py-4 border-2 border-white text-white rounded-full text-lg font-semibold hover:bg-white hover:text-slate-900 transition">
                    <i class="fas fa-file-invoice"></i> Get a Quote
                </a>
            </div>
        </div>
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
            <a href="#about" class="text-white/60 hover:text-gold text-2xl"><i class="fas fa-chevron-down"></i></a>
        </div>
    </section>

    {{-- About Section --}}
    <section id="about" class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="bg-gradient-to-br from-slate-100 to-blue-50 rounded-2xl flex items-center justify-center h-[400px] lg:h-[500px] shadow-lg">
                    <div class="text-center">
                        <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-camera text-5xl text-royal"></i>
                        </div>
                        <p class="text-slate-400 font-medium">Your Vision, Our Lens</p>
                    </div>
                </div>
                <div>
                    <h2 class="text-4xl md:text-5xl font-black font-display mb-6">
                        <span class="text-royal">About</span>
                        <span class="text-slate-900"> Hunkie Productions</span>
                    </h2>
                    <p class="text-slate-600 leading-relaxed mb-6 text-lg">
                        At Hunkie Productions, we believe every moment tells a story. From intimate events to large-scale commercial productions, our team of passionate creatives brings your vision to life with cinematic excellence.
                    </p>
                    <p class="text-slate-500 leading-relaxed mb-8">
                        With years of experience in photography, videography, and post-production, we blend artistic vision with technical precision to deliver content that captivates and inspires.
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-royal/5 p-6 rounded-xl border-l-4 border-royal">
                            <h3 class="font-bold text-royal text-lg mb-2">Mission</h3>
                            <p class="text-slate-600 text-sm">To deliver exceptional visual content that exceeds expectations and tells compelling stories through the lens.</p>
                        </div>
                        <div class="bg-gold/5 p-6 rounded-xl border-l-4 border-gold">
                            <h3 class="font-bold text-gold-600 text-lg mb-2">Vision</h3>
                            <p class="text-slate-600 text-sm">To be East Africa's most sought-after production house, known for creativity, quality, and professionalism.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Workflow Section --}}
    <section id="workflow" class="py-20 md:py-28 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black font-display mb-4">
                    <span class="text-royal">How</span>
                    <span class="text-slate-900"> We Work</span>
                </h2>
                <p class="text-slate-500 text-lg max-w-2xl mx-auto">A seamless process from concept to final delivery</p>
            </div>
            @if(isset($workflowSteps) && count($workflowSteps) > 0)
            <div class="relative grid md:grid-cols-{{ min(count($workflowSteps), 4) }} gap-8">
                @if(count($workflowSteps) > 1)
                <div class="hidden md:block step-connector"></div>
                @endif
                @foreach($workflowSteps as $index => $step)
                <div class="relative text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center text-2xl font-bold shadow-lg {{ $index % 2 === 0 ? 'bg-royal text-white' : 'bg-gold text-slate-900' }}" style="position:relative; z-index:2;">
                        <i class="fas {{ $step['icon'] ?? 'fa-arrow-right' }}"></i>
                    </div>
                    <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-10 h-10 rounded-full {{ $index % 2 === 0 ? 'bg-royal/20' : 'bg-gold/20' }} flex items-center justify-center text-sm font-bold {{ $index % 2 === 0 ? 'text-royal' : 'text-gold-600' }}" style="z-index:3;">
                        {{ $index + 1 }}
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $step['name'] ?? $step['title'] ?? 'Step ' . ($index + 1) }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ $step['description'] ?? '' }}</p>
                </div>
                @endforeach
            </div>
            @else
            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-royal flex items-center justify-center text-2xl text-white shadow-lg" style="position:relative; z-index:2;">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-10 h-10 rounded-full bg-royal/20 flex items-center justify-center text-sm font-bold text-royal" style="z-index:3;">1</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Concept</h3>
                    <p class="text-slate-500 text-sm">We brainstorm and plan every detail of your project</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gold flex items-center justify-center text-2xl text-slate-900 shadow-lg" style="position:relative; z-index:2;">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center text-sm font-bold text-gold-600" style="z-index:3;">2</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Shoot</h3>
                    <p class="text-slate-500 text-sm">Professional capture with top-tier equipment</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-royal flex items-center justify-center text-2xl text-white shadow-lg" style="position:relative; z-index:2;">
                        <i class="fas fa-cut"></i>
                    </div>
                    <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-10 h-10 rounded-full bg-royal/20 flex items-center justify-center text-sm font-bold text-royal" style="z-index:3;">3</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Edit</h3>
                    <p class="text-slate-500 text-sm">Post-production magic with industry-leading software</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gold flex items-center justify-center text-2xl text-slate-900 shadow-lg" style="position:relative; z-index:2;">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center text-sm font-bold text-gold-600" style="z-index:3;">4</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Deliver</h3>
                    <p class="text-slate-500 text-sm">Polished final product delivered on time</p>
                </div>
            </div>
            @endif
        </div>
    </section>

    {{-- Services Section --}}
    <section id="services" class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black font-display mb-4">
                    <span class="text-royal">Our</span>
                    <span class="text-slate-900"> Services</span>
                </h2>
                <p class="text-slate-500 text-lg max-w-2xl mx-auto">Comprehensive media production services tailored to your needs</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($serviceCategories ?? [] as $service)
                <div class="service-card bg-white rounded-2xl p-8 shadow-lg border border-slate-100 flex flex-col">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-royal/10 to-blue-100 flex items-center justify-center mb-6">
                        <i class="fas {{ $service['icon'] ?? 'fa-camera' }} text-3xl text-royal"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-3">{{ $service['name'] ?? 'Service' }}</h3>
                    <p class="text-slate-500 mb-6 flex-grow">{{ $service['description'] ?? '' }}</p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="openPreviewModal('{{ $service['name'] ?? 'Service' }}', '{{ $service['description'] ?? '' }}')" class="flex-1 px-4 py-3 border-2 border-royal text-royal rounded-xl text-sm font-semibold hover:bg-royal hover:text-white transition text-center">
                            <i class="fas fa-eye mr-2"></i>Preview
                        </button>
                        <button onclick="openWhatsAppModal('{{ $service['name'] ?? 'Service' }}')" class="flex-1 px-4 py-3 bg-gold text-slate-900 rounded-xl text-sm font-bold hover:bg-gold-600 transition text-center">
                            <i class="fab fa-whatsapp mr-2"></i>Book via WhatsApp
                        </button>
                    </div>
                </div>
                @empty
                <div class="service-card bg-white rounded-2xl p-8 shadow-lg border border-slate-100 flex flex-col">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-royal/10 to-blue-100 flex items-center justify-center mb-6">
                        <i class="fas fa-camera text-3xl text-royal"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-3">Photography</h3>
                    <p class="text-slate-500 mb-6 flex-grow">Professional photography services for events, portraits, commercial shoots, and more.</p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="openPreviewModal('Photography', 'Professional photography services for events, portraits, commercial shoots, and more.')" class="flex-1 px-4 py-3 border-2 border-royal text-royal rounded-xl text-sm font-semibold hover:bg-royal hover:text-white transition text-center">
                            <i class="fas fa-eye mr-2"></i>Preview
                        </button>
                        <button onclick="openWhatsAppModal('Photography')" class="flex-1 px-4 py-3 bg-gold text-slate-900 rounded-xl text-sm font-bold hover:bg-gold-600 transition text-center">
                            <i class="fab fa-whatsapp mr-2"></i>Book via WhatsApp
                        </button>
                    </div>
                </div>
                <div class="service-card bg-white rounded-2xl p-8 shadow-lg border border-slate-100 flex flex-col">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-royal/10 to-blue-100 flex items-center justify-center mb-6">
                        <i class="fas fa-video text-3xl text-royal"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-3">Videography</h3>
                    <p class="text-slate-500 mb-6 flex-grow">Cinematic video production for weddings, corporate films, music videos, and documentaries.</p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="openPreviewModal('Videography', 'Cinematic video production for weddings, corporate films, music videos, and documentaries.')" class="flex-1 px-4 py-3 border-2 border-royal text-royal rounded-xl text-sm font-semibold hover:bg-royal hover:text-white transition text-center">
                            <i class="fas fa-eye mr-2"></i>Preview
                        </button>
                        <button onclick="openWhatsAppModal('Videography')" class="flex-1 px-4 py-3 bg-gold text-slate-900 rounded-xl text-sm font-bold hover:bg-gold-600 transition text-center">
                            <i class="fab fa-whatsapp mr-2"></i>Book via WhatsApp
                        </button>
                    </div>
                </div>
                <div class="service-card bg-white rounded-2xl p-8 shadow-lg border border-slate-100 flex flex-col">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-royal/10 to-blue-100 flex items-center justify-center mb-6">
                        <i class="fas fa-paint-brush text-3xl text-royal"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-3">Post Production</h3>
                    <p class="text-slate-500 mb-6 flex-grow">Expert editing, color grading, motion graphics, and sound design to polish your content.</p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="openPreviewModal('Post Production', 'Expert editing, color grading, motion graphics, and sound design to polish your content.')" class="flex-1 px-4 py-3 border-2 border-royal text-royal rounded-xl text-sm font-semibold hover:bg-royal hover:text-white transition text-center">
                            <i class="fas fa-eye mr-2"></i>Preview
                        </button>
                        <button onclick="openWhatsAppModal('Post Production')" class="flex-1 px-4 py-3 bg-gold text-slate-900 rounded-xl text-sm font-bold hover:bg-gold-600 transition text-center">
                            <i class="fab fa-whatsapp mr-2"></i>Book via WhatsApp
                        </button>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Portfolio Section --}}
    <section id="portfolio" class="py-20 md:py-28 bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-black font-display mb-4">
                    <span class="text-gold">Our</span>
                    <span class="text-white"> Portfolio</span>
                </h2>
                <p class="text-slate-400 text-lg max-w-2xl mx-auto">A showcase of our finest work</p>
            </div>
            @php
                $categories = collect($featuredMedia ?? [])
                    ->pluck('portfolioCategory.name')
                    ->filter()
                    ->unique();
            @endphp
            <div class="flex flex-wrap justify-center gap-3 mb-12" id="portfolio-filters">
                <button class="filter-btn px-6 py-2 rounded-full text-sm font-semibold transition bg-gold text-slate-900" data-filter="all" onclick="filterPortfolio('all')">All</button>
                @foreach($categories as $category)
                <button class="filter-btn px-6 py-2 rounded-full text-sm font-semibold transition bg-white/10 text-white/70 hover:bg-white/20" data-filter="{{ Str::slug($category) }}" onclick="filterPortfolio('{{ Str::slug($category) }}')">{{ $category }}</button>
                @endforeach
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" id="portfolio-grid">
                @forelse($featuredMedia ?? [] as $media)
                @php
                    $catName = $media->portfolioCategory?->name ?? 'Uncategorized';
                    $mediaIcon = match($media->media_type) { 'video' => 'fa-video', 'image' => 'fa-image', default => 'fa-file' };
                @endphp
                <div class="portfolio-item relative rounded-xl overflow-hidden group cursor-pointer" data-category="{{ Str::slug($catName) }}">
                    <div class="bg-gradient-to-br {{ $loop->index % 2 === 0 ? 'from-royal/30 to-blue-900' : 'from-gold/30 to-amber-900' }} h-72 flex items-center justify-center">
                        <i class="fas {{ $mediaIcon }} text-6xl text-white/30"></i>
                    </div>
                    <div class="overlay absolute inset-0 bg-gradient-to-t from-slate-900/95 via-slate-900/50 to-transparent flex flex-col justify-end p-6">
                        <span class="text-gold text-xs font-semibold uppercase tracking-wider mb-2">{{ $catName }}</span>
                        <h3 class="text-white text-xl font-bold mb-3">{{ $media->title }}</h3>
                        <button onclick="openPreviewModal(@js($media->title), @js($media->description ?? ''))" class="inline-flex items-center gap-2 text-white border border-white/30 rounded-full px-4 py-2 text-sm hover:bg-white hover:text-slate-900 transition self-start">
                            <i class="fas fa-expand"></i> View Details
                        </button>
                    </div>
                </div>
                @empty
                <div class="portfolio-item relative rounded-xl overflow-hidden group cursor-pointer" data-category="all">
                    <div class="bg-gradient-to-br from-royal/30 to-blue-900 h-72 flex items-center justify-center">
                        <i class="fas fa-image text-6xl text-white/30"></i>
                    </div>
                    <div class="overlay absolute inset-0 bg-gradient-to-t from-slate-900/95 via-slate-900/50 to-transparent flex flex-col justify-end p-6">
                        <span class="text-gold text-xs font-semibold uppercase tracking-wider mb-2">Wedding</span>
                        <h3 class="text-white text-xl font-bold mb-3">Elegant Wedding Gallery</h3>
                        <button onclick="openPreviewModal('Elegant Wedding Gallery', 'A beautiful collection of wedding moments captured with cinematic precision.')" class="inline-flex items-center gap-2 text-white border border-white/30 rounded-full px-4 py-2 text-sm hover:bg-white hover:text-slate-900 transition self-start">
                            <i class="fas fa-expand"></i> View Details
                        </button>
                    </div>
                </div>
                <div class="portfolio-item relative rounded-xl overflow-hidden group cursor-pointer" data-category="all">
                    <div class="bg-gradient-to-br from-gold/30 to-amber-900 h-72 flex items-center justify-center">
                        <i class="fas fa-video text-6xl text-white/30"></i>
                    </div>
                    <div class="overlay absolute inset-0 bg-gradient-to-t from-slate-900/95 via-slate-900/50 to-transparent flex flex-col justify-end p-6">
                        <span class="text-gold text-xs font-semibold uppercase tracking-wider mb-2">Corporate</span>
                        <h3 class="text-white text-xl font-bold mb-3">Brand Commercial</h3>
                        <button onclick="openPreviewModal('Brand Commercial', 'Professional corporate video production for a leading brand.')" class="inline-flex items-center gap-2 text-white border border-white/30 rounded-full px-4 py-2 text-sm hover:bg-white hover:text-slate-900 transition self-start">
                            <i class="fas fa-expand"></i> View Details
                        </button>
                    </div>
                </div>
                <div class="portfolio-item relative rounded-xl overflow-hidden group cursor-pointer" data-category="all">
                    <div class="bg-gradient-to-br from-emerald-500/30 to-teal-900 h-72 flex items-center justify-center">
                        <i class="fas fa-music text-6xl text-white/30"></i>
                    </div>
                    <div class="overlay absolute inset-0 bg-gradient-to-t from-slate-900/95 via-slate-900/50 to-transparent flex flex-col justify-end p-6">
                        <span class="text-gold text-xs font-semibold uppercase tracking-wider mb-2">Music Video</span>
                        <h3 class="text-white text-xl font-bold mb-3">Artists Visualizer</h3>
                        <button onclick="openPreviewModal('Artists Visualizer', 'Music video production with creative visual effects and storytelling.')" class="inline-flex items-center gap-2 text-white border border-white/30 rounded-full px-4 py-2 text-sm hover:bg-white hover:text-slate-900 transition self-start">
                            <i class="fas fa-expand"></i> View Details
                        </button>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Reviews Section --}}
    <section id="reviews" class="py-20 md:py-28 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black font-display mb-4">
                    <span class="text-royal">What</span>
                    <span class="text-slate-900"> Our Clients Say</span>
                </h2>
                <p class="text-slate-500 text-lg">Hear from the people we've worked with</p>
            </div>
            <div class="swiper reviews-swiper">
                <div class="swiper-wrapper">
                    @forelse($reviews ?? [] as $review)
                    <div class="swiper-slide">
                        <div class="bg-slate-50 rounded-2xl p-8 md:p-10 text-center max-w-2xl mx-auto">
                            <div class="text-gold text-5xl mb-6 opacity-30"><i class="fas fa-quote-left"></i></div>
                            <p class="text-slate-600 text-lg leading-relaxed mb-8 italic">"{{ $review->content }}"</p>
                            <div class="flex items-center justify-center gap-1 mb-3">
                                @for($i = 0; $i < $review->rating; $i++)
                                <i class="fas fa-star text-gold"></i>
                                @endfor
                                @for($i = $review->rating; $i < 5; $i++)
                                <i class="far fa-star text-gold"></i>
                                @endfor
                            </div>
                            <div class="font-bold text-slate-800 text-lg">{{ $review->client_name }}</div>
                            <div class="text-slate-400 text-sm">{{ $review->serviceCategory?->name ?? $review->project?->title ?? '' }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="swiper-slide">
                        <div class="bg-slate-50 rounded-2xl p-8 md:p-10 text-center max-w-2xl mx-auto">
                            <div class="text-gold text-5xl mb-6 opacity-30"><i class="fas fa-quote-left"></i></div>
                            <p class="text-slate-600 text-lg leading-relaxed mb-8 italic">"Hunkie Productions exceeded our expectations! The team was professional, creative, and delivered stunning results that captured the essence of our event perfectly."</p>
                            <div class="flex items-center justify-center gap-1 mb-3">
                                <i class="fas fa-star text-gold"></i>
                                <i class="fas fa-star text-gold"></i>
                                <i class="fas fa-star text-gold"></i>
                                <i class="fas fa-star text-gold"></i>
                                <i class="fas fa-star text-gold"></i>
                            </div>
                            <div class="font-bold text-slate-800 text-lg">Sarah Wanjiku</div>
                            <div class="text-slate-400 text-sm">Wedding Client</div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg-slate-50 rounded-2xl p-8 md:p-10 text-center max-w-2xl mx-auto">
                            <div class="text-gold text-5xl mb-6 opacity-30"><i class="fas fa-quote-left"></i></div>
                            <p class="text-slate-600 text-lg leading-relaxed mb-8 italic">"The corporate video they produced for our brand was nothing short of cinematic brilliance. Highly recommended for any business looking to elevate their visual presence."</p>
                            <div class="flex items-center justify-center gap-1 mb-3">
                                <i class="fas fa-star text-gold"></i>
                                <i class="fas fa-star text-gold"></i>
                                <i class="fas fa-star text-gold"></i>
                                <i class="fas fa-star text-gold"></i>
                                <i class="fas fa-star text-gold"></i>
                            </div>
                            <div class="font-bold text-slate-800 text-lg">James Kiprop</div>
                            <div class="text-slate-400 text-sm">CEO, TechCorp Ltd</div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg-slate-50 rounded-2xl p-8 md:p-10 text-center max-w-2xl mx-auto">
                            <div class="text-gold text-5xl mb-6 opacity-30"><i class="fas fa-quote-left"></i></div>
                            <p class="text-slate-600 text-lg leading-relaxed mb-8 italic">"From concept to delivery, the Hunkie team was incredible. Our music video looks amazing thanks to their creative direction and technical expertise."</p>
                            <div class="flex items-center justify-center gap-1 mb-3">
                                <i class="fas fa-star text-gold"></i>
                                <i class="fas fa-star text-gold"></i>
                                <i class="fas fa-star text-gold"></i>
                                <i class="fas fa-star text-gold"></i>
                                <i class="fas fa-star text-gold"></i>
                            </div>
                            <div class="font-bold text-slate-800 text-lg">Mzee Vibes</div>
                            <div class="text-slate-400 text-sm">Recording Artist</div>
                        </div>
                    </div>
                    @endforelse
                </div>
                <div class="swiper-pagination mt-8"></div>
            </div>
        </div>
    </section>

    {{-- Social Gallery Section --}}
    <section id="gallery" class="py-20 md:py-28 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black font-display mb-4">
                    <span class="text-royal">Follow</span>
                    <span class="text-slate-900"> Us</span>
                </h2>
                <p class="text-slate-500 text-lg">Behind the scenes & latest work on social media</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($galleryPosts ?? [] as $post)
                @php
                    $colors = ['blue', 'purple', 'amber', 'emerald', 'pink', 'cyan'];
                    $color = $colors[$loop->index % count($colors)];
                    $postIcon = $post->event_type === 'video' ? 'fa-video' : 'fa-camera';
                @endphp
                <div class="polaroid rounded-lg">
                    <div class="bg-gradient-to-br from-{{ $color }}-100 to-{{ $color }}-200 h-56 flex items-center justify-center rounded">
                        <i class="fas {{ $postIcon }} text-5xl text-white/50"></i>
                    </div>
                    <div class="mt-3 px-1">
                        <p class="text-slate-700 text-sm font-medium truncate">{{ $post->caption }}</p>
                        <div class="flex items-center justify-between mt-2 text-slate-400 text-xs">
                            <span><i class="fas fa-heart text-red-400 mr-1"></i> {{ $post->likes_count ?? $post->likes->count() }}</span>
                            <span><i class="fas fa-download mr-1"></i> {{ $post->downloads_count ?? $post->downloads->count() }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="polaroid rounded-lg">
                    <div class="bg-gradient-to-br from-blue-100 to-blue-200 h-56 flex items-center justify-center rounded">
                        <i class="fas fa-camera text-5xl text-blue-300"></i>
                    </div>
                    <div class="mt-3 px-1">
                        <p class="text-slate-700 text-sm font-medium truncate">Behind the scenes at Hunkie Productions</p>
                        <div class="flex items-center justify-between mt-2 text-slate-400 text-xs">
                            <span><i class="fas fa-heart text-red-400 mr-1"></i> 245</span>
                            <span><i class="fas fa-download mr-1"></i> 18</span>
                        </div>
                    </div>
                </div>
                <div class="polaroid rounded-lg">
                    <div class="bg-gradient-to-br from-purple-100 to-purple-200 h-56 flex items-center justify-center rounded">
                        <i class="fas fa-video text-5xl text-purple-300"></i>
                    </div>
                    <div class="mt-3 px-1">
                        <p class="text-slate-700 text-sm font-medium truncate">Latest corporate shoot highlights</p>
                        <div class="flex items-center justify-between mt-2 text-slate-400 text-xs">
                            <span><i class="fas fa-heart text-red-400 mr-1"></i> 189</span>
                            <span><i class="fas fa-download mr-1"></i> 12</span>
                        </div>
                    </div>
                </div>
                <div class="polaroid rounded-lg">
                    <div class="bg-gradient-to-br from-amber-100 to-amber-200 h-56 flex items-center justify-center rounded">
                        <i class="fas fa-image text-5xl text-amber-300"></i>
                    </div>
                    <div class="mt-3 px-1">
                        <p class="text-slate-700 text-sm font-medium truncate">Golden hour photography session</p>
                        <div class="flex items-center justify-between mt-2 text-slate-400 text-xs">
                            <span><i class="fas fa-heart text-red-400 mr-1"></i> 312</span>
                            <span><i class="fas fa-download mr-1"></i> 27</span>
                        </div>
                    </div>
                </div>
                <div class="polaroid rounded-lg">
                    <div class="bg-gradient-to-br from-emerald-100 to-emerald-200 h-56 flex items-center justify-center rounded">
                        <i class="fas fa-film text-5xl text-emerald-300"></i>
                    </div>
                    <div class="mt-3 px-1">
                        <p class="text-slate-700 text-sm font-medium truncate">Editing bay setup walkthrough</p>
                        <div class="flex items-center justify-between mt-2 text-slate-400 text-xs">
                            <span><i class="fas fa-heart text-red-400 mr-1"></i> 156</span>
                            <span><i class="fas fa-download mr-1"></i> 9</span>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Trusted Brands Section --}}
    <section class="py-16 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-black font-display">
                    <span class="text-royal">Trusted</span>
                    <span class="text-slate-700"> By</span>
                </h2>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-8 md:gap-16">
                @forelse($trustedBrands ?? $partners ?? [] as $brand)
                <div class="brand-logo w-32 h-16 bg-slate-100 rounded-lg flex items-center justify-center">
                    <span class="text-slate-400 font-bold text-sm">{{ $brand['name'] ?? $brand ?? 'Brand' }}</span>
                </div>
                @empty
                <div class="brand-logo w-32 h-16 bg-slate-100 rounded-lg flex items-center justify-center"><span class="text-slate-400 font-bold text-sm">BrandCo</span></div>
                <div class="brand-logo w-32 h-16 bg-slate-100 rounded-lg flex items-center justify-center"><span class="text-slate-400 font-bold text-sm">MediaPlus</span></div>
                <div class="brand-logo w-32 h-16 bg-slate-100 rounded-lg flex items-center justify-center"><span class="text-slate-400 font-bold text-sm">CreativeHub</span></div>
                <div class="brand-logo w-32 h-16 bg-slate-100 rounded-lg flex items-center justify-center"><span class="text-slate-400 font-bold text-sm">VisionCorp</span></div>
                <div class="brand-logo w-32 h-16 bg-slate-100 rounded-lg flex items-center justify-center"><span class="text-slate-400 font-bold text-sm">Studio 9</span></div>
                <div class="brand-logo w-32 h-16 bg-slate-100 rounded-lg flex items-center justify-center"><span class="text-slate-400 font-bold text-sm">PixelPro</span></div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Contact/CTA Section --}}
    <section id="contact" class="py-20 md:py-28 bg-royal">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-black font-display text-white mb-6">Ready to Create Something Amazing?</h2>
            <p class="text-blue-200 text-lg md:text-xl mb-10 max-w-2xl mx-auto">Let's bring your vision to life. Reach out today and let's start crafting your masterpiece.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:+1234567890" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-white text-royal rounded-full text-lg font-bold hover:bg-slate-100 transition shadow-lg">
                    <i class="fas fa-phone-alt"></i> Call Us
                </a>
                <a href="mailto:info@hunkieproductions.com" class="inline-flex items-center justify-center gap-3 px-8 py-4 border-2 border-white text-white rounded-full text-lg font-semibold hover:bg-white hover:text-royal transition">
                    <i class="fas fa-envelope"></i> Get in Touch
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-slate-900 text-slate-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="text-2xl font-black font-display text-gold">HUNKIE</span>
                        <span class="text-lg font-bold text-white">PRODUCTIONS</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">Capturing moments, creating masterpieces. Premier media production company specializing in photography, videography, and content creation.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-gold hover:text-slate-900 transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-gold hover:text-slate-900 transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-gold hover:text-slate-900 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-gold hover:text-slate-900 transition"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-gold hover:text-slate-900 transition"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg mb-6">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="#home" class="text-slate-400 hover:text-gold text-sm transition">Home</a></li>
                        <li><a href="#about" class="text-slate-400 hover:text-gold text-sm transition">About Us</a></li>
                        <li><a href="#services" class="text-slate-400 hover:text-gold text-sm transition">Services</a></li>
                        <li><a href="#portfolio" class="text-slate-400 hover:text-gold text-sm transition">Portfolio</a></li>
                        <li><a href="#reviews" class="text-slate-400 hover:text-gold text-sm transition">Reviews</a></li>
                        <li><a href="#contact" class="text-slate-400 hover:text-gold text-sm transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg mb-6">Services</h3>
                    <ul class="space-y-3">
                        <li><a href="#services" class="text-slate-400 hover:text-gold text-sm transition">Photography</a></li>
                        <li><a href="#services" class="text-slate-400 hover:text-gold text-sm transition">Videography</a></li>
                        <li><a href="#services" class="text-slate-400 hover:text-gold text-sm transition">Post Production</a></li>
                        <li><a href="#services" class="text-slate-400 hover:text-gold text-sm transition">Event Coverage</a></li>
                        <li><a href="#services" class="text-slate-400 hover:text-gold text-sm transition">Commercial Shoots</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg mb-6">Contact Info</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-gold mt-1"></i>
                            <span class="text-slate-400 text-sm">123 Production Lane, Nairobi, Kenya</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-phone-alt text-gold mt-1"></i>
                            <a href="tel:+1234567890" class="text-slate-400 hover:text-gold text-sm transition">+1 (234) 567-890</a>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-envelope text-gold mt-1"></i>
                            <a href="mailto:info@hunkieproductions.com" class="text-slate-400 hover:text-gold text-sm transition">info@hunkieproductions.com</a>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-clock text-gold mt-1"></i>
                            <span class="text-slate-400 text-sm">Mon - Sat: 8:00 AM - 6:00 PM</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-t border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-slate-500 text-sm">&copy; {{ date('Y') }} Hunkie Productions. All rights reserved.</p>
                <div class="flex gap-6 text-xs text-slate-500">
                    <a href="#" class="hover:text-gold transition">Privacy Policy</a>
                    <a href="#" class="hover:text-gold transition">Terms of Service</a>
                    <a href="#" class="hover:text-gold transition">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Preview Modal --}}
    <div id="preview-modal" class="fixed inset-0 z-[100] hidden">
        <div class="modal-backdrop absolute inset-0 bg-black/60" onclick="closePreviewModal()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="modal-content bg-white rounded-2xl max-w-lg w-full p-8 relative">
                <button onclick="closePreviewModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-xl"><i class="fas fa-times"></i></button>
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-royal/10 to-blue-100 flex items-center justify-center mb-6">
                    <i class="fas fa-camera text-3xl text-royal"></i>
                </div>
                <h3 id="preview-modal-title" class="text-2xl font-bold text-slate-800 mb-4">Service Title</h3>
                <p id="preview-modal-description" class="text-slate-500 leading-relaxed mb-6">Service description goes here.</p>
                <div class="border-t border-slate-100 pt-6">
                    <h4 class="font-semibold text-slate-700 mb-3">Why choose this service?</h4>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-gold"></i> Professional-grade equipment</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-gold"></i> Experienced creative team</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-gold"></i> Timely delivery guaranteed</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-gold"></i> Customized to your needs</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- WhatsApp Booking Modal --}}
    <div id="whatsapp-modal" class="fixed inset-0 z-[100] hidden">
        <div class="modal-backdrop absolute inset-0 bg-black/60" onclick="closeWhatsAppModal()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="modal-content bg-white rounded-2xl max-w-md w-full p-8 relative">
                <button onclick="closeWhatsAppModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-xl"><i class="fas fa-times"></i></button>
                <div class="text-center mb-6">
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fab fa-whatsapp text-3xl text-green-500"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800">Book via WhatsApp</h3>
                    <p class="text-slate-500 text-sm mt-1">Service: <span id="whatsapp-service-name" class="font-semibold text-royal">Photography</span></p>
                </div>
                <form id="whatsapp-form" class="space-y-4" onsubmit="submitWhatsApp(event)">
                    <input type="hidden" id="booking-service" value="">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Your Name *</label>
                        <input type="text" id="booking-name" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-royal focus:border-transparent outline-none text-sm" placeholder="John Doe">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Phone Number *</label>
                        <input type="tel" id="booking-phone" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-royal focus:border-transparent outline-none text-sm" placeholder="+254 712 345 678">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                        <input type="email" id="booking-email" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-royal focus:border-transparent outline-none text-sm" placeholder="john@example.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Event Date</label>
                        <input type="date" id="booking-date" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-royal focus:border-transparent outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Message</label>
                        <textarea id="booking-message" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-royal focus:border-transparent outline-none text-sm resize-none" placeholder="Tell us about your project..."></textarea>
                    </div>
                    <button type="submit" class="w-full py-4 bg-green-500 hover:bg-green-600 text-white rounded-xl font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-green-500/25">
                        <i class="fab fa-whatsapp text-xl"></i> Send via WhatsApp
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('menu-icon');
            menu.classList.toggle('hidden');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        }

        // Close mobile menu on link click
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                const menu = document.getElementById('mobile-menu');
                const icon = document.getElementById('menu-icon');
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                    icon.classList.add('fa-bars');
                    icon.classList.remove('fa-times');
                }
            });
        });

        // Portfolio filtering
        function filterPortfolio(category) {
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('bg-gold', 'text-slate-900');
                btn.classList.add('bg-white/10', 'text-white/70');
            });
            const activeBtn = document.querySelector(`.filter-btn[data-filter="${category}"]`);
            if (activeBtn) {
                activeBtn.classList.remove('bg-white/10', 'text-white/70');
                activeBtn.classList.add('bg-gold', 'text-slate-900');
            }
            document.querySelectorAll('.portfolio-item').forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Reviews Swiper
        new Swiper('.reviews-swiper', {
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            spaceBetween: 30,
            breakpoints: {
                640: { slidesPerView: 1 },
                768: { slidesPerView: 1 },
                1024: { slidesPerView: 1 }
            }
        });

        // Preview Modal
        function openPreviewModal(title, description) {
            document.getElementById('preview-modal-title').textContent = title;
            document.getElementById('preview-modal-description').textContent = description;
            document.getElementById('preview-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePreviewModal() {
            document.getElementById('preview-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // WhatsApp Modal
        function openWhatsAppModal(service) {
            document.getElementById('whatsapp-service-name').textContent = service;
            document.getElementById('booking-service').value = service;
            document.getElementById('whatsapp-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeWhatsAppModal() {
            document.getElementById('whatsapp-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Close modals on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closePreviewModal();
                closeWhatsAppModal();
            }
        });

        // WhatsApp form submission
        function submitWhatsApp(event) {
            event.preventDefault();
            const service = document.getElementById('booking-service').value;
            const name = document.getElementById('booking-name').value;
            const phone = document.getElementById('booking-phone').value;
            const email = document.getElementById('booking-email').value;
            const date = document.getElementById('booking-date').value;
            const message = document.getElementById('booking-message').value;

            const text = `Hello Hunkie Productions! I'd like to book the *${service}* service.%0A%0A*Name:* ${name}%0A*Phone:* ${phone}%0A*Email:* ${email}%0A*Event Date:* ${date}%0A*Message:* ${message}`;

            window.open(`https://wa.me/1234567890?text=${text}`, '_blank');
            closeWhatsAppModal();
            event.target.reset();
        }
    </script>
</body>
</html>
