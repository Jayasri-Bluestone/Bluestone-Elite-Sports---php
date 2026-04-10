<?php
require_once 'api_helper.php';
$api = new ApiHelper();

$page_id = $_GET['id'] ?? null;
if (!$page_id) {
    header("Location: sports.php");
    exit;
}

$sport = $api->getSportById($page_id);

if (!$sport || isset($sport['error'])) {
    include 'includes/header.php';
    echo "<section class='py-32 text-center bg-gray-50'><h1 class='text-4xl font-black uppercase italic tracking-tighter'>Sport Not Found</h1><a href='sports.php' class='text-primary font-black mt-4 block uppercase tracking-widest text-sm hover:underline italic'>← Back to Programs</a></section>";
    include 'includes/footer.php';
    exit;
}

$page_title = $sport['name'];
include 'includes/header.php';
?>

<!-- Enhanced Sport Detail Hero -->
<section class="relative min-h-[85vh] bg-primary flex items-center overflow-hidden">
    <!-- Animated background element -->
    <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full blur-[120px] animate-pulse"></div>
    
    <div class="absolute inset-0">
        <?php if (!empty($sport['image_path'])): ?>
            <img src="<?php echo $sport['image_path']; ?>" alt="<?php echo $sport['name']; ?>" class="w-full h-full object-cover opacity-30 transform scale-105 group-hover:scale-110 transition-transform duration-[20s]">
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-t from-secondary via-white/10 to-transparent"></div>
    </div>
    
    <div class="container mx-auto px-4 md:px-12 relative z-10 text-white pt-24 pb-12 md:py-20">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-12">
            <div class="max-w-4xl">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-black/10 border border-black/20 text-black text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-8 italic backdrop-blur-md">
                    <span class="w-2 h-2 bg-black rounded-full animate-ping"></span>
                    <?php echo $sport['category']; ?>
                </span>
                <h1 class="text-3xl md:text-7xl font-black mb-8 leading-[0.85] uppercase tracking-tighter italic text-black">
                    <?php echo $sport['name']; ?> <br> 
                    <span class="italic relative">
                        ELITE HUB
                        <svg class="absolute -bottom-2 left-0 w-full h-3 text-black/10" viewBox="0 0 100 10" preserveAspectRatio="none"><path d="M0 0 C 20 10 80 10 100 0" stroke="currentColor" fill="transparent" stroke-width="2" /></svg>
                    </span>
                </h1>
                <p class="text-black/80 font-bold uppercase tracking-[0.3em] text-[10px] md:text-xs mb-10 italic">Professional Discipline • Technical Excellence • Championship Mindset</p>
            </div>
            
            <!-- Quick Stats Bar (Desktop) -->
            <div class="hidden lg:grid grid-cols-2 gap-4 mb-2">
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl text-center min-w-[160px]">
                    <p class="text-[10px] font-black uppercase tracking-widest text-primary mb-1">Age Group</p>
                    <p class="text-lg font-black italic uppercase tracking-tighter"><?php echo $sport['age_category'] ?: '6 - 24Y'; ?></p>
                </div>
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl text-center min-w-[160px]">
                    <p class="text-[10px] font-black uppercase tracking-widest text-primary mb-1">Intensity</p>
                    <p class="text-lg font-black italic uppercase tracking-tighter">Pro Level</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Architecture -->
