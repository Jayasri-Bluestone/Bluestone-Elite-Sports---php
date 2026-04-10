<?php
session_start();
// Simple Auth
if (isset($_POST['password']) && $_POST['password'] === 'elite123') {
    $_SESSION['admin'] = true;
}
if (!isset($_SESSION['admin'])) {
    echo '<form method="POST" style="text-align:center; margin-top:20vh; font-family:sans-serif;">
            <h2 style="color:#ea580c">ELITE ADMIN PORTAL</h2>
            <input type="password" name="password" placeholder="Passphrase" style="padding:12px; border:1px solid #ddd; border-radius:8px;">
            <button type="submit" style="padding:12px 24px; background:#ea580c; color:white; border:none; border-radius:8px; cursor:pointer;">Enter Dashboard</button>
          </form>';
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
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .sidebar-link.active { background: #ea580c; color: white; }
        #cropModal { z-index: 100; }
        .cropper-view-box, .cropper-face { border-radius: 20px; }
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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 italic">
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Total Sports</p>
                    <h3 class="text-4xl font-black text-orange-600" id="dash-sports-count">0</h3>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 italic">
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Recent Leads</p>
                    <h3 class="text-4xl font-black text-blue-600" id="dash-leads-count">0</h3>
                </div>
                <!-- More dash cards can be added -->
            </div>
        </div>

        <!-- SPORTS SECTION -->
        <div id="section-sports" class="section-content hidden space-y-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-x-auto">
                <table class="w-full text-left min-w-[800px]">
                    <thead class="bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                        <tr>
                            <th class="px-8 py-4">Program</th>
                            <th class="px-8 py-4">Type</th>
                            <th class="px-8 py-4">Category</th>
                            <th class="px-8 py-4">Age Group</th>
                            <th class="px-8 py-4">Schedule/Timing</th>
                            <th class="px-8 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sportsTableBody" class="divide-y divide-slate-50 italic font-semibold">
                        <!-- Rows injected here -->
                    </tbody>
                </table>
            </div>
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
                            <option value="Competition">Competition</option>
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
        const API_BASE = 'http://localhost:5004/api';
        let cropper = null;
        let currentTarget = null; // For cropping
        let currentFile = null;   // To store cropped blob

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
            else if(id === 'gallery') btnContainer.innerHTML = `<label class="bg-orange-600 text-white px-6 py-2 rounded-xl font-bold text-xs uppercase tracking-widest cursor-pointer hover:bg-orange-700 transition"><input type="file" onchange="uploadToGallery(this)" class="hidden"> Upload Media</label>`;
            else btnContainer.innerHTML = '';

            loadData(id);
        }

        async function loadData(section) {
            if(section === 'sports') {
                const res = await fetch(`${API_BASE}/sports`);
                const data = await res.json();
                document.getElementById('dash-sports-count').innerText = data.length;
                renderSports(data);
            } else if(section === 'gallery') {
                const res = await fetch(`${API_BASE}/gallery`);
                const data = await res.json();
                renderGallery(data);
            } else if(section === 'stats') {
                const res = await fetch(`${API_BASE}/stats`);
                const data = await res.json();
                renderStats(data);
            } else if(section === 'leads') {
                const res = await fetch(`${API_BASE}/contact`);
                const data = await res.json();
                document.getElementById('dash-leads-count').innerText = data.length;
                renderLeads(data);
            } else if(section === 'dashboard') {
                // Fetch stats for cards
                const resS = await fetch(`${API_BASE}/sports`);
                const sports = await resS.json();
                document.getElementById('dash-sports-count').innerText = sports.length;
                
                const resL = await fetch(`${API_BASE}/contact`);
                const leads = await resL.json();
                document.getElementById('dash-leads-count').innerText = leads.length;
            }
        }

        // SPORTS LOGIC
        function renderSports(data) {
            const body = document.getElementById('sportsTableBody');
            body.innerHTML = data.map(s => `
                <tr>
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
                        <span class="px-3 py-1 bg-slate-100 text-[10px] font-black uppercase tracking-widest rounded-full text-slate-500">${s.program_type || 'Academy'}</span>
                    </td>
                    <td class="px-8 py-6 text-[10px] uppercase text-slate-500 font-bold tracking-widest">${s.category}</td>
                    <td class="px-8 py-6 text-[10px] uppercase text-orange-600 font-black tracking-widest">${s.age_category || 'All Ages'}</td>
                    <td class="px-8 py-6">
                        <div class="text-[10px] text-slate-500 font-bold italic line-clamp-1 max-w-[150px]">${s.training_schedule || 'Not Set'}</div>
                    </td>
                    <td class="px-8 py-6 text-right space-x-2">
                        <button onclick='openSportEdit(${JSON.stringify(s)})' class="text-blue-500 hover:text-blue-700 text-xs font-black uppercase tracking-widest">Edit</button>
                        <button onclick="deleteSport(${s.id})" class="text-red-500 hover:text-red-700 text-xs font-black uppercase tracking-widest">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        function openSportModal() {
            document.getElementById('sportForm').reset();
            document.getElementById('sportId').value = '';
            document.getElementById('modalTitle').innerText = 'Add New Program';
            document.getElementById('sportModal').classList.remove('hidden');
        }

        function openSportEdit(s) {
            document.getElementById('sportId').value = s.id;
            document.getElementById('sName').value = s.name;
            document.getElementById('sProgramType').value = s.program_type || 'Academy';
            document.getElementById('sCategory').value = s.category;
            document.getElementById('sAge').value = s.age_category || '';
            document.getElementById('sTiming').value = ''; 
            document.getElementById('sSchedule').value = s.training_schedule || '';
            document.getElementById('sDesc').value = s.description;
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
                image: currentFile // This is the Base64 string
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
                    alert('Saved to Database!');
                    closeModal('sportModal');
                    showSection('sports');
                    currentFile = null;
                }
            } catch(e) { alert('Save Failed'); }
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
        function renderLeads(data) {
            const body = document.getElementById('leadsTableBody');
            if(data.length === 0) {
                body.innerHTML = `<tr><td colspan="5" class="px-8 py-12 text-center text-slate-400 font-bold uppercase tracking-widest text-xs italic">No Enquiries Found Yet</td></tr>`;
                return;
            }
            body.innerHTML = data.map(l => {
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
        }

        async function deleteLead(id) {
            if(confirm('Delete Lead Record?')) {
                await fetch(`${API_BASE}/contact/${id}`, { method: 'DELETE' });
                showSection('leads');
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
            alert('Stat Updated');
            showSection('stats');
        }

        // INIT
        showSection('dashboard');

    </script>
</body>
</html>
