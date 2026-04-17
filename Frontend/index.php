<?php
$page_title = "Home";
include 'includes/header.php';
?>

<!-- Hero Section -->
<!-- Split Hero (Text Left, Image Right) -->
<section class="relative min-h-[90vh] bg-primary flex items-center overflow-hidden pt-24 md:pt-0">
    <!-- Background Accents -->
    <div class="absolute top-0 left-0 w-1/3 h-full bg-primary/5 -skew-x-12 transform -translate-x-20"></div>
    <div class="absolute top-40 right-10 w-96 h-96 bg-primary/10 blur-[120px] rounded-full"></div>

    <div class="container mx-auto px-4 md:px-12 grid md:grid-cols-2 gap-12 items-center relative z-10 py-12 md:py-20">
        <!-- Text Content (Left) -->
        <div class="text-white">
            <span class="inline-block px-4 py-1.5 bg-black/10 text-white border border-black/20 text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-8">World Class Training Hub</span>
            <h1 class="text-5xl md:text-7xl font-black mb-8 leading-[0.85] uppercase tracking-tighter italic">
                FORGE YOUR <br> <span class="text-secondary italic">LEGACY</span>
            </h1>
            <p class="text-base md:text-xl text-white/80 max-w-lg mb-12 leading-relaxed font-bold">
                Unlock your potential with elite-level coaching, state-of-the-art facilities, and a <span class="text-secondary">championship mindset</span>.
            </p>
            <div class="flex flex-wrap gap-4 mt-4">
                <a href="#contact" class="bg-transparent text-white px-6 md:px-10 py-3 md:py-5 border-2 border-white hover:bg-white hover:text-black rounded-2xl text-sm md:text-lg font-black uppercase tracking-widest hover:scale-105 transition-all shadow-2xl">Start Training</a>
                <a href="sports.php" class="border-2 border-white px-6 md:px-10 py-3 md:py-5 rounded-xl text-sm md:text-lg font-black uppercase tracking-widest text-black bg-white hover:bg-transparent hover:text-white transition-all">Programs →</a>
            </div>
        </div>

        <!-- Image Content (Right Side) -->
        <div class="relative group">
            <div class="absolute -inset-10 bg-primary/10 rounded-full blur-[100px] group-hover:bg-primary/20 transition duration-1000"></div>
            <div class="relative aspect-[3/2] max-h-[500px] rounded-[4rem] overflow-hidden border border-white/10 shadow-3xl transform rotate-2 hover:rotate-0 transition duration-700 bg-gray-100 skeleton">
                <img src="assets/hero.png" alt="Elite Academy Legacy" class="w-full h-full border-8 border-white object-cover" fetchpriority="high" decoding="sync">
                <div class="absolute inset-0 bg-gradient-to-t from-secondary/60 via-transparent to-transparent"></div>
            </div>
            <!-- Floating Achievement -->
            <div class="absolute -top-10 -right-10 bg-white p-8 rounded-[2.5rem] shadow-2xl hidden lg:block animate-bounce-slow">
                <div class="text-secondary font-black text-5xl italic leading-none mb-1">Elite</div>
                <div class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Standard</div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Bar -->
<section class="bg-white py-8 md:py-12 -mt-10 relative z-20 w-[calc(100%-2rem)] md:container mx-auto px-4 md:px-12 max-w-6xl shadow-2xl rounded-3xl border border-gray-100 grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 text-center">
    <?php if (is_array($stats) && !isset($stats['error'])): ?>
        <?php foreach ($stats as $stat): ?>
            <?php if (is_array($stat) && isset($stat['value'], $stat['label'])): ?>
                <div>
                    <h3 class="text-4xl font-black text-primary"><?php echo $stat['value']; ?></h3>
                    <p class="text-gray-500 font-bold uppercase text-xs tracking-widest mt-1"><?php echo $stat['label']; ?></p>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div><h3 class="text-4xl font-black text-primary">15+</h3><p class="text-gray-500 font-bold uppercase text-xs tracking-widest mt-1">Sports Offered</p></div>
        <div><h3 class="text-4xl font-black text-primary">500+</h3><p class="text-gray-500 font-bold uppercase text-xs tracking-widest mt-1">Athletes Trained</p></div>
        <div><h3 class="text-4xl font-black text-primary">20+</h3><p class="text-gray-500 font-bold uppercase text-xs tracking-widest mt-1">Pro Coaches</p></div>
        <div><h3 class="text-4xl font-black text-primary">365</h3><p class="text-gray-500 font-bold uppercase text-xs tracking-widest mt-1">Days Open</p></div>
    <?php endif; ?>