<section class="py-24 bg-white relative">
    <!-- Decorative background text -->
    <div class="absolute top-20 right-0 text-[180px] font-black italic text-gray-50 select-none pointer-events-none uppercase leading-none transform translate-x-1/4">STRATEGY</div>

    <div class="container mx-auto px-4 md:px-12">
        <div class="grid lg:grid-cols-12 gap-20">
            <!-- Main Content Area -->
            <div class="lg:col-span-7 space-y-16">
                <!-- Overview -->
                <div>
                    <h2 class="text-xs font-black uppercase tracking-[0.4em] text-primary mb-6 italic">Academy Blueprint</h2>
                    <p class="text-gray-600 text-2xl leading-relaxed italic font-medium">
                        <?php echo $sport['description']; ?>
                    </p>
                </div>

                <!-- Training Pillars -->
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="p-10 bg-gray-50 rounded-[3rem] border border-gray-100 hover:border-primary/20 transition group">
                        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary font-black mb-6 group-hover:bg-primary group-hover:text-white transition-colors uppercase italic">T</div>
                        <h4 class="text-xl font-black uppercase italic tracking-tighter mb-4">Technical Mastery</h4>
                        <p class="text-gray-500 text-sm leading-relaxed italic">Deep dive into fundamentals and advanced maneuvers specific to <?php echo $sport['name']; ?>.</p>
                    </div>
                    <div class="p-10 bg-gray-50 rounded-[3rem] border border-gray-100 hover:border-primary/20 transition group">
                        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary font-black mb-6 group-hover:bg-primary group-hover:text-white transition-colors uppercase italic">P</div>
                        <h4 class="text-xl font-black uppercase italic tracking-tighter mb-4">Physical Conditioning</h4>
                        <p class="text-gray-500 text-sm leading-relaxed italic">Sport-specific strength, agility, and endurance training for peak performance.</p>
                    </div>
                </div>

                <!-- Schedule Section -->
                <div class="bg-secondary p-12 md:p-16 rounded-[4rem] text-white overflow-hidden relative group">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-primary/10 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
                    <h3 class="text-3xl font-black italic uppercase tracking-tighter mb-8 flex items-center gap-4">
                        <span class="w-2 h-12 bg-primary rounded-full"></span>
                        Weekly <span class="text-primary italic">Schedule</span>
                    </h3>
                    <div class="space-y-6 relative z-10">
                        <div class="flex justify-between items-center py-4 border-b border-white/10 italic">
                            <span class="font-black uppercase tracking-widest text-xs text-gray-400">Regular Sessions</span>
                            <span class="font-bold text-lg"><?php echo $sport['training_schedule'] ?: 'Mon - Fri (6 AM - 9 AM)'; ?></span>
                        </div>
                        <div class="flex justify-between items-center py-4 border-b border-white/10 italic">
                            <span class="font-black uppercase tracking-widest text-xs text-gray-400">Advanced Hub</span>
                            <span class="font-bold text-lg italic">Sat (4 PM - 7 PM)</span>
                        </div>
                        <div class="pt-6">
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">* Personalized training slots available upon request</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sticky Enquiry Sidebar -->
            <div class="lg:col-span-5">
                <div class="sticky top-32">
                    <div class="bg-white p-10 md:p-12 rounded-[4rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] border border-gray-100 relative group">
                        <!-- Form Header -->
                        <div class="mb-10">
                            <h3 class="text-4xl font-black italic uppercase tracking-tighter mb-2 leading-none">JOIN THE <span class="text-primary italic">SQUAD</span></h3>
                            <p class="text-gray-400 font-bold uppercase tracking-widest text-[10px] italic">Portal for Academy Enrollment</p>
                        </div>

                        <form id="enquiryForm" class="space-y-6">
                            <input type="hidden" name="program" value="<?php echo $sport['name']; ?>">
                            
                            <div class="space-y-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 ml-4 italic">Full Name</label>
                                        <input type="text" name="fullName" required class="w-full px-6 py-4 rounded-3xl bg-gray-50 border-none focus:ring-2 focus:ring-primary/20 transition outline-none font-bold italic text-sm">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 ml-4 italic">Age</label>
                                        <input type="number" name="age" required class="w-full px-6 py-4 rounded-3xl bg-gray-50 border-none focus:ring-2 focus:ring-primary/20 transition outline-none font-bold italic text-sm">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 ml-4 italic">Email Hub</label>
                                    <input type="email" name="email" required class="w-full px-6 py-4 rounded-3xl bg-gray-50 border-none focus:ring-2 focus:ring-primary/20 transition outline-none font-bold italic text-sm">
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 ml-4 italic">Phone Terminal</label>
                                    <input type="tel" name="phone" required class="w-full px-6 py-4 rounded-3xl bg-gray-50 border-none focus:ring-2 focus:ring-primary/20 transition outline-none font-bold italic text-sm">
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 ml-4 italic">Training Objectives</label>
                                    <textarea name="message" rows="3" class="w-full px-6 py-4 rounded-3xl bg-gray-50 border-none focus:ring-2 focus:ring-primary/20 transition outline-none font-bold italic text-sm"></textarea>
                                </div>
                            </div>

                            <button type="submit" class="w-full group/btn relative bg-primary py-6 rounded-3xl text-white font-black text-xs uppercase italic tracking-[0.2em] shadow-2xl shadow-orange-500/20 hover:bg-orange-700 transition overflow-hidden">
                                <span class="relative z-10">Initialize Application →</span>
                                <div class="absolute inset-0 bg-white/10 translate-x-[-100%] group-hover/btn:translate-x-0 transition-transform duration-500"></div>
                            </button>
                        </form>
                        
                        <div id="formStatus" class="mt-6 text-center font-bold text-[10px] uppercase tracking-widest italic hidden"></div>

                        <div class="mt-10 pt-8 border-t border-gray-100 flex items-center justify-between italic">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Global Support:</span>
                            <span class="text-[10px] font-black text-secondary">+91 98765 43210</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Programs Preview -->
