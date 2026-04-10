require('dotenv').config();
const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');
const nodemailer = require('nodemailer');
const jwt = require('jsonwebtoken');
const bcrypt = require('bcryptjs');
const multer = require('multer');
const path = require('path');
const fs = require('fs');

const app = express();
app.use(cors());
app.use(express.json({ limit: '50mb' }));
app.use(express.urlencoded({ limit: '50mb', extended: true }));

// Auto-create uploads directory if missing (kept for backward compatibility/other files)
const uploadDir = path.join(__dirname, 'uploads');
if (!fs.existsSync(uploadDir)) {
    fs.mkdirSync(uploadDir, { recursive: true });
}
app.use('/uploads', express.static(uploadDir));

// Remote MySQL Connection Pool
const pool = mysql.createPool({
    host: 'auth-db1278.hstgr.io',
    user: 'u287260207_elitesports',
    password: 'merge*YOGA3',
    database: 'u287260207_elitesports_db',
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0,
    ssl: { rejectUnauthorized: false }
});

const db = pool.promise();

// Migration: Ensure table schema is up to date
(async () => {
    try {
        await db.query('ALTER TABLE sports MODIFY image_path LONGTEXT');
        await db.query('ALTER TABLE gallery MODIFY image_path LONGTEXT');
        
        // Add new columns if they don't exist
        const [columns] = await db.query('SHOW COLUMNS FROM sports');
        const columnNames = columns.map(c => c.Field);
        
        if (!columnNames.includes('age_category')) {
            await db.query('ALTER TABLE sports ADD COLUMN age_category VARCHAR(100) DEFAULT "All Ages"');
        }
        if (!columnNames.includes('training_schedule')) {
            await db.query('ALTER TABLE sports ADD COLUMN training_schedule TEXT');
        }
        if (!columnNames.includes('program_type')) {
            await db.query('ALTER TABLE sports ADD COLUMN program_type VARCHAR(50) DEFAULT "Academy"');
        }
        
        console.log('Database schema migrated for Base64 and Enhanced Details support.');
    } catch (e) {
        console.log('Migration status:', e.message);
    }
})();

// --- Multer (Kept only for general use, not for Base64) ---
const storage = multer.diskStorage({
    destination: (req, file, cb) => cb(null, 'uploads/'),
    filename: (req, file, cb) => cb(null, Date.now() + path.extname(file.originalname)),
});
const upload = multer({ storage });

// --- API ROUTES ---

// 1. Get All Sports
app.get('/api/sports', async (req, res) => {
    try {
        const [rows] = await db.query('SELECT * FROM sports ORDER BY category');
        res.json(rows);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// 1.1 Get Single Sport by ID
app.get('/api/sports/:id', async (req, res) => {
    try {
        const [rows] = await db.query('SELECT * FROM sports WHERE id = ?', [req.params.id]);
        if (rows.length === 0) {
            return res.status(404).json({ error: 'Sport not found' });
        }
        res.json(rows[0]);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// 2. Get Gallery
app.get('/api/gallery', async (req, res) => {
    try {
        const [rows] = await db.query('SELECT * FROM gallery');
        res.json(rows);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// 3. Get Stats
app.get('/api/stats', async (req, res) => {
    try {
        const [rows] = await db.query('SELECT * FROM stats');
        res.json(rows);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// 4. Post Contact Submission
app.post('/api/contact', async (req, res) => {
    const { fullName, age, email, phone, program, message } = req.body;
    try {
        const sql = `INSERT INTO contact_submissions 
                    (full_name, age, email, phone, program, message) 
                    VALUES (?, ?, ?, ?, ?, ?)`;
        const [result] = await db.query(sql, [fullName, age, email, phone, program, message]);
        res.json({ success: true, id: result.insertId });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// 4.1 Get All Contact Submissions
app.get('/api/contact', async (req, res) => {
    try {
        const [rows] = await db.query('SELECT * FROM contact_submissions ORDER BY created_at DESC');
        res.json(rows);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// 4.2 Delete Contact Submission
app.delete('/api/contact/:id', async (req, res) => {
    try {
        await db.query('DELETE FROM contact_submissions WHERE id = ?', [req.params.id]);
        res.json({ success: true });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// --- BASE64 ADMIN API ---

// Create Sport (Accepts Base64 + Enhanced Fields)
app.post('/api/sports', async (req, res) => {
    const { name, category, description, details_url, image, age_category, training_schedule, program_type } = req.body;
    try {
        const sql = `INSERT INTO sports (name, category, description, image_path, details_url, age_category, training_schedule, program_type) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)`;
        const [result] = await db.query(sql, [name, category, description, image, details_url, age_category, training_schedule, program_type || 'Academy']);
        res.json({ success: true, id: result.insertId });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// Update Sport (Accepts Base64 + Enhanced Fields)
app.put('/api/sports/:id', async (req, res) => {
    const { name, category, description, details_url, image, age_category, training_schedule, program_type } = req.body;
    let sql = `UPDATE sports SET name = ?, category = ?, description = ?, details_url = ?, age_category = ?, training_schedule = ?, program_type = ?`;
    let params = [name, category, description, details_url, age_category, training_schedule, program_type];

    if (image) {
        sql += `, image_path = ?`;
        params.push(image);
    }

    sql += ` WHERE id = ?`;
    params.push(req.params.id);

    try {
        await db.query(sql, params);
        res.json({ success: true });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// Delete Sport
app.delete('/api/sports/:id', async (req, res) => {
    try {
        await db.query('DELETE FROM sports WHERE id = ?', [req.params.id]);
        res.json({ success: true });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// --- GALLERY (Base64) ---
app.post('/api/gallery', async (req, res) => {
    const { image } = req.body;
    try {
        const [result] = await db.query('INSERT INTO gallery (image_path) VALUES (?)', [image]);
        res.json({ success: true, id: result.insertId });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

app.delete('/api/gallery/:id', async (req, res) => {
    try {
        await db.query('DELETE FROM gallery WHERE id = ?', [req.params.id]);
        res.json({ success: true });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// --- STATS ---
app.put('/api/stats/:id', async (req, res) => {
    const { label, value } = req.body;
    try {
        await db.query('UPDATE stats SET label = ?, value = ? WHERE id = ?', [label, value, req.params.id]);
        res.json({ success: true });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// Add new stat (optional)
app.post('/api/stats', async (req, res) => {
    const { label, value } = req.body;
    try {
        const [result] = await db.query('INSERT INTO stats (label, value) VALUES (?, ?)', [label, value]);
        res.json({ success: true, id: result.insertId });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

const PORT = process.env.PORT || 5004;
app.listen(PORT, () => console.log(`Server live on port ${PORT}`));
