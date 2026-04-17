<?php
$page_title = "Contact Us";
include 'includes/header.php';
?>

<!-- Secondary Hero -->
<section class="bg-secondary pt-32 pb-24 relative overflow-hidden text-center text-white">
    <div class="absolute inset-x-0 top-0 h-full bg-[url('assets/hero.png')] bg-cover bg-center opacity-10 mix-blend-overlay"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-secondary/50 via-secondary to-secondary"></div>
    <div class="container mx-auto px-4 md:px-12 relative z-10">
        <h1 class="text-5xl md:text-8xl font-black uppercase tracking-tighter mb-4 italic leading-none">Get in <span class="text-primary italic">Touch</span></h1>
        <p class="text-gray-400 font-bold uppercase tracking-widest text-xs md:text-sm">We are here to help your elite sports journey</p>
    </div>
</section>

<!-- Contact Info & Form -->
<section class="py-24 container mx-auto px-4 md:px-12 relative">
    <div class="grid lg:grid-cols-2 gap-16">
        
        <!-- Info Column -->
        <div class="space-y-12">
            <div>
                <h2 class="text-4xl font-black uppercase tracking-tighter mb-8 italic">Elite <span class="text-primary italic">HQ</span></h2>
                <div class="space-y-8">
                    <!-- Address -->
                    <div class="flex items-start gap-6 group">
                        <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary text-xl shrink-0 transition group-hover:bg-primary group-hover:text-white">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h4 class="font-black uppercase tracking-widest text-[10px] text-primary mb-2 italic">Official Address</h4>
                            <p class="text-gray-600 font-bold leading-relaxed">Sankagiri main road, Vettukadu, Konganapuram,<br>Ammankattur, Tamil Nadu 637102</p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex items-start gap-6 group">
                        <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary text-xl shrink-0 transition group-hover:bg-primary group-hover:text-white">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <div>
                            <h4 class="font-black uppercase tracking-widest text-[10px] text-primary mb-2 italic">Direct Line</h4>
                            <p class="text-gray-600 font-black text-2xl tracking-tighter">87788 39909</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start gap-6 group">
                        <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary text-xl shrink-0 transition group-hover:bg-primary group-hover:text-white">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <h4 class="font-black uppercase tracking-widest text-[10px] text-primary mb-2 italic">Email Support</h4>
                            <p class="text-gray-600 font-bold">bluestoneelitesports@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-10 rounded-[2.5rem] border border-gray-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-3xl -translate-y-12 translate-x-12"></div>
                <h4 class="text-xl font-black uppercase italic tracking-tighter mb-6">Training Hours</h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm border-b border-gray-200 pb-3">
                        <span class="text-gray-500 font-bold">Mon - Sun</span>
                        <span class="text-secondary font-black tracking-tighter uppercase bg-white px-3 py-1 rounded-full shadow-sm">5:00 AM - 7:00 PM</span>
                    </div>
                    <p class="text-[10px] text-primary font-black uppercase tracking-widest">Open 365 Days • Elite Standard</p>
                </div>
            </div>
            <div class="relative group">
                <div class="absolute -inset-2 bg-primary/20 rounded-[2rem] blur-xl opacity-0 group-hover:opacity-100 transition duration-700"></div>
                <img src="assets/cricket team.png" alt="Elite Hub" class="w-full h-64 md:h-80 object-cover rounded-3xl relative z-10 shadow-xl border-4 border-white" loading="lazy">
            </div>
        </div>

        <!-- Form Column -->
        <div class="bg-white p-10 md:p-16 rounded-[4rem] shadow-2xl border border-gray-50">
            <h3 class="text-3xl font-black uppercase italic tracking-tighter mb-8 leading-none">Drop an <span class="text-primary italic">Enquiry</span></h3>
            
            <form id="contactPageForm" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <input type="text" name="fullName" placeholder="Full Name" required class="w-full px-6 py-4 rounded-2xl bg-white border border-gray-100 focus:border-primary transition outline-none shadow-sm text-sm font-bold">
                    <input type="tel" name="phone" placeholder="Phone Number" required class="w-full px-6 py-4 rounded-2xl bg-white border border-gray-100 focus:border-primary transition outline-none shadow-sm text-sm font-bold">
                </div>
                <input type="email" name="email" placeholder="Email Address" required class="w-full px-6 py-4 rounded-2xl bg-white border border-gray-100 focus:border-primary transition outline-none shadow-sm text-sm font-bold">
                
                <div class="relative">
                    <select name="program" class="w-full px-6 py-4 rounded-2xl bg-white border border-gray-100 focus:border-primary transition outline-none appearance-none shadow-sm font-bold text-sm">
                        <option value="">Subject / Interested Program</option>
                        <?php if (is_array($sports)): foreach ($sports as $s): ?>
                            <option value="<?php echo $s['name']; ?>"><?php echo $s['name']; ?></option>
                        <?php endforeach; endif; ?>
                        <option value="General">Other / General Enquiry</option>
                    </select>
                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-primary">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>

                <textarea name="message" placeholder="How can we help you?" rows="4" class="w-full px-6 py-4 rounded-2xl bg-white border border-gray-100 focus:border-primary transition outline-none shadow-sm text-sm font-bold"></textarea>
                
                <!-- Alpha-Numeric Captcha -->
                <div class="bg-gray-50/50 p-6 rounded-[2.5rem] border border-gray-100">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-500 mb-4 text-center">Security Verification</p>
                    <div class="flex items-center gap-4 mb-4">
                        <div id="captchaDisplay" style="color: #FF6B00 !important; font-family: 'Courier New', monospace;" class="bg-secondary px-6 py-3 rounded-2xl font-black text-2xl tracking-[0.4em] select-none shadow-inner pointer-events-none flex-1 text-center">
                            LOADING
                        </div>
                        <button type="button" onclick="generateCaptcha()" class="w-14 h-14 bg-white rounded-2xl border border-gray-200 text-primary hover:bg-primary hover:text-white transition transform active:rotate-180 duration-500 flex items-center justify-center shadow-md">
                            <i class="fa-solid fa-rotate-right text-xl"></i>
                        </button>
                    </div>
                    <input type="text" id="captchaInput" placeholder="Enter Verification Code" required class="w-full px-6 py-4 rounded-2xl bg-white border border-gray-200 focus:border-primary transition outline-none shadow-sm text-sm font-bold tracking-widest uppercase text-center focus:ring-4 focus:ring-primary/5">
                </div>

                <button type="submit" class="w-full bg-primary py-5 rounded-2xl text-white font-black text-lg uppercase tracking-widest hover:scale-[1.02] active:scale-100 transition shadow-2xl shadow-orange-500/40">Send Message →</button>
                <div id="formStatus" class="text-center mt-6 font-black hidden text-sm"></div>
            </form>
        </div>
    </div>

    <!-- Map Section -->
    <div class="mt-24 rounded-[3rem] overflow-hidden shadow-2xl border-8 border-white shadow-orange-500/10 h-[500px]">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15655.8033621946!2d77.923456!3d11.554321!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bab99f9c0000001%3A0x3bab99f9c0000001!2sAmmankattur%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1713175000000!5m2!1sen!2sin" 
            width="100%" 
            height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</section>