<section class="py-24 bg-gray-50 overflow-hidden">
    <div class="container mx-auto px-4 md:px-12 mb-16 flex justify-between items-end">
        <div>
            <h2 class="text-4xl font-black italic uppercase tracking-tighter leading-none">EXPLORE OTHER <span class="text-primary italic">HUBS</span></h2>
            <p class="text-gray-400 font-bold uppercase tracking-widest text-[10px] mt-2 italic">Diversified Elite Academy Selection</p>
        </div>
        <a href="sports.php" class="text-primary font-black uppercase tracking-widest text-xs hover:underline decoration-2 underline-offset-8 italic">View All Programs →</a>
    </div>
    
    <div class="flex gap-8 overflow-x-auto pb-12 custom-scrollbar px-12">
        <?php 
        $all = $api->getSports();
        if (is_array($all)): 
            foreach(array_slice($all, 0, 6) as $s): 
                if ($s['id'] == $page_id) continue;
        ?>
            <a href="sport-detail.php?id=<?php echo $s['id']; ?>" class="min-w-[300px] bg-white p-8 rounded-[3rem] shadow-xl border border-gray-100 hover:border-primary/20 transition group">
                <div class="h-40 bg-gray-100 rounded-3xl overflow-hidden mb-6 relative">
                    <?php if (!empty($s['image_path'])): ?>
                        <img src="<?php echo $s['image_path']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
                <h4 class="text-xl font-black uppercase italic tracking-tighter mb-2 group-hover:text-primary transition-colors"><?php echo $s['name']; ?></h4>
                <p class="text-[10px] font-black tracking-widest text-gray-400 uppercase"><?php echo $s['category']; ?></p>
            </a>
        <?php 
            endforeach;
        endif; 
        ?>
    </div>
</section>

<script>
    document.getElementById('enquiryForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const status = document.getElementById('formStatus');
        const submitBtn = form.querySelector('button');
        const originalText = submitBtn.innerText;
        
        submitBtn.innerText = 'PROCESSING PORTAL...';
        submitBtn.disabled = true;
        
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        try {
            const response = await fetch('http://localhost:5004/api/contact', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.success) {
                status.innerText = 'APPLICATION SUCCESSFUL! CHECK EMAIL.';
                status.className = 'mt-6 text-center font-bold text-[10px] uppercase tracking-widest italic text-green-600';
                status.classList.remove('hidden');
                form.reset();
            } else { throw new Error('FAILED'); }
        } catch (err) {
            status.innerText = 'PORTAL ERROR. RETRY IN 60S.';
            status.className = 'mt-6 text-center font-bold text-[10px] uppercase tracking-widest italic text-red-600';
            status.classList.remove('hidden');
        } finally {
            setTimeout(() => {
                submitBtn.innerText = originalText;
                submitBtn.disabled = false;
            }, 2000);
        }
    });
</script>

<?php include 'includes/footer.php'; ?>
