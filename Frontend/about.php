<?php
$page_title = "About Us";
include 'includes/header.php';
?>

<!-- Secondary Hero -->
<!-- Split Hero -->
<section class="bg-primary relative overflow-hidden min-h-[60vh] flex items-center">
    <!-- Background Accents -->
    <div class="absolute top-0 right-0 w-1/2 h-full bg-primary/5 -skew-x-12 transform translate-x-20"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary/10 blur-[100px] rounded-full"></div>

    <div class="container mx-auto px-4 md:px-12 grid md:grid-cols-2 gap-12 md:gap-16 items-center relative z-10 pt-24 pb-12 md:py-20">
        <!-- Image Left Side -->
        <div class="relative group order-2 md:order-1">
            <div class="absolute -inset-4 bg-black/10 rounded-[3rem] blur-2xl group-hover:bg-black/20 transition duration-700"></div>
            <div class="relative aspect-[4/3] rounded-[3rem] overflow-hidden border border-white/20 shadow-2xl">
                <img src="assets/md gallery6.png" alt="Elite Academy Action" class="w-full h-full object-cover" loading="lazy" decoding="async">
                <div class="absolute inset-0 bg-black/20"></div>
            </div>
            <!-- Floating Badge -->
            <div class="absolute -bottom-6 -right-6 bg-white p-6 rounded-3xl shadow-2xl hidden lg:block">
                <div class="text-secondary font-black text-4xl tracking-tighter uppercase">10+</div>
                <div class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Years Elite</div>
            </div>
        </div>

        <!-- Text Right Side -->
        <div class="text-white order-1 md:order-2">
            <div class="inline-block bg-black/10 text-white border border-black/20 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-6">Established 2012</div>
            <h1 class="text-3xl md:text-8xl font-black uppercase italic tracking-tighter leading-[0.9] mb-8">
                Our <span class="text-secondary block italic">Legacy</span>
            </h1>
            <p class="text-white/90 text-lg md:text-xl font-bold tracking-wide leading-relaxed">
                Fueling the next generation of <span class="text-secondary uppercase">international sports icons</span> through precision and passion.
            </p>
        </div>
    </div>
</section>

<!-- About Detail -->
<section class="py-24 container mx-auto px-4 md:px-12">
    <div class="grid md:grid-cols-2 gap-20 items-center">
        <div>
            <h2 class="text-4xl font-black mb-8 italic uppercase tracking-tighter">Mission: <span class="text-primary italic">Global Performance</span></h2>
            <div class="h-1.5 w-20 bg-primary mb-12 rounded-full"></div>
            <div class="space-y-6 text-lg text-gray-600 leading-relaxed">
                <p>
                    BlueStone Elite Sports was founded with a single vision: to bridge the gap between regional talent and international excellence. We combine world-class coaching with advanced sports science to create an environment where athletes can thrive.
                </p>
                <p>
                    Our facility in Salem, TN, serves as a beacon for aspiring champions. We don't just train bodies; we build character, discipline, and the mental fortitude required for professional competition.
                </p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="aspect-square bg-slate-900 rounded-3xl overflow-hidden shadow-2xl mt-12 mb-12 border-4 border-white">
                <img src="assets/karate team.png" class="w-full h-full object-cover opacity-80 hover:opacity-100 transition duration-500" loading="lazy" decoding="async">
            </div>
            <div class="aspect-square bg-slate-900 rounded-3xl overflow-hidden shadow-2xl border-4 border-primary">
                <img src="assets/cricket team.png" class="w-full h-full object-cover opacity-80 hover:opacity-100 transition duration-500" loading="lazy" decoding="async">
            </div>
            <div class="aspect-square bg-slate-900 rounded-3xl overflow-hidden shadow-2xl -mt-12 border-4 border-primary">
                <img src="assets/gallery8.png" class="w-full h-full object-cover opacity-80 hover:opacity-100 transition duration-500" loading="lazy" decoding="async">
            </div>
            <div class="aspect-square bg-slate-900 rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                <img src="assets/gallery9.png" class="w-full h-full object-cover opacity-80 hover:opacity-100 transition duration-500" loading="lazy" decoding="async">
            </div>
        </div>
    </div>
</section>

