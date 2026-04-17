<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'api_helper.php';
$api = new ApiHelper();
$siteData = $api->getSiteData();
$stats = $siteData['stats'] ?? [];
$sports = $siteData['sports'] ?? [];
$gallery = $siteData['gallery'] ?? [];
$testimonials = $siteData['testimonials'] ?? [];

// Active Page Logic
$current_page = basename($_SERVER['PHP_SELF']);
function isActive($page, $current) {
    return ($page == $current) ? 'text-primary border-b-2 border-primary' : 'hover:text-primary transition';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/log.png">
    <title><?php echo isset($page_title) ? $page_title . " | Bluestone Elite Sports" : "Bluestone Elite Sports Academy"; ?></title>
    
    <!-- Rapid Navigation & DNS Prefetching -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Priority Preloads -->
    <link rel="preload" href="assets/css/output.css" as="style">
    <link rel="preload" href="assets/Logo.png" as="image">
    <?php if ($current_page === 'index.php'): ?>
    <link rel="preload" href="assets/hero.png" as="image">
    <?php endif; ?>

    <!-- Tailwind CSS (Production Build) -->
    <link rel="stylesheet" href="assets/css/output.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" media="print" onload="this.media='all'">
    <style> 
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; } 
        .active-link { color: #ea580c; border-bottom: 2px solid #ea580c; }
        
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #ea580c; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #c2410c; }
        
        @media (max-width: 767px) {
            .desktop-nav { display: none !important; }
        }

        /* Skeleton Shimmer Effect for Instant Layouts */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #f8f8f8 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        /* Elite Top Progress Bar */
        #elite-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: #ea580c;
            z-index: 9999;
            width: 0;
            transition: width 0.4s ease, opacity 0.4s ease;
            pointer-events: none;
            box-shadow: 0 0 10px rgba(234, 88, 12, 0.5);
        }

        /* Hover Bridge to prevent dropdown flickering */
        .dropdown-bridge::before {
            content: "";
            position: absolute;
            top: -20px;
            left: 0;
            width: 100%;
            height: 20px;
            background: transparent;
        }
    </style>
    <script>
        // Progress Bar Control
        window.startEliteProgress = function() {
            const bar = document.getElementById('elite-progress');
            if (bar) {
                bar.style.opacity = '1';
                bar.style.width = '30%';
                setTimeout(() => { bar.style.width = '70%'; }, 200);
            }
        };
        window.finishEliteProgress = function() {
            const bar = document.getElementById('elite-progress');
            if (bar) {
                bar.style.width = '100%';
                setTimeout(() => { bar.style.opacity = '0'; }, 300);
                setTimeout(() => { bar.style.width = '0%'; }, 700);
            }
        };
        document.addEventListener('DOMContentLoaded', window.finishEliteProgress);
        window.addEventListener('beforeunload', window.startEliteProgress);
    </script>
