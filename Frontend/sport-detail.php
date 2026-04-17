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
    echo "<section class='py-20 text-center bg-gray-50'>
            <h1 class='text-3xl md:text-4xl font-black uppercase italic'>Sport Not Found</h1>
            <a href='sports.php' class='text-primary font-black mt-4 block uppercase text-sm hover:underline'>← Back</a>
          </section>";
    include 'includes/footer.php';
    exit;
}

$page_title = $sport['name'];
include 'includes/header.php';
?>

<!-- HERO -->
<section class="relative min-h-[70vh] md:min-h-[85vh] bg-primary flex items-center overflow-hidden">
    
    <div class="absolute inset-0">
        <?php 
        $displayImage = $api->resolveSportImage($sport);
        if (!empty($displayImage)): ?>
            <img src="<?php echo $displayImage; ?>" 
                 class="w-full h-full object-cover opacity-30 scale-105" fetchpriority="high" decoding="sync">
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-white/10 to-transparent"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 md:px-12 relative z-10 pt-20 pb-10">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-10">

            <!-- LEFT -->
            <div class="max-w-3xl">
                <span class="inline-block px-3 py-1 text-[10px] bg-white/20 backdrop-blur text-white font-bold rounded-full mb-6">
                    <?php echo $sport['category']; ?>
                </span>

                <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-black italic leading-tight text-white">
                    <?php echo $sport['name']; ?><br>
                    <span class="text-secondary">ELITE HUB</span>
                </h1>

                <p class="text-xs sm:text-sm mt-4 text-white/80 font-bold uppercase">
                    Professional Discipline • Technical Excellence
                </p>
            </div>

            <!-- RIGHT STATS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full lg:w-auto">
                <div class="bg-white/10 backdrop-blur p-4 rounded-2xl text-center">
                    <p class="text-xs font-bold text-secondary">Age</p>
                    <p class="text-white text-bold"><?php echo $sport['age_category'] ?: '6-24Y'; ?></p>
                </div>
                <div class="bg-white/10 backdrop-blur p-4 rounded-2xl text-center">
                    <p class="text-xs font-bold text-secondary">Level</p>
                    <p class="text-white text-bold">Pro</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- CONTENT -->
<section class="py-12 sm:py-16 md:py-24 bg-white">
    <div class="container mx-auto px-4 sm:px-6 md:px-12">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 md:gap-16">

            <!-- LEFT CONTENT -->
            <div class="lg:col-span-7 space-y-12">

                <!-- DESCRIPTION -->
                <div>
                    <h2 class="text-xs font-black uppercase text-primary mb-4">Overview</h2>
                    <p class="text-base sm:text-lg md:text-xl text-gray-600 leading-relaxed">
                        <?php echo $sport['description']; ?>
                    </p>
                </div>

                <!-- PILLARS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="p-6 bg-gray-50 rounded-2xl">
                        <h4 class="font-black mb-2">Technical Mastery</h4>
                        <p class="text-sm text-gray-500">
                            Skills & fundamentals of <?php echo $sport['name']; ?>
                        </p>
                    </div>
                    <div class="p-6 bg-gray-50 rounded-2xl">
                        <h4 class="font-black mb-2">Physical Training</h4>
                        <p class="text-sm text-gray-500">
                            Strength, agility & endurance
                        </p>
                    </div>
                </div>

                <!-- CURRICULUM -->
                <div>
                    <h3 class="text-xs font-black uppercase text-primary mb-6">Curriculum</h3>
                    <div class="space-y-4">
                        <div class="p-4 bg-orange-100 rounded-xl">Foundation</div>
                        <div class="p-4 bg-orange-100 rounded-xl">Intermediate</div>
                        <div class="p-4 bg-orange-100 rounded-xl">Advanced</div>
                    </div>
                </div>

                <!-- SCHEDULE -->
                <div class="bg-secondary p-6 sm:p-10 rounded-2xl text-white">
                    <h3 class="text-xl font-black mb-6">Schedule</h3>

                    <div class="space-y-4">
                        <div class="flex justify-between text-sm">
                            <span>Weekdays</span>
                            <span><?php echo $sport['training_schedule'] ?: '6AM - 9AM'; ?></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>Weekend</span>
                            <span>4PM - 7PM</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- FORM -->
            <div class="lg:col-span-5 w-full">
                <div class="relative lg:sticky top-24">

                    <div class="bg-white p-6 sm:p-8 md:p-10 rounded-2xl shadow-lg">

                        <h3 class="text-2xl font-black mb-6">Join Now</h3>

                        <form id="enquiryForm" class="space-y-4">
                            <input type="hidden" name="program" value="<?php echo $sport['name']; ?>">

                            <input type="text" name="fullName" placeholder="Full Name" required class="w-full p-3 bg-gray-100 rounded-lg">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <input type="number" name="age" placeholder="Age" required class="p-3 bg-gray-100 rounded-lg">
                                <input type="tel" name="phone" placeholder="Phone" required class="p-3 bg-gray-100 rounded-lg">
                            </div>

                            <input type="email" name="email" placeholder="Email" required class="w-full p-3 bg-gray-100 rounded-lg">

                            <textarea name="message" placeholder="Your goals" class="w-full p-3 bg-gray-100 rounded-lg"></textarea>

                            <div class="flex flex-col gap-3 p-4 bg-secondary rounded-xl border border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div id="captchaDisplay" style="color: #FF6B00 !important; font-family: monospace;" class="bg-secondary px-4 py-2 rounded-lg font-black text-xl tracking-[0.3em] select-none pointer-events-none">
                                        LOADING
                                    </div>
                                    <button type="button" onclick="generateCaptcha()" class="text-primary hover:text-secondary p-2 transition">
                                        <i class="fa-solid fa-rotate-right"></i>
                                    </button>
                                </div>
                                <input type="text" id="captchaInput" placeholder="Verify Code" required class="w-full p-2 bg-white border border-gray-200 rounded-lg text-sm font-bold uppercase tracking-widest outline-none focus:border-primary transition">
                            </div>

                            <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-bold">
                                Submit
                            </button>
                        </form>

                        <div id="formStatus" class="mt-4 text-sm text-center hidden"></div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- RELATED -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 md:px-12">

        <h2 class="text-2xl md:text-4xl font-black text-secondary mb-10 italic uppercase tracking-tighter">Other <span class="text-primary italic">Programs</span></h2>

        <div class="relative group">
            <!-- Navigation Buttons -->
            <button onclick="slidePrograms('prev')" class="absolute left-0 top-1/2 -translate-y-1/2 z-20 bg-white/80 backdrop-blur-md text-secondary w-12 h-12 rounded-full flex items-center justify-center shadow-xl border border-gray-100 opacity-0 group-hover:opacity-100 -translate-x-6 hover:bg-primary hover:text-white transition-all duration-300">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button onclick="slidePrograms('next')" class="absolute right-0 top-1/2 -translate-y-1/2 z-20 bg-white/80 backdrop-blur-md text-secondary w-12 h-12 rounded-full flex items-center justify-center shadow-xl border border-gray-100 opacity-0 group-hover:opacity-100 translate-x-6 hover:bg-primary hover:text-white transition-all duration-300">
                <i class="fa-solid fa-chevron-right"></i>
            </button>

            <div id="programsSlider" class="flex gap-6 overflow-x-auto pb-6 scroll-smooth h-scroll-hide">

            <?php 
            $all = $api->getSports();
            if (is_array($all)):
                foreach(array_slice($all, 0, 6) as $s):
                if ($s['id'] == $page_id) continue;
            ?>

            <a href="sport-detail.php?id=<?php echo $s['id']; ?>" 
               class="min-w-[240px] sm:min-w-[280px] bg-white p-6 rounded-xl shadow">

                <?php 
                $displayImage = $api->resolveSportImage($s);
                if (!empty($displayImage)): ?>
                    <img src="<?php echo $displayImage; ?>" 
                         class="w-full h-32 object-cover rounded mb-4" loading="lazy" decoding="async">
                <?php endif; ?>

                <h4 class="font-bold"><?php echo $s['name']; ?></h4>
                <p class="text-xs text-gray-400"><?php echo $s['category']; ?></p>

            </a>

            <?php endforeach; endif; ?>
            </div>
        </div>

    </div>
