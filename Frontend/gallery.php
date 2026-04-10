<?php
$page_title = "Elite Gallery";
include 'includes/header.php';
?>

<!-- Secondary Hero -->
<section class="bg-secondary py-32 relative overflow-hidden text-center text-white">
    <div class="absolute inset-0 bg-primary/10 blur-3xl opacity-30"></div>
    <div class="container mx-auto px-4 md:px-12 relative z-10">
        <h1 class="text-6xl font-black uppercase italic tracking-tighter mb-4">Elite <span class="text-primary italic">Action</span></h1>
        <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">Moments of Glory & Intensity</p>
    </div>
</section>

<!-- Gallery Archive -->
<section class="py-24 container mx-auto px-4 md:px-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <?php if (is_array($gallery) && !isset($gallery['error'])): ?>
            <?php foreach ($gallery as $img): ?>
                <?php if (is_array($img)): ?>
                    <div class="relative h-80 rounded-[2rem] overflow-hidden group shadow-2xl border border-gray-100 italic transition-transform duration-500 hover:-translate-y-2">
                         <img src="<?php echo $img['image_path']; ?>" alt="Elite Gallery" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                         <div class="absolute inset-0 bg-secondary/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white">
                             <div class="text-3xl mb-4 text-primary">📸</div>
                             <span class="text-xs font-black uppercase tracking-widest italic">View Highlight</span>
                         </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
             <!-- Fallback Masonry Tiles -->
             <div class="h-80 bg-gray-100 rounded-3xl animate-pulse"></div>
             <div class="h-80 bg-gray-300 rounded-3xl animate-pulse delay-75"></div>
             <div class="h-80 bg-gray-200 rounded-3xl animate-pulse delay-150"></div>
             <div class="h-80 bg-gray-300 rounded-3xl animate-pulse delay-200"></div>
             <div class="h-80 bg-gray-200 rounded-3xl animate-pulse delay-300"></div>
             <div class="h-80 bg-gray-100 rounded-3xl animate-pulse delay-400"></div>
             <div class="h-80 bg-gray-300 rounded-3xl animate-pulse delay-500"></div>
             <div class="h-80 bg-gray-200 rounded-3xl animate-pulse delay-600"></div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