</section>

<!-- Featured Sports Selection -->
<section class="bg-gray-50 py-24">
    <div class="container mx-auto px-4 md:px-12">
        <div class="flex justify-between items-end mb-16">
            <div>
                <h2 class="text-4xl font-black uppercase tracking-tighter italic">Featured <span class="text-primary italic">Academy</span></h2>
                <p class="text-gray-500 font-bold mt-2">Professional training for major leagues.</p>
            </div>
            <a href="sports.php" class="hidden md:block text-primary font-bold hover:underline mb-1">View All Programs →</a>
        </div>

        <div class="overflow-x-auto pb-12 custom-scrollbar">
            <div class="flex flex-row gap-6 min-h-[500px] w-max px-4">
                <?php 
                if (is_array($sports) && !isset($sports['error'])): 
                    // Filter for Active Academy programs
                    $academyPrograms = array_filter($sports, function($s) {
                        return ($s['program_type'] ?? 'Academy') === 'Academy' && ($s['status'] ?? 'Active') === 'Active';
                    });
                    
                    foreach ($academyPrograms as $sport): 
                ?>
                        <div class="w-[240px] hover:w-[550px] transition-all duration-700 ease-in-out group relative overflow-hidden bg-white rounded-[2.5rem] border border-gray-100 shadow-2xl cursor-pointer" onclick="location.href='sport-detail.php?id=<?php echo $sport['id']; ?>'">
                                <!-- Background Image -->
                                <div class="absolute inset-0 bg-gray-200 skeleton"></div>
                                <div class="absolute inset-0">
                                    <?php 
                                    $displayImage = $api->resolveSportImage($sport);
                                    if (!empty($displayImage)): ?>
                                        <img src="<?php echo $displayImage; ?>" alt="<?php echo $sport['name']; ?>" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 opacity-70 group-hover:opacity-100" loading="lazy" decoding="async">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-gradient-to-br from-gray-400 to-gray-600"></div>
                                    <?php endif; ?>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                                </div>

                                <!-- Content Overlay -->
                                <div class="absolute inset-0 p-8 flex flex-col justify-end text-white">
                                    <!-- Category Badge -->
                                    <span class="mb-4 bg-primary px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full self-start opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                        <?php echo $sport['category'] ?: 'Elite'; ?>
                                    </span>

                                    <div class="relative">
                                        <!-- Title: Rotated when collapsed, Normal when expanded -->
                                        <h3 class="text-3xl font-black uppercase tracking-tighter italic mb-4 leading-none transition-all duration-500 origin-left 
                                                   lg:group-hover:rotate-0 lg:group-hover:translate-x-0
                                                   lg:absolute lg:bottom-12 lg:left-0 lg:-rotate-90 lg:whitespace-nowrap lg:translate-x-2
                                                   group-hover:relative group-hover:bottom-0">
                                            <?php echo $sport['name']; ?>
                                        </h3>

                                        <!-- Expanded Content -->
                                        <div class="opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500 delay-100">
                                            <p class="text-gray-300 text-sm mb-6 leading-relaxed line-clamp-2 max-w-xs">
                                                <?php echo $sport['description'] ?: 'Master-level coaching and athletic excellence at Bluestone Elite Hub.'; ?>
                                            </p>
                                            <span class="inline-flex items-center gap-3 text-primary font-black uppercase tracking-widest text-[10px]">
                                                Academy Details 
                                                <span class="text-lg">→</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
        </div>
    </div>