</section>
<style>
    .h-scroll-hide::-webkit-scrollbar { display: none; }
    .h-scroll-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
function slidePrograms(direction) {
    const slider = document.getElementById('programsSlider');
    const scrollAmount = 300; // Approx width of one card + gap
    if (direction === 'next') {
        slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    } else {
        slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    }
}

(function() {
    window._bluestoneCaptchaSport = "";

    window.generateCaptcha = function() {
        try {
            const display = document.getElementById('captchaDisplay');
            if (!display) return;
            
            const chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
            let code = '';
            for (let i = 0; i < 6; i++) {
                code += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            window._bluestoneCaptchaSport = code;
            display.innerHTML = code;
        } catch (e) {
            console.error("Sport Captcha Error:", e);
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

document.getElementById('enquiryForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const captchaInput = document.getElementById('captchaInput').value.trim().toUpperCase();
    const formStatus = document.getElementById('formStatus');

    if (captchaInput !== window._bluestoneCaptchaSport) {
        formStatus.innerText = "INVALID CAPTCHA! Please enter the correct code.";
        formStatus.className = "text-red-600 text-center mt-4 font-bold border border-red-200 bg-red-50 p-2 rounded-lg";
        formStatus.classList.remove('hidden');
        window.generateCaptcha();
        document.getElementById('captchaInput').value = '';
        return;
    }

    const form = e.target;

    const data = Object.fromEntries(new FormData(form).entries());

    const payload = {
        name: data.fullName,
        fullName: data.fullName,
        student_name: data.fullName,
        email: data.email,
        phone: data.phone,
        domain: "Elite Sports",
        category: "Website Enquiry",
        interested_in: data.program,
        businessFocus: [data.program],
        message: `Age: ${data.age}, ${data.message}`
    };

    try {
        const res = await fetch('https://bluestoneinternationalpreschool.com/bgoi_portal/api/contact', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        const result = await res.json();

        if (res.ok || result.success) {
            formStatus.innerText = "APPLICATION SUCCESSFUL!";
            formStatus.className = "text-green-600 text-center mt-4 p-2 bg-green-50 border border-green-200 rounded-lg";
            form.reset();
            window.generateCaptcha();
        } else {
            throw new Error(result.message || "Failed");
        }

    } catch (err) {
        console.error(err);
        formStatus.innerText = "ERROR: Please try again later.";
        formStatus.className = "text-red-600 text-center mt-4 p-2 bg-red-50 border border-red-200 rounded-lg";
    }

    formStatus.classList.remove('hidden');
});
</script>

<?php include 'includes/footer.php'; ?>