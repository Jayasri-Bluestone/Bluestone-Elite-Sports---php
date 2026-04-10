<?php
$page_title = "Student Hub";
include 'includes/header.php';
?>

<!-- Secondary Hero -->
<section class="bg-secondary py-32 relative overflow-hidden text-center text-white italic">
    <div class="absolute inset-0 bg-primary/10 blur-3xl opacity-30"></div>
    <div class="container mx-auto px-4 md:px-12 relative z-10">
        <h1 class="text-6xl font-black uppercase tracking-tighter mb-4">Student <span class="text-primary italic">Hub</span></h1>
        <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">Your gateway to excellence</p>
    </div>
</section>

<!-- Student Hub Content -->
<section class="py-24 container mx-auto px-4 md:px-12">
    <div class="grid md:grid-cols-3 gap-12">
        <!-- Portal Card -->
        <div class="bg-white p-12 rounded-[2.5rem] shadow-2xl border border-gray-100 flex flex-col items-center text-center">
            <div class="w-20 h-20 bg-primary/10 rounded-3xl flex items-center justify-center text-primary text-3xl mb-8 italic">🔑</div>
            <h3 class="text-2xl font-black uppercase mb-4 italic tracking-tighter">Student Login</h3>
            <p class="text-gray-500 text-sm mb-10 leading-relaxed italic">Access your training schedules, performance reports, and coaching feedback.</p>
            <button class="w-full bg-secondary text-white py-4 rounded-2xl font-black uppercase tracking-widest text-sm hover:bg-primary transition shadow-xl shadow-orange-500/10">Launch Portal</button>
        </div>
        
        <!-- Resources Card -->
        <div class="bg-white p-12 rounded-[2.5rem] shadow-2xl border border-gray-100 flex flex-col items-center text-center">
            <div class="w-20 h-20 bg-primary/10 rounded-3xl flex items-center justify-center text-primary text-3xl mb-8 italic">📚</div>
            <h3 class="text-2xl font-black uppercase mb-4 italic tracking-tighter">Learning Center</h3>
            <p class="text-gray-500 text-sm mb-10 leading-relaxed italic">Download nutrition guides, mental wellness toolkits, and technical videos.</p>
            <button class="w-full bg-secondary text-white py-4 rounded-2xl font-black uppercase tracking-widest text-sm hover:bg-primary transition shadow-xl shadow-orange-500/10">View Resources</button>
        </div>
        
        <!-- Community Card -->
        <div class="bg-white p-12 rounded-[2.5rem] shadow-2xl border border-gray-100 flex flex-col items-center text-center">
            <div class="w-20 h-20 bg-primary/10 rounded-3xl flex items-center justify-center text-primary text-3xl mb-8 italic">💬</div>
            <h3 class="text-2xl font-black uppercase mb-4 italic tracking-tighter">Athlete Hub</h3>
            <p class="text-gray-500 text-sm mb-10 leading-relaxed italic">Connect with fellow athletes, share experiences, and coordinate team activities.</p>
            <button class="w-full bg-secondary text-white py-4 rounded-2xl font-black uppercase tracking-widest text-sm hover:bg-primary transition shadow-xl shadow-orange-500/10">Join Group</button>
        </div>
    </div>
</section>

<!-- Upcoming Events -->
<section class="bg-gray-50 py-24">
    <div class="container mx-auto px-4 md:px-12">
        <h2 class="text-3xl font-black uppercase italic tracking-tighter mb-12 border-b-4 border-primary inline-block">Upcoming <span class="text-primary italic font-bold">Sessions</span></h2>
        <div class="space-y-4">
             <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-8">
                 <div class="flex items-center gap-8">
                     <span class="text-primary font-black text-2xl uppercase tracking-tighter italic">AUG 15</span>
                     <div>
                         <h4 class="font-black uppercase italic tracking-tighter">Cricket Masterclass</h4>
                         <p class="text-gray-400 text-sm font-bold uppercase tracking-widest">Main Hub, 06:00 AM</p>
                     </div>
                 </div>
                 <button class="bg-primary/10 text-primary px-8 py-3 rounded-full font-black uppercase tracking-widest text-[10px] hover:bg-primary hover:text-white transition italic">Interested</button>
             </div>
             
             <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-8">
                 <div class="flex items-center gap-8">
                     <span class="text-primary font-black text-2xl uppercase tracking-tighter italic">AUG 22</span>
                     <div>
                         <h4 class="font-black uppercase italic tracking-tighter">Dynamic Yoga Workshop</h4>
                         <p class="text-gray-400 text-sm font-bold uppercase tracking-widest">Sky Field Dojo, 07:30 AM</p>
                     </div>
                 </div>
                 <button class="bg-primary/10 text-primary px-8 py-3 rounded-full font-black uppercase tracking-widest text-[10px] hover:bg-primary hover:text-white transition italic">Interested</button>
             </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
