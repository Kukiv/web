# Simple PHP Website

A simple, responsive PHP website demonstrating basic PHP functionality and modern web design.

## Features

- **Dynamic Content**: Server-side rendering with PHP
- **Responsive Design**: Mobile-friendly layout
- **Contact Form**: Interactive form with validation
- **Modern UI**: Clean, professional design
- **Security**: Input validation and XSS protection
- **Configuration**: Centralized config management

## Pages

- **Home** (`index.php`): Main landing page with features overview
- **About** (`about.php`): Information about the site and PHP features
- **Contact** (`contact.php`): Contact form with validation and processing

## Files Structure

```
php-version/
├── index.php          # Home page
├── about.php          # About page
├── contact.php        # Contact page with form
├── styles.css         # CSS styles
├── config.php         # Configuration file
└── README.md          # This file
```

## Requirements

- PHP 7.0 or higher
- Web server (Apache, Nginx, or built-in PHP server)
- No database required (uses file-based storage)

## Installation

1. Clone or download the files to your web server directory
2. Ensure PHP is installed and running
3. Set proper file permissions (755 for directories, 644 for files)
4. Access the site through your web browser

## Running with Built-in Server

For development/testing, you can use PHP's built-in server:

```bash
php -S localhost:8000
```

Then visit `http://localhost:8000` in your browser.

## Configuration

Edit `config.php` to customize:
- Site name and email
- Database settings (if needed)
- Security settings
- File upload limits
- Debug mode

## Security Features

- Input sanitization and validation
- XSS protection
- CSRF token generation (ready for implementation)
- Secure session configuration
- Activity logging

## Contact Form

The contact form includes:
- Client-side and server-side validation
- Email format validation
- Required field checking
- Success/error message display
- Form data logging to file

## Customization

- Modify `styles.css` for design changes
- Update page content in PHP files
- Add new pages by following the existing structure
- Extend functionality in `config.php`

## License

This project is open source and available under the MIT License.
