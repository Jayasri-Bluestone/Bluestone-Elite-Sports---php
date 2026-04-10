const mysql = require('mysql2/promise');

async function seed() {
    
    // Database credentials
    const connection = await mysql.createConnection({
        host: 'auth-db1278.hstgr.io',
        user: 'u287260207_elitesports',
        password: 'merge*YOGA3',
        database: 'u287260207_elitesports_db',
        ssl: { rejectUnauthorized: false }
    });

    const sports = [
        ['Cricket Academy', 'Elite Academy', 'Professional cricket training with national coaches.', '/uploads/cricket.jpg', 'sports.php'],
        ['Yoga & Wellness', 'Wellness', 'Focus and flexibility sessions for elite athletes.', '/uploads/yoga.jpg', 'sports.php'],
        ['Karate Dojo', 'Martial Arts', 'Self-defense and discipline training.', '/uploads/karate.jpg', 'sports.php'],
        ['Pro Football', 'Academy', 'Master tactical gameplay and agility.', '/uploads/football.jpg', 'sports.php'],
        ['Tennis Masters', 'Elite Academy', 'High-intensity tennis training and match play.', '/uploads/tennis.jpg', 'sports.php'],
        ['Kabaddi Pro', 'Traditional', 'Strength and strategy sessions for pro Kabaddi.', '/uploads/kabaddi.jpg', 'sports.php']
    ];

    try {
        console.log('--- Starting Seeding Process ---');
        
        // 1. Ensure table exists
        await connection.execute(`
            CREATE TABLE IF NOT EXISTS sports (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                category VARCHAR(100),
                description TEXT,
                image_path VARCHAR(255),
                details_url VARCHAR(255)
            )
        `);
        console.log('Table structure verified.');

        // 2. Clear existing (optional - user can remove this if they want to keep previous)
        // await connection.execute('DELETE FROM sports');

        // 3. Batch Check & Insert
        for (const s of sports) {
            const [rows] = await connection.execute('SELECT id FROM sports WHERE name = ?', [s[0]]);
            if (rows.length === 0) {
                await connection.execute(
                    'INSERT INTO sports (name, category, description, image_path, details_url) VALUES (?, ?, ?, ?, ?)', 
                    s
                );
                console.log(`Successfully Added: ${s[0]}`);
            } else {
                console.log(`Skipped (already exists): ${s[0]}`);
            }
        }
        
        console.log('--- Seeding Completed! ---');
    } catch (err) {
        console.error('CRITICAL SEEDING ERROR:', err.message);
    } finally {
        await connection.end();
    }
}

seed();