</section>
 
 <!-- The Elite Edge - Core Pillars -->
 <section class="py-24 bg-white relative overflow-hidden">
     <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
     <div class="container mx-auto px-4 md:px-12">
         <div class="text-center mb-16 md:mb-20">
             <h2 class="text-4xl md:text-5xl font-black uppercase tracking-tighter italic mb-4">THE ELITE <span class="text-primary italic">EDGE</span></h2>
             <p class="text-gray-500 font-bold uppercase tracking-widest text-[10px] md:text-xs">Why champions choose BlueStone Elite Academy</p>
         </div>
 
         <div class="grid md:grid-cols-3 gap-8 md:gap-12">
             <div class="relative bg-gray-50 p-10 rounded-[3rem] border border-gray-100 hover:border-primary/20 transition group overflow-hidden">
                 <div class="absolute -right-10 -bottom-10 w-40 h-40 opacity-10 group-hover:opacity-20 transition-opacity">
                     <img src="assets/gallery5.jpeg" class="w-full h-full object-cover rounded-full" loading="lazy" decoding="async">
                 </div>
                 <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary font-black mb-8 group-hover:bg-primary group-hover:text-white transition-colors text-xl">A</div>
                 <h4 class="text-2xl font-black uppercase italic tracking-tighter mb-4">Precision Analytics</h4>
                 <p class="text-gray-500 text-sm leading-relaxed">Real-time performance tracking using AI-driven biomechanics and data-driven insights for technical perfection.</p>
             </div>
             <div class="relative bg-gray-50 p-10 rounded-[3rem] border border-gray-100 hover:border-primary/20 transition group overflow-hidden">
                 <div class="absolute -right-10 -bottom-10 w-40 h-40 opacity-10 group-hover:opacity-20 transition-opacity">
                     <img src="assets/gallery4.jpeg" class="w-full h-full object-cover rounded-full" loading="lazy" decoding="async">
                 </div>
                 <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary font-black mb-8 group-hover:bg-primary group-hover:text-white transition-colors text-xl">M</div>
                 <h4 class="text-2xl font-black uppercase italic tracking-tighter mb-4">Mental Resilience</h4>
                 <p class="text-gray-500 text-sm leading-relaxed">Dedicated psychology sessions to build the mental stamina required for high-pressure professional environments.</p>
             </div>
             <div class="relative bg-gray-50 p-10 rounded-[3rem] border border-gray-100 hover:border-primary/20 transition group overflow-hidden">
                 <div class="absolute -right-10 -bottom-10 w-40 h-40 opacity-10 group-hover:opacity-20 transition-opacity">
                     <img src="assets/gallery2.jpeg" class="w-full h-full object-cover rounded-full" loading="lazy" decoding="async">
                 </div>
                 <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary font-black mb-8 group-hover:bg-primary group-hover:text-white transition-colors text-xl">R</div>
                 <h4 class="text-2xl font-black uppercase italic tracking-tighter mb-4">Pro Recovery</h4>
                 <p class="text-gray-500 text-sm leading-relaxed">On-site physiotherapy and world-class recovery protocols to ensure peak physical condition and injury prevention.</p>
             </div>
         </div>
     </div>
 </section>

<!-- Coaches & Expertise -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-4 md:px-12">
        <div class="grid md:grid-cols-2 gap-12 md:gap-20 items-center">
            <div class="relative">
                <div class="absolute -top-10 -left-10 w-32 h-32 bg-primary/20 rounded-full blur-3xl"></div>
                <div class="relative aspect-[2/2] bg-gray-900 rounded-[2rem] md:rounded-[3rem] overflow-hidden shadow-3xl border-4 border-slate-50">
                     <img src="assets/MD.jpeg" alt="Head Coach" class="w-full h-full object-contain" loading="lazy" decoding="async">
                     <div class="absolute inset-0 bg-gradient-to-t from-secondary via-transparent to-transparent"></div>
                     <div class="absolute bottom-6 left-8 text-white">
                         <h3 class="text-2xl md:text-3xl font-black italic uppercase tracking-tighter">Mr <span class="italic">Kumaresan Thangavel</span></h3>
                         <p class="text-[10px] md:text-xs font-bold uppercase tracking-widest text-white/80">CEO & Founder</p>
                     </div>
                </div>
                <div class="absolute -bottom-4 -right-2 md:-bottom-6 md:-right-6 bg-primary text-white p-4 md:p-8 rounded-2xl md:rounded-3xl shadow-xl font-black uppercase text-[10px] md:text-xs tracking-widest z-10">10+ Years Exp.</div>
            </div>
            <div class="mt-8 md:mt-0">
                <span class="text-primary font-black uppercase tracking-widest text-[10px] md:text-xs">Our CEO</span>
                <h2 class="text-3xl md:text-5xl font-black italic uppercase tracking-tighter mt-4 mb-6 md:mb-8 text-secondary">Visionary <span class="text-primary italic">Leadership</span></h2>
                <p class="text-gray-500 text-base md:text-lg leading-relaxed mb-8 md:mb-10 font-medium">
                    "Bluestone Elite Sports was founded on the core principle that professional sports discipline is the ultimate catalyst for life-long success and leadership. Our mission is to bridge the gap between regional talent and international professional standards through elite infrastructure and coaching."
                </p>
                <div class="grid grid-cols-2 gap-4 md:gap-8">
                     <div>
                         <h4 class="text-primary font-black text-2xl md:text-3xl italic">15+</h4>
                         <p class="text-[9px] md:text-xs font-bold uppercase text-gray-400 mt-2">National Coaches</p>
                     </div>
                     <div>
                         <h4 class="text-primary font-black text-2xl md:text-3xl italic">100%</h4>
                         <p class="text-[9px] md:text-xs font-bold uppercase text-gray-400 mt-2">Success Rate</p>
                     </div>
                </div>
                <a href="about.php" class="inline-block mt-10 md:mt-12 bg-primary text-white px-8 md:px-10 py-3 md:py-4 rounded-full font-black uppercase tracking-widest text-[10px] md:text-xs hover:bg-secondary transition shadow-lg shadow-orange-600/20">Meet the Team →</a>
            </div>
        </div>
    </div>
