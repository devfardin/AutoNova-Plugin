# Ele Addons for Elementor

Ele Addons for Elementor is a starter project designed to help developers build custom addons and widgets for the Elementor page builder using a clean and scalable architecture.

This project uses **Composer for dependency management and autoloading**, which helps maintain a well-structured and maintainable codebase.

The goal of this repository is to provide developers with a **ready-to-use development environment for Elementor addon development**.

---

# Project Overview

Developing Elementor widgets can quickly become difficult to maintain without a proper structure.  
This project provides a well-organized development setup that allows developers to build Elementor extensions in a cleaner and more scalable way.

It includes a structured architecture, Composer integration, and a development-ready plugin environment.

---

# Features

- Clean and scalable project structure
- Composer-based dependency management
- PSR-4 autoloading support
- Organized widget development structure
- Ready plugin setup for Elementor development
- Developer-friendly architecture

---

# Requirements

Before using this project, ensure the following tools are available on your system:

- PHP version 7.4 or higher
- WordPress installation
- Elementor plugin installed and activated
- Composer installed on your system

Composer can be downloaded from the official Composer website.

---

# Installation Guide

To set up the project, first download or clone the repository to your local environment.

After downloading the project, open the project folder in your development environment.

Next, initialize Composer for the project. During the Composer setup process you can use the following information:

- Package name: `devfardin/ele-addons`
- Description: Ele Addons for Elementor
- Minimum Stability: stable
- Package Type: project
- License: GPL-2.0-only

Once Composer is initialized, install the project dependencies so that the required packages and autoload files are generated.

Whenever new classes or namespaces are added to the project, regenerate the Composer autoload files so the classes can be automatically loaded.

---

# Project Structure

The project follows a clean and organized folder structure.

ele-addons  
│  
├── includes  
│ ├── Widgets  
│ ├── Controls  
│ ├── Helpers  
│ └── Core  
│  
├── vendor  
├── composer.json  
├── composer.lock  
├── ele-addons.php  
└── README.md  

---

# Folder Explanation

**includes**  
Contains the main source code for the plugin.

**Widgets**  
All Elementor widgets should be created inside this directory.

**Controls**  
Custom Elementor controls can be placed here.

**Helpers**  
Utility classes and helper functions.

**Core**  
Core plugin functionality and loader classes.

**vendor**  
Composer dependencies are stored in this folder.

---

# Development Guide

When developing new Elementor widgets, create new classes inside the **Widgets directory**.

Each widget should follow a clean namespace structure that matches the Composer PSR-4 autoload configuration.

After creating new classes, ensure the Composer autoload files are refreshed so the classes can be automatically loaded by the system.

---

# Composer Usage

Composer is used in this project to manage dependencies and provide automatic class loading.

Whenever new classes are added to the project, the autoload files should be updated to ensure proper loading of the classes.

---

# Contributing

Contributions are welcome.

If you would like to improve this project:

1. Fork the repository
2. Create a new branch
3. Make your changes
4. Submit a pull request

---

# Reporting Issues

If you encounter any bugs or problems while using the project, please open an issue in the repository.

When reporting issues, try to include:

- WordPress version
- Elementor version
- PHP version
- Steps to reproduce the issue

---


# Author

Fardin Ahmed  
Email: contactfardin22@gmail.com

---

# Support

If you find this project helpful, consider giving the repository a ⭐ star on GitHub.


- composer init
- composer install
- composer dump-autoload# AutoNova-Plugin
# AutoNova-Plugin
