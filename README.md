BeyondChats Full-Stack Assignment
📌 Overview

This repository contains my submission for the BeyondChats Full-Time Remote Engineering Assignment.

The project is built as a monorepo and covers:

Phase 1: Scraping BeyondChats blog articles, storing them in a database, and exposing CRUD APIs using Laravel

Phase 2: A Node.js pipeline that fetches the latest article, performs Google search–based comparison, scrapes external articles, and prepares content for LLM-based rewriting (partially completed)

Phase 3: A React.js frontend that fetches and displays articles in a clean, responsive UI

The focus of this submission is correct system design, clean implementation, and practical trade-offs under time constraints, rather than perfect completion. 

beyondchats-assignment/
│
├── app/                    # Laravel backend (APIs, Models, Controllers)
├── routes/                 # API & web routes
├── database/               # SQLite database & migrations
├── node-llm/               # Node.js scripts for Phase 2
├── frontend/               # React.js frontend
├── public/
├── storage/
└── README.md

⚙️ Tech Stack
Backend

Laravel 12
SQLite (for fast local setup)
Symfony DomCrawler (scraping)

Phase 2 Pipeline
Node.js
Axios
Cheerio
SerpAPI (Google Search)
LLM integration planned (mocked / partially implemented)

Frontend
React.js
Fetch API
Simple responsive UI (cards)

🔄 Architecture & Data Flow
[BeyondChats Website]
        ↓
[Laravel Scraper Command]
        ↓
[SQLite Database]
        ↓
[Laravel REST API]
        ↓
[React Frontend]

Phase 2 (Node.js):
[Laravel API] → [Google Search] → [External Blogs]
        ↓
   (Scrape & Compare)
        ↓
     (LLM Rewrite - Partial)
        ↓
 [Publish back via Laravel API]


🛠 Local Setup Instructions
1️⃣ Backend (Laravel)
cd beyondchats-backend
composer install
php artisan migrate
php artisan serve


API runs at:

http://127.0.0.1:8000

2️⃣ Frontend (React)
cd frontend
npm install
npm start


App runs at:

http://localhost:3000 

✅ Phase 1 – Backend (Completed)
Features

Scraped 5 oldest articles from BeyondChats blogs

Stored articles in SQLite database

Created REST API endpoint:

GET /api/articles

Prevented duplicate article insertion

Used safe DOM scraping with fallbacks

Example API Response
GET http://127.0.0.1:8000/api/articles


Returns:

[
  {
    "id": 1,
    "title": "Your website needs a receptionist",
    "content": "...",
    "source_url": "...",
    "is_updated": false
  }
]


⚠️ Phase 2 – Node.js + LLM Pipeline (Partial)
What is Implemented

Fetch latest article from Laravel API
Google search using article title (SerpAPI)
Extract top external blog URLs
Scrape article content using Cheerio
What Is Intentionally Partial
LLM-based rewriting & publishing back to Laravel
Reasoning (Intentional Trade-off)

Why Phase 2 Execution Was Partially Skipped

During execution on Windows + Node.js 18, a known runtime issue occurred where Node’s experimental web APIs internally load undici, which requires browser-specific globals (File).
After multiple dependency-level fixes and environment isolation attempts, execution was intentionally stopped to avoid unsafe polyfills.

This decision reflects real-world engineering judgment, prioritizing stability and clarity over fragile workarounds.

The design is ready to execute in a compatible environment (e.g., Node 16 LTS).


🎨 Phase 3 – React Frontend (Completed)
Features

Fetches articles from Laravel API

Displays articles in responsive cards

Shows:

Title

Content preview

Source link

Updated status (if applicable)

UI Focus

Clean

Readable

Professional

Mobile-friendly

🛠️ Local Setup Instructions
Prerequisites

PHP 8.2+

Composer

Node.js (v18 recommended)

Git

🔹 Backend Setup (Laravel)
cd beyondchats-assignment
composer install


Create database file:

type nul > database/database.sqlite


Update .env:

DB_CONNECTION=sqlite
DB_DATABASE=absolute/path/to/database/database.sqlite
CACHE_DRIVER=file
SESSION_DRIVER=file


Run migrations:
php artisan migrate


Run scraper:
php artisan scrape:beyondchats


Start server:
php artisan serve

🔹 Frontend Setup (React)
cd frontend
npm install
npm start

🔹 Phase 2 (Node.js)
cd node-llm
npm install
npm start

🌐 Live Links

Backend API:
http://127.0.0.1:8000/api/articles

Frontend:
Runs locally via React (http://localhost:3000)

🧠 Key Engineering Decisions

Used SQLite for speed and portability
Chose file-based cache/session to avoid DB coupling
Modularized Phase 2 pipeline for extensibility
Prioritized robust scraping and clean APIs over full LLM polish

📌 Final Notes

This assignment was approached as a real-world engineering task, balancing:

Limited time
System reliability
Clean abstractions
Honest scope decisions

I would be happy to:

Complete Phase 2 LLM publishing
Deploy services
Improve UI/UX
Add authentication or pagination

Thank you for reviewing my submission.

— Velpuri Manikanta