</section>
 
 <!-- Path to Pro - Journey Workflow -->
 <section class="py-24 bg-secondary text-white overflow-hidden relative">
     <div class="container mx-auto px-4 md:px-12">
         <div class="mb-16 md:mb-20">
             <h2 class="text-4xl md:text-5xl font-black uppercase tracking-tighter italic leading-none">PATH TO <span class="text-primary italic">PRO</span></h2>
             <p class="text-gray-400 font-bold uppercase tracking-widest text-[10px] md:text-xs mt-4">Professional Recruitment & Development Cycle</p>
         </div>
 
         <div class="grid md:grid-cols-4 gap-8 relative">
             <!-- Connector Line (Desktop) -->
             <div class="hidden md:block absolute top-12 left-0 w-full h-px bg-white/10 z-0"></div>
 
             <div class="relative z-10 space-y-6 group">
                 <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center font-black text-2xl shadow-2xl group-hover:scale-110 transition duration-500">01</div>
                 <h4 class="text-xl font-black uppercase italic tracking-tighter">Elite Trial</h4>
                 <p class="text-gray-400 text-xs font-bold uppercase leading-relaxed tracking-widest">Skill Assessment & Potential Evaluation</p>
             </div>
             <div class="relative z-10 space-y-6 group">
                 <div class="w-16 h-16 bg-white text-secondary rounded-full flex items-center justify-center font-black text-2xl shadow-2xl group-hover:scale-110 transition duration-500">02</div>
                 <h4 class="text-xl font-black uppercase italic tracking-tighter">Core Mastery</h4>
                 <p class="text-gray-400 text-xs font-bold uppercase leading-relaxed tracking-widest">Intensive Technical Training & Discipline</p>
             </div>
             <div class="relative z-10 space-y-6 group">
                 <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center font-black text-2xl shadow-2xl group-hover:scale-110 transition duration-500">03</div>
                 <h4 class="text-xl font-black uppercase italic tracking-tighter">Match Exposure</h4>
                 <p class="text-gray-400 text-xs font-bold uppercase leading-relaxed tracking-widest">Competition, Leagues & Pressure Testing</p>
             </div>
             <div class="relative z-10 space-y-6 group">
                 <div class="w-16 h-16 bg-white text-secondary rounded-full flex items-center justify-center font-black text-2xl shadow-2xl group-hover:scale-110 transition duration-500">04</div>
                 <h4 class="text-xl font-black uppercase italic tracking-tighter">Pro Selection</h4>
                 <p class="text-gray-400 text-xs font-bold uppercase leading-relaxed tracking-widest">Recruitment, Scout Connection & Success</p>
             </div>
         </div>
     </div>
 </section>

