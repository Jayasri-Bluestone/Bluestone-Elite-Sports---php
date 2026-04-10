<?php
$page_title = "Elite Sports Programs";
include 'includes/header.php';
?>

<!-- Secondary Hero -->
<section class="bg-primary pt-32 pb-20 relative overflow-hidden text-center text-white">
    <div class="absolute inset-0 bg-black/10 blur-3xl opacity-30"></div>
    <div class="container mx-auto px-4 md:px-12 relative z-10">
        <h1 class="text-4xl md:text-6xl font-black uppercase italic tracking-tighter mb-4">The <span class="text-black italic">Academy Hub</span></h1>
        <p class="text-black font-bold uppercase tracking-widest text-[10px] md:text-xs">Professional Disciplines & Training</p>
    </div>
</section>

<!-- Sports Archive -->
<section class="py-24 container mx-auto px-4 md:px-12">
    <div class="flex flex-wrap justify-center gap-4 mb-16">
        <button class="bg-primary text-white px-8 py-3 rounded-full font-bold uppercase text-xs tracking-widest shadow-xl shadow-orange-500/20">All Categories</button>
        <button class="border border-gray-200 px-8 py-3 rounded-full font-bold uppercase text-xs tracking-widest hover:border-primary hover:text-primary transition">Academy</button>
        <button class="border border-gray-200 px-8 py-3 rounded-full font-bold uppercase text-xs tracking-widest hover:border-primary hover:text-primary transition">Professional</button>
        <button class="border border-gray-200 px-8 py-3 rounded-full font-bold uppercase text-xs tracking-widest hover:border-primary hover:text-primary transition">Summer & Indoor</button>
    </div>

    <div class="overflow-x-auto pb-12 custom-scrollbar">
        <div class="flex flex-row gap-6 min-h-[600px] w-max px-4">
            <?php if (is_array($sports) && !isset($sports['error'])): ?>
                <?php foreach ($sports as $sport): ?>
                    <?php if (is_array($sport)): ?>
                        <div class="w-[240px] hover:w-[550px] transition-all duration-700 ease-in-out group relative overflow-hidden bg-white rounded-[2.5rem] border border-gray-100 shadow-2xl cursor-pointer">
                            <!-- Background Image -->
                            <div class="absolute inset-0">
                                <?php if (!empty($sport['image_path'])): ?>
                                    <img src="<?php echo $sport['image_path']; ?>" alt="<?php echo $sport['name']; ?>" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                                <?php else: ?>
                                    <div class="w-full h-full bg-gradient-to-br from-gray-400 to-gray-600"></div>
                                <?php endif; ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                            </div>

                            <!-- Content Overlay -->
                            <div class="absolute inset-0 p-8 flex flex-col justify-end text-white">
                                <!-- Category Badge -->
                                <span class="mb-4 bg-primary px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full self-start">
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
                                        <p class="text-gray-300 text-sm mb-6 leading-relaxed line-clamp-3 max-w-md">
                                            <?php echo $sport['description'] ?: 'Master-level coaching and athletic excellence at Bluestone Elite Sports Hub.'; ?>
                                        </p>
                                        <a href="sport-detail.php?id=<?php echo $sport['id']; ?>" class="inline-flex items-center gap-3 text-primary font-black uppercase tracking-widest text-xs">
                                            Exploration Program 
                                            <span class="text-xl">→</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="w-full py-20 text-center text-gray-400 font-bold uppercase tracking-widest italic">Loading Academy Programs...</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
