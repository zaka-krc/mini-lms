#!/usr/bin/env node

import { spawnSync, spawn } from 'child_process';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const isWindows = process.platform === 'win32';
const isWsl = !isWindows && fs.existsSync('/proc/version')
    && fs.readFileSync('/proc/version', 'utf8').toLowerCase().includes('microsoft');
const root = path.dirname(fileURLToPath(import.meta.url));

// ── Helpers ────────────────────────────────────────────────────────

function run(cmd, args = []) {
    const result = spawnSync(cmd, args, { cwd: root, stdio: 'inherit', shell: isWindows });
    if (result.status !== 0) {
        console.error(`\n[ERREUR] La commande a échoué : ${cmd} ${args.join(' ')}`);
        process.exit(1);
    }
}

function exists(cmd) {
    const check = spawnSync(isWindows ? 'where' : 'which', [cmd], { stdio: 'pipe' });
    return check.status === 0;
}

function step(n, total, msg) {
    console.log(`[${n}/${total}] ${msg}`);
}

// ── Vérification des prérequis ─────────────────────────────────────

console.log('\n ╔══════════════════════════════════════╗');
console.log(' ║        Mini LMS — Démarrage          ║');
console.log(' ╚══════════════════════════════════════╝\n');

if (!exists('php')) {
    console.error("[ERREUR] 'php' n'est pas installé ou pas dans le PATH.");
    if (isWsl) {
        console.error('\n  → Dans WSL, installez PHP avec :');
        console.error('    sudo apt update && sudo apt install php php-cli php-mbstring php-xml php-sqlite3 php-curl\n');
    }
    process.exit(1);
}

if (!exists('composer')) {
    console.error("[ERREUR] 'composer' n'est pas installé ou pas dans le PATH.");
    if (isWsl) {
        console.error('\n  → Dans WSL, installez Composer avec :');
        console.error('    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer\n');
    }
    process.exit(1);
}

// ── 1. Répertoires requis ──────────────────────────────────────────

const requiredDirs = [
    path.join(root, 'bootstrap', 'cache'),
    path.join(root, 'storage', 'app', 'public'),
    path.join(root, 'storage', 'framework', 'cache', 'data'),
    path.join(root, 'storage', 'framework', 'sessions'),
    path.join(root, 'storage', 'framework', 'views'),
    path.join(root, 'storage', 'logs'),
];

const missingDirs = requiredDirs.filter(d => !fs.existsSync(d));
if (missingDirs.length > 0) {
    step(1, 7, 'Création des répertoires requis...');
    for (const d of missingDirs) fs.mkdirSync(d, { recursive: true });
} else {
    step(1, 7, 'Répertoires requis déjà présents.');
}

// ── 2. Fichier .env ────────────────────────────────────────────────

const envPath = path.join(root, '.env');
if (!fs.existsSync(envPath)) {
    step(2, 7, 'Copie de .env.example vers .env...');
    fs.copyFileSync(path.join(root, '.env.example'), envPath);
} else {
    step(2, 7, 'Fichier .env déjà présent.');
}

// ── 3. Dépendances PHP ─────────────────────────────────────────────

if (!fs.existsSync(path.join(root, 'vendor'))) {
    step(3, 7, 'Installation des dépendances PHP (composer install)...');
    run('composer', ['install', '--no-interaction']);
} else {
    step(3, 7, 'Dépendances PHP déjà installées.');
}

// ── 4. Dépendances Node.js ─────────────────────────────────────────
// Détecte si node_modules a été installé sur une autre plateforme (ex: Windows → WSL)
// et réinstalle automatiquement si c'est le cas.

const platformFile = path.join(root, 'node_modules', '.install-platform');
const nodeModulesExist = fs.existsSync(path.join(root, 'node_modules'));
const installedPlatform = nodeModulesExist && fs.existsSync(platformFile)
    ? fs.readFileSync(platformFile, 'utf8').trim()
    : null;

if (!nodeModulesExist) {
    step(4, 7, 'Installation des dépendances Node.js (npm install)...');
    const lockFile = path.join(root, 'package-lock.json');
    if (fs.existsSync(lockFile)) fs.rmSync(lockFile);
    run('npm', ['install']);
    fs.writeFileSync(platformFile, process.platform);
} else if (installedPlatform !== process.platform) {
    step(4, 7, `Réinstallation des dépendances Node.js (plateforme changée : ${installedPlatform ?? '?'} → ${process.platform})...`);
    fs.rmSync(path.join(root, 'node_modules'), { recursive: true, force: true });
    const lockFile = path.join(root, 'package-lock.json');
    if (fs.existsSync(lockFile)) fs.rmSync(lockFile);
    run('npm', ['install']);
    fs.writeFileSync(platformFile, process.platform);
} else {
    step(4, 7, 'Dépendances Node.js déjà installées.');
}

// ── 5. Clé d'application ───────────────────────────────────────────

const envContent = fs.readFileSync(envPath, 'utf8');
if (!envContent.includes('APP_KEY=base64:')) {
    step(5, 7, "Génération de la clé d'application...");
    run('php', ['artisan', 'key:generate', '--quiet']);
} else {
    step(5, 7, "Clé d'application déjà définie.");
}

// ── 6. Base de données ─────────────────────────────────────────────

const dbPath = path.join(root, 'database', 'database.sqlite');
if (!fs.existsSync(dbPath)) {
    step(6, 7, 'Création de la base de données et insertion des données de démo...');
    fs.writeFileSync(dbPath, '');
    run('php', ['artisan', 'migrate', '--force', '--quiet']);
    run('php', ['artisan', 'db:seed', '--force', '--quiet']);
} else {
    step(6, 7, 'Base de données déjà présente.');
}

// ── 7. Démarrage ───────────────────────────────────────────────────

step(7, 7, 'Démarrage des serveurs...');
console.log(`
 ┌─────────────────────────────────────────┐
 │  Application : http://localhost:8000     │
 │                                          │
 │  Comptes de démo :                       │
 │    admin@lms.test   / password  (admin)  │
 │    alice@lms.test   / password           │
 │    bob@lms.test     / password           │
 └─────────────────────────────────────────┘

  Ctrl+C pour tout arrêter.
`);

const npm = isWindows ? 'npm.cmd' : 'npm';

const devProcess = spawn(npm, ['run', 'dev'], { cwd: root, stdio: 'inherit' });
const serveProcess = spawn('php', ['artisan', 'serve'], { cwd: root, stdio: 'inherit' });

function cleanup() {
    devProcess.kill();
    serveProcess.kill();
}

process.on('SIGINT', cleanup);
process.on('SIGTERM', cleanup);
serveProcess.on('close', () => devProcess.kill());
