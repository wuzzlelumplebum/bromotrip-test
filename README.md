# 🏔️ BromoTrip — Tour Ticketing System

A web-based tour ticketing platform for booking Mount Bromo adventure packages, built with Laravel 9.

## 🌐 Live Demo
> Coming soon (deployment in progress)

**Demo Accounts:**
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@bromotrip.com | password |
| Loyal Customer | loyal@bromotrip.com | password |
| Regular Customer | customer@bromotrip.com | password |

---

## ✨ Features

### Customer
- Browse & filter tour packages (price, duration, search)
- View package details with itinerary
- Book a tour with participant details
- Real-time quota availability
- Booking confirmation & status tracking (Pending → Confirmed → Completed)
- Cancel pending bookings
- Email notifications (booking confirmation & status updates)
- Profile management & password change
- 10% discount for Loyal Customers

### Admin
- Dashboard with statistics (bookings, revenue, customers)
- Full CRUD for tour packages + photo upload
- Schedule management per package
- Booking management (confirm, complete, cancel)
- Edit booking participant details
- Monthly reports with revenue breakdown
- Auto-cancel expired pending bookings (scheduled command)

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 9, PHP 8.2 |
| Database | MySQL |
| Frontend | Blade, Tailwind CSS, Alpine.js |
| Build Tool | Vite |
| Email | Mailtrap (SMTP) |
| Auth | Laravel Breeze |
| Version Control | Git & GitHub |

---

## 🗄️ Database Schema
users
├── id, name, email, password
├── role (1=admin, 2=loyal_customer, 3=customer)
└── timestamps
tour_packages
├── id, name, slug, description, itinerary
├── price, duration_days, meeting_point
├── thumbnail, is_active
└── timestamps
tour_schedules
├── id, tour_package_id (FK)
├── departure_date, quota, booked
├── is_active
└── timestamps
bookings
├── id, booking_code (unique)
├── user_id (FK), tour_schedule_id (FK)
├── total_participants, price_per_person, total_price
├── status (pending/confirmed/cancelled/completed)
├── notes
└── timestamps
booking_participants
├── id, booking_id (FK)
├── name, id_number, birth_date
├── id_type (ktp/passport)
└── timestamps

---

## ⚙️ Installation

### Requirements
- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/wuzzlelumplebum/bromotrip-test.git
cd bromotrip-test

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Configure database in .env
DB_DATABASE=bromotrip
DB_USERNAME=root
DB_PASSWORD=

# 7. Configure mail in .env (Mailtrap)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password

# 8. Run migrations & seeders
php artisan migrate --seed

# 9. Create storage link
php artisan storage:link

# 10. Build assets
npm run build

# 11. Start server
php artisan serve
```

---

## 📁 Project Structure

app/
├── Console/Commands/     # Scheduled commands (CancelExpiredBookings)
├── Http/Controllers/
│   ├── Admin/           # Admin controllers
│   └── Auth/            # Authentication controllers
├── Mail/                # Email classes
└── Models/              # Eloquent models
resources/views/
├── admin/               # Admin panel views
├── bookings/            # Customer booking views
├── components/          # Reusable blade components
├── emails/              # Email templates
└── tours/               # Tour listing views

---

## 🔑 Key Implementation Details

- **Role-based access control** — Middleware for admin and customer routes
- **Real-time quota management** — Booking decrements available spots instantly
- **Price snapshot** — Price per person saved at booking time, immune to future price changes
- **Duplicate booking prevention** — One active booking per schedule per customer
- **Auto-cancel expired bookings** — Laravel scheduler runs daily at midnight
- **Email notifications** — Triggered on booking creation and status changes

---

## 👤 Author

**Yanuar Cahya Pratama**
- GitHub: [@wuzzlelumplebum](https://github.com/wuzzlelumplebum)

---

## 📄 License

This project is open-sourced for portfolio purposes