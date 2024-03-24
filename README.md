# Flash Briefing Skill Application

This is a PHP-based application for creating and managing Flash Briefing Skills for Amazon Alexa. It provides a web interface for users to create, view, and edit their flash briefing content.

A free and ready-to-use version is available at [https://alexa.technotablet.com/flash-briefing-feed](https://alexa.technotablet.com/flash-briefing-feed), which is a part of a larger Alexa Skill Building course available at [https://alexa.technotablet.com](https://alexa.technotablet.com)

However, in case you intend to deploy it locally, then you can use the source code to deploy it yourself.

## Features

- Create new flash briefing links with unique IDs
- View and edit flash briefing content
- Generate JSON links for random and daily flash briefing requests
- Limit flash briefing content size to 50KB
- The content is saved as individual files
- Anybody with access to the unique id and link can edit the feed

## Requirements

- PHP 
- Apache web server
- `mod_rewrite` module enabled in Apache

## Installation

1. Clone the repository to your local machine or server:
```
git clone https://github.com/your-username/flash-briefing-skill.git
```
2. Install PHP and Apache web server on your machine if not already installed. You can follow the official PHP and Apache documentation for installation instructions specific to your operating system. On Ubuntu it would be
```
apt install php libapache2-mod-php apache2
```
3. Enable the `mod_rewrite` module in Apache. Refer to the Apache documentation for instructions on enabling mod_rewrite based on your operating system and Apache version. Typically it is `a2enmod rewrite`
4. Configure Apache to allow `.htaccess` overrides. Open the Apache configuration file (e.g., `/etc/apache2/apache2.conf`) and locate the `<Directory>` section for your web server's document root. Inside that section, set `AllowOverride` to `All`. For example:
```
<Directory "/var/www">
  AllowOverride All
  # Other directives...
</Directory>
```
5. **IMPORTANT** Modify `.htaccess` file and set the appropriate `RewriteBase` based on the folder where you have deployed the skill.
```
RewriteEngine On
RewriteBase /flash-briefing-skill/
```
6. Restart the Apache web server for the changes to take effect.

7. Upload the cloned repository files to your web server's document root or the desired directory.

8. Ensure that the web server has write permissions to the `flashbriefing` directory and its subdirectories. The application will create folders and files in this directory to store flash briefing content. For instance,
```
chown www-data flash-briefing-feed
```
9. Access the application in your web browser using the appropriate URL (e.g., `http://localhost/flash-briefing-skill` or `http://your-domain.com/flash-briefing-skill`).
10. For using it in Alexa Flash Briefing Skill, you would need this URL to be hosted on a `https://` based environment and it should be publicly accesible.

## Demo App for Web-based Testing

A live version of this Flash Briefing Feed application is available for testing at [https://alexa.technotablet.com/flash-briefing-feed](https://alexa.technotablet.com/flash-briefing-feed). You can use this URL to create, view, and edit flash briefing content without setting up the application locally.

Please note that the web-based testing environment is provided for convenience and may not always reflect the latest version of the code in this repository.

## License

This project is open-source and available under the [MIT License](LICENSE).

## Contact

This is part of the Alexa Skill Building course at [https://alexa.technotablet.com](https://alexa.technotablet.com)

Happy skill building!
