# Stadium (football pitch) reservation system

## Description

My project helps to connect between users and stadium owners. Users can find near stadiums and book it easily for convenient time. 

## Table of Contents
- [Installation](#installation)
- [Usage](#usage)
- [Features](#features)

## Features

This project includes a set of role-based permissions for various user roles, enabling different access levels and actions within the system. The features are organized as follows:

### Admin
- Can do everything

### Customer
- **Stadium**: View stadium details and view all stadiums
- **Review**: View, create, update, and delete reviews; view all reviews
- **Booking**: View and manage bookings; create, update, and delete bookings; view all bookings
- **Chat**: Send, edit, and delete messages; view chat conversations (soon)

### Manager
- **Stadium**: View, create, update, and delete stadiums; view all stadiums
- **Review**: View and delete reviews; view all reviews
- **Booking**: View and delete bookings; view all bookings

### Helpdesk Support
- **Chat**: Send, edit, and delete messages; view chat conversations (soon)

Each role is granted specific permissions to interact with different entities such as **stadiums**, **reviews**, **bookings**, and **chat**. This permission system ensures that users only have access to the features necessary for their role.


## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/abdulloh-uzb/stadium-reservation.git

## Usage

1. Navigate to the project directory
    ```bash
    cd my-awesome-project

2. Generate the application key:
    ```bash
    php artisan key:generate

3. Run database migrations
    ```bash
    php artisan migrate

4. Generate fake data
    ```bash
    php artisan db:seed

2. Run server using php (You need server to run project in local)
    ```bash
    php artisan serve

Project will be in http://localhost:8000