<!-- Testimonials Section -->
<section class="bg-gray-50 py-24">
    <div class="container mx-auto px-4 md:px-12 text-center mb-16">
        <h2 class="text-4xl font-black italic uppercase tracking-tighter">Voices of <span class="text-primary italic">Excellence</span></h2>
        <p class="text-gray-500 font-bold mt-2 uppercase text-xs tracking-widest">Real stories from real champions</p>
    </div>
    <div class="container mx-auto px-4 md:px-12 grid md:grid-cols-3 gap-8">
        <?php 
        $activeTestimonials = array_filter($testimonials, function($t) {
            return ($t['status'] ?? 'Active') === 'Active';
        });

        if (!empty($activeTestimonials)): 
            foreach ($activeTestimonials as $t): 
        ?>
            <div class="bg-white p-12 rounded-[2.5rem] shadow-xl border border-orange-500 transition-transform hover:-translate-y-2">
                <p class="text-gray-500 leading-relaxed mb-8">"<?php echo htmlspecialchars($t['content']); ?>"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center text-white font-black text-lg border-2 border-white shadow-md">
                        <?php echo strtoupper(substr($t['name'], 0, 1)); ?>
                    </div>
                    <div>
                        <h4 class="font-black uppercase tracking-tight text-sm"><?php echo htmlspecialchars($t['name']); ?></h4>
                        <p class="text-[10px] text-primary uppercase font-bold"><?php echo htmlspecialchars($t['role']); ?></p>
                    </div>
                </div>
            </div>
        <?php 
            endforeach; 
        else: 
        ?>
            <!-- Fallback if no testimonials exist -->
            <div class="bg-white p-12 rounded-[2.5rem] shadow-xl border border-gray-100 transition-transform hover:-translate-y-2">
                <p class="text-gray-500 leading-relaxed mb-8">"The cricket coaching here is transformative. My son's technique improved in just two months. Unbelievable precision."</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-secondary flex items-center justify-center text-white font-black text-lg border-2 border-white shadow-md">R</div>
                    <div>
                        <h4 class="font-black uppercase tracking-tight text-sm">Rahul S.</h4>
                        <p class="text-[10px] text-primary uppercase font-bold">Parent of Athlete</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-12 border-primary rounded-[2.5rem] shadow-xl border border-gray-100 transition-transform hover:-translate-y-2">
                <p class="text-gray-500 leading-relaxed mb-8">"Elite facilities and coaches who actually care about your mental game. This is more than a sports academy."</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center text-white font-black text-lg border-2 border-white shadow-md">A</div>
                    <div>
                        <h4 class="font-black uppercase tracking-tight text-sm">Aakash K.</h4>
                        <p class="text-[10px] text-primary uppercase font-bold">State Level Cricket Player</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-12 rounded-[2.5rem] shadow-xl border border-gray-100 transition-transform hover:-translate-y-2">
                <p class="text-gray-500 leading-relaxed mb-8">"The atmosphere is electric. Everyone here is pushing for greatness. Highly recommended for young athletes."</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-secondary flex items-center justify-center text-white font-black text-lg border-2 border-white shadow-md">V</div>
                    <div>
                        <h4 class="font-black uppercase tracking-tight text-sm">Vikram M.</h4>
                        <p class="text-[10px] text-primary uppercase font-bold">Kabaddi Player</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Summer Sports Special Banner -->
<section class="py-12 md:py-24 container mx-auto px-4 md:px-12">
    <div class="bg-primary rounded-[3rem] md:rounded-[4rem] p-8 md:p-20 text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-12">
         <div class="absolute inset-0 bg-gradient-to-r from-black/20 to-transparent"></div>
         <div class="relative z-10 max-w-2xl">
             <span class="inline-block px-4 py-1.5 bg-white/10 border border-white/20 text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-8 text-white">Enrollment Open</span>
             <h2 class="text-4xl md:text-6xl font-black italic uppercase tracking-tighter leading-tight mb-8">Summer <br> <span class="text-secondary italic">Masters 2026</span></h2>
             <p class="text-base md:text-lg font-bold mb-10 opacity-90 uppercase tracking-widest">Early bird registrations now open for Chess, Carrom, and Table Tennis camps. Limited slots available!</p>
             <div class="flex flex-wrap gap-4">
                 <a href="#contact" class="bg-white text-primary px-10 py-4 rounded-full font-black uppercase tracking-widest text-xs hover:bg-black hover:text-white transition shadow-2xl">Enroll Today</a>
                 <div class="flex -space-x-4">
                     <div class="w-10 h-10 rounded-full border-2 border-primary bg-gray-200 overflow-hidden"><img src="assets/gallery1.png" class="w-full h-full object-cover" loading="lazy" decoding="async"></div>
                     <div class="w-10 h-10 rounded-full border-2 border-primary bg-gray-300 overflow-hidden"><img src="assets/gallery3.jpeg" class="w-full h-full object-cover" loading="lazy" decoding="async"></div>
                     <div class="w-10 h-10 rounded-full border-2 border-primary bg-secondary flex items-center justify-center text-[10px] font-bold">+15</div>
                 </div>
             </div>
         </div>
         
         <div class="relative z-10 flex gap-4 md:gap-8 items-center h-full">
             <!-- Chess Image Card -->
             <div class="group/img relative w-48 md:w-64 aspect-[4/5] bg-white rounded-3xl overflow-hidden shadow-2xl transform -rotate-6 hover:rotate-0 transition duration-500 border-4 border-white">
                 <img src="assets/chess.png" alt="Chess" class="w-full h-full object-cover group-hover/img:scale-110 transition duration-700" loading="lazy" decoding="async">
                 <div class="absolute bottom-4 left-4 bg-secondary backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">Chess Hub</div>
             </div>
             
             <!-- Carrom Image Card -->
             <div class="group/img relative w-44 md:w-56 aspect-[4/5] bg-white rounded-3xl overflow-hidden shadow-2xl transform rotate-6 hover:rotate-0 transition duration-500 border-4 border-white mt-12 md:mt-24">
                 <img src="assets/carrom.png" alt="Carrom" class="w-full h-full object-cover group-hover/img:scale-110 transition duration-700" loading="lazy" decoding="async">
                 <div class="absolute bottom-4 left-4 bg-secondary backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">Carrom Pro</div>
             </div>
         </div>
    </div>
