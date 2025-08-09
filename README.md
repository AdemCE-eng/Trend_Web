<p align="center">
  <img src="public/images/Trends_Logo.png" width="80" alt="Trends Logo">
  <h1 align="center">Trends</h1>
  <p align="center">A modern social media platform built with Laravel</p>
</p>

<p align="center">
<img src="https://img.shields.io/badge/Laravel-11.x-red.svg" alt="Laravel Version">
<img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP Version">
<img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
</p>

## About Trends

Trends is a modern, feature-rich social media platform that allows users to share thoughts, images, and connect with others. Built with Laravel and modern web technologies, Trends provides a seamless and engaging social experience.

### Key Features

- **User Authentication & Profiles** - Secure registration, login, and customizable user profiles
- **Tweet System** - Share thoughts, images, and engage with content
- **Social Interactions** - Like, retweet, reply, and share functionality
- **Media Support** - Upload and share images with tweets
- **Follow System** - Follow users and build your social network
- **Responsive Design** - Beautiful UI that works on all devices
- **Real-time Updates** - Dynamic content loading and interactions
- **Profile Customization** - Custom avatars, banners, and bio information

### Technology Stack

- **Backend**: Laravel 11.x (PHP 8.2+)
- **Frontend**: Blade Templates with Tailwind CSS
- **Database**: SQLite/MySQL
- **File Storage**: Laravel File Storage with Symbolic Links
- **Authentication**: Laravel Breeze
- **Icons**: Tabler Icons
- **Styling**: DaisyUI + Tailwind CSS

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- SQLite or MySQL

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/AdemCE-eng/Trend_Web.git
   cd Trend_Web
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Storage setup**
   ```bash
   php artisan storage:link
   ```

6. **Build assets**
   ```bash
   npm run dev
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to access the application.

## Features Overview

### User Management
- User registration with avatar upload
- Profile editing (bio, location, website, banner)
- Password strength validation
- Terms and privacy policy agreement

### Content Creation
- Create tweets with text and images
- Reply to tweets with threaded conversations
- Retweet functionality
- Like/unlike tweets

### Social Features
- Follow/unfollow users
- Profile views with tabbed content (Tweets, Replies, Media, Likes)
- User statistics (tweets, following, followers)
- Media gallery view

### Design & UX
- Modern, responsive design
- Dark/light theme support
- Smooth animations and transitions
- Mobile-first approach
- Accessibility considerations

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request. For major changes, please open an issue first to discuss what you would like to change.

## Security

If you discover any security vulnerabilities, please send an email to the project maintainer. All security vulnerabilities will be promptly addressed.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
