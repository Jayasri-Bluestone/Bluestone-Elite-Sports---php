<?php
session_start();

// Logout Logic
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// Credentials (In a real system, these would be in a secure database)
$correct_email = "admin@bluestone.com";
$correct_pass = "elite@123";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';
    
    if ($email === $correct_email && $pass === $correct_pass) {
        $_SESSION['admin'] = true;
    } else {
        $error = "Access Denied: Invalid Authentication";
    }
}

if (!isset($_SESSION['admin'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Access | Bluestone Sports</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Premium Background -->
    <div class="absolute inset-0 z-0">
        <img src="assets/crick.png" class="w-full h-full object-cover opacity-100" alt="Sports Background">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-900/80 to-primary/20"></div>
    </div>

    <!-- Login Card -->
    <div class="glass w-full max-w-md rounded-[3rem] shadow-2xl p-10 md:p-14 relative z-10 border border-white/20">
        <div class="text-center mb-5">
            <div class="inline-flex items-center justify-center bg-primary/10 rounded-3xl mb-6">
                <img src="assets/Logo.png" class="w-[80%] h-[80%] object-contain" alt="Logo">
            </div>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-50 border border-red-100 text-red-600 px-6 py-4 rounded-2xl text-xs font-black uppercase tracking-widest text-center mb-8 animate-shake italic">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <input type="hidden" name="login" value="1">
            
            <div class="space-y-2">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-900 ml-4 italic">Mail ID</label>
                <div class="relative group">
                    <i class="fa-solid fa-user absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors text-sm"></i>
                    <input type="email" name="email" placeholder="admin@bluestone.com" required 
                           class="w-full pl-14 pr-6 py-4 rounded-2xl bg-slate-50 border border-black focus:ring-2 focus:ring-primary outline-none text-sm font-bold text-slate-700 transition-all shadow-inner italic">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-900 ml-4 italic">Password</label>
                <div class="relative group">
                    <i class="fa-solid fa-lock absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors text-sm"></i>
                    <input type="password" name="password" placeholder="••••••••" required 
                           class="w-full pl-14 pr-6 py-4 rounded-2xl bg-slate-50 border border-black focus:ring-2 focus:ring-primary outline-none text-sm font-bold text-slate-700 transition-all shadow-inner tracking-widest italic">
                </div>
            </div>

            <button type="submit" 
                    class="w-full bg-orange-500 py-5 rounded-2xl text-white font-black text-xs uppercase italic tracking-[0.2em] shadow-2xl shadow-orange-500/40 hover:scale-[1.02] active:scale-95 transition-all mt-4 border-none flex items-center justify-center gap-3">
                Authorize Access <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

        <div class="text-center mt-12">
            <p class="text-[9px] text-slate-300 font-bold uppercase tracking-[0.3em] italic">© 2026 BLUESTONE ELITE SPORTS ACADEMY</p>
        </div>
    </div>
</body>
</html>
<?php
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .sidebar-link.active { background: #ea580c; color: white; }
        #cropModal { z-index: 100; }
        .cropper-view-box, .cropper-face { border-radius: 20px; }

        /* Toggle Switch Styling - Enhanced Hit Area */
        .toggle-switch { position: relative; display: inline-block; width: 44px; height: 24px; cursor: pointer; }
        .toggle-switch input { position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer; z-index: 10; margin: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; border-radius: 24px; z-index: 1; }
        .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; z-index: 2; }
        input:checked + .slider { background-color: #ea580c; }
        input:checked + .slider:before { transform: translateX(20px); }

        /* Pagination Styling */
        .page-btn { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .page-btn:hover:not(:disabled) { transform: translateY(-2px); }
        .page-btn:active:not(:disabled) { transform: scale(0.95); }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-slate-900 text-slate-300 flex flex-col fixed h-full z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
        <div class="p-8 border-b border-slate-800 flex justify-between items-center">
            <h1 class="text-xl font-black text-white italic tracking-tighter uppercase">Elite <span class="text-orange-600 italic">Admin</span></h1>
            <button onclick="toggleSidebar()" class="md:hidden text-white text-2xl">&times;</button>
        </div>
        <nav class="flex-1 p-4 space-y-2 mt-4">
            <button onclick="showSection('dashboard')" class="sidebar-link w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition font-semibold hover:bg-slate-800" id="link-dashboard">
                <span>📊</span> Dashboard
            </button>
            <button onclick="showSection('sports')" class="sidebar-link w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition font-semibold hover:bg-slate-800" id="link-sports">
                <span>🏆</span> Sports Programs
            </button>
            <button onclick="showSection('leads')" class="sidebar-link w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition font-semibold hover:bg-slate-800" id="link-leads">
                <span>📩</span> Enquiries
            </button>
            <button onclick="showSection('gallery')" class="sidebar-link w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition font-semibold hover:bg-slate-800" id="link-gallery">
                <span>🖼️</span> Gallery
            </button>
            <button onclick="showSection('stats')" class="sidebar-link w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition font-semibold hover:bg-slate-800" id="link-stats">
                <span>📈</span> Site Stats
            </button>
            <button onclick="showSection('testimonials')" class="sidebar-link w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition font-semibold hover:bg-slate-800" id="link-testimonials">
                <span>💬</span> Testimonials
            </button>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <a href="?logout=1" class="w-full block text-center py-2 text-xs text-red-500 hover:text-red-400 font-bold uppercase tracking-widest italic">Logout System</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-0 md:ml-64 flex-1 p-6 md:p-12">
        
        <!-- Header -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
            <div class="flex items-center gap-4 w-full md:w-auto">
                <button onclick="toggleSidebar()" class="md:hidden p-2 bg-slate-900 text-white rounded-lg shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
                <div>
                    <h2 id="sectionTitle" class="text-2xl md:text-3xl font-black text-slate-900 uppercase italic tracking-tighter">Dashboard</h2>
                    <p class="text-slate-500 font-medium text-[10px] md:text-sm mt-1">Real-time management for BlueStone Elite Sports.</p>
                </div>
            </div>
            <div id="actionBtnContainer" class="w-full md:w-auto flex justify-end"></div>
        </header>

        <!-- DASHBOARD SECTION -->
        <div id="section-dashboard" class="section-content space-y-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Sports Card -->
                <div onclick="showSection('sports')" class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 italic cursor-pointer group hover:shadow-2xl hover:shadow-orange-500/10 hover:-translate-y-2 transition-all duration-300 relative overflow-hidden text-slate-800">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-500/5 rounded-full group-hover:bg-orange-500/10 transition-colors"></div>
                    <div class="mb-6">
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                             <i class="fa-solid fa-trophy text-orange-600"></i> Total Sports
                        </p>
                    </div>
                    <div class="flex items-end justify-between">
                        <h3 class="text-5xl font-black leading-none" id="dash-sports-count">0</h3>
                        <span class="text-[10px] font-black uppercase text-orange-600 tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">View All →</span>
                    </div>
                </div>

                <!-- Leads Card -->
                <div onclick="showSection('leads')" class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 italic cursor-pointer group hover:shadow-2xl hover:shadow-blue-500/10 hover:-translate-y-2 transition-all duration-300 relative overflow-hidden text-slate-800">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/5 rounded-full group-hover:bg-blue-500/10 transition-colors"></div>
                    <div class="mb-6">
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                            <i class="fa-solid fa-envelope-open-text text-blue-600"></i> New Enquiries
                        </p>
                    </div>
                    <div class="flex items-end justify-between">
                        <h3 class="text-5xl font-black leading-none" id="dash-leads-count">0</h3>
                        <span class="text-[10px] font-black uppercase text-blue-600 tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">Review →</span>
                    </div>
                </div>

                <!-- Gallery Card -->
                <div onclick="showSection('gallery')" class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 italic cursor-pointer group hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-2 transition-all duration-300 relative overflow-hidden text-slate-800">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-500/5 rounded-full group-hover:bg-indigo-500/10 transition-colors"></div>
                    <div class="mb-6">
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                            <i class="fa-solid fa-images text-indigo-600"></i> Gallery Media
                        </p>
                    </div>
                    <div class="flex items-end justify-between">
                        <h3 class="text-5xl font-black leading-none" id="dash-gallery-count">0</h3>
                        <span class="text-[10px] font-black uppercase text-indigo-600 tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">Manage →</span>
                    </div>
                </div>

                <!-- Testimonials Card -->
                <div onclick="showSection('testimonials')" class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 italic cursor-pointer group hover:shadow-2xl hover:shadow-rose-500/10 hover:-translate-y-2 transition-all duration-300 relative overflow-hidden text-slate-800">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-500/5 rounded-full group-hover:bg-rose-500/10 transition-colors"></div>
                    <div class="mb-6">
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                            <i class="fa-solid fa-comment-dots text-rose-600"></i> Student Voice
                        </p>
                    </div>
                    <div class="flex items-end justify-between">
                        <h3 class="text-5xl font-black leading-none" id="dash-testimonials-count">0</h3>
                        <span class="text-[10px] font-black uppercase text-rose-600 tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">Edit →</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- SPORTS SECTION -->
        <div id="section-sports" class="section-content hidden space-y-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-x-auto">
                <table class="w-full text-left min-w-[800px]">
                    <thead class="bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                        <tr>
                            <th class="px-8 py-4">Program</th>
                            <th class="px-8 py-4">Status</th>
                            <th class="px-8 py-4">Type</th>
                            <th class="px-8 py-4">Popup</th>
                            <th class="px-8 py-4">Schedule</th>
                            <th class="px-8 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                            <tbody id="sportsTableBody" class="divide-y divide-slate-50 italic font-semibold">
                                <!-- Rows injected here -->
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination for Sports -->
                    <div id="pagination-sports" class="flex flex-col md:flex-row justify-between items-center gap-6 pt-6 px-4 bg-slate-50/50 pb-6 rounded-b-3xl border-t border-slate-100"></div>
                </div>
        <!-- LEADS SECTION -->
        <div id="section-leads" class="section-content hidden space-y-8">
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-x-auto">
                <table class="w-full text-left text-sm min-w-[900px]">
                    <thead class="bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                        <tr>
                            <th class="px-8 py-4">Candidate</th>
                            <th class="px-8 py-4">Program Interest</th>
                            <th class="px-8 py-4">Message</th>
                            <th class="px-8 py-4">Date</th>
                            <th class="px-8 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                            <tbody id="leadsTableBody" class="divide-y divide-slate-50 italic">
                                <!-- Rows injected here -->
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination for Leads -->
                    <div id="pagination-leads" class="flex flex-col md:flex-row justify-between items-center gap-6 pt-6 px-4 bg-slate-50/50 pb-6 rounded-b-[2rem] border-t border-slate-100"></div>
                </div>

        <!-- GALLERY SECTION -->
        <div id="section-gallery" class="section-content hidden space-y-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8" id="galleryGrid">
                <!-- Images injected here -->
            </div>
        </div>

        <!-- STATS SECTION -->
        <div id="section-stats" class="section-content hidden space-y-8 max-w-2xl">
            <div id="statsContainer" class="space-y-4">
                <!-- Stat inputs injected here -->
            </div>
        </div>

        <!-- TESTIMONIALS SECTION -->
        <div id="section-testimonials" class="section-content hidden space-y-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-x-auto">
                <table class="w-full text-left min-w-[800px]">
                    <thead class="bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                        <tr>
                            <th class="px-8 py-4">Source</th>
                            <th class="px-8 py-4">Visibility</th>
                            <th class="px-8 py-4">Feedback</th>
                            <th class="px-8 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="testimonialsTableBody" class="divide-y divide-slate-50 italic font-semibold text-sm">
                        <!-- Rows injected here -->
                    </tbody>
                </table>
            </div>
            <div id="pagination-testimonials" class="flex flex-col md:flex-row justify-between items-center gap-6 pt-6 px-4 bg-slate-50/50 pb-6 rounded-b-3xl border-t border-slate-100"></div>
        </div>

    </main>

    <!-- MODAL FOR ADD/EDIT SPORT -->
    <div id="sportModal" class="fixed inset-0 bg-slate-900/60 flex items-center justify-center hidden p-4 z-40">
        <div class="bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl p-12 overflow-y-auto max-h-[90vh]">
            <h3 id="modalTitle" class="text-2xl font-black mb-8 italic uppercase tracking-tighter">Add New Program</h3>
            <form id="sportForm" class="space-y-6">
                <input type="hidden" id="sportId">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-2 tracking-widest">Name</label>
                        <input type="text" id="sName" required class="w-full px-6 py-3 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-2 tracking-widest">Program Type</label>
                        <select id="sProgramType" required class="w-full px-6 py-3 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 outline-none">
                            <option value="Academy">Academy Program</option>
                            <option value="Summer Hub">Summer Hub</option>
                            <option value="Competition">Events</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 mb-2 tracking-widest">Skill Category (e.g. Beginner)</label>
                    <input type="text" id="sCategory" required class="w-full px-6 py-3 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-2 tracking-widest">Age Category</label>
                        <input type="text" id="sAge" placeholder="e.g. 6 - 18 Years" class="w-full px-6 py-3 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-2 tracking-widest">Training Timing</label>
                        <input type="text" id="sTiming" placeholder="e.g. 6 AM - 9 AM" class="w-full px-6 py-3 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 mb-2 tracking-widest">Detailed Schedule (Optional)</label>
                    <textarea id="sSchedule" rows="2" placeholder="e.g. Mon-Fri sessions, Sat specialized" class="w-full px-6 py-3 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 mb-2 tracking-widest">Description</label>
                    <textarea id="sDesc" rows="3" class="w-full px-6 py-3 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 mb-2 tracking-widest">Sport Image (Auto-Crop Available)</label>
                    <input type="file" id="sImage" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl">
                        <label class="toggle-switch">
                            <input type="checkbox" id="sStatus" checked>
                            <span class="slider"></span>
                        </label>
                        <span class="text-xs font-bold uppercase text-slate-400 tracking-widest">Program Visibility (Active)</span>
                    </div>
                    <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl">
                        <label class="toggle-switch">
                            <input type="checkbox" id="sIsBrochure">
                            <span class="slider"></span>
                        </label>
                        <span class="text-xs font-bold uppercase text-slate-400 tracking-widest">Active Brochure Popup</span>
                    </div>
                </div>
                <div id="imagePreviewContainer" class="hidden mt-4">
                     <img id="imagePreview" src="" class="max-h-48 rounded-2xl border">
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="bg-orange-600 text-white px-8 py-3 rounded-2xl font-black uppercase text-xs tracking-widest shadow-lg shadow-orange-500/20">Save Program</button>
                    <button type="button" onclick="closeModal('sportModal')" class="bg-slate-100 text-slate-500 px-8 py-3 rounded-2xl font-black uppercase text-xs tracking-widest">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL FOR ADD/EDIT TESTIMONIAL -->
    <div id="testimonialModal" class="fixed inset-0 bg-slate-900/60 flex items-center justify-center hidden p-4 z-40">
        <div class="bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl p-12 overflow-y-auto max-h-[90vh]">
            <h3 id="tModalTitle" class="text-2xl font-black mb-8 italic uppercase tracking-tighter">Add Student Feedback</h3>
            <form id="testimonialForm" class="space-y-6">
                <input type="hidden" id="tId">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-2 tracking-widest">Name</label>
                        <input type="text" id="tName" required class="w-full px-6 py-3 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-2 tracking-widest">Role/Sub-title</label>
                        <input type="text" id="tRole" placeholder="e.g. Cricket Student" class="w-full px-6 py-3 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 mb-2 tracking-widest">Feedback Content</label>
                    <textarea id="tContent" required rows="4" class="w-full px-6 py-3 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Their success story..."></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 mb-2 tracking-widest">Profile Image (Square Crop)</label>
                    <input type="file" id="tImage" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                </div>
                <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl">
                    <label class="toggle-switch">
                        <input type="checkbox" id="tStatus" checked>
                        <span class="slider"></span>
                    </label>
                    <span class="text-xs font-bold uppercase text-slate-400 tracking-widest">Active visibility on site</span>
                </div>
                <div id="tImagePreviewContainer" class="hidden mt-4">
                     <img id="tImagePreview" src="" class="w-24 h-24 rounded-full border object-cover">
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="bg-orange-600 text-white px-8 py-3 rounded-2xl font-black uppercase text-xs tracking-widest shadow-lg shadow-orange-500/20">Save Feedback</button>
                    <button type="button" onclick="closeModal('testimonialModal')" class="bg-slate-100 text-slate-500 px-8 py-3 rounded-2xl font-black uppercase text-xs tracking-widest">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- CROPPER MODAL -->
    <div id="cropModal" class="fixed inset-0 bg-slate-900 flex items-center justify-center hidden z-[100] p-8">
        <div class="bg-white w-full max-w-4xl p-8 rounded-[3rem] shadow-2xl relative">
            <h3 class="text-xl font-black mb-6 italic uppercase tracking-tighter">Crop Image Structure</h3>
            <div class="max-h-[60vh] overflow-hidden bg-slate-100 rounded-2xl">
                <img id="cropImageTarget" src="" class="max-w-full">
            </div>
            <div class="flex gap-4 mt-8">
                <button id="saveCropBtn" class="bg-orange-600 text-white px-8 py-3 rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl">Apply Crop</button>
                <button onclick="closeModal('cropModal')" class="bg-slate-100 text-slate-500 px-8 py-3 rounded-2xl font-black uppercase text-xs tracking-widest">Discard</button>
            </div>
        </div>
    </div>

    <script>
        // Auto-detect environment for API
        const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
        const API_BASE = isLocal 
            ? 'http://localhost:5009/api' 
            : 'https://bluestoneinternationalpreschool.com/bes_web_api/api';
            
        let cropper = null;

        function showToast(text, type = 'success') {
            Toastify({
                text: text,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: type === 'success' ? "#ea580c" : "#ef4444",
                    borderRadius: "12px",
                    fontWeight: "bold",
                    textTransform: "uppercase",
                    fontSize: "10px",
                    boxShadow: "0 10px 15px -3px rgba(0, 0, 0, 0.1)"
                }
            }).showToast();
        }
        let currentTarget = null; // For cropping
        let currentFile = null;   // To store cropped blob

        // PAGINATION STATE
        const state = {
            sports: { currentPage: 1, pageSize: 10, total: 0, allData: [] },
            leads: { currentPage: 1, pageSize: 10, total: 0, allData: [] },
            testimonials: { currentPage: 1, pageSize: 10, total: 0, allData: [] }
        };

        // SECTIONS ROUTING
        function showSection(id) {
            if(window.innerWidth < 768) toggleSidebar(); // Close sidebar on mobile after selection
            document.querySelectorAll('.section-content').forEach(s => s.classList.add('hidden'));
            document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
            document.getElementById(`section-${id}`).classList.remove('hidden');
            document.getElementById(`link-${id}`).classList.add('active');
            document.getElementById('sectionTitle').innerText = id.charAt(0).toUpperCase() + id.slice(1);
            
            // Context Button
            const btnContainer = document.getElementById('actionBtnContainer');
            if(id === 'sports') btnContainer.innerHTML = `<button onclick="openSportModal()" class="bg-orange-600 text-white px-6 py-2 rounded-xl font-bold text-xs uppercase tracking-widest">+ Add New</button>`;
            else if(id === 'testimonials') btnContainer.innerHTML = `<button onclick="openTestimonialModal()" class="bg-orange-600 text-white px-6 py-2 rounded-xl font-bold text-xs uppercase tracking-widest">+ Add New</button>`;
            else if(id === 'gallery') btnContainer.innerHTML = `<label class="bg-orange-600 text-white px-6 py-2 rounded-xl font-bold text-xs uppercase tracking-widest cursor-pointer hover:bg-orange-700 transition"><input type="file" onchange="uploadToGallery(this)" class="hidden"> Upload Media</label>`;
            else btnContainer.innerHTML = '';

            loadData(id);
        }

        async function loadData(section) {
            if(section === 'sports') {
                const res = await fetch(`${API_BASE}/sports`);
                const data = await res.json();
                state.sports.allData = data;
                state.sports.currentPage = 1;
                document.getElementById('dash-sports-count').innerText = data.length;
                renderSports();
            } else if(section === 'gallery') {
                const res = await fetch(`${API_BASE}/gallery`);
                const data = await res.json();
                renderGallery(data);
            } else if(section === 'stats') {
                const res = await fetch(`${API_BASE}/stats`);
                const data = await res.json();
                renderStats(data);
            } else if(section === 'testimonials') {
                const res = await fetch(`${API_BASE}/testimonials`);
                const data = await res.json();
                state.testimonials.allData = data;
                state.testimonials.currentPage = 1;
                renderTestimonials();
            } else if(section === 'leads') {
                const res = await fetch(`${API_BASE}/contact`);
                const data = await res.json();
                state.leads.allData = data;
                state.leads.currentPage = 1;
                document.getElementById('dash-leads-count').innerText = data.length;
                renderLeads();
            } else if(section === 'dashboard') {
                // Fetch stats for cards
                const resS = await fetch(`${API_BASE}/sports`);
                const sports = await resS.json();
                document.getElementById('dash-sports-count').innerText = sports.length;
                
                const resL = await fetch(`${API_BASE}/contact`);
                const leads = await resL.json();
                document.getElementById('dash-leads-count').innerText = leads.length;

                const resG = await fetch(`${API_BASE}/gallery`);
                const gallery = await resG.json();
                document.getElementById('dash-gallery-count').innerText = gallery.length;

                const resT = await fetch(`${API_BASE}/testimonials`);
                const testimonials = await resT.json();
                document.getElementById('dash-testimonials-count').innerText = testimonials.length;
            }
        }

        // SPORTS LOGIC
        function renderSports() {
            const body = document.getElementById('sportsTableBody');
            const data = state.sports.allData;
            const start = (state.sports.currentPage - 1) * state.sports.pageSize;
            const slice = data.slice(start, start + state.sports.pageSize);

            body.innerHTML = slice.map(s => `
                <tr class="${(s.status || 'Active') === 'Inactive' ? 'opacity-50' : ''}">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <img src="${s.image_path}" class="w-10 h-10 rounded-lg object-cover bg-slate-100 flex-shrink-0">
                            <div>
                                <div class="font-black text-slate-800">${s.name}</div>
                                <div class="text-[10px] text-slate-400 truncate max-w-[150px] uppercase font-bold tracking-widest">${s.description}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <label class="toggle-switch">
                            <input type="checkbox" onchange="toggleStatus(${s.id}, this.checked)" ${ (s.status || 'Active') === 'Active' ? 'checked' : '' }>
                            <span class="slider"></span>
                        </label>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-slate-100 text-[10px] font-black uppercase tracking-widest rounded-full text-slate-500">${s.program_type || 'Academy'}</span>
                    </td>
                    <td class="px-8 py-6">
                        <label class="toggle-switch">
                            <input type="checkbox" onchange="toggleBrochure(${s.id}, this.checked)" ${ s.is_brochure == 1 ? 'checked' : '' }>
                            <span class="slider"></span>
                        </label>
                    </td>
                    <td class="px-8 py-6">
                        <div class="text-[10px] text-slate-500 font-bold italic line-clamp-1 max-w-[150px]">${s.training_schedule || 'Not Set'}</div>
                    </td>
                    <td class="px-8 py-6 text-right space-x-2">
                        <button onclick='openSportEdit(${s.id})' class="text-blue-500 hover:text-blue-700 text-xs font-black uppercase tracking-widest">Edit</button>
                        <button onclick="deleteSport(${s.id})" class="text-red-500 hover:text-red-700 text-xs font-black uppercase tracking-widest">Delete</button>
                    </td>
                </tr>
            `).join('');

            renderPagination('sports');
        }

        async function toggleStatus(id, isActive) {
            console.log('Toggling Status:', id, isActive);
            const status = isActive ? 'Active' : 'Inactive';
            try {
                const res = await fetch(`${API_BASE}/sports/${id}/status`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ status })
                });
                if (!res.ok) throw new Error('Toggle Failed');
                console.log('Status Updated Successfully');
                // Update local state without full reload to prevent flicker/revert
                const sport = state.sports.allData.find(s => s.id == id);
                if (sport) sport.status = status;
                renderSports(); 
            } catch (e) {
                console.error(e);
                showToast('Connection Error', 'error');
                loadData('sports'); // Revert UI
            }
        }

        async function toggleBrochure(id, isBrochure) {
            console.log('Toggling Brochure:', id, isBrochure);
            try {
                const res = await fetch(`${API_BASE}/sports/${id}/brochure`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ is_brochure: isBrochure })
                });
                if (!res.ok) throw new Error('Toggle Failed');
                console.log('Brochure Updated Successfully');
                const sport = state.sports.allData.find(s => s.id == id);
                if (sport) sport.is_brochure = isBrochure ? 1 : 0;
                renderSports();
            } catch (e) {
                console.error(e);
                showToast('Connection Error', 'error');
                loadData('sports');
            }
        }

        function openSportModal() {
            document.getElementById('sportForm').reset();
            document.getElementById('sportId').value = '';
            document.getElementById('sIsBrochure').checked = false;
            document.getElementById('sStatus').checked = true;
            document.getElementById('modalTitle').innerText = 'Add New Program';
            document.getElementById('sportModal').classList.remove('hidden');
        }

        function openSportEdit(id) {
            const s = state.sports.allData.find(item => item.id == id);
            if (!s) return;
            
            document.getElementById('sportId').value = s.id;
            document.getElementById('sName').value = s.name;
            document.getElementById('sProgramType').value = s.program_type || 'Academy';
            document.getElementById('sCategory').value = s.category || '';
            document.getElementById('sAge').value = s.age_category || '';
            document.getElementById('sTiming').value = ''; 
            document.getElementById('sSchedule').value = s.training_schedule || '';
            document.getElementById('sDesc').value = s.description || '';
            document.getElementById('sIsBrochure').checked = s.is_brochure == 1;
            document.getElementById('sStatus').checked = (s.status || 'Active') === 'Active';
            document.getElementById('modalTitle').innerText = 'Edit Program';
            document.getElementById('sportModal').classList.remove('hidden');
        }

        // CROPPER LOGIC
        document.getElementById('sImage').onchange = function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('cropImageTarget').src = e.target.result;
                    document.getElementById('cropModal').classList.remove('hidden');
                    if(cropper) cropper.destroy();
                    cropper = new Cropper(document.getElementById('cropImageTarget'), {
                        aspectRatio: 4 / 5, // Best for Sports cards
                        viewMode: 2
                    });
                };
                reader.readAsDataURL(this.files[0]);
            }
        };

        document.getElementById('saveCropBtn').onclick = function() {
            // Get Base64 instead of Blob
            const base64 = cropper.getCroppedCanvas().toDataURL('image/jpeg', 0.8);
            currentFile = base64; // Store the string
            document.getElementById('imagePreview').src = base64;
            document.getElementById('imagePreviewContainer').classList.remove('hidden');
            document.getElementById('cropModal').classList.add('hidden');
        };

        document.getElementById('sportForm').onsubmit = async (e) => {
            e.preventDefault();
            const id = document.getElementById('sportId').value;
            
            const payload = {
                name: document.getElementById('sName').value,
                program_type: document.getElementById('sProgramType').value,
                category: document.getElementById('sCategory').value,
                description: document.getElementById('sDesc').value,
                age_category: document.getElementById('sAge').value,
                training_schedule: document.getElementById('sSchedule').value || document.getElementById('sTiming').value,
                details_url: 'sports.php',
                image: currentFile, // This is the Base64 string
                is_brochure: document.getElementById('sIsBrochure').checked,
                status: document.getElementById('sStatus').checked ? 'Active' : 'Inactive'
            };

            const method = id ? 'PUT' : 'POST';
            const url = id ? `${API_BASE}/sports/${id}` : `${API_BASE}/sports`;

            try {
                const res = await fetch(url, { 
                    method, 
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload) 
                });
                if(res.ok) {
                    showToast('Saved to Database!');
                    closeModal('sportModal');
                    showSection('sports');
                    currentFile = null;
                }
            } catch(e) { showToast('Save Failed', 'error'); }
        };

        // GALLERY LOGIC (Base64)
        async function uploadToGallery(input) {
            if(input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = async (e) => {
                    const base64 = e.target.result;
                    await fetch(`${API_BASE}/gallery`, { 
                        method: 'POST', 
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ image: base64 }) 
                    });
                    showSection('gallery');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function renderGallery(data) {
            const grid = document.getElementById('galleryGrid');
            grid.innerHTML = data.map(i => `
                <div class="relative group rounded-3xl overflow-hidden shadow-sm h-64">
                    <img src="${i.image_path}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-red-600/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                        <button onclick="deleteGallery(${i.id})" class="bg-white text-red-600 px-4 py-2 rounded-xl font-bold text-xs uppercase tracking-widest">Delete</button>
                    </div>
                </div>
            `).join('');
        }

        // LEADS LOGIC
        function renderLeads() {
            const body = document.getElementById('leadsTableBody');
            const data = state.leads.allData;
            
            if(data.length === 0) {
                body.innerHTML = `<tr><td colspan="5" class="px-8 py-12 text-center text-slate-400 font-bold uppercase tracking-widest text-xs italic">No Enquiries Found Yet</td></tr>`;
                return;
            }

            const start = (state.leads.currentPage - 1) * state.leads.pageSize;
            const slice = data.slice(start, start + state.leads.pageSize);

            body.innerHTML = slice.map(l => {
                const date = new Date(l.created_at).toLocaleDateString();
                return `
                <tr>
                    <td class="px-8 py-6">
                        <div class="font-black text-slate-800 tracking-tighter uppercase italic">${l.full_name}</div>
                        <div class="text-[10px] text-blue-500 font-bold tracking-widest uppercase italic">${l.email} • ${l.phone}</div>
                        <div class="text-[10px] text-slate-400 font-bold italic">Age: ${l.age}</div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="bg-orange-50 text-orange-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest italic border border-orange-100">
                            ${l.program}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="text-xs text-slate-500 line-clamp-2 max-w-xs font-medium italic">${l.message || 'No specific objective provided.'}</div>
                    </td>
                    <td class="px-8 py-6 text-xs text-slate-400 font-bold italic uppercase tracking-tighter">${date}</td>
                    <td class="px-8 py-6 text-right">
                        <button onclick="deleteLead(${l.id})" class="text-red-500 hover:text-red-700 text-xs font-black uppercase tracking-widest italic transition-colors">Delete</button>
                    </td>
                </tr>
            `}).join('');

            renderPagination('leads');
        }

        // PAGINATION CORE LOGIC
        function renderPagination(section) {
            const container = document.getElementById(`pagination-${section}`);
            const currentPage = state[section].currentPage;
            const pageSize = state[section].pageSize;
            const total = state[section].allData.length;
            const totalPages = Math.ceil(total / pageSize);

            if (total === 0) {
                container.innerHTML = '';
                return;
            }

            let pagesHtml = '';
            // Show up to 5 page buttons or dots
            for (let i = 1; i <= totalPages; i++) {
                if (totalPages > 5 && i > 3 && i < totalPages) {
                    if (i === 4) pagesHtml += '<span class="px-2">...</span>';
                    continue;
                }
                pagesHtml += `
                    <button onclick="changePage('${section}', ${i})" class="w-10 h-10 rounded-xl font-bold text-sm transition-all ${i === currentPage ? 'bg-orange-600 text-white shadow-lg' : 'bg-white text-slate-500 hover:bg-slate-100'}">
                        ${i}
                    </button>
                `;
            }

            container.innerHTML = `
                <div class="text-slate-400 font-black text-xs uppercase italic tracking-widest">
                    Page <span class="text-orange-600">${currentPage}</span> of ${totalPages || 1}
                </div>
                
                <div class="flex items-center gap-2">
                    <button onclick="changePage('${section}', ${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''} class="w-10 h-10 rounded-xl bg-white text-slate-500 flex items-center justify-center disabled:opacity-30 hover:bg-slate-100 transition shadow-sm border border-slate-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    
                    ${pagesHtml}

                    <button onclick="changePage('${section}', ${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''} class="w-10 h-10 rounded-xl bg-white text-slate-500 flex items-center justify-center disabled:opacity-30 hover:bg-slate-100 transition shadow-sm border border-slate-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-slate-400 font-black text-[10px] uppercase tracking-widest italic">Show</span>
                    <select onchange="changePageSize('${section}', this.value)" class="bg-white px-4 py-2 rounded-xl text-xs font-bold text-slate-700 border border-slate-100 outline-none focus:ring-2 focus:ring-orange-500 italic shadow-sm">
                        <option value="10" ${pageSize == 10 ? 'selected' : ''}>10</option>
                        <option value="25" ${pageSize == 25 ? 'selected' : ''}>25</option>
                        <option value="50" ${pageSize == 50 ? 'selected' : ''}>50</option>
                        <option value="100" ${pageSize == 100 ? 'selected' : ''}>100</option>
                    </select>
                </div>
            `;
        }

        // TESTIMONIALS LOGIC
        function renderTestimonials() {
            const body = document.getElementById('testimonialsTableBody');
            const data = state.testimonials.allData;
            const start = (state.testimonials.currentPage - 1) * state.testimonials.pageSize;
            const slice = data.slice(start, start + state.testimonials.pageSize);

            body.innerHTML = slice.map(t => `
                <tr class="${(t.status || 'Active') === 'Inactive' ? 'opacity-50' : ''}">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <img src="${t.image_path || 'assets/logo.png'}" class="w-10 h-10 rounded-full object-cover bg-slate-100 flex-shrink-0">
                            <div>
                                <div class="font-black text-slate-800 uppercase tracking-tight">${t.name}</div>
                                <div class="text-[10px] text-slate-400 uppercase font-black tracking-widest">${t.role}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <label class="toggle-switch">
                            <input type="checkbox" onchange="toggleTStatus(${t.id}, this.checked)" ${ (t.status || 'Active') === 'Active' ? 'checked' : '' }>
                            <span class="slider"></span>
                        </label>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-[10px] text-slate-500 font-bold italic line-clamp-2 max-w-xs">${t.content}</p>
                    </td>
                    <td class="px-8 py-6 text-right space-x-4">
                        <button onclick='openTestimonialEdit(${t.id})' class="text-blue-500 hover:text-blue-700 text-xs font-black uppercase tracking-widest transition-colors">Edit</button>
                        <button onclick="deleteTestimonial(${t.id})" class="text-red-500 hover:text-red-700 text-xs font-black uppercase tracking-widest transition-colors">Delete</button>
                    </td>
                </tr>
            `).join('');

            renderPagination('testimonials');
        }

        async function toggleTStatus(id, isActive) {
            const status = isActive ? 'Active' : 'Inactive';
            try {
                const res = await fetch(`${API_BASE}/testimonials/${id}/status`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ status })
                });
                if (!res.ok) throw new Error('Toggle Failed');
                const testimonial = state.testimonials.allData.find(t => t.id == id);
                if (testimonial) testimonial.status = status;
                renderTestimonials(); 
            } catch (e) {
                showToast('Connection Error', 'error');
                loadData('testimonials');
            }
        }

        function openTestimonialModal() {
            document.getElementById('testimonialForm').reset();
            document.getElementById('tId').value = '';
            document.getElementById('tStatus').checked = true;
            document.getElementById('tImagePreviewContainer').classList.add('hidden');
            document.getElementById('tModalTitle').innerText = 'Add Student Feedback';
            document.getElementById('testimonialModal').classList.remove('hidden');
        }

        function openTestimonialEdit(id) {
            const t = state.testimonials.allData.find(item => item.id == id);
            if (!t) return;
            
            document.getElementById('tId').value = t.id;
            document.getElementById('tName').value = t.name;
            document.getElementById('tRole').value = t.role || '';
            document.getElementById('tContent').value = t.content;
            document.getElementById('tStatus').checked = (t.status || 'Active') === 'Active';
            
            if(t.image_path) {
                document.getElementById('tImagePreview').src = t.image_path;
                document.getElementById('tImagePreviewContainer').classList.remove('hidden');
            } else {
                document.getElementById('tImagePreviewContainer').classList.add('hidden');
            }

            document.getElementById('tModalTitle').innerText = 'Edit Student Feedback';
            document.getElementById('testimonialModal').classList.remove('hidden');
        }

        // Testimonial Image Logic (Simpler than Sports for now, can be upgraded to cropper if needed)
        document.getElementById('tImage').onchange = function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    const base64 = e.target.result;
                    currentFile = base64;
                    document.getElementById('tImagePreview').src = base64;
                    document.getElementById('tImagePreviewContainer').classList.remove('hidden');
                };
                reader.readAsDataURL(this.files[0]);
            }
        };

        document.getElementById('testimonialForm').onsubmit = async (e) => {
            e.preventDefault();
            const id = document.getElementById('tId').value;
            
            const payload = {
                name: document.getElementById('tName').value,
                role: document.getElementById('tRole').value,
                content: document.getElementById('tContent').value,
                image: currentFile,
                status: document.getElementById('tStatus').checked ? 'Active' : 'Inactive'
            };

            const method = id ? 'PUT' : 'POST';
            const url = id ? `${API_BASE}/testimonials/${id}` : `${API_BASE}/testimonials`;

            try {
                const res = await fetch(url, { 
                    method, 
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload) 
                });
                if(res.ok) {
                    showToast('Student Feedback Saved!');
                    closeModal('testimonialModal');
                    showSection('testimonials');
                    currentFile = null;
                }
            } catch(e) { showToast('Save Failed', 'error'); }
        };

        async function deleteTestimonial(id) {
            if(confirm('Delete this feedback?')) {
                await fetch(`${API_BASE}/testimonials/${id}`, { method: 'DELETE' });
                showSection('testimonials');
            }
        }

        // COMMON FUNCTIONS
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
        
        async function deleteSport(id) {
            if(confirm('Delete Program?')) {
                await fetch(`${API_BASE}/sports/${id}`, { method: 'DELETE' });
                showSection('sports');
            }
        }

        async function deleteGallery(id) {
            if(confirm('Delete Image?')) {
                await fetch(`${API_BASE}/gallery/${id}`, { method: 'DELETE' });
                showSection('gallery');
            }
        }

        // STATS LOGIC
        function renderStats(data) {
            const cont = document.getElementById('statsContainer');
            cont.innerHTML = data.map(s => `
                <div class="bg-white p-6 rounded-2xl border border-slate-100 italic space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest">${s.label}</label>
                    <div class="flex gap-4">
                        <input type="text" id="stat-${s.id}" value="${s.value}" class="flex-1 px-4 py-2 rounded-xl bg-slate-50 border-none outline-none font-black text-orange-600 ring-orange-500 focus:ring-1">
                        <button onclick="updateStat(${s.id}, '${s.label}')" class="bg-slate-900 text-white px-6 py-2 rounded-xl font-bold text-xs uppercase tracking-widest">Save</button>
                    </div>
                </div>
            `).join('');
        }

        async function updateStat(id, label) {
            const value = document.getElementById(`stat-${id}`).value;
            await fetch(`${API_BASE}/stats/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ label, value })
            });
            showToast('Stat Updated');
            showSection('stats');
        }

        // INIT
        showSection('dashboard');

    </script>
</body>
</html>