</section>

<!-- Gallery Preview Section -->
<section class="bg-white py-24 overflow-hidden">
    <div class="container mx-auto px-4 md:px-12 flex justify-between items-end mb-16">
        <h2 class="text-4xl font-black italic uppercase tracking-tighter">Follow the <span class="text-primary italic">Movement</span></h2>
        <a href="gallery.php" class="text-primary font-black uppercase tracking-widest text-[10px] hover:underline underline-offset-8 transition-all">View Full Gallery →</a>
    </div>
    <div class="flex gap-4 md:gap-8 animate-marquee whitespace-nowrap">
        <!-- Active Assets for Marquee -->
        <div class="w-64 md:w-96 h-64 md:h-80 bg-slate-900 rounded-[2.5rem] overflow-hidden shadow-xl shrink-0 border-4 border-slate-50 translate-y-4">
            <img src="assets/cricket team.png" class="w-full h-full object-cover" loading="lazy">
        </div>
        <div class="w-64 md:w-96 h-64 md:h-80 bg-slate-900 rounded-[2.5rem] overflow-hidden shadow-xl shrink-0 border-4 border-primary">
            <img src="assets/karate team.png" class="w-full h-full object-cover" loading="lazy">
        </div>
        <div class="w-64 md:w-96 h-64 md:h-80 bg-slate-900 rounded-[2.5rem] overflow-hidden shadow-xl shrink-0 border-4 border-slate-50 translate-y-4">
            <img src="assets/silambbu.png" class="w-full h-full object-cover" loading="lazy">
        </div>
        <div class="w-64 md:w-96 h-64 md:h-80 bg-slate-900 rounded-[2.5rem] overflow-hidden shadow-xl shrink-0 border-4 border-primary">
            <img src="assets/champ.png" class="w-full h-full object-cover" loading="lazy">
        </div>
        <div class="w-64 md:w-96 h-64 md:h-80 bg-slate-900 rounded-[2.5rem] overflow-hidden shadow-xl shrink-0 border-4 border-slate-50 translate-y-4">
            <img src="assets/gallery6.png" class="w-full h-full object-cover" loading="lazy">
        </div>
        <div class="w-64 md:w-96 h-64 md:h-80 bg-slate-900 rounded-[2.5rem] overflow-hidden shadow-xl shrink-0 border-4 border-primary">
            <img src="assets/md gallery2.png" class="w-full h-full object-cover" loading="lazy">
        </div>
        <div class="w-64 md:w-96 h-64 md:h-80 bg-slate-900 rounded-[2.5rem] overflow-hidden shadow-xl shrink-0 border-4 border-slate-50 translate-y-4">
            <img src="assets/md gallery6.png" class="w-full h-full object-cover" loading="lazy">
        </div>
    </div>
</section>