<script>
(function() {
    window._bluestoneCaptchaContact = "";

    window.generateCaptcha = function() {
        try {
            const display = document.getElementById('captchaDisplay');
            if (!display) return;
            
            const chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
            let code = '';
            for (let i = 0; i < 6; i++) {
                code += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            window._bluestoneCaptchaContact = code;
            display.innerHTML = code;
        } catch (e) {
            console.error("Contact Captcha Error:", e);
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

document.getElementById('contactPageForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const captchaInput = document.getElementById('captchaInput').value.trim().toUpperCase();
    const status = document.getElementById('formStatus');

    if (captchaInput !== window._bluestoneCaptchaContact) {
        status.innerText = "INVALID CAPTCHA! Please enter the correct code.";
        status.className = "text-red-600 text-center mt-4 font-black bg-red-50 p-4 border border-red-100 rounded-xl uppercase";
        status.classList.remove('hidden');
        window.generateCaptcha();
        document.getElementById('captchaInput').value = '';
        return;
    }

    const form = e.target;
    const submitBtn = form.querySelector('button');
    const originalText = submitBtn.innerText;
    
    submitBtn.innerText = 'SENDING ENQUIRY...';
    submitBtn.disabled = true;

    const data = Object.fromEntries(new FormData(form).entries());

    const payload = {
        name: data.fullName,
        email: data.email,
        phone: data.phone,
        domain: "Elite Sports",
        category: "Website Contact Page",
        interested_in: data.program || "General Enquiry",
        message: data.message
    };

    try {
        const res = await fetch('https://bluestoneinternationalpreschool.com/bgoi_portal/api/contact', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        const result = await res.json();

        if (result.success) {
            status.innerText = "YOUR MESSAGE HAS BEEN SENT SUCCESSFULLY!";
            status.className = "text-green-600 text-center mt-6 font-black bg-green-50 p-4 border border-green-100 rounded-xl uppercase";
            form.reset();
            window.generateCaptcha();
        } else {
            throw new Error("Failed");
        }

    } catch (err) {
        status.innerText = "ERROR: System is currently busy. Please call directly.";
        status.className = "text-red-600 text-center mt-6 font-black bg-red-50 p-4 border border-red-100 rounded-xl uppercase";
    } finally {
        submitBtn.innerText = originalText;
        submitBtn.disabled = false;
        status.classList.remove('hidden');
    }
});
</script>

<?php include 'includes/footer.php'; ?>