</head>
<body class="bg-white text-secondary overflow-x-hidden">
    <!-- Instant Feedback Progress Bar -->
    <div id="elite-progress"></div>

    <!-- Top Bar -->
    <div class="bg-primary text-white py-2 px-4 md:px-12 flex justify-between items-center text-[10px] md:text-sm shadow-inner overflow-hidden">
        <div class="flex items-center gap-4 md:gap-8">
            <a href="tel:+918778839909" class="flex items-center gap-2 font-black whitespace-nowrap hover:text-black transition-colors">
                <i class="fa-solid fa-phone-volume text-white text-xs"></i> +91 87788 39909
            </a>
            <a href="mailto:bluestoneelitesports@gmail.com" class="hidden sm:flex items-center gap-2 font-black whitespace-nowrap hover:text-black transition-colors">
                <i class="fa-solid fa-envelope text-white text-xs"></i> bluestoneelitesports@gmail.com
            </a>
        </div>
        
        <!-- Top Bar Social Links -->
        <div class="flex items-center gap-4">
            <a href="https://www.facebook.com/bluestoneelitesports" target="_blank" class="hover:text-secondary transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/bluestone_elitesports" target="_blank" class="hover:text-secondary transition-colors"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://www.youtube.com/@bluestoneelitesports" target="_blank" class="hover:text-secondary transition-colors"><i class="fa-brands fa-youtube"></i></a>
            <a href="https://www.linkedin.com/company/bluestone-elite-sports" target="_blank" class="hover:text-secondary transition-colors"><i class="fa-brands fa-linkedin-in"></i></a>
        </div>
    </div>

    <!-- Navigation -->
    <header class="sticky top-0 bg-white/90 backdrop-blur-xl shadow-lg z-50 border-b border-primary/10 w-full">
        <nav class="max-w-8xl mx-auto px-4 md:px-8 py-3 md:py-4 flex justify-between items-center gap-2">
            <div class="flex items-center gap-2 shrink-0 cursor-pointer" onclick="location.href='index.php'">
                <img src="assets/Logo.png" alt="Bluestone Elite Sports" class="h-8 md:h-14 w-auto object-contain">
            </div>
            
            <ul class="desktop-nav hidden md:flex gap-8 font-semibold items-center h-16">
                <li><a href="index.php" class="<?php echo isActive('index.php', $current_page); ?> py-1">Home</a></li>
                <li><a href="about.php" class="<?php echo isActive('about.php', $current_page); ?> py-1">About</a></li>
                
                <!-- Dynamic Menus -->
                <?php 
                $academySports = array_filter($sports, fn($s) => ($s['program_type'] ?? 'Academy') === 'Academy');
                $summerSports = array_filter($sports, fn($s) => ($s['program_type'] ?? '') === 'Summer Hub');
                $competitionSports = array_filter($sports, fn($s) => ($s['program_type'] ?? '') === 'Competition');
                ?>

                <!-- Sports Academy Dropdown -->
                <li class="relative group h-full flex items-center">
                    <a href="sports.php" class="<?php echo isActive('sports.php', $current_page); ?> flex items-center gap-1 py-1">Academy 
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </a>
                    <div class="absolute top-full left-0 w-64 bg-white shadow-2xl rounded-2xl p-4 border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-[100] dropdown-bridge">
                        <div class="space-y-2">
                             <?php if (!empty($academySports)): ?>
                                 <?php foreach (array_slice($academySports, 0, 8) as $s): ?>
                                     <a href="sport-detail.php?id=<?php echo $s['id']; ?>" class="block px-4 py-2 hover:bg-gray-50 rounded-xl text-sm transition font-bold"><?php echo $s['name']; ?></a>
                                 <?php endforeach; ?>
                             <?php else: ?>
                                 <p class="px-4 py-2 text-xs text-gray-400 font-bold uppercase tracking-wider">No Academy Programs</p>
                             <?php endif; ?>
                             <div class="h-px bg-gray-100 my-2"></div>
                             <a href="sports.php" class="block px-4 py-2 text-primary text-xs font-black uppercase tracking-widest hover:underline">View Full Academy →</a>
                        </div>
                    </div>
                </li>

                <!-- Summer Hub Dropdown -->
                <li class="relative group h-full flex items-center">
                    <a href="#" class="hover:text-primary transition flex items-center gap-1 py-1">Summer Hub
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </a>
                    <div class="absolute top-full left-0 w-64 bg-white shadow-2xl rounded-2xl p-4 border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-[100] dropdown-bridge">
                        <div class="space-y-2">
                             <?php if (!empty($summerSports)): ?>
                                 <?php foreach ($summerSports as $s): ?>
                                     <a href="sport-detail.php?id=<?php echo $s['id']; ?>" class="block px-4 py-2 hover:bg-gray-50 rounded-xl text-sm transition font-bold"><?php echo $s['name']; ?> Hub</a>
                                 <?php endforeach; ?>
                             <?php endif; ?>
                             
                             <!-- Fixed Indoor Sports -->
                           
                             <div class="h-px bg-gray-100 my-2"></div>
                             <p class="px-4 py-1 text-[10px] text-primary uppercase font-black">Limited Slots • Enrol Now</p>
                        </div>
                    </div>
                </li>

                <!-- Competitions Dropdown -->
                <li class="relative group h-full flex items-center">
                    <a href="#" class="hover:text-primary transition flex items-center gap-1 py-1">Events
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </a>
                    <div class="absolute top-full left-0 w-64 bg-white shadow-2xl rounded-2xl p-4 border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-[100] dropdown-bridge">
                        <div class="space-y-2">
                             <?php if (!empty($competitionSports)): ?>
                                 <?php foreach ($competitionSports as $s): ?>
                                     <a href="sport-detail.php?id=<?php echo $s['id']; ?>" class="block px-4 py-2 hover:bg-gray-50 rounded-xl text-sm transition font-bold">🏆 <?php echo $s['name']; ?></a>
                                 <?php endforeach; ?>
                             <?php else: ?>
                                 <p class="px-4 py-2 text-xs text-gray-400 font-bold uppercase tracking-wider">No Active Events</p>
                             <?php endif; ?>
                             <div class="h-px bg-gray-100 my-2"></div>
                             <p class="px-4 py-1 text-[10px] text-slate-400 uppercase font-black">Marathon • League • Cups</p>
                        </div>
                    </div>
                </li>

                <li><a href="gallery.php" class="<?php echo isActive('gallery.php', $current_page); ?> py-1">Gallery</a></li>
                <li><a href="contact.php" class="<?php echo isActive('contact.php', $current_page); ?> py-1">Contact</a></li>
                <li><a href="index.php#contact" class="bg-primary text-white px-6 py-2 rounded-full hover:bg-secondary transition">Join Now</a></li>
            </ul>

            <button class="md:hidden text-secondary p-2 shrink-0" id="mobileMenuBtn">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </nav>
        
        <!-- Mobile Dropdown -->
        <div id="mobileMenu" class="hidden md:hidden bg-secondary inset-0 z-[100] flex flex-col transition-all duration-500">
            <div class="bg-white p-4 flex justify-between items-center border-b border-primary/10">
                <img src="assets/Logo.png" alt="Bluestone Elite Sports" class="h-8 w-auto object-contain">
                <button class="text-secondary text-4xl leading-none p-2" onclick="document.getElementById('mobileMenu').classList.add('hidden')">&times;</button>
            </div>
            
            <nav class="flex-1 overflow-y-auto p-8 space-y-2">
                <a href="index.php" class="block py-4 text-3xl font-black uppercase italic tracking-tighter border-b border-white/10 <?php echo $current_page == 'index.php' ? 'text-primary' : 'text-white'; ?>">Home</a>
                <a href="about.php" class="block py-4 text-3xl font-black uppercase italic tracking-tighter border-b border-white/10 <?php echo $current_page == 'about.php' ? 'text-primary' : 'text-white'; ?>">About</a>
                <a href="sports.php" class="block py-4 text-3xl font-black uppercase italic tracking-tighter border-b border-white/10 <?php echo $current_page == 'sports.php' ? 'text-primary' : 'text-white'; ?>">Academy</a>
                
                <!-- Summer Hub (Mobile Links) -->
                <div>
                    <h3 class="text-primary font-black uppercase tracking-widest text-[10px] mt-8 mb-4 italic">Summer Hub</h3>
                    <div class="space-y-4">
                        <?php foreach (array_slice($summerSports, 0, 4) as $s): ?>
                            <a href="sport-detail.php?id=<?php echo $s['id']; ?>" class="block text-xl font-bold text-white/80 uppercase tracking-tighter"><?php echo $s['name']; ?> Hub</a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Events (Mobile Links) -->
                <div>
                    <h3 class="text-primary font-black uppercase tracking-widest text-[10px] mt-8 mb-4 italic">Elite Events</h3>
                    <div class="space-y-4">
                         <?php if (!empty($competitionSports)): ?>
                             <?php foreach (array_slice($competitionSports, 0, 3) as $s): ?>
                                 <a href="sport-detail.php?id=<?php echo $s['id']; ?>" class="block text-xl font-bold text-white/80 uppercase tracking-tighter">🏆 <?php echo $s['name']; ?></a>
                             <?php endforeach; ?>
                         <?php else: ?>
                             <p class="text-white/40 text-[10px] font-bold uppercase tracking-widest">No Active Events</p>
                         <?php endif; ?>
                    </div>
                </div>

                <a href="gallery.php" class="block py-4 text-3xl font-black uppercase italic tracking-tighter border-b border-white/10 <?php echo $current_page == 'gallery.php' ? 'text-primary' : 'text-white'; ?>">Gallery</a>
                <a href="contact.php" class="block py-4 text-3xl font-black uppercase italic tracking-tighter border-b border-white/10 <?php echo $current_page == 'contact.php' ? 'text-primary' : 'text-white'; ?>">Contact</a>
            </nav>
            
            <div class="p-8 bg-primary mt-auto">
                <a href="index.php#contact" class="block w-full bg-white text-primary text-center py-5 rounded-2xl font-black tracking-widest uppercase text-sm shadow-xl" onclick="document.getElementById('mobileMenu').classList.add('hidden')">Join Now →</a>
            </div>
        </div>
    </header>

    <script>
        const btn = document.getElementById('mobileMenuBtn');
        const menu = document.getElementById('mobileMenu');
        btn.onclick = () => menu.classList.toggle('hidden');

        // Predictive Navigation Accelerator
        document.addEventListener('DOMContentLoaded', () => {
             const prefetch = (url) => {
                 if (!url || url.includes('#') || !url.includes('.php')) return;
                 // Don't prefetch if already loaded
                 if (document.querySelector(`link[href="${url}"]`)) return;
                 
                 const link = document.createElement('link');
                 link.rel = 'prefetch';
                 link.href = url;
                 document.head.appendChild(link);
             };
             
             document.querySelectorAll('a').forEach(a => {
                 // Check if internal link
                 if (a.hostname === window.location.hostname) {
                    a.addEventListener('mouseenter', () => prefetch(a.href), { once: true });
                    a.addEventListener('touchstart', () => prefetch(a.href), { once: true });
                 }
             });
        });
    </script>

    <!-- Brochure Slider Popup - HOME PAGE ONLY -->
    <?php 
    $brochures = $api->getAllActiveBrochures();
    if (!empty($brochures) && $current_page === 'index.php'): 
    ?>
    <div id="brochurePopup" class="fixed inset-0 z-[1000] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm hidden transition-all duration-500 opacity-0">
        <div class="bg-white w-full max-w-4xl rounded-[2.5rem] overflow-hidden shadow-2xl relative flex flex-col transform scale-95 transition-transform duration-500" id="brochureContent">
            
            <!-- Close Button -->
            <button onclick="closeBrochure()" class="absolute top-6 right-6 z-[1010] bg-orange-500 backdrop-blur-md text-white hover:bg-white hover:text-primary w-10 h-10 rounded-full flex items-center justify-center transition-all shadow-lg border border-white/20">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

            <!-- Slider Wrapper -->
            <div class="relative overflow-hidden w-full" id="brochureSlider">
                <div class="flex transition-transform duration-700 ease-in-out" id="sliderTrack">
                    <?php foreach ($brochures as $index => $b): ?>
                        <div class="min-w-full flex flex-col md:flex-row">
                            <!-- Image Side -->
                            <div class="md:w-1/2 h-64 md:h-[450px] overflow-hidden relative group">
                                <img src="<?php echo $b['image_path']; ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Special Event">
                                <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent"></div>
                                <div class="absolute bottom-8 left-8">
                                    <span class="bg-white/20 backdrop-blur-md text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-white/30">Featured Event</span>
                                    <h4 class="text-white text-3xl font-black italic uppercase tracking-tighter mt-2 leading-none"><?php echo $b['name']; ?></h4>
                                </div>
                            </div>

                            <!-- Content Side -->
                            <div class="md:w-1/2 p-10 flex flex-col justify-center bg-white relative">
                                <div class="space-y-4">
                                    <p class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">Limited Opportunity</p>
                                    <h3 class="text-3xl font-black text-secondary leading-none uppercase tracking-tighter">Accelerate Your <span class="text-primary italic">Pro Journey</span></h3>
                                    <p class="text-slate-500 text-sm font-medium leading-relaxed line-clamp-3"><?php echo $b['description']; ?></p>
                                    
                                    <div class="flex flex-col gap-3 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center text-primary text-xs"><i class="fa-solid fa-calendar-day"></i></span>
                                            <span class="text-[10px] font-black uppercase text-slate-700 tracking-widest"><?php echo $b['age_category'] ?: 'All Ages Welcome'; ?></span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center text-primary text-xs"><i class="fa-solid fa-clock"></i></span>
                                            <span class="text-[10px] font-black uppercase text-slate-700 tracking-widest"><?php echo $b['training_schedule'] ?: 'Contact for Schedule'; ?></span>
                                        </div>
                                    </div>

                                    <div class="flex gap-4 pt-4">
                                        <a href="sport-detail.php?id=<?php echo $b['id']; ?>" class="flex-1 bg-primary text-white text-center py-4 rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl shadow-primary/20 hover:bg-orange-600 transition-all hover:-translate-y-1">View Details</a>
                                        <a href="index.php#contact" class="flex-1 bg-secondary text-white text-center py-4 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-secondary transition-all hover:-translate-y-1" onclick="closeBrochure()">Register Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (count($brochures) > 1): ?>
                <!-- Navigation Arrows -->
                <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 bg-white/20 hover:bg-white/40 backdrop-blur-md text-white w-10 h-10 rounded-full flex items-center justify-center transition-all border border-white/30">
                    <i class="fa-solid fa-chevron-left text-sm"></i>
                </button>
                <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 bg-orange-200 hover:bg-orange-400 backdrop-blur-md text-white w-10 h-10 rounded-full flex items-center justify-center transition-all border border-white/30">
                    <i class="fa-solid fa-chevron-right text-sm"></i>
                </button>

                <!-- Navigation Dots -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                    <?php foreach ($brochures as $index => $b): ?>
                        <button onclick="goToSlide(<?php echo $index; ?>)" class="w-2 h-2 rounded-full transition-all duration-300 slider-dot <?php echo $index === 0 ? 'bg-primary w-8' : 'bg-slate-300'; ?>" data-index="<?php echo $index; ?>"></button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        let brochureTimer = null;
        let slideInterval = null;
        let currentSlide = 0;
        const totalSlides = <?php echo count($brochures); ?>;
        const brochureModal = document.getElementById('brochurePopup');
        const brochureContent = document.getElementById('brochureContent');
        const sliderTrack = document.getElementById('sliderTrack');
        const dots = document.querySelectorAll('.slider-dot');

        function showBrochure() {
            if (!brochureModal) return;
            brochureModal.classList.remove('hidden');
            setTimeout(() => {
                brochureModal.classList.remove('opacity-0');
                brochureContent.classList.remove('scale-95');
                brochureContent.classList.add('scale-100');
                startAutoSlide();
            }, 10);
        }

        function closeBrochure() {
            if (!brochureModal) return;
            brochureModal.classList.add('opacity-0');
            brochureContent.classList.add('scale-95');
            brochureContent.classList.remove('scale-100');
            stopAutoSlide();
            setTimeout(() => {
                brochureModal.classList.add('hidden');
                clearTimeout(brochureTimer);
                // brochureTimer = setTimeout(showBrochure, 10000); // REMOVED REPETITIVE SHOWING
            }, 500);
        }

        function goToSlide(index) {
            currentSlide = index;
            sliderTrack.style.transform = `translateX(-${index * 100}%)`;
            dots.forEach(dot => {
                const dotIndex = parseInt(dot.getAttribute('data-index'));
                if (dotIndex === index) {
                    dot.classList.add('bg-primary', 'w-8');
                    dot.classList.remove('bg-slate-300');
                } else {
                    dot.classList.remove('bg-primary', 'w-8');
                    dot.classList.add('bg-slate-300');
                }
            });
            // Reset auto-slide timer on manual interaction
            startAutoSlide();
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            goToSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            goToSlide(currentSlide);
        }

        function startAutoSlide() {
            if (totalSlides <= 1) return;
            stopAutoSlide();
            slideInterval = setInterval(nextSlide, 5000);
        }

        function stopAutoSlide() {
            if (slideInterval) clearInterval(slideInterval);
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (brochureModal) {
                brochureTimer = setTimeout(showBrochure, 2000);
            }
        });
    </script>
    <?php endif; ?>