<!-- Contact & Enrollment Section -->
<section id="contact" class="py-24 bg-white relative overflow-hidden">
    <div class="container mx-auto px-4 md:px-12 max-w-7xl">
        <div class="grid md:grid-cols-2 gap-10 md:gap-16 bg-gray-50 p-6 md:p-16 rounded-[2.5rem] md:rounded-[4rem] shadow-2xl border border-gray-100">
            <div>
                <h2 class="text-3xl md:text-4xl font-black mb-6 md:mb-8 leading-tight italic uppercase tracking-tighter text-secondary">Ready to <span class="text-primary italic">Join the Elite?</span></h2>
                <p class="text-base md:text-lg text-gray-600 mb-8 md:mb-10 leading-relaxed font-bold">Fill out the form below and our head coach will get back to you within 24 hours. Start your journey today.</p>
                <div class="space-y-6">
                    <a href="https://maps.app.goo.gl/yvbCNNTipnRtoFXv9" target="_blank" class="flex items-center gap-4 group">
                        <div class="w-10 h-10 md:w-16 md:h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary font-black transition-colors group-hover:bg-primary group-hover:text-white">H</div>
                        <p class="font-bold text-secondary text-[11px] md:text-sm tracking-tight group-hover:text-primary transition-colors">Sankagiri main road, Vettukadu, Konganapuram, Ammankattur, Tamil Nadu 637102</p>
                    </a>
                    <a href="mailto:bluestoneelitesports@gmail.com" class="flex items-center gap-4 group">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary font-black transition-colors group-hover:bg-primary group-hover:text-white">M</div>
                        <p class="font-bold text-secondary text-[11px] md:text-sm tracking-tight group-hover:text-primary transition-colors">bluestoneelitesports@gmail.com</p>
                    </a>
                    <a href="tel:+918778839909" class="flex items-center gap-4 group">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary font-black transition-colors group-hover:bg-primary group-hover:text-white">P</div>
                        <p class="font-bold text-secondary text-[11px] md:text-sm tracking-tight group-hover:text-primary transition-colors">87788 39909</p>
                    </a>
                </div>

                <!-- Embedded Map Below Links -->
                <div class="mt-10 rounded-3xl overflow-hidden shadow-xl border-4 border-white h-48 md:h-64">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3909.007952729669!2d77.894973!3d11.5512869!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x860136d551614371%3A0x6643a2ac8117ad05!2sBluestone%20International%20Pre-school!5e0!3m2!1sen!2sin!4v1776251225871!5m2!1sen!2sin"
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
            
            <form id="enrollmentForm" class="space-y-4 md:space-y-6">
                <div class="grid grid-cols-2 gap-4 md:gap-6">
                    <input type="text" name="fullName" placeholder="Full Name" required class="w-full px-5 md:px-6 py-3 md:py-4 rounded-xl md:rounded-2xl bg-white border-transparent focus:bg-white focus:border-primary transition outline-none shadow-sm text-sm">
                    <input type="number" name="age" placeholder="Age" required class="w-full px-5 md:px-6 py-3 md:py-4 rounded-xl md:rounded-2xl bg-white border-transparent focus:bg-white focus:border-primary transition outline-none shadow-sm text-sm">
                </div>
                <input type="email" name="email" placeholder="Email Address" required class="w-full px-5 md:px-6 py-3 md:py-4 rounded-xl md:rounded-2xl bg-white border-transparent focus:bg-white focus:border-primary transition outline-none shadow-sm text-sm">
                <input type="tel" name="phone" placeholder="Phone Number" required class="w-full px-5 md:px-6 py-3 md:py-4 rounded-xl md:rounded-2xl bg-white border-transparent focus:bg-white focus:border-primary transition outline-none shadow-sm text-sm">
                <select name="program" class="w-full px-5 md:px-6 py-3 md:py-4 rounded-xl md:rounded-2xl bg-white border-transparent focus:bg-white focus:border-primary transition outline-none appearance-none shadow-sm font-bold text-sm">
                    <option value="">Interested Program Selection</option>
                    <?php if (is_array($sports)): foreach ($sports as $s): ?>
                        <option value="<?php echo $s['name']; ?>"><?php echo $s['name']; ?></option>
                    <?php endforeach; endif; ?>
                    <option value="General">Other / General Enquiry</option>
                </select>
                <textarea name="message" placeholder="Training Goals / Special Requirements" rows="3" class="w-full px-5 md:px-6 py-3 md:py-4 rounded-xl md:rounded-2xl bg-white border-transparent focus:bg-white focus:border-primary transition outline-none shadow-sm text-sm"></textarea>
                
                <!-- Alpha-Numeric Captcha -->
                <div class="bg-gray-50/50 p-4 rounded-3xl border border-gray-200">
                    <div class="flex items-center gap-3 mb-3">
                        <div id="captchaDisplay" style="color:black !important; font-family: 'Courier New', monospace;" class="px-5 py-3 rounded-2xl font-black text-2xl tracking-[0.3em] select-none shadow-inner pointer-events-none flex-1 text-center">
                            LOADING
                        </div>
                        <button type="button" onclick="generateCaptcha()" class="w-12 h-12 bg-white rounded-2xl border border-gray-200 text-primary hover:bg-primary hover:text-white transition transform active:rotate-180 duration-500 flex items-center justify-center shadow-sm">
                            <i class="fa-solid fa-rotate-right text-lg"></i>
                        </button>
                    </div>
                    <input type="text" id="captchaInput" placeholder="Enter Verification Code" required class="w-full px-6 py-4 rounded-2xl bg-white border border-gray-200 focus:border-primary transition outline-none shadow-sm text-sm font-bold tracking-widest uppercase text-center">
                </div>

                <button type="submit" class="w-full bg-primary py-4 md:py-5 rounded-xl md:rounded-2xl text-white font-black text-base md:text-lg uppercase tracking-widest hover:scale-[1.02] active:scale-100 transition shadow-2xl shadow-orange-500/30">Submit Application</button>
                <div id="formStatus" class="text-center mt-4 font-bold hidden text-sm"></div>
            </form>
        </div>
    </div>
