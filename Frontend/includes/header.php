<?php
require_once 'api_helper.php';
$api = new ApiHelper();
$stats = $api->getStats();
$sports = $api->getSports();
$gallery = $api->getGallery();

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
    <title><?php echo isset($page_title) ? $page_title . " | Bluestone Elite Sports" : "Bluestone Elite Sports Academy"; ?></title>
    <title><?php echo isset($page_title) ? $page_title . " | Bluestone Elite Sports" : "Bluestone Elite Sports Academy"; ?></title>
    <!-- Tailwind CSS (Development CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ea580c',
                        secondary: '#1f2937',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
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
    </style>
</head>
<body class="bg-white text-secondary overflow-x-hidden">

    <!-- Top Bar -->
    <div class="bg-primary text-white py-2 px-4 flex justify-between items-center text-[10px] md:text-sm shadow-inner overflow-hidden">
        <div class="flex items-center gap-2 md:gap-6">
            <span class="hidden sm:inline font-bold italic tracking-widest uppercase text-[10px]">Elite Sports Academy</span>
            <span class="flex items-center gap-2 font-black italic whitespace-nowrap"><span class="text-black">📞</span> +91 96291 55562</span>
        </div>
    </div>

    <!-- Navigation -->
    <header class="sticky top-0 bg-white/90 backdrop-blur-xl shadow-lg z-50 border-b border-primary/10 w-full overflow-x-hidden">
        <nav class="max-w-7xl mx-auto px-4 md:px-12 py-3 md:py-4 flex justify-between items-center gap-2">
            <div class="flex items-center gap-1.5 md:gap-2 shrink-0 max-w-[75%]">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold text-lg md:text-xl cursor-pointer" onclick="location.href='index.php'">B</div>
                <span class="text-sm sm:text-lg md:text-2xl font-extrabold tracking-tighter text-secondary cursor-pointer uppercase truncate" onclick="location.href='index.php'">BLUESTONE <span class="text-primary italic">ELITE</span></span>
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
                    <div class="absolute top-[60px] left-0 w-64 bg-white shadow-2xl rounded-2xl p-4 border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-1 group-hover:translate-y-0 z-[100]">
                        <div class="space-y-2">
                             <?php if (!empty($academySports)): ?>
                                 <?php foreach (array_slice($academySports, 0, 8) as $s): ?>
                                     <a href="sport-detail.php?id=<?php echo $s['id']; ?>" class="block px-4 py-2 hover:bg-gray-50 rounded-xl text-sm transition font-bold"><?php echo $s['name']; ?></a>
                                 <?php endforeach; ?>
                             <?php else: ?>
                                 <p class="px-4 py-2 text-xs text-gray-400 italic font-bold uppercase tracking-wider">No Academy Programs</p>
                             <?php endif; ?>
                             <div class="h-px bg-gray-100 my-2"></div>
                             <a href="sports.php" class="block px-4 py-2 text-primary text-xs font-black uppercase tracking-widest hover:underline italic">View Full Academy →</a>
                        </div>
                    </div>
                </li>

                <!-- Summer Hub Dropdown -->
                <li class="relative group h-full flex items-center">
                    <a href="#" class="hover:text-primary transition flex items-center gap-1 py-1">Summer Hub
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </a>
                    <div class="absolute top-[60px] left-0 w-64 bg-white shadow-2xl rounded-2xl p-4 border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-1 group-hover:translate-y-0 z-[100]">
                        <div class="space-y-2">
                             <?php if (!empty($summerSports)): ?>
                                 <?php foreach ($summerSports as $s): ?>
                                     <a href="sport-detail.php?id=<?php echo $s['id']; ?>" class="block px-4 py-2 hover:bg-gray-50 rounded-xl text-sm transition font-bold"><?php echo $s['name']; ?> Hub</a>
                                 <?php endforeach; ?>
                             <?php endif; ?>
                             
                             <!-- Fixed Indoor Sports -->
                             <a href="#" class="block px-4 py-2 hover:bg-gray-50 rounded-xl text-sm transition font-bold">Chess Masters</a>
                             <a href="#" class="block px-4 py-2 hover:bg-gray-50 rounded-xl text-sm transition font-bold">Carrom Championship</a>
                             <a href="#" class="block px-4 py-2 hover:bg-gray-50 rounded-xl text-sm transition font-bold">Table Tennis Hub</a>
                             
                             <div class="h-px bg-gray-100 my-2"></div>
                             <p class="px-4 py-1 text-[10px] text-primary uppercase font-black italic">Limited Slots • Enrol Now</p>
                        </div>
                    </div>
                </li>

                <!-- Competitions Dropdown -->
                <li class="relative group h-full flex items-center">
                    <a href="#" class="hover:text-primary transition flex items-center gap-1 py-1 italic">Events
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </a>
                    <div class="absolute top-[60px] left-0 w-64 bg-white shadow-2xl rounded-2xl p-4 border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-1 group-hover:translate-y-0 z-[100]">
                        <div class="space-y-2">
                             <?php if (!empty($competitionSports)): ?>
                                 <?php foreach ($competitionSports as $s): ?>
                                     <a href="sport-detail.php?id=<?php echo $s['id']; ?>" class="block px-4 py-2 hover:bg-gray-50 rounded-xl text-sm transition font-bold">🏆 <?php echo $s['name']; ?></a>
                                 <?php endforeach; ?>
                             <?php else: ?>
                                 <p class="px-4 py-2 text-xs text-gray-400 italic font-bold uppercase tracking-wider">No Active Events</p>
                             <?php endif; ?>
                             <div class="h-px bg-gray-100 my-2"></div>
                             <p class="px-4 py-1 text-[10px] text-slate-400 uppercase font-black italic">Marathon • League • Cups</p>
                        </div>
                    </div>
                </li>

                <li><a href="student-hub.php" class="<?php echo isActive('student-hub.php', $current_page); ?> py-1">Hub</a></li>
                <li><a href="gallery.php" class="<?php echo isActive('gallery.php', $current_page); ?> py-1">Gallery</a></li>
                <li><a href="index.php#contact" class="bg-primary text-white px-6 py-2 rounded-full hover:bg-orange-700 transition">Join Now</a></li>
            </ul>

            <button class="md:hidden text-secondary p-2 shrink-0" id="mobileMenuBtn">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </nav>
        
        <!-- Mobile Dropdown -->
        <div id="mobileMenu" class="hidden md:hidden bg-primary p-8 space-y-6 shadow-2xl text-white italic uppercase tracking-tighter fixed inset-0 z-[100] flex flex-col">
         <div class="flex justify-between items-center mb-8">
             <span class="text-2xl font-black italic tracking-tighter uppercase">BLUESTONE <span class="text-black italic">ELITE</span></span>
             <button class="text-white text-4xl leading-none" onclick="document.getElementById('mobileMenu').classList.add('hidden')">&times;</button>
         </div>
             
             <nav class="space-y-6 text-3xl font-black">
                 <a href="index.php" class="block border-b border-white/20 pb-4">Home</a>
                 <a href="about.php" class="block border-b border-white/20 pb-4">About</a>
                 <a href="sports.php" class="block border-b border-white/20 pb-4">Academy</a>
                 <a href="student-hub.php" class="block border-b border-white/20 pb-4">Hub</a>
                 <a href="gallery.php" class="block border-b border-white/20 pb-4">Gallery</a>
             </nav>
             
             <div class="mt-auto">
                 <a href="index.php#contact" class="block w-full bg-white text-primary text-center py-5 rounded-2xl font-black tracking-widest uppercase text-sm shadow-xl" onclick="document.getElementById('mobileMenu').classList.add('hidden')">Join Now →</a>
             </div>
        </div>
    </header>

    <script>
        const btn = document.getElementById('mobileMenuBtn');
        const menu = document.getElementById('mobileMenu');
        btn.onclick = () => menu.classList.toggle('hidden');
    </script>
