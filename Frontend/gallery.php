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
    <div id="galleryGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <?php 
        if (is_array($gallery) && !isset($gallery['error'])): 
            $initialCount = 12;
            // Map the entire gallery for easy JS access
            $allGalleryData = array_map(function($i) { return ['image_path' => $i['image_path']]; }, $gallery);
            $initialGallery = array_slice($gallery, 0, $initialCount);
            $remainingGallery = array_slice($gallery, $initialCount);
            
            foreach ($initialGallery as $index => $img): 
                if (is_array($img)): 
        ?>
                     <div class="relative h-80 rounded-[2rem] overflow-hidden group shadow-2xl border border-gray-100 transition-all duration-500 hover:-translate-y-2 cursor-pointer gallery-item bg-gray-100 skeleton" 
                          onclick="openGalleryModal(<?php echo $index; ?>)">
                          <img src="<?php echo $img['image_path']; ?>" alt="Elite Gallery" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy" decoding="async">
                          <div class="absolute inset-0 bg-secondary/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col items-center justify-center text-white">
                             <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center mb-4 scale-75 group-hover:scale-100 transition-transform duration-500">
                                <i class="fa-solid fa-expand text-2xl text-white"></i>
                             </div>
                             <span class="text-[10px] font-black uppercase tracking-[0.2em] translate-y-4 group-hover:translate-y-0 transition-transform duration-500">Elite Moment</span>
                          </div>
                    </div>
        <?php 
                endif; 
            endforeach; 
        ?>
    </div>

    <!-- Load More Button -->
    <?php if (count($remainingGallery) > 0): ?>
    <div id="loadMoreContainer" class="mt-24 text-center">
        <button onclick="loadMoreImages()" class="group relative px-12 py-5 bg-secondary text-white rounded-full font-black uppercase tracking-widest text-xs overflow-hidden transition-all hover:pr-16">
            <span class="relative z-10 transition-all group-hover:tracking-[0.2em]">Explore More Glory</span>
            <div class="absolute inset-0 bg-primary translate-x-[-100%] group-hover:translate-x-0 transition-transform duration-500"></div>
            <i class="fa-solid fa-arrow-right absolute right-8 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-500"></i>
        </button>
    </div>
    <?php endif; ?>

    <script>
        const allImages = <?php echo json_encode($allGalleryData); ?>;
        let currentModalIndex = 0;
        let displayedCount = <?php echo $initialCount; ?>;
        const batchSize = 12;

        function loadMoreImages() {
            const grid = document.getElementById('galleryGrid');
            const nextBatch = allImages.slice(displayedCount, displayedCount + batchSize);
            
            nextBatch.forEach((img, idx) => {
                const globalIndex = displayedCount + idx;
                const div = document.createElement('div');
                div.className = "relative h-80 rounded-[2rem] overflow-hidden group shadow-2xl border border-gray-100 transition-all duration-500 hover:-translate-y-2 cursor-pointer opacity-0 translate-y-8 gallery-item";
                div.onclick = () => openGalleryModal(globalIndex);
                
                div.innerHTML = `
                    <div class="absolute inset-0 bg-gray-100 skeleton"></div>
                    <img src="${img.image_path}" alt="Elite Gallery" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 relative z-10" loading="lazy" decoding="async">
                    <div class="absolute inset-0 bg-secondary/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col items-center justify-center text-white z-20">
                        <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center mb-4 scale-75 group-hover:scale-100 transition-transform duration-500">
                             <i class="fa-solid fa-expand text-2xl text-white"></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] translate-y-4 group-hover:translate-y-0 transition-transform duration-500">Elite Moment</span>
                    </div>
                `;
                
                grid.appendChild(div);
                
                // Trigger animation with staggering
                setTimeout(() => {
                    div.classList.remove('opacity-0', 'translate-y-8');
                }, idx * 100);
            });

            displayedCount += batchSize;
            if (displayedCount >= allImages.length) {
                document.getElementById('loadMoreContainer').style.display = 'none';
            }
        }

        // --- ENHANCED LIGHTBOX ENGINE ---
        function openGalleryModal(index) {
            currentModalIndex = index;
            updateModalContent();
            
            const modal = document.getElementById('galleryModal');
            const container = document.getElementById('modalContainer');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                container.classList.replace('scale-95', 'scale-100');
                container.classList.remove('opacity-0');
            }, 10);
        }

        function updateModalContent() {
            const img = document.getElementById('modalImage');
            const counter = document.getElementById('modalCounter');
            const data = allImages[currentModalIndex];
            
            // Fade out current image
            img.classList.add('opacity-0');
            
            setTimeout(() => {
                img.src = data.image_path;
                counter.innerText = `Moment ${currentModalIndex + 1} of ${allImages.length}`;
                img.onload = () => img.classList.remove('opacity-0');
            }, 200);
        }

        function nextImage() {
            currentModalIndex = (currentModalIndex + 1) % allImages.length;
            updateModalContent();
        }

        function prevImage() {
            currentModalIndex = (currentModalIndex - 1 + allImages.length) % allImages.length;
            updateModalContent();
        }

        function closeGalleryModal() {
            const modal = document.getElementById('galleryModal');
            const container = document.getElementById('modalContainer');
            
            modal.classList.remove('opacity-100');
            container.classList.replace('scale-100', 'scale-95');
            container.classList.add('opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Global Listeners for Keyboard
        document.addEventListener('keydown', (e) => {
            const modal = document.getElementById('galleryModal');
            if (modal.classList.contains('hidden')) return;
            
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
            if (e.key === 'Escape') closeGalleryModal();
        });
    </script>

    <?php else: ?>
         <!-- Fallback Masonry Tiles -->
         <div class="columns-1 md:columns-2 lg:columns-4 gap-8 space-y-8">
             <div class="h-80 bg-gray-100 rounded-3xl animate-pulse break-inside-avoid"></div>
             <div class="h-64 bg-gray-300 rounded-3xl animate-pulse delay-75 break-inside-avoid"></div>
             <div class="h-96 bg-gray-200 rounded-3xl animate-pulse delay-150 break-inside-avoid"></div>
             <div class="h-72 bg-gray-300 rounded-3xl animate-pulse delay-200 break-inside-avoid"></div>
         </div>
    <?php endif; ?>
</section>

<!-- Elite Gallery Modal (Matched to Reference with Visibility Fix) -->
<div id="galleryModal" class="fixed inset-0 z-[200] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-secondary/95 backdrop-blur-md" onclick="closeGalleryModal()"></div>
    
    <!-- Navigation UI (Simplified and outside the frame) -->
 Parse error: syntax error, unexpected token "endif", expecting end of file in C:\xampp\htdocs\Bluestone Elite Sports - php\Frontend\includes\header.php on line 441

    <div class="relative z-[210] max-w-[95vw] md:max-w-4xl px-4 transition-all duration-500 transform scale-95 opacity-0" id="modalContainer">
        <!-- White Frame Container (Streamlined) -->
        <div class="bg-white p-1 md:p-2 rounded-[2.5rem] shadow-2xl overflow-hidden border-2 border-white relative">
            
            <!-- High-Visibility Close Button -->
            <button onclick="closeGalleryModal()" class="absolute top-4 right-4 w-10 h-10 bg-secondary text-white rounded-full flex items-center justify-center shadow-xl hover:bg-primary transition-all z-[300] border-2 border-white">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

            <img id="modalImage" src="" alt="Expanded View" class="w-full h-auto max-h-[60vh] object-contain rounded-[2rem] transition-opacity duration-300" decoding="async">
        </div>
        
        <!-- Subtle Accessibility Hint -->
        <div class="mt-6 text-center">
            <span id="modalCounter" class="text-[10px] font-black uppercase tracking-[0.4em] text-white/30">Click background or 'X' to close</span>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