</section>

<!-- AJAX Form Handling -->
<script>
    (function() {
        window._bluestoneCaptcha = "";

        window.generateCaptcha = function() {
            try {
                const display = document.getElementById('captchaDisplay');
                if (!display) return;
                
                const chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
                let code = '';
                for (let i = 0; i < 6; i++) {
                    code += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                window._bluestoneCaptcha = code;
                display.innerHTML = code;
            } catch (e) {
                console.error("Captcha Error:", e);
            }
        };

        // Initialize immediately
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', window.generateCaptcha);
        } else {
            window.generateCaptcha();
        }
        
        // Backup triggers
        window.addEventListener('load', window.generateCaptcha);
        setTimeout(window.generateCaptcha, 100);
        setTimeout(window.generateCaptcha, 500);
    })();

    document.getElementById('enrollmentForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const captchaInput = document.getElementById('captchaInput').value.trim().toUpperCase();
        const formStatus = document.getElementById('formStatus');

        if (captchaInput !== window._bluestoneCaptcha) {
            formStatus.innerText = 'INVALID CAPTCHA CODE. PLEASE TRY AGAIN.';
            formStatus.className = 'text-center mt-4 font-black text-red-600 uppercase';
            formStatus.classList.remove('hidden');
            window.generateCaptcha();
            document.getElementById('captchaInput').value = '';
            return;
        }

        const form = e.target;
        const submitBtn = form.querySelector('button');
        const originalText = submitBtn.innerText;
        submitBtn.innerText = 'PROCESSING APPLICATION...';
        submitBtn.disabled = true;
        const formData = new FormData(form);
        const rawData = Object.fromEntries(formData.entries());

        // Map website fields to CRM fields
        const crmPayload = {
            name: rawData.fullName,
            email: rawData.email,
            phone: rawData.phone,
            message: `Age: ${rawData.age} | Goals: ${rawData.message}`,
            domain: "Elite Sports", // CRM normalization handles this
            category: "Website Enquiry",
            interested_in: rawData.program || "Elite Sports Hub"
        };

        try {
            const response = await fetch('https://bluestoneinternationalpreschool.com/bgoi_portal/api/contact', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(crmPayload)
            });
            const result = await response.json();
            if (result.success) {
                formStatus.innerText = 'APPLICATION SUBMITTED SUCCESSFULLY!';
                formStatus.className = 'text-center mt-4 font-bold text-green-600 uppercase';
                formStatus.classList.remove('hidden');
                form.reset();
            } else { throw new Error('FAILED'); }
        } catch (err) {
            formStatus.innerText = 'PORTAL ERROR. PLEASE TRY AGAIN.';
            formStatus.className = 'text-center mt-4 font-bold text-red-600 uppercase';
            formStatus.classList.remove('hidden');
        } finally {
             submitBtn.innerText = originalText;
             submitBtn.disabled = false;
        }
    });
</script>

<?php include 'includes/footer.php'; ?>