<!-- Academy Vision (Transcribed from Branding) -->
<section class="py-24 bg-secondary text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1541252260730-0412e8e2108e?q=80&w=2674&auto=format&fit=crop')] opacity-10 bg-fixed bg-cover"></div>
    
    <div class="container mx-auto px-4 md:px-12 relative z-10 text-center">
        <!-- Tagline Badge -->
        <div class="inline-block bg-primary text-white px-10 py-4 rounded-full text-2xl font-black uppercase tracking-tighter mb-12 shadow-2xl shadow-primary/20">
            Train Hard. Play Smart. Rise Elite
        </div>

        <p class="max-w-4xl mx-auto text-lg md:text-xl font-bold leading-relaxed text-slate-300 mb-16">
            "Bluestone Elite Sports is a premier academy focused on identifying and nurturing young talent. With expert coaches, modern facilities, and performance-driven training, we help players grow as skilled athletes with discipline, fitness, and sportsmanship."
        </p>

        <!-- Program Divider -->
        <div class="flex flex-wrap items-center justify-center gap-8 md:gap-20 mb-20">
            <div class="text-center">
                <div class="text-xs font-black uppercase tracking-[0.3em] text-primary mb-2">Cricket</div>
                <div class="text-2xl font-black uppercase italic tracking-tighter">Training</div>
            </div>
            <div class="hidden md:block w-px h-12 bg-slate-700"></div>
            <div class="text-center">
                <div class="text-xs font-black uppercase tracking-[0.3em] text-primary mb-2">Silambam</div>
                <div class="text-2xl font-black uppercase italic tracking-tighter">Coaching</div>
            </div>
            <div class="hidden md:block w-px h-12 bg-slate-700"></div>
            <div class="text-center">
                <div class="text-xs font-black uppercase tracking-[0.3em] text-primary mb-2">Yoga &</div>
                <div class="text-2xl font-black uppercase italic tracking-tighter">Fitness</div>
            </div>
        </div>

        <!-- Vision Gallery (Circular) -->
        <div class="flex flex-row items-center justify-center gap-2 md:gap-4 mb-20 translate-y-10 group">
            <div class="w-32 h-32 md:w-64 md:h-64 rounded-full border-[6px] md:border-[10px] border-primary overflow-hidden shadow-2xl transform md:-translate-x-8 hover:scale-105 transition duration-500 shrink-0">
                <img src="assets/md gallery1.png" class="w-full h-full object-cover" loading="lazy" decoding="async">
            </div>
            <div class="w-40 h-40 md:w-80 md:h-80 rounded-full border-[8px] md:border-[12px] border-white overflow-hidden shadow-2xl z-20 scale-110 hover:scale-[1.15] transition duration-500 shrink-0">
                <img src="assets/md gallery3.png" class="w-full h-full object-cover" loading="lazy" decoding="async">
            </div>
            <div class="w-32 h-32 md:w-64 md:h-64 rounded-full border-[6px] md:border-[10px] border-primary overflow-hidden shadow-2xl transform md:translate-x-8 hover:scale-105 transition duration-500 shrink-0">
                <img src="assets/gallery10.png" class="w-full h-full object-cover" loading="lazy" decoding="async">
            </div>
        </div>

        <!-- Closing Sentiment -->
        <div class="mt-24 max-w-2xl mx-auto">
            <div class="bg-white/5 backdrop-blur-md p-8 rounded-3xl border border-white/10 mb-8">
                <p class="text-xl md:text-2xl font-black uppercase leading-1.5">
                    Transforming passion into performance and <span class="text-primary">potential into podium success!!</span>
                </p>
            </div>
            <div class="inline-flex items-center gap-4 bg-primary px-8 py-3 rounded-2xl border border-slate-700">
                <span class="text-xs font-bold uppercase tracking-widest text-secondary">Contact Elite</span>
                <span class="text-xl font-black text-white tracking-tighter">87788 39909</span>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="bg-gray-50 py-24">
    <div class="container mx-auto px-4 md:px-12 text-center mb-16">
        <h2 class="text-3xl font-black uppercase tracking-tighter">Our Core <span class="text-primary italic">Values</span></h2>
    </div>
    <div class="container mx-auto px-4 md:px-12 grid md:grid-cols-3 gap-8">
        <div class="bg-white p-12 rounded-[2.5rem] shadow-xl border border-gray-100 transition-transform hover:-translate-y-2">
            <div class="text-4xl mb-6">🔥</div>
            <h4 class="text-xl font-black uppercase mb-4">Passion</h4>
            <p class="text-gray-500 leading-relaxed text-sm">A relentless drive to be the best version of yourself, every single day.</p>
        </div>
        <div class="bg-white p-12 rounded-[2.5rem] shadow-xl border border-gray-100 transition-transform hover:-translate-y-2">
            <div class="text-4xl mb-6">🎯</div>
            <h4 class="text-xl font-black uppercase mb-4">Precision</h4>
            <p class="text-gray-500 leading-relaxed text-sm">Technical excellence in every movement, strategy, and mental process.</p>
        </div>
        <div class="bg-white p-12 rounded-[2.5rem] shadow-xl border border-gray-100 transition-transform hover:-translate-y-2">
            <div class="text-4xl mb-6">🛡️</div>
            <h4 class="text-xl font-black uppercase mb-4">Integrity</h4>
            <p class="text-gray-500 leading-relaxed text-sm">Honesty, sportsmanship, and respect for the game and opponents.</p>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
